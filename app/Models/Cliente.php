<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\MockObject\OriginalConstructorInvocationRequiredException;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'email'
    ];

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }

}
