<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HijabSupport extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
    ];
    protected static function booted()
    {
        static::creating(function ($kumanya) {
            $kumanya->amount = 50;
        });
    }
}
