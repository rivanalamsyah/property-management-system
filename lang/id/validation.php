<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi standar pesan kesalahan yang digunakan oleh
    | kelas validator. Beberapa aturan memiliki beberapa versi seperti
    | aturan ukuran. Silakan sesuaikan masing-masing pesan di sini.
    |
    | Translator: Rivan Alamsyah
    |
    */

    'accepted' => ':attribute harus diterima.',
    'accepted_if' => ':attribute harus diterima ketika :other berisi :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa array.',
    'ascii' => ':attribute hanya boleh berisi karakter alfanumerik byte tunggal dan simbol.',
    'before' => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki antara :min dan :max anggota.',
        'file' => ':attribute harus berukuran antara :min dan :max kilobita.',
        'numeric' => ':attribute harus bernilai antara :min dan :max.',
        'string' => ':attribute harus terdiri dari :min sampai :max karakter.',
    ],
    'boolean' => ':attribute harus bernilai true atau false.',
    'can' => ':attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak cocok dengan format :format.',
    'decimal' => ':attribute harus memiliki :decimal tempat desimal.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak ketika :other berisi :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus terdiri dari :digits angka.',
    'digits_between' => ':attribute harus terdiri dari :min sampai :max angka.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => ':attribute memiliki nilai yang duplikat.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'extensions' => ':attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => ':attribute harus berupa file.',
    'filled' => ':attribute wajib diisi.',
    'gt' => [
        'array' => ':attribute harus memiliki lebih dari :value anggota.',
        'file' => ':attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari :value.',
        'string' => ':attribute harus terdiri dari lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus memiliki :value anggota atau lebih.',
        'file' => ':attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string' => ':attribute harus terdiri dari lebih dari atau sama dengan :value karakter.',
    ],
    'hex_color' => ':attribute harus berupa warna heksadesimal yang valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute tidak ada di dalam :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa string JSON yang valid.',
    'lowercase' => ':attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => ':attribute harus memiliki kurang dari :value anggota.',
        'file' => ':attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => ':attribute harus bernilai kurang dari :value.',
        'string' => ':attribute harus terdiri dari kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :value anggota.',
        'file' => ':attribute tidak boleh berukuran lebih besar dari :value kilobita.',
        'numeric' => ':attribute tidak boleh bernilai lebih besar dari :value.',
        'string' => ':attribute tidak boleh terdiri dari lebih dari :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :max anggota.',
        'file' => ':attribute tidak boleh berukuran lebih besar dari :max kilobita.',
        'numeric' => ':attribute tidak boleh bernilai lebih besar dari :max.',
        'string' => ':attribute tidak boleh terdiri dari lebih dari :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => ':attribute harus berupa file bertipe: :values.',
    'mimetypes' => ':attribute harus berupa file bertipe: :values.',
    'min' => [
        'array' => ':attribute harus memiliki minimal :min anggota.',
        'file' => ':attribute harus berukuran minimal :min kilobita.',
        'numeric' => ':attribute harus bernilai minimal :min.',
        'string' => ':attribute minimal harus terdiri dari :min karakter.',
    ],
    'min_digits' => ':attribute harus memiliki minimal :min digit.',
    'missing' => ':attribute harus tidak ada.',
    'missing_if' => ':attribute harus tidak ada ketika :other berisi :value.',
    'missing_unless' => ':attribute harus tidak ada kecuali :other berisi :value.',
    'missing_with' => ':attribute harus tidak ada ketika :values ada.',
    'missing_with_all' => ':attribute harus tidak ada ketika :values ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus berisi minimal satu huruf.',
        'mixed' => ':attribute harus berisi minimal satu huruf besar dan satu huruf kecil.',
        'numbers' => ':attribute harus berisi minimal satu angka.',
        'symbols' => ':attribute harus berisi minimal satu simbol.',
        'uncompromised' => ':attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => ':attribute harus ada.',
    'present_if' => ':attribute harus ada ketika :other berisi :value.',
    'present_unless' => ':attribute harus ada kecuali :other berisi :value.',
    'present_with' => ':attribute harus ada ketika :values ada.',
    'present_with_all' => ':attribute harus ada ketika :values ada.',
    'prohibited' => ':attribute tidak diperbolehkan.',
    'prohibited_if' => ':attribute tidak diperbolehkan ketika :other berisi :value.',
    'prohibited_unless' => ':attribute tidak diperbolehkan kecuali :other berisi :value.',
    'prohibits' => ':attribute melarang :other untuk ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus berisi entri untuk: :values.',
    'required_if' => ':attribute wajib diisi ketika :other berisi :value.',
    'required_if_accepted' => ':attribute wajib diisi ketika :other diterima.',
    'required_unless' => ':attribute wajib diisi kecuali :other memiliki nilai di dalam :values.',
    'required_with' => ':attribute wajib diisi ketika :values ada.',
    'required_with_all' => ':attribute wajib diisi ketika :values ada.',
    'required_without' => ':attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi ketika tidak ada satupun :values yang ada.',
    'same' => ':attribute dan :other harus cocok.',
    'size' => [
        'array' => ':attribute harus mengandung :size anggota.',
        'file' => ':attribute harus berukuran :size kilobita.',
        'numeric' => ':attribute harus berukuran :size.',
        'string' => ':attribute harus terdiri dari :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah terdaftar.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => ':attribute harus berupa huruf besar.',
    'url' => ':attribute harus berupa URL yang valid.',
    'ulid' => ':attribute harus berupa ULID yang valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi khusus untuk atribut menggunakan
    | konvensi "attribute.rule" untuk menamai baris. Ini membuatnya cepat untuk
    | menentukan baris bahasa khusus untuk aturan atribut tertentu.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar placeholder atribut kami
    | dengan sesuatu yang lebih ramah pembaca seperti "Alamat E-Mail" sebagai
    | ganti "email". Ini membantu kita membuat pesan lebih bersih.
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'username' => 'Nama pengguna',
        'email' => 'Alamat email',
        'first_name' => 'Nama depan',
        'last_name' => 'Nama belakang',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'city' => 'Kota',
        'country' => 'Negara',
        'address' => 'Alamat',
        'phone' => 'Nomor HP',
        'mobile' => 'Nomor HP',
        'age' => 'Usia',
        'sex' => 'Jenis kelamin',
        'gender' => 'Jenis kelamin',
        'day' => 'Hari',
        'month' => 'Bulan',
        'year' => 'Tahun',
        'hour' => 'Jam',
        'minute' => 'Menit',
        'second' => 'Detik',
        'title' => 'Judul',
        'content' => 'Konten',
        'description' => 'Deskripsi',
        'excerpt' => 'Kutipan',
        'date' => 'Tanggal',
        'time' => 'Waktu',
        'available' => 'Tersedia',
        'size' => 'Ukuran',
        'subject' => 'Subjek',
        'message' => 'Pesan',
    ],

];
