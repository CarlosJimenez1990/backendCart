<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleOrden;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes = Orden::with('detalleOrden','cliente')->get();

        return response()->json($ordenes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        //Registrar Cliente
        $cliente = $this->createCliente($input['customer']);

        $productos = $input['products'];

        $orden = New Orden();
        $orden->total         = $this->calcularTotal($input['products']);
        $orden->cliente_id    = $cliente->id;
        $orden->fecha         = now();
        $orden->subtotal      = $this->calcularTotal($input['products']) * 0.1;
        $orden->descuento     = 0;
        $orden->observaciones = isset($input['observaciones'])? $input['observaciones']: 'No Aplica';
        $orden->save();

        $this->detalleOrden($productos,$orden);

        return response()->json($orden->load('detalleOrden','cliente'));
    }

    public function calcularTotal($input) {
        $total = 0;
        foreach ($input as $producto) {
          $total += $producto['precio'] * $producto['cantidad']; // Sumar el precio total de cada producto
        }
        return $total;
    }

    public function detalleOrden($productos,$orden) {

        foreach ($productos as $producto) {
            $detalle = new DetalleOrden();
            $detalle->orden_id = $orden->id;
            $detalle->producto_id = $producto['producto_id'];
            $detalle->cantidad = $producto['cantidad'];
            $detalle->precio_unitario = $producto['precio'];
            $detalle->precio_total = $producto['precio'] * $producto['cantidad'];
            $detalle->save();
          }
    }

    public function createCliente($input){

        $cliente = Cliente::where('email','=',$input['email'])->first();

        if (empty($cliente)) {
            $cliente = Cliente::create($input);
        }

        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orden = Orden::find($id);

        if (empty($orden)) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        return response()->json($orden->load('detalleOrden','cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
