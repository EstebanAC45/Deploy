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
        $datos['proveedores'] = Proveedor::paginate();

        return view('proveedor.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $datosProveedor = request()->except('_token');
        Proveedor::insert($datosProveedor);

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
        return view('proveedor.edit', compact('proveedor'));
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
        $datos['proveedores'] = Proveedor::paginate();

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
