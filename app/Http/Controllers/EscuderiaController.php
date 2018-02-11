<?php

namespace App\Http\Controllers;

use App\escuderia;
use Illuminate\Http\Request;
use App\images;

class EscuderiaController extends Controller
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
                $data = escuderia::all();

                foreach ($data as $i) {
                    $img = images::find($i->img_escuderia);
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
        $cod_escuderia = $request->cod_escuderia;
        $nom_escuderia = $request->nom_escuderia;
        $img_escuderia = $request->img_escuderia;

        if(!isset($cod_escuderia)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el codigo de la escuderia'
                ));
        }else
            if(escuderia::where('cod_escuderia',$cod_escuderia)->exists())
                return response()->json($res = array(
                    'code' => 3,
                    'status' => 'fail',
                    'msj' => 'El codigo ya existe'
                    ));

        if(!isset($nom_escuderia)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar el nombre de la escuderia'
                ));
        }

        if(!isset($img_escuderia)){
            return response()->json($res = array(
                'code' => 1,
                'status' => 'fail',
                'msj' => 'Debe enviar la imagen de la escuderia'
                ));
        } 

        $values = array(
            'cod_escuderia' => $cod_escuderia, 
            'nom_escuderia' => $nom_escuderia, 
            'img_escuderia' => $img_escuderia
            );
        if(escuderia::create($values)){
            return response()->json($res = array(
                'code' => 0,
                'status' => 'success',
                'msj' => 'Escuderia agregada exitosamente'
                ));
        }else{
            return response()->json($res = array(
                'code' => 2,
                'status' => 'fail',
                'msj' => 'Fallo al agregar la escuderia'
                ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\escuderia  $escuderia
     * @return \Illuminate\Http\Response
     */
    public function show(escuderia $escuderia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\escuderia  $escuderia
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\escuderia  $escuderia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cod_escuderia = $request->cod_escuderia;
        $nom_escuderia = $request->nom_escuderia;
        $img_escuderia = $request->img_escuderia;        
        $values = array();    
        
        if(isset($nom_escuderia))        
            $values['nom_escuderia'] = $nom_escuderia;    

        if(isset($img_escuderia))        
            $values['img_escuderia'] = $img_escuderia; 

        escuderia::where('cod_escuderia', $cod_escuderia)->update($values);
        
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Escuderia editada'
            ));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\escuderia  $escuderia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cod_escuderia = $request->cod_escuderia;
        $data = escuderia::where('cod_escuderia', $cod_escuderia)->delete();
        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'msj' => 'Escuderia eliminada' 
            ));
    }
}
