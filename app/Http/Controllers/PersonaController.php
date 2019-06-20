<?php

namespace App\Http\Controllers;

use Validator;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
        return response()->json($personas,200);
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
                try {
                    if ($persona->save()) {
                        return response()->json(['status' => '200', 'description' => 'Update Success'], 200);
                    } else {
                        return response()->json(['status' => '500', 'description' => 'Update Not Succcess'], 500);
                    }
                } catch (Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => '500', 'description' => 'Duplicate Data'], 500);

                } catch (PDOException $e) {
                    return response()->json(['status' => '500', 'description' => 'Duplicate Data'], 500);
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
            } else {
                return response()->json(['status' => '500', 'description' => 'Delete Not Succcess'], 500);
            }
        } else {
            return response()->json(['status' => '404', 'description' => 'Persona Not Found'], 404);
        }
    }


    private function rulesValidate(Request $request, $resp)
    {

        if ($resp === 1) {
            $rules = [
                'nombre' => 'required|string|min:3|max:60',
                'apellido' => 'required|string|min:3|max:60',
                'telefono' => 'required|numeric|min:10',
                'email' => 'required|email|unique:personas',
                'direccion' => 'required|string|min:4|max:60',
            ];
        } elseif ($resp === 0) {
            $rules = [
                'nombre' => 'required|string|min:3|max:60',
                'apellido' => 'required|string|min:3|max:60',
                'telefono' => 'required|numeric|min:10',
                'email' => 'required|email',
                'direccion' => 'required|string|min:4|max:60',
            ];
        } else {
            return response()->json(['status' => 500, 'description' => 'Error Validate'], 500);
        }
        return Validator::make($request->all(), $rules);
    }

    public function SearchNombres(Request $request)
    {
        $personas = DB::table('personas')->where('nombre', 'LIKE', '%' . $request->input('value') . '%')->orWhere('apellido', 'LIKE', '%' . $request->input('value') . '%')->paginate(10);

        if (!$personas->isEmpty()) {

            return response()->json(['status' => 200, 'results' => $personas], 200);
        } else {
            return response()->json(['status' => 404, 'description' => 'Persona Not Found'], 404);
        }
    }

    public function SearchEmail(Request $request)
    {
        $personas = DB::table('personas')->where('email', 'LIKE', '%' . $request->input('value') . '%')->paginate(10);

        if (!$personas->isEmpty()) {
            return response()->json(['status' => 200, 'results' => $personas], 200);
        } else {
            return response()->json(['status' => 404, 'description' => 'Email Not Found'], 404);
        }
    }


    public function SearchCreated(Request $request)
    {
        $rules = [
            'fecha' => 'required|date_format:d/m/Y'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
        } else {
            $x = Carbon::now();
            $fecha = str_replace('/', '-', $request->input('fecha'));
            $y = date("Y-m-d", strtotime($fecha));
            $personas = Persona::whereBetween('created_at', [$y, $x])->paginate(10);
            return response()->json(['status' => 200, 'results' => $personas], 200);
        }
    }
}
