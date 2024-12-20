<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->text('summary');
            $table->string('slug')->unique();
            $table->enum('status', ['draft', 'published', 'unpublished'])->default('draft');    
            $table->date('published_at')->nullable();

            $table->foreignId('author_id')
                    ->constrained('authors');   
            $table->foreignId('file_id')
                    ->nullable()->constrained('files');
            $table->foreignId('category_id')
                    ->nullable()->constrained('categories');
            $table->foreignId('municipality_id')
                    ->nullable()->constrained('municipalities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
