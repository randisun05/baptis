<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'year_number',
        'place_birth',
        'date_birth',
        'gender',
        'address',
        'education',
        'father_name',
        'father_religion',
        'father_address',
        'mother_name',
        'mother_religion',
        'mother_address',
        'guardian_name',
        'name',
        'email',
        'contact',
        'document',
        'status',
        'info',
        'emailstatus',
        'user_id',
    ];

    protected $keyType = 'string'; // Menetapkan tipe kunci ke string
    protected $primaryKey = 'id'; // Menetapkan nama primary key
    public $incrementing = false; // Menonaktifkan auto increment

    protected static function boot()
    {
        parent::boot();

        
        static::creating(function ($model) {
            // Menggunakan ULID saat membuat instance baru
            $model->id = (string) Str::orderedUuid();
        });
    }

}
