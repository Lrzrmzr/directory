<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    use HasFactory;
    protected $fillable =['correo', 'contacto_id'];

    public function contacto(){
        return $this->belongsTo(Contacto::class);
    }
}
