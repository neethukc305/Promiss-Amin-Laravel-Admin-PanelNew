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
}