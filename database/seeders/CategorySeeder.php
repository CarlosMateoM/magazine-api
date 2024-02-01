<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sincelejo',
                'description' => 'Noticias de Sincelejo'
            ],
            [
                'name' => 'Deportes',
                'description' => 'Noticias de Deportes'
            ],
            [
                'name' => 'Regionales',
                'description' => 'Noticias de Regionales'
            ],
            [
                'name' => 'Culturales',
                'description' => 'Noticias de Culturales'
            ],
            [
                'name' => 'Entretenimiento',
                'description' => 'Noticias de Entretenimiento'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
