<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contacto extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'ap_first', 'ap_last'];


    public function correos():HasMany{
        return $this->hasMany(Correo::class);
    }


    public function direcciones():HasMany{
        return $this->hasMany(Direcciones::class);
    }

    public function telefonos():HasMany{
        return $this->hasMany(Telefono::class);
    }
}
