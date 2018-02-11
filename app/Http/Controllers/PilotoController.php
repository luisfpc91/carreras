<?php

namespace App\Http\Controllers;

use App\piloto;
use Illuminate\Http\Request;
use App\images;
use Carbon\Carbon;

class PilotoController extends Controller
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
                $data = piloto::join('escuderias','pilotos.cod_escuderia','=','escuderias.cod_escuderia')
                ->select(
                    'pilotos.*',
                    'escuderias.cod_escuderia as escuderia_cod',
                    'escuderias.nom_escuderia as escuderia_name'
                    )
                ->get();

                foreach ($data as $i) {
                    $img = images::find($i->img_piloto);
                    $img['url'] = config('app.url').$img['url'];
                    $i->image = $img;
                }

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
        $doc_piloto = $request->doc_piloto;
        $nom_piloto = $request->nom_piloto;
        $cod_escuderia = $request->cod_escuderia;
        $fec_nacimiento = $request->fec_nacimiento;
        $img_piloto = $request->img_piloto;

        if(!isset($doc_piloto)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el documneto del piloto'
                ));
        }else
            if(piloto::where('doc_piloto',$doc_piloto)->exists())
                return response()->json($res = array(
                    'code' => 3,
                    'status' => 'fail',
                    'msj' => 'El Documento ya existe'
                    ));

        if(!isset($nom_piloto)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el nombre del piloto'
                ));
        }

        if(!isset($cod_escuderia)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el Código de la escuderia'
                ));
        }

        if(!isset($fec_nacimiento)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar la fecha de nacimineto del piloto'
                ));
        }

        if(!isset($img_piloto)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar la imagen del piloto'
                ));
        } 

        $values = array(
            'doc_piloto' => $doc_piloto,
            'nom_piloto' => $nom_piloto,
            'cod_escuderia' => $cod_escuderia, 
            'fec_nacimiento' => Carbon::parse($fec_nacimiento), 
            'img_piloto' => $img_piloto
            );

        if(piloto::create($values)){
            return response()->json($res = array(
                'code' => 0,
                'status' => 'success',
                'msj' => 'piloto agregado exitosamente'
                ));
        }else
            return response()->json($res = array(
                'code' => 2,
                'status' => 'fail',
                'msj' => 'Fallo al agregar el piloto'
                ));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\piloto  $piloto
     * @return \Illuminate\Http\Response
     */
    public function show(piloto $piloto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\piloto  $piloto
     * @return \Illuminate\Http\Response
     */
    public function edit(piloto $piloto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\piloto  $piloto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, piloto $piloto)
    {
        $doc_piloto = $request->doc_piloto;
        $nom_piloto = $request->nom_piloto;
        $cod_escuderia = $request->cod_escuderia;
        $fec_nacimiento = $request->fec_nacimiento;
        $img_piloto = $request->img_piloto;       
        $values = array();    
        
        if(isset($nom_piloto))        
            $values['nom_piloto'] = $nom_piloto;    

        if(isset($cod_escuderia))        
            $values['cod_escuderia'] = $cod_escuderia; 

        if(isset($fec_nacimiento))        
            $values['fec_nacimiento'] = Carbon::parse($fec_nacimiento); 

        if(isset($img_piloto))       
            $values['img_piloto'] = $img_piloto; 

        piloto::where('doc_piloto', $doc_piloto)->update($values);
        
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Escuderia editada'
            ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\piloto  $piloto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $doc_piloto = $request->doc_piloto;
        $data = piloto::where('doc_piloto', $doc_piloto)->delete();
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Piloto eliminado' 
            ));
    }
}
