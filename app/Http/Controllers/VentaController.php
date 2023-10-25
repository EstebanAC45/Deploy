<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sentencia = "SELECT venta.id,venta.numero_venta,venta.created_at,venta.fecha,venta.id_cliente,cliente.direccion,cliente.telefono, cliente.nombres,cliente.apellidos, venta.precio_venta FROM ventas as venta INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id";
        $datos['ventas'] = \DB::select($sentencia);
        return view('venta.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('venta.create');
    }

    public function factura()
    {
        //
        return view('venta.factura');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosVenta = request()->except('_token','compras_realizadas');
        Venta::insert($datosVenta);

        $compras_realizadas = $request->input('compras_realizadas');
        $id_cliente = $request->input('id_cliente');

        $compras_realizadas = $compras_realizadas + 1;

        $sentenciaParaActualizarCompra = "UPDATE clientes SET compras_realizadas = $compras_realizadas WHERE id = $id_cliente";
        \DB::select($sentenciaParaActualizarCompra);

        return redirect('venta')->with('mensaje', 'Venta agregada con éxito');

    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
        return view('venta.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $numero_venta)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
