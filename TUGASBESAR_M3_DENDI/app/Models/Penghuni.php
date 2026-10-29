<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $fillable = [
        'nama_lengkap', 'no_ktp', 'pekerjaan', 'no_hp', 'kontak_darurat', 'hubungan_kontak_darurat'
    ];
}