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
         Schema::create('test_norms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('test_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('category');
            $table->decimal('min_value', 8, 2)
                ->nullable();
            $table->decimal('max_value', 8, 2)
                ->nullable();
            $table->integer('score');
            $table->enum('operator', [
                'between',
                'less_than',
                'greater_than',
                'less_equal',
                'greater_equal'
            ])->default('between');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_norms');
    }
};
