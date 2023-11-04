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
}
