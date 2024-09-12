<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleType::cases() as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
