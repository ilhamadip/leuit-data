<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sekolah extends Model
{
    use HasFactory;

    // Define fillable attributes
    protected $fillable = [
        'bentuk_pendidikan',
        'nama',
        'npsn',
        'kecamatan',
        'desa',
        'rw',
        'rt',
        'alamat_lengkap',
        'lon',
        'lat',
        'status_data'
    ];
}
