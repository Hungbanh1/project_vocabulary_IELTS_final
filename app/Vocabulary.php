<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vocabulary extends Model
{
    //
    protected $table = 'vocabularies';
    protected $fillable = [
        'id',
        'english',
        'vietnam',
        'type_id'
    ];
    // public function type()
    // {
    //     return $this->hasOne(Type::class, 'type', 'id');
    // }
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
