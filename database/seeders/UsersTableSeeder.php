<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'administrador')->first();
        $meseroRole = Role::where('name', 'mesero')->first();
        $cocinaRole = Role::where('name', 'cocina')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Mesero User',
            'email' => 'mesero@example.com',
            'password' => bcrypt('password'),
            'role_id' => $meseroRole->id,
        ]);

        User::create([
            'name' => 'Cocina User',
            'email' => 'cocina@example.com',
            'password' => bcrypt('password'),
            'role_id' => $cocinaRole->id,
        ]);
    }
}
