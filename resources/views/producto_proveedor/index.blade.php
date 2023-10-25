@inject('carritos', 'App\Models\Carrito')
@inject('productos', 'App\Models\Producto')
@inject ('venta', 'App\Models\Venta')
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

<h2>BIENVENIDO {{$nombre}}, HECHA UN VISTAZO A NUESTROS PRODUCTOS</h2>

<br><br>


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
        <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage').'/'.$producto_proveedor->imagen }}" alt="" width="280" height="160">
            <div class="card-body">
                <input type="text" name="id_producto" id="id_producto" value="{{$producto_proveedor->id_producto}}" hidden>
                <h5 class="card-title">{{$producto_proveedor->nombre_producto}} - $ {{$producto_proveedor->precio}}</h5>
                <h6 class="card-title"> Disponibles: {{$producto_proveedor->stock}}</h6>
                <input type="number" name="cantidad" id="cantidad{{$producto_proveedor->id_producto}}" class="form-control" value="1" placeholder="Ingrese cantidad" min="1" max="{{$producto_proveedor->stock}}">
                <p class="card-text">{{$producto_proveedor->descripcion}}</p>
                <input type="number" name="stock" id="stock{{$producto_proveedor->id_producto}}" value="{{$producto_proveedor->stock}}" hidden>
                <h6><i>Proveedor: {{$producto_proveedor->nombre_proveedor}}</i></h6>
                </p>
                <button class="btn btn-primary" id="seleccionarProducto{{$producto_proveedor->id_producto}}"
                onclick='carritoCatalogo({{ $producto_proveedor->id_producto }})'><i class="bi bi-cart">
                    Añadir al carrito</i>
                </button>
                <script>
                 function carritoCatalogo(id_producto){
                     let rutacarrito = '{{ route('carrito.store') }}';
                     let stock = $('#stock'+id_producto).val();
                     let cantidad = $('#cantidad'+id_producto).val();
                        if(cantidad > stock){
                            swal.fire({
                                title: "No hay suficiente stock",
                                text: "Solo hay "+stock+" productos disponibles",
                                icon: "error",
                                confirmButtonText: "Aceptar",
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }else{
                        console.log('ruta',rutacarrito)
                             $.ajax({
                                url: rutacarrito,
                                     method: 'POST',
                                     data: {
                                        id_producto: id_producto,
                                        cantidad: $('#cantidad'+id_producto).val(),
                                         numero_venta:"{{$contador_ventas + 1}}",
                                         _token: '{{ csrf_token() }}'
                                            },
                                        success: function(data){
                                            
                                            swal.fire({
                                                title: "Producto añadido al carrito",
                                                text: "Puede ver sus productos en el carrito",
                                                icon: "success",
                                                confirmButtonText: "Aceptar",
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    location.reload();
                                                }
                                            });

                                 }
                                });
                        }
                    }

                                            
                        </script>
                </div>
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
            },


        });
    });   

</script>

@endsection

