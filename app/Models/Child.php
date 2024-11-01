<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $table = 'childs';

    use Translatable;

    protected $fillable = [
        'hotel_id',
        'room_id',
        'without_place',
        'price_without',
        'extra_place',
        'price_extra',
        'age_to',
        'age_from'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
