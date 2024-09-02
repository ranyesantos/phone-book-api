<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'profile_picture',
    ];
    protected $dates = ['deleted_at'];
}
