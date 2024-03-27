<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Volunteer extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
