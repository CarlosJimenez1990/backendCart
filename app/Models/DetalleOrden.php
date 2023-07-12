<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;
    protected $table = 'detalles_ordenes';
    protected $fillable = [
        'orden_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
    ];
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
