<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurban extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'animal_type',
        'sacrifice_date',
        // 'amount' alanını burada belirlemiyoruz çünkü otomatik olarak 50 olarak atanacak
    ];

    // amount alanını otomatik olarak 50'ye ayarlamak için model olayını kullanıyoruz
    protected static function booted()
    {
        static::creating(function ($kurban) {
            $kurban->amount = 150;
        });
    }
}
