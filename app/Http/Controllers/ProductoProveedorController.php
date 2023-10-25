<?php

namespace App\Http\Controllers;

use App\Models\Producto_Proveedor;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sentenciaSQL = "SELECT producto__proveedors.id,producto__proveedors.id_producto,productos.activo,productos.precio,productos.stock,productos.imagen, productos.nombre as nombre_producto,productos.descripcion, proveedors.nombre as nombre_proveedor, proveedors.id as id_proveedor,proveedors.direccion, proveedors.telefono,proveedors.email as id_proveedor, producto__proveedors.precio_compra
        FROM producto__proveedors INNER JOIN productos ON producto__proveedors.id_producto = productos.id
        INNER JOIN proveedors ON producto__proveedors.id_proveedor = proveedors.id";

        $datos['producto_proveedors'] = \DB::select($sentenciaSQL);

        return view('producto_proveedor.index', $datos);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('producto_proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosProductoProveedor = request()->except('_token');
        Producto_Proveedor::insert($datosProductoProveedor);
        return redirect('producto');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto_Proveedor $producto_Proveedor)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $producto_proveedor = Producto_Proveedor::findOrFail($id);
        return view('producto_proveedor.edit', compact('producto_proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosProductoProveedor = request()->except(['_token', '_method']);
        Producto_Proveedor::where('id', '=', $id)->update($datosProductoProveedor);
        
        $producto_Proveedor = Producto_Proveedor::findOrFail($id);
        $datos['producto_proveedor'] = Producto_Proveedor::Paginate();

        redirect ('producto_proveedor')->with('mensaje', 'Producto actualizado con éxito');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $sentenciaSQL = "DELETE FROM producto__proveedors WHERE id = '$id'";
        \DB::select($sentenciaSQL);
        return redirect('producto_proveedor');

        

    }
}
