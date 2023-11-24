<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'id',
        'id_tutor',
        'id_blog',
        'id_member',
        'active',
        'day',
        'hour',
        'location'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class,'id_tutor');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class,'id_blog');
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'id_member');
    }
}
