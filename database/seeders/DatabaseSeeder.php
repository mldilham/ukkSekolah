<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'Admin MarSchool',
            'kontak' => '082119787632',
            'username' => 'Admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'nama' => 'Member MarSchool',
            'kontak' => '082119787633',
            'username' => 'Member',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);
    }
}
