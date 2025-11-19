<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'code-password',
        'qr_link'
    ];

    protected $hidden = [
        'email',
        'password',
    ];


}
