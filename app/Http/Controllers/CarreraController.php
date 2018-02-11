<?php

namespace App\Http\Controllers;

use App\carrera;
use App\detalle_carrera;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\images;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $act = $request->act;

        switch ($act) {
            case 'list':
                $data = carrera::all();
                break;
            
            case 'panel':
                $month = $request->month;
                $year = $request->year;
                $date_start = Carbon::createFromDate($year, $month, 01);
                $date_finist = Carbon::createFromDate($year, $month, 31);

                $data = carrera::whereBetween('fec_carrera',[$date_start, $date_finist])->get();

                foreach ($data as $c) {
                    $ranking_escuderias = detalle_carrera::join(
                        'pilotos', function($join){
                            $join->on('detalle_carreras.doc_piloto', '=', 'pilotos.doc_piloto')
                                ->where('detalle_carreras.pos_final','<',4);
                        })
                        ->join('escuderias', 'pilotos.cod_escuderia', '=', 'escuderias.cod_escuderia')
                        ->where('detalle_carreras.nro_carrera',$c->nro_carrera)
                        ->select(DB::raw(
                            'COUNT(pilotos.cod_escuderia) as countEscuderias, escuderias.nom_escuderia, escuderias.img_escuderia'
                            ))
                        ->groupBy(
                            'pilotos.cod_escuderia',
                            'escuderias.nom_escuderia',
                            'escuderias.img_escuderia'
                            )
                        ->orderBy('countEscuderias','desc')
                        ->get();

                    foreach ($ranking_escuderias as $i) {
                        $img = images::find($i->img_escuderia);
                        $img['url'] = config('app.url').$img['url'];
                        $i->image = $img;
                    }    

                    $detalles = detalle_carrera::join(
                        'pilotos', 'detalle_carreras.doc_piloto', '=', 'pilotos.doc_piloto')
                        ->join('escuderias', 'pilotos.cod_escuderia', '=', 'escuderias.cod_escuderia')
                        ->where('detalle_carreras.nro_carrera',$c->nro_carrera)
                        ->select(
                            'detalle_carreras.*',
                            'pilotos.nom_piloto as piloto_name',
                            'pilotos.img_piloto as piloto_img',
                            'pilotos.cod_escuderia as piloto_cod_escuderia',
                            'escuderias.nom_escuderia as escuderia_name',
                            'escuderias.img_escuderia as escuderia_img',
                            'escuderias.cod_escuderia as escuderia_cod' 
                            ) 
                        ->orderBy('detalle_carreras.pos_final')                          
                        ->get();

                    
                    $promedio_vueltas = detalle_carrera::join(
                        'carreras', 'detalle_carreras.nro_carrera', '=', 'carreras.nro_carrera')
                        ->where('detalle_carreras.nro_carrera',$c->nro_carrera)
                        ->select(DB::raw(
                            'AVG(detalle_carreras.vueltas) as promedio'
                            ))
                        ->first();
                    $c->promedio_vueltas = $promedio_vueltas;

                    foreach ($detalles as $i) {
                        $img = images::find($i->piloto_img);
                        $img['url'] = config('app.url').$img['url'];
                        $i->image = $img;
                    }
                    
                    $c->details = $detalles;  


                }
                
                break;
        }

         return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'data' => $data
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nro_carrera = $request->nro_carrera;
        $fec_carrera = $request->fec_carrera;
        $pais = $request->pais;
        $vueltas_totales = $request->vueltas_totales;

        if(!isset($nro_carrera)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el número de la carrera'
                ));
        }else
            if(carrera::where('nro_carrera',$nro_carrera)->exists())
                return response()->json($res = array(
                    'code' => 3,
                    'status' => 'fail',
                    'msj' => 'El número ya existe'
                    ));

        if(!isset($fec_carrera)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar fécha de la carrera'
                ));
        }

        if(!isset($pais)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar país de la carrera'
                ));
        }

        if(!isset($vueltas_totales)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el número de vueltas totales de la carrera'
                ));
        } 

        $values = array(
            'nro_carrera' => $nro_carrera, 
            'fec_carrera' => Carbon::parse($fec_carrera), 
            'pais' => $pais,
            'vueltas_totales' => $vueltas_totales
            );
        if(carrera::create($values)){
            return response()->json($res = array(
                'code' => 0,
                'status' => 'success',
                'msj' => 'Carrera agregada exitosamente'
                ));
        }else{
            return response()->json($res = array(
                'code' => 2,
                'status' => 'fail',
                'msj' => 'Fallo al agregar la carrera'
                ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function show(carrera $carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(carrera $carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, carrera $carrera)
    {
        $nro_carrera = $request->nro_carrera;
        $fec_carrera = $request->fec_carrera;
        $pais = $request->pais;
        $vueltas_totales = $request->vueltas_totales;   
        $values = array(); 
        
        if(isset($fec_carrera))        
            $values['fec_carrera'] = Carbon::parse($fec_carrera); 

        if(isset($pais))        
            $values['pais'] = $pais;

        if(isset($vueltas_totales))        
            $values['vueltas_totales'] = $vueltas_totales;

        carrera::where('nro_carrera', $nro_carrera)->update($values);
        
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Carrera editada'
            ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $nro_carrera = $request->nro_carrera;
        $data = carrera::where('nro_carrera', $nro_carrera)->delete();
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Carrera eliminado' 
            ));
    }
}
