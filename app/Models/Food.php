<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    use Translatable;

    protected $fillable = [
        'room_id',
        'hotel_id',
        'title',
        'title_en',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
