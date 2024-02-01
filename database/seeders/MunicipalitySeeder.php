<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            [
                'name' => 'Sincelejo',
                'department_id' => 1
            ],
            [
                'name' => 'Corozal',
                'department_id' => 1
            ],
            [
                'name' => 'Sampues',
                'department_id' => 1
            ],
            [
                'name' => 'Tolu',
                'department_id' => 1
            ],
            [
                'name' => 'San Onofre',
                'department_id' => 1
            ],
            [
                'name' => 'Santiago de Tolu',
                'department_id' => 1
            ],
            [
                'name' => 'San Marcos',
                'department_id' => 1
            ],
            [
                'name' => 'San Benito Abad',
                'department_id' => 1
            ],
            [
                'name' => 'San Juan de Betulia',
                'department_id' => 1
            ],
            [
                'name' => 'San Pedro',
                'department_id' => 1
            ],
            [
                'name' => 'San Luis de Sincé',
                'department_id' => 1
            ],
            [
                'name' => 'San Antonio de Palmito',
                'department_id' => 1
            ],
            [
                'name' => 'San Onofre',
                'department_id' => 1
            ],
            [
                'name' => 'San Juan de Uraba',
                'department_id' => 2
            ],
            [
                'name' => 'San Pedro de Uraba',
                'department_id' => 2
            ],
            [
                'name' => 'San Pelayo',
                'department_id' => 2
            ],
            [
                'name' => 'San Carlos',
                'department_id' => 2
            ],
            [
                'name' => 'San Bernardo del Viento',
                'department_id' => 2
            ],
            [
                'name' => 'San Andres de Sotavento',
                'department_id' => 2
            ],
            [
                'name' => 'Sahagun',
                'department_id' => 2
            ],
            [
                'name' => 'Monteria',
                'department_id' => 2
            ],
            [
                'name' => 'Momil',
                'department_id' => 2
            ],
            [
                'name' => 'Moñitos',
                'department_id' => 2
            ],
            [
                'name' => 'Montelibano',
                'department_id' => 2
            ],
            [
                'name' => 'Montelíbano',
                'department_id' => 2
            ],
            [
                'name' => 'Los Cordobas',
                'department_id' => 2
            ],
            [
                'name' => 'Los Córdobas',
                'department_id' => 2
            ],
            [
                'name' => 'Lorica',
                'department_id' => 2
            ]  
        ];


        foreach ($municipalities as $municipality) {
            Municipality::create($municipality);
        }
    }
}
