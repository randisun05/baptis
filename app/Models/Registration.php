<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal (Mass Assignment).
     * Disesuaikan dengan kolom yang ada di file migration.
     */
    protected $fillable = [
        'number',
        'name',
        'gender',
        'email',
        'contact',
        'group',      // Di migration tipe boolean
        'publish_at',
        'status',
    ];

    /**
     * Konfigurasi Primary Key UUID.
     */
    protected $keyType = 'string'; 
    protected $primaryKey = 'id'; 
    public $incrementing = false; 

    /**
     * Casting tipe data otomatis.
     * Penting karena di migration 'gender' dan 'group' adalah boolean (0/1),
     * tapi kita ingin Laravel menganggapnya true/false.
     */
    protected $casts = [
        'gender' => 'boolean',
        'group'  => 'boolean',
        'publish_at' => 'datetime',
    ];

    /**
     * Boot function untuk generate UUID otomatis saat create.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->id = (string) Str::orderedUuid();
            }
        });
    }
}