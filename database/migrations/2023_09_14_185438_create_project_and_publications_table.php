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
        Schema::create('project_and_publications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['official', 'personal'])->comment('Official project or Personal project')->nullable();
            $table->string('duration')->comment('start-end');
            $table->string('link')->nullable();
            $table->string('rename_as')->nullable();
            $table->string('technologies_used');
            $table->longText('description');
            $table->string('images');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_and_publications');
    }
};
