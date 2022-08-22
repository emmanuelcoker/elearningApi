<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['user', 'instructor', 'admin'];

        foreach ($roles as $role) {
            $newRole = Role::create([
                'role_name' => $role
            ]);
        }
    }
}
