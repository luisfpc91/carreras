<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carrera extends Model
{
    protected $table = 'carreras';
    public $fillable = ['nro_carrera', 'fec_carrera', 'pais', 'vueltas_totales'];
    public $timestamps = false;
}
