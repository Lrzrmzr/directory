<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;
    protected $fillable = ['telefono', 'contacto_id'];

    public function contacto(){
        return $this->belongsTo(Contacto::class);
    }
}
