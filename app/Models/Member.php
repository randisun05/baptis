<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'email',
        'contact',
        'status',
        'password',
        'code-password',
        'group',
    ];

    protected $hidden = [
        'password',
    ];
     // --- DEFINISI RELATIONSHIP UNTUK EAGER LOADING ---

    // Relasi untuk Data Katekumen (Asumsi HasOne dan menggunakan 'number')
    public function dataKatekumen(): HasOne
    {
        // Parameter: (Model Tujuan, Kunci Asing di Model Tujuan, Kunci Lokal di Model Ini)
        return $this->hasOne(DataKatekumen::class, 'number', 'number');
    }

    // Relasi untuk Data Riwayat (Asumsi HasOne dan menggunakan 'number')
    public function dataRiwayat(): HasOne
    {
        return $this->hasOne(DataRiwayat::class, 'number', 'number');
    }

    // Relasi untuk Data Menikah (Asumsi HasOne dan menggunakan 'number')
    public function dataMenikah(): HasOne
    {
        return $this->hasOne(DataMenikah::class, 'number', 'number');
    }

    // Relasi untuk Data Baptis (Asumsi HasOne dan menggunakan 'number')
    public function dataBaptis(): HasOne
    {
        return $this->hasOne(DataBaptis::class, 'number', 'number');
    }

    // Relasi untuk Data Keluarga (Asumsi HasMany karena bisa banyak record per Member)
    public function dataKeluarga(): HasMany
    {
        return $this->hasMany(DataKeluarga::class, 'number', 'number');
    }
}