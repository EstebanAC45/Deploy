@inject('categoria', 'App\Models\Categoria')
@inject('productog', 'App\Models\Producto')
@inject('proveedor', 'App\Models\Proveedor')

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

@php
    $contador = 1;
@endphp

@foreach ($productog->all() as $product)
    @php
        $contador++;
    @endphp
@endforeach

@php
function ceros($numero) {
    $cantidad_ceros = 5;
    $aux = $numero;
    $pos = strlen($numero);
    $len = $cantidad_ceros - $pos;
    for ($i = 0; $i < $len; $i++) {
        $aux = "0" . $aux;
    }
    return $aux;
}
@endphp


<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<h5>Complete los campos correctamente:</h5>


<form id="agregarProductoInventario" action="{{ url ('/producto') }}" id="formA" method="post" enctype="multipart/form-data">
    @csrf
    
<label for="codigo">Codigo:</label><br>
<input type="" class="form-control" name="" id="" value="{{'P-'. ceros($contador)}}" disabled><br>
<input type="text" name="codigo" id="codigo" value="{{'P-'. ceros($contador)}}" hidden>

<label for="nombre">Nombre:</label><br>
<input type="text" class="form-control" name="nombre" id="nombre" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required ><br>

<label for="categoria">Categoría:</label><br>
<select class="form-select" name="id_categoria" id="id_categoria">
    @foreach ($categoria->all() as $categoria)
        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
    @endforeach
</select> <br>

<label for="descripcion">Descripción</label> <br>
<textarea name="descripcion" id="descripcion" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" cols="30" rows="4" required></textarea><br>

<label for="activo">Activo:</label><br>
<select class="form-select" name="activo" id="activo">
    <option value="1" >Si</option>
    <option value="0" >No</option>
</select><br>

<label for="imagen">Imagen:</label><br>

<input class="form-control" type="file" name="imagen" id="imagen" value="" required><br>

<label for="precio">Precio Venta:</label><br>
<input class="form-control"  type="number" name="precio" id="precio" step="any" required><br>

<label for="stock">Cantidad a comprar:</label><br>
<input class="form-control" class="form-control" type="number" name="stock" id="stock" required><br>

<label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
<input class="form-control" type="date" name="fecha_vencimiento" id="fecha_vencimiento" required><br>
<hr>
<input class="form-control" type="text" id="id_producto" name="id_producto" value="{{ $contador }}"  hidden>

    <label for="id_proveedor">{{'Proveedor'}}</label><br>
    <select class="form-select" name="id_proveedor" id="id_proveedor">
        @foreach ($proveedor->all() as $proveedor)
            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
        @endforeach
    </select> <br>
    <label for="precio_compra">{{'Precio unitario'}}</label><br> 
    <input class="form-control" type="number" name="precio_compra" id="precio_compra" step="any" required><br>
    <br>
<button  id="btnEnviar" type="submit" class="Send btn btn-primary">Guardar</button>

</form>

<script>
    $('#agregarProductoInventario').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Producto agregado correctamente',
            showConfirmButton: false,
            timer: 2000
        }).then(function(){
            $('#agregarProductoInventario').off('submit').submit();
        });
    })
</script>




