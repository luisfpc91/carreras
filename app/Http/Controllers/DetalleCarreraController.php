<?php

namespace App\Http\Controllers;

use App\detalle_carrera;
use Illuminate\Http\Request;

class DetalleCarreraController extends Controller
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
                $data = detalle_carrera::join(
                    'carreras', 'detalle_carreras.nro_carrera', '=', 'carreras.nro_carrera')
                ->join('pilotos', 'detalle_carreras.doc_piloto', '=', 'pilotos.doc_piloto')
                ->select(
                    'detalle_carreras.*',
                    'carreras.nro_carrera as carrera_nro',
                    'carreras.pais as carrera_pais',
                    'pilotos.doc_piloto as piloto_doc',
                    'pilotos.nom_piloto as piloto_name'
                    )
                ->orderBy('detalle_carreras.seq_carrera')
                ->get();

                return response()->json($res = array(
                    'code' => 0,
                    'status' => 'success',
                    'data' => $data
                    ));

                break;
            
            case 'tablero':
                # code...
                break;
        }
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
        $seq_carrera = $request->seq_carrera;
        $nro_carrera = $request->nro_carrera;
        $doc_piloto = $request->doc_piloto;
        $pos_salida = $request->pos_salida;
        $pos_final = $request->pos_final;
        $vueltas = $request->vueltas;

        if(!isset($seq_carrera)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el seq_carrera'
                ));
        }else
            if(detalle_carrera::where('seq_carrera',$seq_carrera)->exists())
                return response()->json($res = array(
                    'code' => 3,
                    'status' => 'fail',
                    'msj' => 'El seq_carrera ya existe'
                    ));

        if(!isset($nro_carrera)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar número de la carrera'
                ));
        }

        if(!isset($doc_piloto)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar dócumento del piloto'
                ));
        }

        if(!isset($pos_salida)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar posición final'
                ));
        }

        if(!isset($pos_final)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar posición final'
                ));
        } 

        if(!isset($vueltas)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar número de vueltas'
                ));
        }  

        $values = array(
            'seq_carrera' => $seq_carrera, 
            'nro_carrera' => $nro_carrera, 
            'doc_piloto' => $doc_piloto,
            'pos_salida' => $pos_salida,
            'pos_final' => $pos_final,
            'vueltas' => $vueltas
            );
        if(detalle_carrera::create($values)){
            return response()->json($res = array(
                'code' => 0,
                'status' => 'success',
                'msj' => 'Detalles de carrera agregados exitosamente'
                ));
        }else{
            return response()->json($res = array(
                'code' => 2,
                'status' => 'fail',
                'msj' => 'Fallo al agregar los detalles de la carrera'
                ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\detalle_carrera  $detalle_carrera
     * @return \Illuminate\Http\Response
     */
    public function show(detalle_carrera $detalle_carrera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\detalle_carrera  $detalle_carrera
     * @return \Illuminate\Http\Response
     */
    public function edit(detalle_carrera $detalle_carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\detalle_carrera  $detalle_carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detalle_carrera $detalle_carrera)
    {
        $seq_carrera = $request->seq_carrera;
        $nro_carrera = $request->nro_carrera;
        $doc_piloto = $request->doc_piloto;
        $pos_salida = $request->pos_salida;
        $pos_final = $request->pos_final;
        $vueltas = $request->vueltas; 
        $values = array(); 
        
        if(isset($nro_carrera))        
            $values['nro_carrera'] = $nro_carrera; 

        if(isset($doc_piloto))        
            $values['doc_piloto'] = $doc_piloto;

        if(isset($pos_salida))        
            $values['pos_salida'] = $pos_salida;

        if(isset($pos_final))        
            $values['pos_final'] = $pos_final;

        if(isset($vueltas))        
            $values['vueltas'] = $vueltas;

        detalle_carrera::where('seq_carrera', $seq_carrera)->update($values);
        
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Detalles editada'
            ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\detalle_carrera  $detalle_carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $seq_carrera = $request->seq_carrera;
        $data = detalle_carrera::where('seq_carrera', $seq_carrera)->delete();
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Detalles eliminados' 
            ));
    }
}
