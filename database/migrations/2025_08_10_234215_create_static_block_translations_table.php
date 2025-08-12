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
        Schema::create('static_block_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_block_id')->constrained()->onDelete('cascade');
            $table->string('locale', 2)->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->timestamps();

            $table->unique(['static_block_id', 'locale']);
            $table->unique(['static_block_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_block_translations');
    }
};
