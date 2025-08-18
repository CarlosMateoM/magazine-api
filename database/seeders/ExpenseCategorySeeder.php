<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ExpenseCategories = [
            ['name' => 'Arriendo'],
            ['name' => 'Internet'], 
            ['name' => 'Transporte'],
            ['name' => 'Desayunos'],
            ['name' => 'Ocio'],
            ['name' => 'Compras personales'],
            ['name' => 'Metas de ahorro'],
            ['name' => 'Otros'],
        ];

        ExpenseCategory::insert($ExpenseCategories);
    }
}
