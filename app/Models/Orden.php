<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'fecha',
        'estado',
        'cliente_id',
        'subtotal',
        'descuento',
        'total',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detalleOrden()
    {
        return $this->hasMany(DetalleOrden::class);
    }

}
