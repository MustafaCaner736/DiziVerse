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
    Schema::create('films', function (Blueprint $table) {
        $table->id();
        $table->string('imdb_id')->unique();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('poster_url')->nullable();
        $table->decimal('rating', 3, 1)->nullable();
        $table->year('year')->nullable();
        $table->json('cast')->nullable();
        $table->string('trailer_url')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
