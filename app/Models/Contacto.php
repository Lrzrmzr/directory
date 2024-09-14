<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'ap_first', 'ap_last'];


    public function correos(){
        return $this->hasMany(Correo::class);
    }


    public function direcciones(){
        return $this->hasMany(Direcciones::class);
    }

    public function telefonos(){
        return $this->hasMany(Telefono::class);
    }
}
