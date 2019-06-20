<?php

namespace App\Http\Controllers;

use App\Vuelo;
use App\Persona;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;
use Validator;

class VueloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vuelos = Vuelo::paginate(10);
        return response()->json($vuelos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $xml = simplexml_load_string($request->getContent());
        $result = XmlToArray::convert($request->getContent());
        foreach ($result as $x) {
            $y = $this->validateAllEmail($x);
            if ($y) {
                if (isset($x[0])) {
                    $sw = false;
                    foreach ($x as $vuelos) {
                        $validator = $this->validateVuelo($vuelos);
                        if ($validator->fails()) {
                            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
                        } else {
                            if ($this->ValidateEmail($vuelos['email']) >= 1) {
                                $sw = $this->CreateVuelo($vuelos);
                            } else {
                                return response()->json(['status' => '400', 'description' => 'Email Not Found'], 400);
                            }
                        }
                    }
                    if ($sw) {
                        return response()->json(['status' => '200', 'description' => 'Register Success'], 200);
                    } else {
                        return response()->json(['status' => '500', 'description' => 'Register Not Succcess'], 500);
                    }
                } else {
                    $sw = false;
                    $y = $this->validateAllEmail($x);
                    $validator = $this->validateVuelo($x);
                    if ($validator->fails()) {
                        return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
                    } else {
                        if ($this->ValidateEmail($x['email']) >= 1) {
                            $sw = $this->CreateVuelo($x);
                            if ($sw) {
                                return response()->json(['status' => '200', 'description' => 'Register Success'], 200);
                            } else {
                                return response()->json(['status' => '500', 'description' => 'Register Not Succcess'], 500);
                            }
                        } else {
                            return response()->json(['status' => '400', 'description' => 'Email Not Found'], 400);
                        }
                    }
                }
            } else {
                return response()->json(['status' => '400', 'description' => 'Email Not Found'], 400);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Vuelo  $vuelo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $rules = ['email' => 'required|email',];
        $param = array('email'=>$request->input('email'));
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
        }
        if(Persona::where('email',$request->input('email'))->count()>=1){
            $persona = Persona::where('email',$request->input('email'))->get();
            $vuelos = Vuelo::where('email',$request->input('email'))->get();
            return response()->json(['status' => '200','persona'=>$persona,'vuelos'=>$vuelos],200);
        }else{
            return response()->json(['status' => '404','description'=>'Persona Not Found'],404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vuelo  $vuelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vuelo $vuelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vuelo  $vuelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vuelo $vuelo)
    {
        //
    }


    private function validateVuelo($x)
    {
        $rules = [
            'fecha_viaje' => 'required|date_format:d/m/Y|after:start_at',
            'pais' => 'required|string|min:3|max:60',
            'ciudad' => 'required|string|min:3',
            'email' => 'required|email',
        ];
        return Validator::make($x, $rules);
    }

    private function ValidateEmail($value)
    {
        $count = Persona::where('email', '=', $value)->count();
        return $count;
    }

    private function CreateVuelo($x)
    {
        $sw = false;
        $vuelo = new Vuelo();
        $vuelo->fecha = date("Y-m-d", strtotime($x['fecha_viaje']));
        $vuelo->pais = $x['pais'];
        $vuelo->ciudad = $x['ciudad'];
        $vuelo->email = $x['email'];
        if ($vuelo->save()) {
            $sw = true;
        } else {
            $sw = false;
        }
        return $sw;
    }


    public function validateAllEmail($array)
    {
        $sw = true;
        if (isset($array[0])) {
            foreach ($array as $x) {
                if ($this->ValidateEmail($x['email']) >= 1) {
                } else {
                    $sw = false;
                }
            }
        } else {
            if ($this->ValidateEmail($array['email']) >= 1) {
            } else {
                $sw= false;
            }
        }
        return $sw;
    }
}
