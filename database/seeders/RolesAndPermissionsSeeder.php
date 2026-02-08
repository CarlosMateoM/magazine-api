<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpia cache de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 🔹 Lista de permisos
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

        // 🔹 Crear permisos (guard = web)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 🔹 Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $writer = Role::firstOrCreate(['name' => 'writer', 'guard_name' => 'web']);

        // 🔹 Asignar permisos a cada rol
        $admin->givePermissionTo(Permission::all());

        $writerPermissions = [
            'read_articles',
            'create_articles',
            'update_articles',
            'read_categories',
            'read_sections',
            'read_authors',
        ];
        $writer->syncPermissions($writerPermissions);

        // Limpia cache de nuevo
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
