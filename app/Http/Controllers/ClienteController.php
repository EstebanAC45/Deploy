<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['clientes'] = Cliente::paginate();
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return view('cliente.index', $datos);
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
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return redirect()->route('cliente.index');
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
        $confirmar_contrasena = $request->input('confirmar_contrasena');

        if ($contrasena != $confirmar_contrasena) {
            if (session()->has('id')) {

                if (session()->get('rol') == 1 || session()->get('rol') == 3) {
                    session ()->flash ('mensaje9', 'Las contraseñas no coinciden');
                    session ()->flash ('icono9', 'warning');
        
                    return redirect('cliente');
                }
            } else {
                session ()->flash ('mensaje9', 'Las contraseñas no coinciden');
                session ()->flash ('icono9', 'warning');
    
                return redirect()->route('login');
            }
        }

        //validaremos que solo exista un correo por cliente y por usuario
        $correoCliente = DB::table('clientes')->where('correo', '=', $correo)->count();
        $correoUsuario = DB::table('users')->where('email', '=', $correo)->count();

        if ($correoCliente > 0 || $correoUsuario > 0 ) {
            session ()->flash ('mensaje', 'El correo ya existe');
            session ()->flash ('icono', 'warning');
            

        }else{
            session ()->flash ('mensaje1', 'Cliente agregado con éxito');
            session ()->flash ('icono1', 'success');
        //Agregamos los datos a la tabla clientes

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
    }
        if (session()->has('id')) {

            if (session()->get('rol') == 1 || session()->get('rol') == 3) {
                return redirect('cliente');
            }
        } else {
            return redirect()->route('login');
        }
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
        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                return redirect ()->route('cliente.index');
            }
            
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
        $datosCliente = request()->except(['_token', '_method']);

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

        DB::table('clientes')->where('id', '=', $cliente->id)->update([
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


        $nombreCliente = $request->input('nombres');
        $apellidoCliente = $request->input('apellidos');
        $correoCliente = $request->input('correo');
        $contrasenaCliente = $request->input('contrasena');
        

        DB::table('users')->where('email', '=', $correoCliente)->update([
            'name' => $nombreCliente . ' ' . $apellidoCliente,
            'email' => $correoCliente,
            'password' => Hash::make($contrasenaCliente),
            'rol' => 2,
        ]);

        
        

        return redirect('cliente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function clienteActivo(){

        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                $clientes = DB::table('clientes')->where('activo', '=', 1)->get();
        
                return view('cliente.index', compact('clientes'));
            }
            
        } else {
            return redirect()->route('login');
        }

    }

    public function clienteInactivo(){

        if (session()->has('id')) {

            if (session()->get('rol') == 2) {
                return redirect()->route('producto_proveedor.index');
            } else {
                $clientes = DB::table('clientes')->where('activo', '=', 0)->get();
        
                return view('cliente.index', compact('clientes'));
            }
            
        } else {
            return redirect()->route('login');
        }



    }


}
