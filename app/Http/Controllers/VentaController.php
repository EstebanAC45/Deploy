<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Carrito;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sentencia = "SELECT venta.fecha_registro,venta.id,venta.numero_venta,venta.created_at,venta.fecha,venta.id_cliente,cliente.direccion,cliente.telefono, cliente.nombres,cliente.apellidos,cliente.correo, venta.precio_venta FROM ventas as venta INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id";
        $datos['ventas'] = \DB::select($sentencia);

        if (session()->has('id')) {
            return view('venta.index', $datos);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (session()->has('id')) {
            return view('venta.create');
        } else {
            return redirect()->route('login');
        }
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

        $compras_realizadas = $request->input('compras_realizadas');
        $id_cliente = $request->input('id_cliente');

        $compras_realizadas = $compras_realizadas + 1;

        if ($id_cliente == 0) {
            session()->flash('mensaje', 'Agregue un cliente');
            session()->flash('icono', 'error');
            return redirect('venta/create');
        }else{
        Venta::insert($datosVenta);
        $sentenciaParaActualizarCompra = "UPDATE clientes SET compras_realizadas = $compras_realizadas WHERE id = $id_cliente";
        \DB::select($sentenciaParaActualizarCompra);
        session()->flash('mensaje1', 'Venta agregada con éxito');
        session()->flash('icono1', 'success');
        return redirect('venta')->with('mensaje', 'Venta agregada con éxito');
        }
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
        if (session()->has('id')) {
            return view('venta.edit', compact('venta'));
        } else {
            return redirect()->route('login');
        }
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

    public function reportes(){

        if (session()->has('id')) {

            if(session()->get('rol') == '3'){
                $sentencia = "SELECT venta.fecha_registro,venta.id,venta.numero_venta,venta.created_at,venta.fecha,venta.id_cliente,cliente.direccion,cliente.telefono, cliente.nombres,cliente.apellidos,cliente.correo, venta.precio_venta FROM ventas as venta INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id";
                $datos['ventas'] = \DB::select($sentencia);

                $cliente = Cliente::all();
                $producto = Producto::all();
                $venta = Venta::all();


            return view('venta.reportes');
            }else{
                return redirect()->route('producto_proveedor.index');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function ventaPorDia(Request $request){
        

        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $tipo_reporte = $request->input('tipo_reporte');


        if ($tipo_reporte == 1) {
        //$sentencia = "SELECT DATE(venta.fecha_registro) as dia, SUM(venta.precio_venta) as total_ventas, COUNT('venta.id') as cantida_compras FROM ventas as venta INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id WHERE venta.fecha_registro LIKE '%$fecha_inicio%' GROUP BY dia";
       $sentencia = "SELECT DATE(TO_DATE(venta.fecha_registro, 'DD-MM-YYYY')) as dia, SUM(venta.precio_venta) as total_ventas, COUNT('venta.id') as cantida_compras
       FROM ventas as venta
       INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id
       WHERE DATE(TO_DATE(venta.fecha_registro, 'DD-MM-YYYY')) = '$fecha_inicio'
       GROUP BY dia;";
        $datos['ventas'] = \DB::select($sentencia);
    
        $ventasPorDia = collect($datos['ventas']);
    
        return view('venta.reportes', compact('ventasPorDia'));
    }elseif ($tipo_reporte == 2) {


        $sentencia = "SELECT DATE(TO_DATE(venta.fecha_registro, 'DD-MM-YYYY')) as dia, SUM(venta.precio_venta) as total_ventas, COUNT('venta.id') as cantida_compras
        FROM ventas as venta
        INNER JOIN clientes as cliente ON venta.id_cliente = cliente.id
        WHERE DATE(TO_DATE(venta.fecha_registro, 'DD-MM-YYYY')) BETWEEN '$fecha_inicio' AND '$fecha_fin'
        GROUP BY dia;";

        $datos['ventas'] = \DB::select($sentencia);

        $ventasPorDia = collect($datos['ventas']);

        return view('venta.reportes', compact('ventasPorDia')); 





    }
    
    }

            
}