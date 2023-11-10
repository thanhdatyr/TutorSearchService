<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistMember extends Model
{
    use HasFactory;

    protected $table = 'wishlistmember';

    protected $fillable = [
        'id',
        'id_member',
        'id_tutor'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class,'id_member');
    }
}
