<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Producto_Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use DNS1D;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$sentenciaSQL = "SELECT p.id, p.codigo, p.nombre, c.nombre as categoria, p.descripcion, p.imagen, p.precio, p.stock, p.fecha_vencimiento FROM productos p, categorias c WHERE p.id_categoria = c.id";
       /* $sentenciaSQL = "SELECT p.id, p.codigo, p.nombre, c.nombre as categoria, p.descripcion, p.imagen, p.precio, p.stock, 
        p.fecha_vencimiento, pp.id_proveedor, pro.nombre as proveedor FROM productos p, categorias c, producto__proveedors pp, 
        proveedors pro WHERE p.id_categoria = c.id AND p.id = pp.id_producto AND pp.id_proveedor = pro.id";
        $datos['productos'] = \DB::select($sentenciaSQL);
        return view('producto.index', $datos);*/


        $sentenciaSQL = "SELECT p.id, p.codigo,p.codigo_barra, p.nombre, c.nombre as categoria, p.descripcion, p.imagen, p.precio, p.stock, p.fecha_vencimiento, p.activo
         FROM productos p, categorias c WHERE p.id_categoria = c.id";
        $datos['productos'] = \DB::select($sentenciaSQL);
        //return json_encode($datos['productos']);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('producto.index', $datos);
            }

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
        $categorias = Categoria::all();
        if (session()->has('id')) {
            
            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return redirect ()->route('producto.index');
            }

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
        $datosProducto = request()->except('_token', 'id_producto', 'id_proveedor', 'precio_compra');
        $codigo_barra = $request->input('codigo_barra');

        if ($codigo_barra == null) {
            $barcode = DNS1D::getBarcodeHTML($request->input('codigo'), 'C128');
            $datosProducto['codigo_barra'] = $barcode;

        }else{
            $datosProducto['codigo_barra'] = $codigo_barra;
        }

        if ($request->hasFile('imagen')) {
            $img = $request->file('imagen');
            $nombreImagen = time().'.'. $img -> getClientOriginalName();
            $img -> move('img', $nombreImagen);
            $datosProducto['imagen'] = $nombreImagen;

        }else{
            $datosProducto['imagen'] = 'no_disponible.jpg';
        }

        Producto::insert($datosProducto);

        $traerElIdDesdeProducto = Producto::select('id')->orderBy('id', 'desc')->first();
        $idProducto = $traerElIdDesdeProducto->id;

        $datosProductoProveedor = request()->except('_token', 'id_producto','codigo_barra', 'nombre', 'descripcion', 'imagen', 'precio', 'stock', 'fecha_vencimiento', 'activo','codigo', 'id_categoria');
        $datosProductoProveedor['id_producto'] = $idProducto;
        Producto_Proveedor::insert($datosProductoProveedor);


        return redirect ('producto')->with('mensaje', 'Producto agregado con éxito');

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $producto = Producto::findOrFail($id);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return redirect ()->route('producto.index', compact('producto'));
            }

        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosProducto = request()->except(['_token', '_method', 'id_producto', 'id_proveedor', 'precio_compra']);
        $codigo_barra = $request->input('codigo_barra');

        if ($codigo_barra == null) {
            $barcode = DNS1D::getBarcodeHTML($request->input('codigo'), 'C128');
            $datosProducto['codigo_barra'] = $barcode;

        }else{
            $datosProducto['codigo_barra'] = $codigo_barra;
        }


        if ($request->hasFile('imagen')) {
            $producto = Producto::findOrFail($id);
            $img = $request->file('imagen');
            $nombreImagen = time().'.'. $img -> getClientOriginalName();
            $img -> move('img', $nombreImagen);
            $datosProducto['imagen'] = $nombreImagen;
            
        }else{
            $producto = Producto::findOrFail($id);
            $datosProducto['imagen'] = $producto->imagen;
        }

        Producto::where('id', '=', $id)->update($datosProducto);

        $producto = Producto::findOrFail($id);
        $datos['productos'] = Producto::paginate();

        //Para actulizar el precio de compra y los demás datos del producto_proveedor
        $datosProductoProveedor = request()->except(['_token', '_method', 'id_producto','codigo_barra', 'nombre', 'descripcion', 'imagen', 'precio', 'stock', 'fecha_vencimiento', 'activo','codigo', 'id_categoria']);
        $datosProductoProveedor['id_producto'] = $id;
        Producto_Proveedor::where('id_producto', '=', $id)->update($datosProductoProveedor);

        return redirect ('producto')->with('mensaje', 'Producto modificado con éxito');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Producto::destroy($id);
        return redirect ('producto')->with('mensaje', 'Producto borrado con éxito');
     }

     public function productoActivo(){

        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                $sentenciaSQL = "SELECT p.id, p.codigo, p.nombre, c.nombre as categoria, p.descripcion, p.imagen, p.precio, p.stock, p.fecha_vencimiento, p.activo
                FROM productos p, categorias c WHERE p.id_categoria = c.id AND p.activo = '1'";
                $datos['productos'] = \DB::select($sentenciaSQL);
                return view('producto.index', $datos);
            }

        } else {
            return redirect()->route('login');
        }

     }

     public function productoInactivo(){

        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                $sentenciaSQL = "SELECT p.id, p.codigo, p.nombre, c.nombre as categoria, p.descripcion, p.imagen, p.precio, p.stock, p.fecha_vencimiento, p.activo
                FROM productos p, categorias c WHERE p.id_categoria = c.id AND p.activo = '0'";
                $datos['productos'] = \DB::select($sentenciaSQL);
                return view('producto.index', $datos);
            }

        } else {
            return redirect()->route('login');
        }
     }

    
             
}
