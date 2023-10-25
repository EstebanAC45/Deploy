<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use RealRashid\SweetAlert\Facades\Alert;


class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sentencia = "SELECT carrito.id, carrito.id_producto, carrito.cantidad, producto.nombre_producto, producto.precio, producto.stock FROM carritos as carrito INNER JOIN productos as producto ON carrito.id_producto = producto.id";
        $datos['carritos'] = \DB::select($sentencia);
        if (session()->has('id')) {
            return view('carrito.index', $datos);
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
            return view('carrito.create');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $cantidad = $request->input('cantidad');
        $id_producto = $request->input('id_producto');

        $actualizarStock = Producto::where('id', $id_producto)->get();
        foreach($actualizarStock as $actualizarStock){
            $stock = $actualizarStock->stock;
        }
        $stock = $stock - $cantidad;
        Producto::where('id', $id_producto)->update(['stock' => $stock]);


        
        $datosCarrito = request()->except('_token');

        Carrito::insert($datosCarrito);

        return redirect('venta');


    }

    /**
     * Display the specified resource.
     */
    public function show(Carrito $carrito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrito $carrito)
    {
        //
    }

    public function devolucion($id)
    {
        //
        $carrito = Carrito::where('id', $id)->get();
        foreach($carrito as $carrito){
            $id_producto = $carrito->id_producto;
            $cantidad = $carrito->cantidad;
        }
        $actualizarStock = Producto::where('id', $id_producto)->get();
        foreach($actualizarStock as $actualizarStock){
            $stock = $actualizarStock->stock;
        }
        $stock = $stock + $cantidad;
        Producto::where('id', $id_producto)->update(['stock' => $stock]);

        //para actualizar el precio_venta en tabla ventas cuando elijo devolver un producto
        $numero_venta = $carrito->numero_venta;
        $venta = Venta::where('numero_venta', $numero_venta)->get();
        foreach($venta as $venta){
            $precio_venta = $venta->precio_venta;
        }
        $precio_venta = $precio_venta - ($cantidad * $actualizarStock->precio);
        Venta::where('numero_venta', $numero_venta)->update(['precio_venta' => $precio_venta]);
        


        Carrito::destroy($id);
        


        return redirect('venta');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrito $carrito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $carrito = Carrito::where('id', $id)->get();
        foreach($carrito as $carrito){
            $id_producto = $carrito->id_producto;
            $cantidad = $carrito->cantidad;
        }
        $actualizarStock = Producto::where('id', $id_producto)->get();
        foreach($actualizarStock as $actualizarStock){
            $stock = $actualizarStock->stock;
        }
        $stock = $stock + $cantidad;
        Producto::where('id', $id_producto)->update(['stock' => $stock]);

        

        Carrito::destroy($id);

        if (session()->has('id')) {
            return redirect('venta/create');
        } else {
            return redirect()->route('login');
        }

       }
}
