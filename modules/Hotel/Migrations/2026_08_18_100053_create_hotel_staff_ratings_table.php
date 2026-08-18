<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bravo_hotel_staff_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->tinyInteger('rating'); // 1-5
            $table->timestamps();

            $table->index('staff_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_hotel_staff_ratings');
    }
};