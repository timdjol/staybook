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
        'type',
        'count'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
