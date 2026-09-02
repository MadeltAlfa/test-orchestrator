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
        Schema::create('position_indicator', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('position_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('indicator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('weight', 5, 2)
                ->default(1);
            $table->timestamps();
            $table->unique([
                'position_id',
                'indicator_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_indicator');
    }
};
