<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bravo_hotel_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('update_user')->nullable()->after('create_user');
        });
    }

    public function down(): void
    {
        Schema::table('bravo_hotel_staffs', function (Blueprint $table) {
            $table->dropColumn('update_user');
        });
    }
};