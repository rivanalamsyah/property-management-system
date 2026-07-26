<?php

namespace Database\Factories;

use App\Enums\ResidentStatus;
use App\Models\BoardingHouse;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentFactory extends Factory
{
    protected $model = Resident::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $firstName = $gender === 'male' ? $this->faker->firstNameMale : $this->faker->firstNameFemale;
        $lastName = $this->faker->lastName;
        $fullName = $firstName . ' ' . $lastName;
        $email = strtolower($firstName . '.' . $lastName . '@' . $this->faker->freeEmailDomain);

        return [
            'tenant_id' => Tenant::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'room_id' => Room::factory(),
            'name' => $fullName,
            'nik' => $this->faker->unique()->numerify('################'),
            'gender' => $gender,
            'date_of_birth' => $this->faker->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
            'place_of_birth' => $this->faker->city,
            'nationality' => 'WNI',
            'occupation' => $this->faker->randomElement(['Mahasiswa', 'Karyawan Swasta', 'PNS', 'Wirausaha', 'Freelancer']),
            'marital_status' => $this->faker->randomElement(['Belum Menikah', 'Menikah']),
            'religion' => $this->faker->randomElement(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'photo' => null,
            'phone' => '08' . $this->faker->numerify('##########'),
            'whatsapp' => '08' . $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail, // we override this in seeder to guarantee no duplicates
            'emergency_name' => $this->faker->name,
            'emergency_relationship' => $this->faker->randomElement(['Orang Tua', 'Saudara Kandung', 'Paman', 'Bibi']),
            'emergency_phone' => '08' . $this->faker->numerify('##########'),
            'emergency_address' => $this->faker->address,
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address,
            'status' => ResidentStatus::ACTIVE,
            'check_in_date' => $this->faker->dateTimeBetween('-6 months', '-1 months')->format('Y-m-d'),
            'move_in_time' => '14:00:00',
            'initial_meter_reading' => $this->faker->randomFloat(2, 100, 500),
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Checked in smoothly.',
            'check_out_date' => null,
            'final_meter_reading' => null,
            'check_out_notes' => null,
            'damage_notes' => null,
        ];
    }
}
