<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $rolePermissions = [
            
            //reader permissions
            [
                'role_id' => 3,
                'permission_id' => 1,
            ],
            [
                'role_id' => 3,
                'permission_id' => 5,
            ],
            [
                'role_id' => 3,
                'permission_id' => 9,
            ],
            [
                'role_id' => 3,
                'permission_id' => 13,
            ],
            [
                'role_id' => 3,
                'permission_id' => 17,
            ],
            [
                'role_id' => 3,
                'permission_id' => 21,
            ],
            [
                'role_id' => 3,
                'permission_id' => 25,
            ],
            [
                'role_id' => 3,
                'permission_id' => 29,
            ],

            // writer permissions

            [
                'role_id' => 2,
                'permission_id' => 1,
            ],
            [
                'role_id' => 2,
                'permission_id' => 2,
            ],
            [
                'role_id' => 2,
                'permission_id' => 3,
            ],
            [
                'role_id' => 2,
                'permission_id' => 4,
            ],
            [
                'role_id' => 2,
                'permission_id' => 5,
            ],
            [
                'role_id' => 2,
                'permission_id' => 6,
            ],
            [
                'role_id' => 2,
                'permission_id' => 9,
            ],
            [
                'role_id' => 2,
                'permission_id' => 10,
            ],
            [
                'role_id' => 2,
                'permission_id' => 12,
            ],
            [
                'role_id' => 2,
                'permission_id' => 14,
            ],
            [
                'role_id' => 2,
                'permission_id' => 17,
            ],
            [
                'role_id' => 2,
                'permission_id' => 18,
            ],
            [
                'role_id' => 2,
                'permission_id' => 21,
            ],
            [
                'role_id' => 2,
                'permission_id' => 22,
            ],
            [
                'role_id' => 2,
                'permission_id' => 23,
            ],
            [
                'role_id' => 2,
                'permission_id' => 25,
            ],
            [
                'role_id' => 2,
                'permission_id' => 26,
            ],
            [
                'role_id' => 2,
                'permission_id' => 27,
            ],
            [
                'role_id' => 2,
                'permission_id' => 29,
            ],
            [
                'role_id' => 2,
                'permission_id' => 30,
            ],
        ];

        

        foreach ($rolePermissions as $rolePermission) {
            Permission::create($rolePermission);
        }
    }
}
