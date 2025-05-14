<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('films', function (Blueprint $table) {
            // featured adlı sütunu ekliyoruz, default false
            $table->boolean('featured')->default(false)->after('trailer_url');
        });
    }

    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            // rollback yaparken kaldır
            $table->dropColumn('featured');
        });
    }
};
