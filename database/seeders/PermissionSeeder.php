<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Artículos
            'read_articles',
            'create_articles',
            'update_articles',
            'delete_articles',
        
            // Categorías
            'read_categories',
            'create_categories',
            'update_categories',
            'delete_categories',
        
            // Secciones del sitio web
            'read_website_sections',
            'create_website_sections',
            'update_website_sections',
            'delete_website_sections',
        
            // Secciones
            'read_sections',
            'create_sections',
            'update_sections',
            'delete_sections',
        
            // Palabras clave
            'read_keywords',
            'create_keywords',
            'update_keywords',
            'delete_keywords',
        
            // Autores
            'read_authors',
            'create_authors',
            'update_authors',
            'delete_authors',
        
            // Municipios
            'read_municipalities',
            'create_municipalities',
            'update_municipalities',
            'delete_municipalities',
        
            // Departamentos
            'read_departments',
            'create_departments',
            'update_departments',
            'delete_departments',
        
            // Usuarios
            'read_users',
            'create_users',
            'update_users',
            'delete_users',
        
            // Roles
            'read_roles',
            'create_roles',
            'update_roles',
            'delete_roles',
        
            // Permisos
            'read_permissions',
            'create_permissions',
            'update_permissions',
            'delete_permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
    }
}
