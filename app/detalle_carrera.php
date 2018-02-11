<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_carrera extends Model
{
    protected $table = 'detalle_carreras';
    public $fillable = ['seq_carrera', 'nro_carrera', 'doc_piloto', 'pos_salida', 'pos_final', 'vueltas'];
    public $timestamps = false;
}
