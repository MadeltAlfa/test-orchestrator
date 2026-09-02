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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('assessment_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('position_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('score', 8, 2);
            $table->integer('ranking')
                ->nullable();
            $table->timestamps();
            $table->unique([
                'assessment_id',
                'position_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
