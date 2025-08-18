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
        Schema::create('fixed_expenses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('Foreign key referencing the users table');

            $table->foreignId('expense_category_id')
                ->constrained('expense_categories')
                ->onDelete('cascade')
                ->comment('Foreign key referencing the expense categories table');

            $table->string('name')
                ->comment('Name of the fixed expense');
            $table->text('description')
                ->nullable()
                ->comment('Description of the fixed expense');

            $table->decimal('amount', 10, 2)
                ->comment('Amount of the fixed expense');

            $table->string('frequency')
                ->comment('Frequency of the fixed expense (e.g., monthly, yearly)');

            $table->softDeletes();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_expenses');
    }
};
