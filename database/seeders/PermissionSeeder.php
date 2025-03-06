<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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

            //anuncios
            'read_advertisements',
            'create_advertisements',
            'update_advertisements',
            'delete_advertisements',

            //Archivos
            'read_files',
            'create_files',
            'update_files',
            'delete_files',

            //redes_sociales
            'read_social_media',
            'create_social_media',
            'update_social_media',
            'delete_social_media',

            //galeria
            'read_galleries',
            'create_galleries',
            'update_galleries',
            'delete_galleries',

            //vista_archivos
            'read_files_views',
            'create_files_views',
            'update_files_views',
            'delete_files_views',

            //News_Letter_Subscription
            'read_newsletter_subscription',
            'create_newsletter_subscription',
            'update_newsletter_subscription',
            'delete_newsletter_subscription',

            //vista_articulos
            'read_article_views',
            'create_article_views',
            'update_article_views',
            'delete_article_views',

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
            Permission::firstOrCreate(["name" => $permission]);
        }

    }
}
