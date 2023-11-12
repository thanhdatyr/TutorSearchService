<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistBlog extends Model
{
    use HasFactory;

    protected $table = 'wishlistblog';

    protected $fillable = [
        'id',
        'id_tutor',
        'id_blog'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class,'id_blog');
    }

}
