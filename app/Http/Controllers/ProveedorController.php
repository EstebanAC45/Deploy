<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sentencia = "SELECT proveedors.id, proveedors.nombre, proveedors.direccion, proveedors.telefono, proveedors.email, proveedors.activo FROM proveedors";
        $datos['proveedors'] = \DB::select($sentencia);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return view('proveedor.index', $datos);
            }
            
        } else {
            return redirect()->route('login');
        }
    }

    public function activos(){
        $sentencia = "SELECT proveedors.id, proveedors.nombre, proveedors.direccion, proveedors.telefono, proveedors.email, proveedors.activo FROM proveedors WHERE proveedors.activo ='1'";
        $datos['proveedors'] = \DB::select($sentencia);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return view('proveedor.index', $datos);
            }
            
        } else {
            return redirect()->route('login');
        }
    }

    public function inactivos(){
        $sentencia = "SELECT proveedors.id, proveedors.nombre, proveedors.direccion, proveedors.telefono, proveedors.email, proveedors.activo FROM proveedors WHERE proveedors.activo ='0'";
        $datos['proveedors'] = \DB::select($sentencia);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return view('proveedor.index', $datos);
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
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return redirect()->route('proveedor.index');
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

        $datosProveedor = request()->except('_token');
                //validaremos que solo exista un correo por proveedor

        $correo = $request->input('email');
        $existe = Proveedor::where('email', '=', $correo)->exists();

        if ($existe) {
            return redirect('proveedor')->with('mensaje', 'El correo ya existe');
        }else{


            Proveedor::insert($datosProveedor);
            return redirect('proveedor')->with('mensaje1', 'Proveedor agregado con éxito');
        }

        return redirect('proveedor');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $proveedor = Proveedor::findOrFail($id);
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return redirect ()->route('proveedor.index');
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
        $datosProveedor = request()->except(['_token', '_method']);
        Proveedor::where('id', '=', $id)->update($datosProveedor);

        $proveedor = Proveedor::findOrFail($id);
        $datos['proveedors'] = Proveedor::paginate();

        return view('proveedor.index', $datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        Proveedor::destroy($proveedor->id);
        return redirect('proveedor'); 
    }
}
