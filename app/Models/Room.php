<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'title_en',
        'description',
        'description_en',
        'price',
        'price2',
        'image',
        'hotel_id',
        'count',
        'pricec',
        'pricec2',
        'pricec3',
        'pricec4',
        'pricec5',
        'pricec6',
        'pricec7',
        'pricec8',
        'pricec9',
        'pricec10',
        'pricec11',
        'pricec12',
        'pricec13',
        'pricec14',
        'pricec15',
        'pricec16',
        'pricec17',
        'status',
        'include',
        'markup',
        'extra_place',
        'cancelled',
        'bed',
        'cancel_fix',
        'cancel_percent',
        'cancel_day',
        'area',
        'services',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'images');
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

}
