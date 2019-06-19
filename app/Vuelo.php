<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    protected $table = 'vuelos';
    protected $fillable = ['fecha', 'pais', 'ciudad', 'email'];
    protected $guarded = ['id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
