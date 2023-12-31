<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
                return redirect ()->route('empleado.index');
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
        $confirmar_contrasena = $request->input('confirmar_contrasena');

        if ($contrasena != $confirmar_contrasena) {
            session ()->flash ('mensaje7', 'Las contraseñas no coinciden');
            session ()->flash ('icono7', 'warning');
            return redirect('empleado');
        }

        //validamos un correo por empleado y un correo por usuario
        $correoCliente = DB::table('empleados')->where('correo', '=', $correo)->count();
        $correoUsuario = DB::table('users')->where('email', '=', $correo)->count();

        if ($correoCliente > 0 || $correoUsuario > 0) {
            session ()->flash ('mensaje', 'El correo ya existe');
            session ()->flash ('icono', 'warning');
            

        }else{
            session ()->flash ('mensaje1', 'Cliente agregado con éxito');
            session ()->flash ('icono1', 'success');


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
    }

        return redirect('empleado');

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
                return redirect ()->route('empleado.index');
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

        session()->flash('mensaje2', 'Empleado modificado con éxito');
        session()->flash('icono2', 'success');

        return redirect('empleado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        session()->flash('mensaje3', 'Empleado eliminado con éxito');
        session()->flash('icono3', 'success');

        //eliminamos tambien de la tabla user
        $user = User::where('email', $empleado->correo)->first();
        $user->delete();
                
        return redirect('empleado');
    }
}
