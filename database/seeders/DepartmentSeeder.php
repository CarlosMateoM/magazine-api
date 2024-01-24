<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Sucre'
            ],
            [
                'name' => 'Cordoba'
            ],
            [
                'name' => 'Bolivar'
            ],
            [
                'name' => 'Atlantico'
            ],
            [
                'name' => 'Magdalena'
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
