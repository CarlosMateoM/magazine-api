<?php

namespace Tests\Feature;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Department;
use App\Models\File;
use App\Models\Municipality;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleTest extends TestCase
{

    public function test_create_article(): void
    {

        /*  $writerRole = Role::factory()->create([
            'name' => RoleType::WRITER->value,
        ]);

        'role_id' => $writerRole->id, */

        $user = User::factory()->create([
            'role_id' => 2
        ]);

        $file = File::factory()->create([
            'name' => fake()->word(),
            'hash' => fake()->word(),
            'url' => fake()->url(),
            'type' => 'image',
            'description' => fake()->sentence(),
        ]);

        $author = Author::factory()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'file_id' => $file->id,
            'biography' => fake()->sentence(),
        ]);

        $category = Category::factory()->create([
            'name' => fake()->word(),
            'description' => 'test category description',
        ]);

        $department = Department::factory()->create([
            'name' => fake()->word(),
        ]);

        $municipality = Municipality::factory()->create([
            'name' => fake()->word(),
            'department_id' => $department->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/v1/articles', [
            'title' => fake()->unique()->sentence(),
            'status' => ArticleStatus::DRAFT->value,
            'image' => [
                'id' => $file->id
            ],
            'author' => [
                'id' => $author->id
            ],
            'category' => [
                'id' => $category->id
            ],
            'municipality' => [
                'id' => $municipality->id
            ],
        ]);

        $response->assertStatus(201)->assertJson([
            "id" => $response->json('id'),
            "title" => $response->json('title'),
            "slug" => $response->json('slug'),
            "status" => ArticleStatus::DRAFT->value,
            "summary" => null,
            "views" => null,
            "publishedAt" => null,
        ]);

        $this->assertDatabaseHas('articles', [
            'id' => $response->json('id'),
            'title' => $response->json('title'),
            'slug' => $response->json('slug'),
            'status' => ArticleStatus::DRAFT->value,
            'summary' => null,
            'views' => 0,
            'published_at' => null,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'municipality_id' => $municipality->id,
        ]);
    }

    public function test_update_article(): void
    {
        $user = User::factory()->create([
            'role_id' => 2
        ]);

        $file = File::factory()->create([
            'name' => fake()->word(),
            'hash' => fake()->word(),
            'url' => fake()->url(),
            'type' => 'image',
            'description' => fake()->sentence(),
        ]);

        $author = Author::factory()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'file_id' => $file->id,
            'biography' => fake()->sentence(),
        ]);

        $category = Category::factory()->create([
            'name' => fake()->word(),
            'description' => 'test category description',
        ]);

        $department = Department::factory()->create([
            'name' => fake()->word(),
        ]);

        $municipality = Municipality::factory()->create([
            'name' => fake()->word(),
            'department_id' => $department->id,
        ]);

        $title = fake()->unique()->sentence();

        $article = Article::factory()->create([
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => ArticleStatus::DRAFT->value,
            'user_id' => $user->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'municipality_id' => $municipality->id,
        ]);

        $title = fake()->unique()->sentence();

        $response = $this->actingAs($user)->putJson("/api/v1/articles/{$article->id}", [
            'title' => $title,
            'status' => ArticleStatus::PUBLISHED->value,
            'image' => [
                'id' => $file->id
            ],
            'author' => [
                'id' => $author->id
            ],
            'category' => [
                'id' => $category->id
            ],
            'municipality' => [
                'id' => $municipality->id
            ],
        ]);

        $response->assertStatus(200)->assertJson([
            "id" => $article->id,
            "title" => $title,
            "slug" => Str::slug($title),
            "status" => ArticleStatus::PUBLISHED->value,
            "summary" => null,
            "views" => $response->json('views'),
            "publishedAt" => $response->json('published'),
        ]);
    }

    public function test_delete_article(): void
    {
        $user = User::factory()->create([
            'role_id' => 2
        ]);

        $file = File::factory()->create([
            'name' => fake()->word(),
            'hash' => fake()->word(),
            'url' => fake()->url(),
            'type' => 'image',
            'description' => fake()->sentence(),
        ]);

        $author = Author::factory()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'file_id' => $file->id,
            'biography' => fake()->sentence(),
        ]);

        $category = Category::factory()->create([
            'name' => fake()->word(),
            'description' => 'test category description',
        ]);

        $department = Department::factory()->create([
            'name' => fake()->word(),
        ]);

        $municipality = Municipality::factory()->create([
            'name' => fake()->word(),
            'department_id' => $department->id,
        ]);

        $title = fake()->unique()->sentence();

        $article = Article::factory()->create([
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => ArticleStatus::DRAFT->value,
            'user_id' => $user->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'municipality_id' => $municipality->id,
        ]);

        $response = $this->actingAs($user)->delete("/api/v1/articles/{$article->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_show_article(): void
    {
        $user = User::factory()->create([
            'role_id' => 1
        ]);

        $file = File::factory()->create([
            'name' => fake()->word(),
            'hash' => fake()->word(),
            'url' => fake()->url(),
            'type' => 'image',
            'description' => fake()->sentence(),
        ]);

        $author = Author::factory()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'file_id' => $file->id,
            'biography' => fake()->sentence(),
        ]);

        $category = Category::factory()->create([
            'name' => fake()->word(),
            'description' => 'test category description',
        ]);

        $department = Department::factory()->create([
            'name' => fake()->word(),
        ]);

        $municipality = Municipality::factory()->create([
            'name' => fake()->word(),
            'department_id' => $department->id,
        ]);

        $title = fake()->unique()->sentence();

        $article = Article::factory()->create([
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => ArticleStatus::DRAFT->value,
            'user_id' => $user->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'municipality_id' => $municipality->id,
        ]);

        $response = $this->actingAs($user)->get("/api/v1/articles/{$article->id}");

        $response->assertStatus(200)->assertJson([
            "id" => $article->id,
            "title" => $article->title,
            "slug" => $article->slug,
            "status" => $article->status,
            "summary" => $article->summary,
            "views" => $article->views,
            "publishedAt" => $article->published_at,
        ]);
    }

    public function test_reader_cannot_show_article():void
    {
        $user = User::factory()->create([
            'role_id' => 2
        ]);

        $file = File::factory()->create([
            'name' => fake()->word(),
            'hash' => fake()->word(),
            'url' => fake()->url(),
            'type' => 'image',
            'description' => fake()->sentence(),
        ]);

        $author = Author::factory()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'file_id' => $file->id,
            'biography' => fake()->sentence(),
        ]);

        $category = Category::factory()->create([
            'name' => fake()->word(),
            'description' => 'test category description',
        ]);

        $department = Department::factory()->create([
            'name' => fake()->word(),
        ]);

        $municipality = Municipality::factory()->create([
            'name' => fake()->word(),
            'department_id' => $department->id,
        ]);

        $title = fake()->unique()->sentence();

        $article = Article::factory()->create([
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => ArticleStatus::DRAFT->value,
            'user_id' => $user->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'municipality_id' => $municipality->id,
        ]);

        $response = $this->actingAs($user)->get("/api/v1/articles/{$article->id}");

        $response->assertStatus(403);
    }
}
