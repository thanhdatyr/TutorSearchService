<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'tutor';

    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'name',
        'phone',
        'sex',
        'birth',
        'id_country',
        'id_district',
        'address',
        'desc',
        'role',
        'rate',
        'time',
        'level',
        'special',
        'id_class',
        'id_subject',
        'type',
        'schedule',
        'avatar',
        'certificate',
        'active'
    ];

    public function class()
    {
        return $this->belongsTo(ActiveClass::class,'id_class');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'id_subject');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'id_district');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'id_country');
    }
}
