<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class piloto extends Model
{
    protected $table = 'pilotos';
    public $fillable = ['doc_piloto', 'nom_piloto', 'cod_escuderia', 'fec_nacimiento', 'img_piloto'];
    public $timestamps = false;
}
