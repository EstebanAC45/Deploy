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

        return view('categoria.index', $datos);
        //return json_encode($datos['categorias']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosCategoria = request()->except('_token');
        Categoria::insert($datosCategoria);
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
        return view('categoria.edit', compact('categoria'));
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

        return view('categoria.index', $datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        Categoria::destroy($id);
        

        return redirect('categoria');

    }
}
