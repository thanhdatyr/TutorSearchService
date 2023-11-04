<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $fillable = [
        'id',
        'title',
        'id_member',
        'id_class',
        'id_subject',
        'price',
        'content',
        'date',
        'active',
        'id_country',
        'id_district'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class,'id_member');
    }

    public function toClass()
    {
        return $this->belongsTo(ActiveClass::class,'id_class');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'id_subject');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'id_country');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'id_district');
    }
}
