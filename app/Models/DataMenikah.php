<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMenikah extends Model
{
    use HasFactory;
 protected $fillable = [
        'number',
        'statusMarried',
        'namePasangan',
        'religionPasangan',
        'placeMarried1',
        'cityMarried1',
        'dateMarried1',
        'namePeneguh1',
        'numberMarried1',
        'placeMarried2',
        'cityMarried2',
        'dateMarried2',
        'namePeneguh2',
        'numberMarried2',
        'cityMarried3',
        'dateMarried3',
        'numberMarried3',
        'placeMarried4',
        'cityMarried4',
        'namePeneguh4',
        'dateMarried4',
        'numberMarried4',
        'nameMantan',
        'cityMantan',
        'statusMantan',
        'yearMantan',
    ];

}
