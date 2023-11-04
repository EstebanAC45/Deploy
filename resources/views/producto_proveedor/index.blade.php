@inject('carritos', 'App\Models\Carrito')
@inject('productos', 'App\Models\Producto')
@inject ('venta', 'App\Models\Venta')
@inject ('categorias', 'App\Models\Categoria')
@extends('layouts.parte1')

@section('contenido')
<br>
@php
    $id = session('id');
    $nombre = session('nombre');
    $email = session('email');
    $password = session('password');
    $rol = session('rol');
@endphp

@if($rol == 2)
<h4>Bienvenid@ {{$nombre}}, navega por nuestro catalogo de productos</h4>
@else
<h4>Empleado:  {{$nombre}}</h4>

@if(session()->has('mensaje'))
    <script>
        Swal.fire({
            position: 'center',
            icon: '{{ session('icono') }}',
            title: '{{ session('mensaje') }}',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
@endif

@php 
    $sesionCarrito = session()->get('mensaje5');
@endphp
@if($sesionCarrito == 'Producto añadido al carrito')
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Producto añadido al carrito',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
@endif

<style>   

</style>
<!--Filtrar por categorias-->
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <form action="{{route('producto_proveedor.filtrarProductoProCategoria')}}" method="GET">
                <select name="id_categoria" id="id_categoria" class="form-select">
                    
                    <option value="">Filtrar por categoría</option>
                    @foreach($categorias->get() as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                    @endforeach
                </select>
                <br>
        </div>
        <div class="col-md-1">
         <!--Para evitar que filtre sin haber seleccionado una categoría-->
            
                <button id="categoriaMover" type="submit" class="btn btn-primary categoriaMover">Filtrar</button>

            </form>
        </div>
        <div class="col-md-2">
            <form action="{{route('producto_proveedor.index')}}" method="GET">
                <button id="categoriaMover" type="submit" class="btn btn-primary categoriaMover">Mostrar todos</button>
            </form>
        </div>
    </div>
</div>



@php 
    $contador_ventas = 0;
@endphp
@foreach ($venta->get() as $venta)
@php
    $contador_ventas = $contador_ventas + 1;
@endphp
@endforeach


<input type="number" name="numero_venta" value="{{$contador_ventas + 1}}" hidden>

<div class="container">
    <div class="row">
        @foreach($producto_proveedors as $producto_proveedor)
            @if($producto_proveedor->activo == 1)
    <div class="col-md-4">
        <form action="{{route('carrito.store')}}" method="POST">
            @csrf
            <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <center><img src="./img/{{$producto_proveedor->imagen}}" alt="" width="140" height="140"></center>
            <div class="card-body">
                <input type="text" name="principal" value="1" hidden>
                <input type="text" name="id_producto" id="id_producto" value="{{$producto_proveedor->id_producto}}" hidden>
                <h5 class="card-title">{{$producto_proveedor->nombre_producto}}  </h5>
                <h5 class="card-title">$ {{$producto_proveedor->precio}}</h5>
                <h6 class="card-title"> Disponibles: {{$producto_proveedor->stock}}</h6>
                <input type="number" name="cantidad" id="cantidad{{$producto_proveedor->id_producto}}" class="form-control" value="1" placeholder="Ingrese cantidad" min="1" max="{{$producto_proveedor->stock}}">
                <p class="card-text">{{$producto_proveedor->descripcion}}</p>
                <input type="number" name="stock" id="stock{{$producto_proveedor->id_producto}}" value="{{$producto_proveedor->stock}}" hidden>
                <h6><i>Proveedor: {{$producto_proveedor->nombre_proveedor}}</i></h6>
                </p>

            <input type="number" name="numero_venta" id="numero_venta" value="{{$contador_ventas + 1}}" hidden>
            <button type="submit" class="btn btn-primary" id="seleccionarProducto{{$producto_proveedor->id_producto}}"><i class="bi bi-cart">Añadir al carrito</i></button>
        </form>
        

                </div>
            </div>
<br>

        </div>
    </div>

        @endif
        @endforeach

    </div>
</div>




@endsection

@section('scripts')
  
<script>
    $(document).ready(function() {

        var crear = "http://localhost:8080/too/public/categoria/create";       

        $('#producto_proveedor').DataTable({
            "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }


        });
    });   

</script>

@endsection

