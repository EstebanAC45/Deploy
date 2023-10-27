<?php



namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       $sentenciaSelect = "SELECT categorias.id, categorias.nombre,categorias.activo FROM categorias";
         $datos['categorias'] = \DB::select($sentenciaSelect);

        if (session()->has('id')) {
            
            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('categoria.index', $datos);
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
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('categoria.create');
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
        $datosCategoria = request()->except('_token');

        //para no agregar categorías existentes
        $categoria = Categoria::where('nombre', '=', $datosCategoria['nombre'])->first();

        if ($categoria != null) {
            session()->flash('mensaje', 'La categoría ya existe');
            
        }else{

            session()->flash('mensaje1', 'Categoría agregada con éxito');
                    
        Categoria::insert($datosCategoria);
        }
;
        return redirect('categoria');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $categoria = Categoria::findOrFail($id);
        if (session()->has('id')) {
            
            if (session()->get('rol') == 2) {
                return redirect ()->route('producto_proveedor.index');
            } else {
                return view('categoria.edit', compact('categoria'));
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
        $datosCategoria = request()->except(['_token', '_method']);
        Categoria::where('id', '=', $id)->update($datosCategoria);



        $categoria = Categoria::findOrFail($id);
        $datos['categorias'] = Categoria::paginate();
        
        if (session()->has('id')) {
            return view('categoria.index', $datos);
        } else {
            return redirect()->route('login');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        Categoria::destroy($id);
        
        if (session()->has('id')) {
            return redirect('categoria');
        } else {
            return redirect()->route('login');
        }
    }
}
