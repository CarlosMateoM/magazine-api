<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keywords = [
            ['name' => 'política'],
            ['name' => 'economía'],
            ['name' => 'deportes'],
            ['name' => 'cultura'],
            ['name' => 'salud'],
            ['name' => 'educación'],
            ['name' => 'tecnología'],
            ['name' => 'entretenimiento'],
            ['name' => 'ciencia'],
            ['name' => 'internacional'],
            ['name' => 'nacional'],
            ['name' => 'local'],
            ['name' => 'seguridad'],
            ['name' => 'justicia'],
            ['name' => 'sociedad'],
            ['name' => 'ambiente'],
            ['name' => 'turismo'],
            ['name' => 'innovación'],
            ['name' => 'negocios'],
            ['name' => 'finanzas'],
            ['name' => 'agricultura'],
            ['name' => 'energía'],
            ['name' => 'medioambiente'],
            ['name' => 'sostenibilidad'],
            ['name' => 'gobierno'],
            ['name' => 'infraestructura'],
            ['name' => 'pandemia'],
            ['name' => 'vacunas'],
            ['name' => 'salud pública'],
            ['name' => 'medicina'],
            ['name' => 'cultura digital'],
            ['name' => 'medios'],
            ['name' => 'televisión'],
            ['name' => 'música'],
            ['name' => 'cine'],
            ['name' => 'fotografía'],
            ['name' => 'gastronomía'],
            ['name' => 'arquitectura'],
            ['name' => 'opinión'],
            ['name' => 'moda'],
            ['name' => 'lifestyle'],
            ['name' => 'policía'],
            ['name' => 'corrupción'],
            ['name' => 'transporte'],
            ['name' => 'emprendimiento'],
            ['name' => 'vivienda'],
            ['name' => 'justicia social'],
            ['name' => 'desigualdad'],
            ['name' => 'elecciones'],
            ['name' => 'cambio climático']
        ];
        
        foreach ($keywords as $keyword) {
            \App\Models\Keyword::create($keyword);
        }
    }
}
