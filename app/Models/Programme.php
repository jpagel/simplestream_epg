<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    public $table = 'programme';
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'visible_name',
        'description',
        'thumbnail_ref',
        'duration'
    ];
}
