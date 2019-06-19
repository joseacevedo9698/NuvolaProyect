<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['nombre', 'apellido', 'telefono', 'email','direccion'];
    protected $guarded = ['id'];


    public function vuelos()
    {
        return $this->hasMany(Vuelo::class);
    }

}
