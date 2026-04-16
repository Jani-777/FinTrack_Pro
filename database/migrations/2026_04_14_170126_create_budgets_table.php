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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id('budget_id'); // PK [cite: 94]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK [cite: 95]
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade'); // FK [cite: 96]
            $table->decimal('amount_limit', 15, 2); // [cite: 97]
            $table->date('month_year'); // [cite: 98]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
