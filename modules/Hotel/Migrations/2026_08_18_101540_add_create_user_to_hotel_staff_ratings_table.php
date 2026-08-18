<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bravo_hotel_staff_ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('create_user')->nullable()->after('rating');
            $table->unsignedBigInteger('update_user')->nullable()->after('create_user');
        });
    }

    public function down(): void
    {
        Schema::table('bravo_hotel_staff_ratings', function (Blueprint $table) {
            $table->dropColumn(['create_user', 'update_user']);
        });
    }
};