<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lahan',
        'luas_lahan',
        'komoditas',
        'kota',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}