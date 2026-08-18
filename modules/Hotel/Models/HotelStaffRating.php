<?php

namespace Modules\Hotel\Models;

use App\BaseModel;

class HotelStaffRating extends BaseModel
{
    protected $table = 'bravo_hotel_staff_ratings';

    protected $fillable = [
        'staff_id',
        'booking_id',
        'customer_id',
        'rating',
    ];
}