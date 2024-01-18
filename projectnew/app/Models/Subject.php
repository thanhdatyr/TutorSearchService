<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';

    protected $fillable = [
        'id',
        'name',
        'id_class'
    ];
    public function class()
    {
        return $this->belongsTo(ActiveClass::class,'id_class');
    }
}
