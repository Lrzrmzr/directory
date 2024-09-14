<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactos = Contacto::all();
        return response()->json($contactos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:2|max:100',
            'ap_first' => 'required|string|min:2|max:100',
            'ap_last' => 'required|string|min:2|max:100',
        ];

        $validator = Validator::make($request->input(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $contacto = new Contacto($request->input());
        $contacto->save();
        return response()->json([
            'status' => true,
            'errors' => 'Contacto creado satisfactoritamente'
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        $contacto = Contacto::find($contacto->id);
        $contacto->direcciones;
        $contacto->correos;
        $contacto->telefonos;
        return response()->json([
            'status' => true,
            'data' => $contacto
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacto $contacto)
    {
        $rules = [
            'name' => 'required|string|min:2|max:100',
            'ap_first' => 'required|string|min:2|max:100',
            'ap_last' => 'required|string|min:2|max:100'
        ];

        $validator = Validator::make($request->input(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $contacto->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Contacto actualizado satisfactoriamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        
    }
}
