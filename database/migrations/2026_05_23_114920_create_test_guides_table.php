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
         Schema::create('test_guides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('test_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title');
            $table->longText('description')
                ->nullable();
            $table->string('image')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_guides');
    }
};
