<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
                'phone' => '081234567890',
                'address' => 'Ruang Admin'
            ]);
        }

        // 2. Create Guru
        if (!User::where('email', 'guru@guru.com')->exists()) {
            $guru = User::create([
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'guru@guru.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'is_active' => true,
                'phone' => '089876543210',
                'address' => 'Jl. Guru No. 1'
            ]);

            Teacher::create([
                'user_id' => $guru->id,
                'nip' => '198501012010011001',
                'full_name' => $guru->name,
                'gender' => 'L',
                'birth_place' => 'Bengkulu',
                'birth_date' => '1985-01-01',
                'phone' => $guru->phone,
                'address' => $guru->address,
                'subject_specialty' => 'Matematika',
                'education' => 'S1 Pendidikan Matematika',
                'join_date' => '2010-01-01',
                'is_active' => true,
            ]);
        }

        // 3. Create Siswa
        if (!User::where('email', 'siswa@siswa.com')->exists()) {
            $siswa = User::create([
                'name' => 'Ahmad Siswa',
                'email' => 'siswa@siswa.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'email_verified_at' => now(),
                'is_active' => true,
                'phone' => '082112345678',
                'address' => 'Jl. Siswa No. 1'
            ]);

            Student::create([
                'user_id' => $siswa->id,
                'nisn' => '0051234567',
                'nis' => '2023001',
                'full_name' => $siswa->name,
                'gender' => 'L',
                'birth_place' => 'Bengkulu',
                'birth_date' => '2005-05-05',
                'phone' => $siswa->phone,
                'address' => $siswa->address,
                'class_name' => 'X IPA 1',
                'enrollment_year' => 2023,
                'parent_name' => 'Orang Tua Ahmad',
                'parent_phone' => '081298765432',
                'is_active' => true,
            ]);
        }
    }
}
