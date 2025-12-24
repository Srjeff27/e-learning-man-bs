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
            ['email' => 'admin@sman2kaur.sch.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@sman2kaur.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample teacher
        User::updateOrCreate(
            ['email' => 'guru@sman2kaur.sch.id'],
            [
                'name' => 'Guru Demo',
                'email' => 'guru@sman2kaur.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample student
        User::updateOrCreate(
            ['email' => 'siswa@sman2kaur.sch.id'],
            [
                'name' => 'Siswa Demo',
                'email' => 'siswa@sman2kaur.sch.id',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Default users created:');
        $this->command->info('Admin: admin@sman2kaur.sch.id / password123');
        $this->command->info('Guru: guru@sman2kaur.sch.id / password123');
        $this->command->info('Siswa: siswa@sman2kaur.sch.id / password123');
    }
}
