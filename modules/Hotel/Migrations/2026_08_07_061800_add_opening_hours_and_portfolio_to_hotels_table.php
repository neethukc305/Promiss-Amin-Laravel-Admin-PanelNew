<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bravo_hotels', function (Blueprint $table) {
            $table->text('opening_hours')->nullable()->after('check_out_time');
            $table->text('portfolio_gallery')->nullable()->after('gallery');
        });
    }

    public function down(): void
    {
        Schema::table('bravo_hotels', function (Blueprint $table) {
            $table->dropColumn(['opening_hours', 'portfolio_gallery']);
        });
    }
};