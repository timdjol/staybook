<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rules';

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
