<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['empleados'] = Empleado::paginate();
        if (session()->has('id')) {
            
            if (session()->get('rol') == 2 || session()->get('rol') == 1) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('empleado.index', $datos);
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

            if (session()->get('rol') == 2 || session()->get('rol') == 1) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('empleado.create');
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
        $datosEmpleado = request()->except('_token');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $telefono = $request->input('telefono');
        $direccion = $request->input('direccion');
        $correo = $request->input('correo');
        $contrasena = $request->input('contrasena');
        $activo = $request->input('activo');
        $fecha_registro = $request->input('fecha_registro');
        $id_rol = $request->input('id_rol');

        DB::table('users')->insert([
            'name' => $nombres . ' ' . $apellidos,
            'email' => $correo,
            'password' => Hash::make($contrasena),
            'rol' => $id_rol
        ]);

        DB::table('empleados')->insert([
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'contrasena' => Hash::make($contrasena),
            'activo' => $activo,
            'fecha_registro' => $fecha_registro,
            'id_rol' => $id_rol
        ]);


        return redirect('empleado')->with('mensaje', 'Empleado registrado exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        //
        if (session()->has('id')) {

            if (session()->get('rol') == 2 || session()->get('rol') == 1) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('empleado.edit', compact('empleado'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
        $datosEmpleado = request()->except(['_token', '_method']);
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $telefono = $request->input('telefono');
        $direccion = $request->input('direccion');
        $correo = $request->input('correo');
        $contrasena = $request->input('contrasena');
        $activo = $request->input('activo');
        $fecha_registro = $request->input('fecha_registro');
        $id_rol = $request->input('id_rol');

        DB::table('users')->where('email', $correo)->update([
            'name' => $nombres . ' ' . $apellidos,
            'email' => $correo,
            'password' => Hash::make($contrasena),
            'rol' => $id_rol
        ]);

        DB::table('empleados')->where('correo', $correo)->update([
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'contrasena' => Hash::make($contrasena),
            'activo' => $activo,
            'fecha_registro' => $fecha_registro,
            'id_rol' => $id_rol
        ]);

        return redirect('empleado')->with('mensaje', 'Empleado actualizado exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
