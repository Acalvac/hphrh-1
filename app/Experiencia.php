<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    //
    protected $table='personaexperiencia';
    protected $primaryKey='idpexperiencia';

    public $timestamps=false;

    protected $fillable=[
    	'empresa',
    	'puesto',
    	'jefeinmediato',
        'teljefeinmediato',
    	'motivoretiro',
    	'ultimosalario',
    	'fingresoex',
    	'fsalidaex',
    	'idempleado',
    	'identificacion',
        'recomiendaexp',
        'confirmadorexp',
        'observacion',
    ];

    protected $guarder=[

    ];
}
