<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'id',
        'name',
        'password',
        'id_country',
        'id_district',
        'email',
        'phone',
        'address',
        'level',
        'active'
    ];
}
