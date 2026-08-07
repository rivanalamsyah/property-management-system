<?php

namespace App\Services\SaaS;

use App\Models\Room;
use App\Models\Resident;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ImportService
{
    /**
     * Parse CSV file and validate schema.
     */
    public function parseCsv(string $filePath, array $requiredHeaders): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new Exception("File CSV tidak dapat dibaca.");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new Exception("Gagal membuka file CSV.");
        }

        $header = fgetcsv($handle, 1000, ',');
        if (!$header) {
            fclose($handle);
            throw new Exception("File CSV kosong atau tidak memiliki header.");
        }

        // Clean headers (remove BOM/spaces/lowercase)
        $header = array_map(fn($h) => strtolower(trim(preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $h))), $header);

        // Check required columns
        foreach ($requiredHeaders as $req) {
            if (!in_array($req, $header)) {
                fclose($handle);
                throw new Exception("Header wajib tidak ditemukan: " . $req);
            }
        }

        $rows = [];
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Skip empty rows
            if (count($data) < count($header)) {
                continue;
            }
            $row = array_combine($header, array_slice($data, 0, count($header)));
            $rows[] = $row;
        }

        fclose($handle);
        return $rows;
    }

    /**
     * Validate and preview Room records.
     */
    public function previewRooms(array $rows, string $boardingHouseId): array
    {
        $preview = [];
        $existingRoomCodes = Room::where('boarding_house_id', $boardingHouseId)->pluck('room_code')->toArray();
        $existingRoomNumbers = Room::where('boarding_house_id', $boardingHouseId)->pluck('room_number')->toArray();

        $seenNumbers = [];

        foreach ($rows as $index => $row) {
            $errors = [];
            
            // Standardize/validate columns
            $roomNumber = trim($row['room_number'] ?? '');
            $floor = (int)($row['floor'] ?? 1);
            $roomType = trim($row['room_type'] ?? 'Standard');
            $rent = (float)($row['monthly_rent'] ?? 0.00);
            $deposit = (float)($row['security_deposit'] ?? 0.00);
            $size = trim($row['room_size'] ?? '3x4');
            $status = trim($row['status'] ?? 'available');
            if ($status === 'vacant') {
                $status = 'available';
            }
            
            $roomCode = 'RM-' . strtoupper($roomNumber);

            // Validation Rules
            if (empty($roomNumber)) {
                $errors[] = "Nomor kamar wajib diisi.";
            }

            if ($rent <= 0) {
                $errors[] = "Harga sewa bulanan harus lebih besar dari 0.";
            }

            // Duplicate checks
            if (in_array($roomNumber, $existingRoomNumbers)) {
                $errors[] = "Kamar '{$roomNumber}' sudah terdaftar di properti kos ini.";
            }
            if (in_array($roomNumber, $seenNumbers)) {
                $errors[] = "Nomor kamar ganda dalam CSV: '{$roomNumber}'.";
            }
            $seenNumbers[] = $roomNumber;

            $preview[] = [
                'index' => $index,
                'data' => [
                    'boarding_house_id' => $boardingHouseId,
                    'room_number' => $roomNumber,
                    'room_name' => 'Kamar ' . $roomNumber,
                    'floor' => $floor,
                    'room_type' => $roomType,
                    'monthly_rent' => $rent,
                    'security_deposit' => $deposit,
                    'room_size' => $size,
                    'status' => $status,
                    'room_code' => $roomCode,
                    'is_published' => true,
                ],
                'errors' => $errors,
                'is_valid' => empty($errors),
            ];
        }

        return $preview;
    }

    /**
     * Validate and preview Resident records.
     */
    public function previewResidents(array $rows, string $tenantId): array
    {
        $preview = [];
        $existingNiks = Resident::where('tenant_id', $tenantId)->pluck('nik')->toArray();
        $existingEmails = Resident::where('tenant_id', $tenantId)->pluck('email')->toArray();

        $seenNiks = [];
        $seenEmails = [];

        foreach ($rows as $index => $row) {
            $errors = [];
            
            $name = trim($row['name'] ?? '');
            $nik = trim($row['nik'] ?? '');
            $email = trim($row['email'] ?? '');
            $phone = trim($row['phone'] ?? '');
            $gender = strtolower(trim($row['gender'] ?? 'male'));
            $occupation = trim($row['occupation'] ?? '');

            if (empty($name)) {
                $errors[] = "Nama wajib diisi.";
            }
            if (empty($nik) || strlen($nik) !== 16 || !is_numeric($nik)) {
                $errors[] = "NIK harus terdiri dari 16 digit angka.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Alamat email tidak valid.";
            }

            // Duplicate checks
            if (in_array($nik, $existingNiks)) {
                $errors[] = "Penghuni dengan NIK '{$nik}' sudah terdaftar.";
            }
            if (in_array($nik, $seenNiks)) {
                $errors[] = "NIK ganda dalam CSV: '{$nik}'.";
            }
            $seenNiks[] = $nik;

            if (in_array($email, $existingEmails)) {
                $errors[] = "Email '{$email}' sudah digunakan.";
            }
            if (in_array($email, $seenEmails)) {
                $errors[] = "Email ganda dalam CSV: '{$email}'.";
            }
            $seenEmails[] = $email;

            $preview[] = [
                'index' => $index,
                'data' => [
                    'tenant_id' => $tenantId,
                    'name' => $name,
                    'nik' => $nik,
                    'email' => $email,
                    'phone' => $phone,
                    'whatsapp' => $phone,
                    'gender' => $gender,
                    'occupation' => $occupation,
                    'status' => 'inactive',
                ],
                'errors' => $errors,
                'is_valid' => empty($errors),
            ];
        }

        return $preview;
    }

    /**
     * Import validated Room preview entries with absolute database rollback safety.
     */
    public function importRooms(array $preview): void
    {
        DB::beginTransaction();
        try {
            foreach ($preview as $item) {
                if (!$item['is_valid']) {
                    throw new Exception("Tidak dapat mengimpor. File CSV mengandung kesalahan validasi.");
                }
                Room::create($item['data']);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Import validated Resident preview entries with absolute database rollback safety.
     */
    public function importResidents(array $preview): void
    {
        DB::beginTransaction();
        try {
            foreach ($preview as $item) {
                if (!$item['is_valid']) {
                    throw new Exception("Tidak dapat mengimpor. File CSV mengandung kesalahan validasi.");
                }
                Resident::create($item['data']);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
