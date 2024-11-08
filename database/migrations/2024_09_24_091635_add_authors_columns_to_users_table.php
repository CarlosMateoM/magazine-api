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
        Schema::table('users', function (Blueprint $table) {
            $table->string('biography')->nullable();
            $table->boolean('is_public_author')->default(false);
            $table->boolean('is_locked_account')->default(false);
            
            $table->foreignId('file_id')->nullable()
                ->constrained()->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('biography');
            $table->dropColumn('is_author');
            $table->dropColumn('is_locked_account');
            $table->dropForeign(['file_id']);
            $table->dropColumn('file_id');
        });
    }
};
