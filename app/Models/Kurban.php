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
        'amount',
        'status',
        'Notes',
        'payment_type',
        'association', // Dernek alanı eklendi
    ];

    // amount alanını otomatik olarak 50'ye ayarlamak için model olayını kullanıyoruz

}
