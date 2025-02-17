<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminPermissions = Permission::all();
        $writerPermissions = [
            // Usuarios
            'read_users',
            'create_users',
            'update_users',
            'delete_users',

            // Autores
            'read_authors',
            'create_authors',
            'update_authors',
            'delete_authors',

            // Artículos
            'read_articles',
            'create_articles',
            'update_articles',
            'delete_articles',

            // Palabras clave
            'read_keywords',
            'create_keywords',
            'update_keywords',
            'delete_keywords',

            //galeria
            'read_galleries',
            'create_galleries',
            'update_galleries',
            'delete_galleries',

            //redes_sociales
            'read_social_media',
            'create_social_media',
            'update_social_media',
            'delete_social_media',

            // Secciones
            'read_sections',

            // Municipios
            'read_municipalities',

            // Departamentos
            'read_departments',

            // Categorías
            'read_categories',
        ];

        $readerPermissions = [

            //News_Letter_Subscription
            'read_newsletter_subscription',
            'create_newsletter_subscription',
            'update_newsletter_subscription',
            'delete_newsletter_subscription',

            // Artículos
            'read_articles',

            // Categorías
            'read_categories',

            // Secciones
            'read_sections',

            // Palabras clave
            'read_keywords',

            // Autores
            'read_authors',

            // Municipios
            'read_municipalities',

            // Departamentos
            'read_departments',

            //anuncios
            'read_advertisements',

            // Secciones del sitio web
            'read_website_sections',
        ];

        $writerRol = Role::findByName('writer', 'web');
        $readerRol = Role::findByName('reader', 'web');
        $adminRol = Role::findByName('admin', 'web');

        $writerRol->syncPermissions($writerPermissions);
        $readerRol->syncPermissions($readerPermissions);
        $adminRol->syncPermissions($adminPermissions);


    }
}
