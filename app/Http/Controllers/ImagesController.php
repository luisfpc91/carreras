<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\images;
use Illuminate\Support\Facades\Storage;


class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $path = public_path();
        $imageName = time(microtime(true));
        $img_escuderia = $request->file('file');     

        $tmp_name = md5(($img_escuderia->getClientOriginalName()).$imageName.'.'.($img_escuderia->getClientOriginalExtension()));

        $img_escuderia->move($path.'/upload', $tmp_name.'.'.$img_escuderia->getClientOriginalExtension());

        $image = array(
            'name' => $tmp_name,
            'url' => 'upload/'.$tmp_name.'.'.$img_escuderia->getClientOriginalExtension()
            );
        $id_img = images::insertGetId($image);

        return response()->json($res = array(
            'code' => 0,
            'status' => 'success',
            'id' => $id_img
            ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
