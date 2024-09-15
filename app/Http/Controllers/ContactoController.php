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
        $contactos = Contacto::with(['correos', 'direcciones', 'telefonos'])->get();
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

            'correos.*.correo' => 'nullable|email',
            'direcciones.*.direcciones' => 'nullable|string',
            'telefonos.*.telefono' => 'nullable|string|min:7',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $contacto = Contacto::create($request->only('name', 'ap_first', 'ap_last'));

        // Insertar los correos relacionados
        if ($request->has('correos')) {
            foreach ($request->correos as $correoData) {
                $contacto->correos()->create($correoData);
            }
        }

        // Insertar las direcciones relacionadas
        if ($request->has('direcciones')) {
            foreach ($request->direcciones as $direccionData) {
                $contacto->direcciones()->create($direccionData);
            }
        }

        // Insertar los teléfonos relacionados
        if ($request->has('telefonos')) {
            foreach ($request->telefonos as $telefonoData) {
                $contacto->telefonos()->create($telefonoData);
            }
        }

        return response()->json([
            'status' => true,
            'errors' => 'Contacto creado satisfactoritamente',
            'data' => $contacto->load(['correos', 'direcciones', 'telefonos'])
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        $contacto->load(['correos', 'direcciones', 'telefonos']);
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
            'ap_last' => 'required|string|min:2|max:100',

            'correos.*.correo' => 'nullable|email',
            'direcciones.*.direccion' => 'nullable|string|max:255',
            'telefonos.*.telefono' => 'nullable|string|min:7'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $contacto->update($request->only('name', 'ap_first', 'ap_last'));

         // Actualizar correos existentes o agregar nuevos
        if ($request->has('correos')) {
            foreach ($request->correos as $correoData) {
                if (isset($correoData['id'])) {

                    $correo = $contacto->correos()->find($correoData['id']);
                    if ($correo) {
                        $correo->update($correoData);
                    }
                } else {
                    $contacto->correos()->create($correoData);
                }
            }
        }

        // Actualizar direcciones existentes o agregar nuevas
        if ($request->has('direcciones')) {
            foreach ($request->direcciones as $direccionData) {
                if (isset($direccionData['id'])) {
                    $direccion = $contacto->direcciones()->find($direccionData['id']);
                    if ($direccion) {
                        $direccion->update($direccionData);
                    }
                } else {
                    $contacto->direcciones()->create($direccionData);
                }
            }
        }

        // Actualizar teléfonos existentes o agregar nuevos
        if ($request->has('telefonos')) {
            foreach ($request->telefonos as $telefonoData) {
                if (isset($telefonoData['id'])) {
                    $telefono = $contacto->telefonos()->find($telefonoData['id']);
                    if ($telefono) {
                        $telefono->update($telefonoData);
                    }
                } else {
                    $contacto->telefonos()->create($telefonoData);
                }
            }
        }


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
        $contacto->delete();
        return response()->json([
            'status' => true,
            'message' => 'Contacto eliminado satisfactoriamente'
        ], 200);
    }
}
