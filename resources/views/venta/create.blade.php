
@inject ('producto', 'App\Models\Producto')
@inject ('producto_proveedor', 'App\Models\Producto_Proveedor')
@inject ('proveedor', 'App\Models\Proveedor')
@inject ('cliente', 'App\Models\Cliente')
@inject ('carritos', 'App\Models\Carrito')
@inject ('venta', 'App\Models\Venta')
@extends('layouts.parte1')


@section('contenido')

<h3>Bienvenido, aquí puede realizar su compra</h3>
@if (session()->has('mensaje'))
    <script>
        Swal.fire(
            '!Error!',
            'Agregue un cliente para realizar la compra',
            'error'
        )
    </script>
@endif

@if (session()->has('error'))
    <script>
        Swal.fire(
            '!Error!',
            'Agregue un cliente para realizar la compra',
            'error'
        )
    </script>
@endif




@php 
    $contador_ventas = 0;
@endphp
@foreach ($venta->get() as $venta)
@php
    $contador_ventas = $contador_ventas + 1;
@endphp

@endforeach
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <p>Número de venta:</p>
               <input type="text" name="" id="" value="{{$contador_ventas + 1}}" disabled>
             <input type="number" name="numero_venta" id="numero_venta" value="{{$contador_ventas + 1}}" hidden>
        </div>
        <div class="col-md-6">
             <p>Fecha:</p>
             <input type="text" name="" id="" value="{{ date('d-m-Y h:i:s') }}" disabled>
        </div>
    </div>
</div>



<br>

<hr>


<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearVenta" ><i class="bi bi-search"> Buscar Producto</i></a><br><br>

 <!--tabla de carrito para mostrar los productos seleccionados-->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h6>Productos seleccionados</h6>
            <table id="carrito" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
                    <thead>


                        <tr>

                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>

                    @php
                            $contador = 0;
                            $total_pagar = 0;
                    @endphp
                        @foreach ($carritos->get() as $carrito)
                         @if($carrito->numero_venta == $contador_ventas + 1)
                        @php
                            
                            $contador = $contador + 1;
                            $total_pagar = $total_pagar + ($carrito->cantidad * $producto->find($carrito->id_producto)->precio);
                        @endphp

                        <tr>
 
                            
                            @foreach ($producto->get() as $producto)
                                @if ($carrito->id_producto == $producto->id)
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $carrito->cantidad }}</td>
                                    <td><i>$</i> {{ $producto->precio }}</td>
                                    <td><i>$</i> {{ $producto->precio * $carrito->cantidad }}</td>
                                    <input type="number" name="cantidadCarrito" value="{{$carrito->cantidad}}" hidden>
                                @endif
                            @endforeach
                            <td>
                                <form action="{{ route('carrito.destroy', $carrito->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @php
                            $contador = $contador - 1;  
                        @endphp
                        @endif
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-end">Total a pagar</td>
                            <td colspan="1" class="text-end"><i>$</i> {{ $total_pagar }}</td>
                        </tr>
                    </tbody>
            </table>
        
    </div>
        
        <div class="col-md-2">
            <form id="enviarCompraPorEfectivo" action="{{ route('venta.store') }}" method="POST">
                @csrf
                <input type="number" name="numero_venta" id="numero_venta" value="{{$contador_ventas + 1}}" hidden >
                @foreach ($cliente->get() as $cliente)
                @php
                $rol = session('rol');
                @endphp
                @if($cliente->correo == session('email') && $rol == 2)
                <input type="number" name="id_cliente" id="cliente_seleccionado" value="{{$cliente->id}}" hidden >
                <input type="number" name="compras_realizadas" id="compra_seleccionada" value="{{$cliente->compras_realizadas}}" hidden>
                @endif
                @endforeach
                @php
                $rol = session('rol');
                @endphp
                @if($rol == 1 || $rol == 3)
                <input type="number" name="id_cliente" id="cliente_seleccionado" value="" hidden>
                <input type="number" name="compras_realizadas" id="compra_seleccionada" value="" hidden>
                @endif

                <input type="number" name="precio_venta" id="precio_venta" value="{{$total_pagar}}" hidden ><br><br>
                <!--<input type="text" name="fecha" id="fecha" value="{{ date('YYYY-MM-DD') }}" hidden>-->
                <input type="text" name="fecha_registro" id="fecha_registro" value="{{date('d-m-Y h:i:s')}}" hidden >
                @if($total_pagar > 0)
                <button type="submit" class="btn btn-primary">Pago con efectivo</button><br>
                @endif
            </form>
        </div>

        
        <div class="col-md-2">
            <form id="enviarCompraPorTarjeta" action="{{ route('stripe.post') }}" method="POST">
                @csrf
                <input type="number" name="numero_venta" id="numero_venta" value="{{$contador_ventas + 1}}" hidden>
                @foreach ($cliente->get() as $cliente)
                @if($cliente->correo == session('email') && $rol == 2)
                <input type="number" name="id_cliente" id="cliente_seleccionado1" value="{{$cliente->id}}" hidden>
                <input type="number" name="compras_realizadas" id="compra_seleccionada1" value="{{$cliente->compras_realizadas}}" hidden >
                @endif
                @endforeach

                @php 
                $rol = session('rol');
                @endphp

                @if($rol == 1 || $rol == 3)
                <input type="number" name="id_cliente" id="cliente_seleccionado1" value="" hidden>
                <input type="number" name="compras_realizadas" id="compra_seleccionada1" value="" hidden >          
                @endif
                <!--<input type="text" name="fecha" id="fecha" value="{{  date('d-m-Y h:i:s') }}" hidden>-->
                <input type="number" name="precio_venta" id="precio_venta" value="{{$total_pagar}}" hidden><br><br>
                <input type="text" name="fecha_registro" id="fecha_registro" value="{{date('d-m-Y h:i:s')}}" hidden>
                @if($total_pagar > 0)
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-amount="{{$total_pagar}}"
                    data-name="Stripe Demo"
                    data-description="Online course about integrating Stripe"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="clp">
                </script>
                @endif
            </form>
        </div>
    </div>

</div>



<!-- Modal seleccionar producto-->
<div class="modal fade" id="crearVenta" tabindex="-1" aria-labelledby="crearVenta" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccione sus productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <h6>Productos disponibles</h6>
            <div class="table-responsive">
            <table id="ventas" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Disponibles</th>
                        <th>proveedor</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($producto_proveedor->get() as $producto_proveedor)
                        @foreach ($producto->get() as $producto)

                            @if ($producto_proveedor->id_producto == $producto->id && $producto->activo==1)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>$ {{ $producto->precio }}</td>
                                    <td>
                                        <!--Mostrar la imagen del producto-->
                                        <img src="../img/{{$producto->imagen}}" alt="" width="100">
                                    </td>
                                    <td>
                                        <form action="{{route('carrito.store')}}" method="POST">
                                            @csrf
                                        <input type="number" name="cantidad" id="cantidad{{ $producto->id }}" class="form-control form-control-sm"  value="1" min="1" max="{{$producto->stock}}">

                                    </td>

                                    <td>{{ $producto->stock }}</td>
                                    @foreach ($proveedor->get() as $proveedor)
                                    @if($producto_proveedor->id_proveedor == $proveedor->id)
                                    <td>{{ $proveedor->nombre }}</td>
                                    @endif

                                    @endforeach
                                    

                                    <td>
                                        
                                            <input type="text" name="principal" value="0" hidden>
                                            <input type="text" name="id_producto" id="id_producto" value="{{$producto->id}}" hidden>
                                            <input type="number" name="stock" id="stock{{$producto->id}}" value="{{$producto->stock}}" hidden>
                                            <input type="number" name="numero_venta" id="numero_venta" value="{{$contador_ventas + 1}}" hidden>
                                            <button type="submit" class="btn btn-primary" id="seleccionarProducto{{$producto->id}}"><i class="bi bi-cart">Añadir</i></button>
                                        </form>
                                    </td>
                                </tr>


                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<hr>
@php

$rol = session('rol');

@endphp

@if($rol == 1 || $rol == 3)
<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seleccionarCliente" ><i class="bi bi-search"> Seleccion de cliente</i> </a><br><br>
@endif

<h6>Cliente</h6>
            @php 
             
             $correo = session('email');
                                        
            @endphp
    @foreach ($cliente->get() as $cliente)
        @if($cliente->correo == $correo)
<div class="container">
    
    <div class="row">
        <div class="col-md-8">
                    <input type="number" name="id_cliente" id="cliente_seleccionado" value="{{$cliente->id}}" hidden >
                    <input type="number" name="compras_realizadas" id="compra_seleccionada" value="{{$cliente->compras_realizadas}}" hidden>
                    <div class="row">
                <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nombre_cliente">Nombre</label>
                            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="{{$cliente->nombres}}" disabled>
                        </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="apellido_cliente">Apellido</label>
                        <input type="text" name="apellido_cliente" id="apellido_cliente" class="form-control" value="{{$cliente->apellidos}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="telefono_cliente">Telefono</label>
                        <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" value="{{$cliente->telefono}}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="correo_cliente">Correo</label>
                        <input type="text" name="correo_cliente" id="correo_cliente" class="form-control" value="{{$cliente->correo}}" disabled>
                    </div>
                </div>
             </div>
             </div>
                </div>
        @endif
    @endforeach

</div>
@php
$rol = session('rol');
@endphp

@if($rol == 1 || $rol == 3)
    <div class="container">
    
    <div class="row">
        <div class="col-md-8">
                    <input type="number" name="id_cliente" id="cliente_seleccionado" value="{{$cliente->id}}" hidden >
                    <input type="number" name="compras_realizadas" id="compra_seleccionada" value="{{$cliente->compras_realizadas}}" hidden>
                    <div class="row">
                <div class="col-sm-3">
                        <div class="form-group">
                            <label for="nombre_cliente">Nombre</label>
                            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="" disabled>
                        </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="apellido_cliente">Apellido</label>
                        <input type="text" name="apellido_cliente" id="apellido_cliente" class="form-control" value="" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="telefono_cliente">Telefono</label>
                        <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" value="" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="correo_cliente">Correo</label>
                        <input type="text" name="correo_cliente" id="correo_cliente" class="form-control" value="" disabled>
                    </div>
                </div>
             </div>
             </div>
            </div>
            </div>
@endif


            <br>
            <br>




            <style>
.table-responsive {
  overflow-x: auto;
  max-width: 100%;
  width: 100%;
}
#clientes_responsive {
    width: 70%;
  max-width: 1000px;
}
@media (max-width: 768px) {
  #clientes_responsive{
    width: 100%;
  }
}

</style>




<div class="modal fade" id="seleccionarCliente" tabindex="-1" aria-labelledby="seleccionarCliente" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="clientes_responsive">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seleccione sus credenciales</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="clientes" class="table table-striped table-bordered shadow-lg mt-4 table-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cliente->get() as $cliente)
                <tr>

                    <td>{{ $cliente->nombres }}</td>
                    <td>{{ $cliente->apellidos }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>
                        
                        <button class="btn btn-info" data-bs-toggle="modal" id="btn_seleccionar_cliente{{$cliente->id}}" ><i class="bi bi-pencil-fill"> Seleccionar</i></button>
                    </td>
                </tr>
                <script>

                    

                    $('#btn_seleccionar_cliente{{$cliente->id}}').click(function(){
                        
                        var id_cliente = '{{ $cliente->id }}';
                        var nombre_cliente = '{{ $cliente->nombres }}';
                        var apellido_cliente = '{{ $cliente->apellidos }}';
                        var telefono_cliente = '{{ $cliente->telefono }}';
                        var correo_cliente = '{{ $cliente->correo }}';
                        var compras_realizadas_clientes = '{{ $cliente->compras_realizadas }}';

                        $('#id_cliente').val(id_cliente);
                        $('#cliente_seleccionado').val(id_cliente);
                        $('#cliente_seleccionado1').val(id_cliente);
                        $('#nombre_cliente').val(nombre_cliente);
                        $('#apellido_cliente').val(apellido_cliente);
                        $('#telefono_cliente').val(telefono_cliente);
                        $('#correo_cliente').val(correo_cliente);
                        $('#compras_realizadas').val(compras_realizadas_clientes);
                        $('#compra_seleccionada').val(compras_realizadas_clientes);
                        $('#compra_seleccionada1').val(compras_realizadas_clientes);
                        $('#seleccionarCliente').modal('toggle');  
                    
                    });
                </script>
                @endforeach
            </tbody>
        </table>
     </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>

$(document).ready(function() {
     

     $('#ventas').DataTable({
         "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
         "language": {
             "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
         },



     });
 });   
</script>

<script>

$(document).ready(function() {
     

     $('#clientes').DataTable({
         "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
         "language": {
             "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
         },
     }); 
</script>

@endsection