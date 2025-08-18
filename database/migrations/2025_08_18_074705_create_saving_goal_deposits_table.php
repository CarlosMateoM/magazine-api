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
        Schema::create('saving_goal_deposits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('The user who made the deposit');

            $table->foreignId('saving_goal_id')
                ->constrained('saving_goals')
                ->onDelete('cascade')
                ->comment('The saving goal associated with this deposit');

            $table->decimal('amount', 15, 2)
                ->comment('The amount deposited towards the saving goal');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_goal_deposits');
    }
};
