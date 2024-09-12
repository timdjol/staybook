<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $fillable = [
        'code',
        'room_id',
        'hotel_id',
        'title',
        'title_en',
        'product_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
