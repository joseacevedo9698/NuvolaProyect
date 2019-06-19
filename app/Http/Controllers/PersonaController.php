<?php

namespace App\Http\Controllers;

use Validator;
use App\Persona;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::paginate(10);
        return response()->json($personas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->rulesValidate($request, 1);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
        } else {
            Persona::create($request->all());
            return response()->json(['status' => '200', 'description' => 'Register Success'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $persona = Persona::find($id);
        if ($persona) {
            return response()->json($persona);
        } else {
            return response()->json(['status' => '404', 'description' => 'Persona Not Found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::find($id);
        if ($persona) {
            $validator = $this->rulesValidate($request, 0);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
            } else {
                $persona->nombre = $request->input('nombre');
                $persona->apellido = $request->input('apellido');
                $persona->telefono = $request->input('telefono');
                $persona->email = $request->input('email');
                $persona->direccion = $request->input('direccion');
                if ($persona->save()) {
                    return response()->json(['status' => '200', 'description' => 'Update Success'], 200);
                } else {
                    return response()->json(['status' => '500', 'description' => 'Update Not Succcess'], 500);
                }
            }
        } else {
            return response()->json(['status' => '404', 'description' => 'Persona Not Found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona = Persona::find($id);
        if ($persona) {
            if ($persona->delete()) {
                return response()->json(['status' => '200', 'description' => 'Delete Success'], 200);
            }else{
                return response()->json(['status' => '500', 'description' => 'Delete Not Succcess'], 500);
            }
        }else{
            return response()->json(['status' => '404', 'description' => 'Persona Not Found'], 404);
        }
    }


    public function rulesValidate(Request $request, $resp)
    {

        if ($resp === 1) {
            $rules = [
                'nombre' => 'required|string|min:3|max:60',
                'apellido' => 'required|string|min:3|max:60',
                'telefono' => 'required|Numeric|min:10',
                'email' => 'required|email|unique:personas',
                'direccion' => 'required|string|min:4|max:60',
            ];
        } elseif ($resp === 0) {
            $rules = [
                'nombre' => 'required|string|min:3|max:60',
                'apellido' => 'required|string|min:3|max:60',
                'telefono' => 'required|Numeric|min:10',
                'email' => 'required|email',
                'direccion' => 'required|string|min:4|max:60',
            ];
        } else {
            response()->json(['status' => '500', 'description' => 'Error Validate'], 500);
        }
        return Validator::make($request->all(), $rules);
    }
}
