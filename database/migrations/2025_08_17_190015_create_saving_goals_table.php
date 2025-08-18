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
        Schema::create('saving_goals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('The user who owns the saving goal');

            $table->string('title')
                ->comment('The title of the saving goal');

            $table->decimal('target_amount', 15, 2)
                ->comment('The target amount for the saving goal');

            $table->decimal('current_amount', 15, 2)
                ->default(0)
                ->comment('The current amount saved towards the goal');

            $table->date('target_date')
                ->nullable()
                ->comment('The target date for achieving the saving goal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_goals');
    }
};
