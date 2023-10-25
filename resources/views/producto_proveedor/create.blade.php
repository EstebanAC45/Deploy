@inject('producto', 'App\Models\Producto')
@inject('proveedor', 'App\Models\Proveedor')

<form action="{{ url ('/producto_proveedor') }}" method="post" eenctype="multipart/form-data">
    @csrf
<label for="id_producto">{{'Producto'}}</label>
    <select name="id_producto" id="id_producto">
        @foreach ($producto->all() as $producto)
            <option value="{{ $producto->id }}" >{{ $producto->nombre }}</option>
        @endforeach
    </select> <br>
    <label for="id_proveedor">{{'Proveedor'}}</label>
    <select name="id_proveedor" id="id_proveedor">
        @foreach ($proveedor->all() as $proveedor)
            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
        @endforeach
    </select> <br>
    <label for="precio_compra">{{'Precio de compra'}}</label>
    <input type="number" name="precio_compra" id="precio_compra" step="any" value=""><br>
    <input type="submit" value="Agregar">

</form>