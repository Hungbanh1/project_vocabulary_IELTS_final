<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parapharse extends Model
{
    //
    protected $table = 'parapharse';
    protected $fillable = [
        'id',
        'english',
        'vietnam',
        'vocabulary_id',
    ];

}