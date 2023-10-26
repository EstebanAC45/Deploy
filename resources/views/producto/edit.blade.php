@inject('categoria', 'App\Models\Categoria')
@inject('productog', 'App\Models\Producto')
@inject('proveedor', 'App\Models\Proveedor')
@inject('producto_proveedor', 'App\Models\Producto_Proveedor')

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>



Editar producto
<form id="actulizarElProducto{{$producto->id}}" action="{{ url ('/producto/'.$producto->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PATCH') }}
    
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <label for="codigo">Codigo:</label><br>
            <input type="" class="form-control" name="" id="" value="{{ isset($producto->codigo)?$producto->codigo:'P-'. ceros($contador) }}" disabled><br>
            <input type="text" name="codigo" id="codigo" value="{{ isset($producto->codigo)?$producto->codigo:'P-'. ceros($contador) }}" hidden>

            <label for="categoria">Categoría:</label><br>
            <select class="form-select" name="id_categoria" id="id_categoria">
                @foreach ($categoria->all() as $categoria)
                @php
                    $producto_categoria = $productog::where('id', $producto->id)->get();
                @endphp
                <option value="{{ $categoria->id }}" {{isset($producto_categoria[0]->id_categoria) && $producto_categoria[0]->id_categoria==$categoria->id?'selected':''}}>{{ $categoria->nombre }}</option>
                @endforeach
            </select> <br>
            <br>
            <label for="activo">Activo:</label><br>
            <select class="form-select" name="activo" id="activo">
                <option value="1" {{isset($producto->activo) && $producto->activo==1?'selected':''}}>Si</option>
                <option value="0" {{isset($producto->activo) && $producto->activo==0?'selected':''}}>No</option>
            </select><br>

            <label for="precio">Precio venta unidad:</label><br>
            <input class="form-control" type="number" name="precio" id="precio" value="{{ isset($producto->precio)?$producto->precio:'' }}" step="any" required><br>

            <label for="precio_compra">Precio unitario:</label>
            @foreach ($producto_proveedor::where('id_producto', $producto->id)->get() as $producto_proveedor)
            <input class="form-control" type="number" name="precio_compra" id="precio_compra" value="{{ isset($producto_proveedor->precio_compra)?$producto_proveedor->precio_compra:'' }}" step="any" required><br>
            @endforeach

            <label for="stock">Stock actual:</label><br>
            <input class="form-control" type="number" name="stock" id="stock" value="{{ isset($producto->stock)?$producto->stock:'' }}" required><br>

            <input type="text" id="id_producto" name="id_producto" value="{{$producto->id}}" hidden>
            <label for="proveedor">Proveedor</label>
            <select class="form-select" name="id_proveedor" id="id_proveedor">
                @foreach ($proveedor->all() as $proveedor)
                @php
                    $producto_proveedora = $producto_proveedor::where('id_producto', $producto->id)->get();
                @endphp 
                    <option value="{{ $proveedor->id }}" {{isset($producto_proveedora[0]->id_proveedor) && $producto_proveedora[0]->id_proveedor==$proveedor->id?'selected':''}}>{{ $proveedor->nombre }}</option>
                @endforeach
            </select>

        </div>
        <div class="col-md-6">
             <label for="nombre">Nombre:</label><br>
            <input class="form-control" type="text" name="nombre" id="nombre" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" value="{{ isset($producto->nombre)?$producto->nombre:'' }}" pattern="[a-zA-Z ]{3,254}" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
        
            <label for="descripcion">Descripción:</label><br>
            <textarea required name="descripcion" id="descripcion" cols="43" rows="3" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" title="Por favor ingrese al menos 3 caracteres, ya sean letras o números." required>{{isset($producto->descripcion)?$producto->descripcion:''}} </textarea><br>

            <label for="imagen">Imagen:</label><br>
                @if (isset($producto->imagen))
                    <img  src="{{ asset('storage').'/'.$producto->imagen }}" alt="" width="97" ><br>
                @endif
                <br>
                <input class="form-control" type="file" name="imagen" id="imagen" value=""><br>

                <label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
                <input class="form-control" type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ isset($producto->fecha_vencimiento)?$producto->fecha_vencimiento:'' }}" required><br>
                
                <br>
        </div>
    </div>
</div>
<br>
<input type="submit" value="Guardar" class="btn btn-primary">





</form>

<script>
    $('#actulizarElProducto{{$producto->id}}').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Producto editado correctamente',
            showConfirmButton: false,
            timer: 1500
        }).then(function(){
            $('#actulizarElProducto{{$producto->id}}').off('submit').submit();
        });
    })
</script>