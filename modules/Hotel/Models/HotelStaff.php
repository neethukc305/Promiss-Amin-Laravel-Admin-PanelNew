<?php

namespace Modules\Hotel\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Helpers\FileHelper;

class HotelStaff extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bravo_hotel_staffs';

    protected $fillable = [
        'parent_id',
        'name',
        'title',
        'image_id',
        'status',
        'create_user',
    ];

    public static function getModelName()
    {
        return __("Hotel Staff");
    }

    public function getImageUrl($size = 'thumb')
    {
        return FileHelper::url($this->image_id, $size);
    }

    public function ratings()
{
    return $this->hasMany(HotelStaffRating::class, 'staff_id');
}

public function getAverageRating()
{
    $avg = $this->ratings()->avg('rating');
    return $avg ? round($avg, 1) : 0;
}

public function getRatingCount()
{
    return $this->ratings()->count();
}
}