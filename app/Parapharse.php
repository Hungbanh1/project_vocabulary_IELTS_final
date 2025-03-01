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
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id', 'id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

}