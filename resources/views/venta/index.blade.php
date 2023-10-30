@extends('layouts.parte1')
@inject('carritos', 'App\Models\Carrito')
@inject('productos', 'App\Models\Producto')
@inject('clientes', 'App\Models\Cliente')
@inject('pdf', 'App\Http\Controllers\PDFController')


@section('contenido')
<h2>Registro de ventas realizadas</h2>
@if (session()->has('mensaje2'))
    <script>
        Swal.fire(
            '!Éxito!',
            'Compra realizada con éxito',
            'success'
        )
    </script>
@endif

@php 
 $rol = session ('rol');
 $correo = session ('email');
@endphp

@if ($rol == 1 || $rol == 3)
<table id="ventas" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Productos</th>
            <th>Fecha de venta</th>
            <th>Total</th>
            <th>Generar Factura</th>
            <th>Devolución</th>
        </tr>
    </thead>
    <tbody>
        @php
          $contador = 0;
        @endphp
        @foreach($ventas as $venta)

        @php
            
            $carrito_venta = $carritos::where('numero_venta', $venta->numero_venta)->get();
        @endphp
        @if($carrito_venta->count() == 0)
        @php
            continue;

        @endphp
        @else
        @php
            $contador++;
        @endphp
        <tr>
            <td>{{$contador}}</td>
            <td>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#cliente{{$venta->numero_venta}}">
                    <i class="bi bi-person"> {{$venta->nombres}}{{$venta->apellidos}}</i>
                </button>
            </td>
            <td>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal{{$venta->numero_venta}}">
                    <i class="bi bi-list-ol"> Productos</i>
                </button>
            </td>
            
            <td>
                {{ $venta->fecha_registro }}
            </td>
            <td>
                <i>$ {{ $venta->precio_venta }}</i>
            </td>
            <td>
                <a href="{{ route('pdf.show', $venta->numero_venta) }}" class="btn btn-success" target="_blank"><i class="bi bi-file-earmark-pdf"> Factura</i></a>
            </td>
        
            <td>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#devolucion{{$venta->numero_venta}}">
                    <i class="bi bi-arrow-counterclockwise"> Devolución</i>
                </button>            
            </td>
        </tr>
        @endif
        @endforeach
        
    </tbody>
    

</table>
@endif

<!--compararemos el rol del usuario para mostrarle solo sus ventas con el correo del cliente y de sesion-->
@if ($rol == 2)
@php
    $contador = 0;
@endphp

    
    <table id="ventasCliente" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Productos</th>
                <th>Fecha compra</th>
                <th>Total</th>
                <th>Generar Factura</th>
            </tr>
        </thead>
        <tbody>
    @foreach($ventas as $venta)
    @if($venta->correo == $correo)
    @php
        $contador++;
        $carrito_venta = $carritos::where('numero_venta', $venta->numero_venta)->get();
    @endphp
            <tr>
               <td>{{$contador}}</td>
               <td>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#cliente{{$venta->numero_venta}}">
                        <i class="bi bi-person"> {{$venta->nombres}}{{$venta->apellidos}}</i>
                    </button>
               </td>
               <td>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal{{$venta->numero_venta}}">
                       <i class="bi bi-list-ol"> Productos</i>
                    </button>
                </td>

                <td>
                    {{ $venta->fecha_registro }}
                </td>

                <td>
                    <i>$ {{ $venta->precio_venta }}</i>
                </td>

                <td>
                    <a href="{{ route('pdf.show', $venta->numero_venta) }}" class="btn btn-success" target="_blank"><i class="bi bi-file-earmark-pdf"> Factura</i></a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

@endif


@foreach($ventas as $venta)
@php
    $carrito_venta = $carritos::where('numero_venta', $venta->numero_venta)->get(); 
@endphp

<div class="modal fade" id="myModal{{$venta->numero_venta}}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Listado de productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrito_venta as $carrito)
                        @php
                            $producto = $productos::where('id', $carrito->id_producto)->get();
                        @endphp
                        @foreach($producto as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $carrito->cantidad }}</td>
                            <td>$ {{ $producto->precio }}</td>
                            <td>{{ $producto->descripcion }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cliente{{$venta->numero_venta}}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Datos del cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $venta->nombres }}</td>
                                <td>{{ $venta->apellidos }}</td>
                                <td>{{ $venta->direccion }}</td>
                                <td>{{ $venta->telefono }}</td>
                            </tr>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="devolucion{{$venta->numero_venta}}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Devolución de productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h6>Listado de productos</h6>
                    <table class="table table-responsive"> 
                        <thead>
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Fecha de vencimiento</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                                <th>Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 0;
                            @endphp
                            @foreach($carrito_venta as $carrito)
                            @php
                                $contador++;
                                $producto = $productos::where('id', $carrito->id_producto)->get();
                            @endphp
                            @foreach($producto as $producto)
                            <tr>
                                <td>-</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{$producto->fecha_vencimiento}}</td>
                                <td>{{ $carrito->cantidad }}</td>
                                <td>$ {{ $producto->precio }}</td>
                                <td>$ {{ $carrito->cantidad * $producto->precio }}</td>
                                <td>
                                    <form action="{{ route('carrito.devolucion', $carrito->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var crear = "http://localhost:8080/too/public/categoria/create";       

        $('#ventas').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"              
             
            },
            
        });
    });   

</script>


@endsection