<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class escuderia extends Model
{
    protected $table = 'escuderias';
    public $fillable = ['cod_escuderia', 'nom_escuderia', 'img_escuderia'];
    public $timestamps = false;
}
