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
        Schema::create('test_guide_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('test_guide_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('section_title');
            $table->longText('content');
            $table->integer('sort_order')
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_guide_sections');
    }
};
