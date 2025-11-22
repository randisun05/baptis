<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRiwayat extends Model
{
    use HasFactory;


     protected $fillable = [
        'number',
        'religion',
        'location',
        'schedule',
        'dateStart',
        'dateEnd',
        'participateBefore',
        'nameGuru',
        'nameGereja',
        'addressGereja',
        'namePriest',
        'dateBaptis',
        'numberBaptis',
    ];

}
