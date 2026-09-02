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
       Schema::create('assessment_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('assessment_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('indicator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('indicator_name');
            $table->integer('score');
            $table->text('notes')
                ->nullable();
            $table->timestamps();
            $table->unique([
                'assessment_id',
                'indicator_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_scores');
    }
};
