<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['clientes'] = Cliente::paginate();
        return view('cliente.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosCliente = request()->except('_token');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $telefono = $request->input('telefono');
        $direccion = $request->input('direccion');
        $correo = $request->input('correo');
        $contrasena = $request->input('contrasena');
        $compras_realizadas = $request->input('compras_realizadas');
        $activo = $request->input('activo');
        $tarjeta_fidelidad = $request->input('tarjeta_fidelidad');
        $fecha_registro = $request->input('fecha_registro');
        $id_rol = $request->input('id_rol');

        DB::table('clientes')->insert([
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'contrasena' => Hash::make($contrasena),
            'compras_realizadas' => $compras_realizadas,
            'activo' => $activo,
            'tarjeta_fidelidad' => $tarjeta_fidelidad,
            'fecha_registro' => $fecha_registro,
            'id_rol' => $id_rol,
        ]);

        //Vamos a traer los datos para agregarlos tambien a la tabla users
        $nombreCliente = $request->input('nombres');
        $apellidoCliente = $request->input('apellidos');
        $correoCliente = $request->input('correo');
        $contrasenaCliente = $request->input('contrasena');

        //Agregamos los datos a la tabla users
        DB::table('users')->insert([
            'name' => $nombreCliente . ' ' . $apellidoCliente,
            'email' => $correoCliente,
            'password' => Hash::make($contrasenaCliente),
            'rol' => 2,
        ]);

        return redirect('/')->with('mensaje', 'Cliente agregado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
        $datosCliente = request()->except(['_token', '_method']);
        Cliente::where('id', '=', $cliente->id)->update($datosCliente);
        

        return redirect('cliente')->with('mensaje', 'Cliente modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }


}
