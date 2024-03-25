<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'type',
        'date',
        'localisation',
        'required_skills',
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
