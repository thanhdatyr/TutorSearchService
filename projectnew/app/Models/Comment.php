<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';

    protected $fillable = [
        'id',
        'id_member',
        'id_tutor',
        'content'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class,'id_member');
    }
    public function tutor()
    {
        return $this->belongsTo(Tutor::class,'id_tutor');
    }
}
