<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdvertisementOfVolunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'organizer_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
