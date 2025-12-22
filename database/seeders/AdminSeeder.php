<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@smanegeri1.sch.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@smanegeri1.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample teacher
        User::updateOrCreate(
            ['email' => 'guru@smanegeri1.sch.id'],
            [
                'name' => 'Guru Demo',
                'email' => 'guru@smanegeri1.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample student
        User::updateOrCreate(
            ['email' => 'siswa@smanegeri1.sch.id'],
            [
                'name' => 'Siswa Demo',
                'email' => 'siswa@smanegeri1.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Default users created:');
        $this->command->info('Admin: admin@smanegeri1.sch.id / password123');
        $this->command->info('Guru: guru@smanegeri1.sch.id / password123');
        $this->command->info('Siswa: siswa@smanegeri1.sch.id / password123');
    }
}
