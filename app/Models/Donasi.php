<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'donasi';

    protected $fillable = [
        'judul_donasi',
        'deskripsi',
        'target_donasi',
        'donasi_terkumpul',
        'tanggal_mulai',
        'tanggal_berakhir',
        'gambar',
        'status',
        'is_verified',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function donasiDetail()
    {
        return $this->hasMany(DonasiDetail::class);
    }
}
