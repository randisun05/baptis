<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'category_id',
        'image',
        'document',
        'docstatus',
        'imagestatus',
        'user_id',
        'status',
        'publish_at',
    ];




    public function user()
    {
        return $this ->belongsTo(User::class);
    }



}
