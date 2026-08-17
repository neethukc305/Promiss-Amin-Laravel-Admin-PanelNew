<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bravo_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->nullable()->after('object_model');
            $table->boolean('is_first_visit')->nullable()->after('customer_notes');
        });
    }

    public function down(): void
    {
        Schema::table('bravo_bookings', function (Blueprint $table) {
            $table->dropColumn(['staff_id', 'is_first_visit']);
        });
    }
};