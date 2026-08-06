<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bravo_hotel_staffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id'); // hotel/shop id
            $table->string('name');
            $table->string('title')->nullable(); // e.g. "Senior Barber"
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('status')->default('publish');
            $table->unsignedBigInteger('create_user')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bravo_hotel_staffs');
    }
};