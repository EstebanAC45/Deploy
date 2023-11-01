@inject('productos', 'App\Models\Producto')
@inject('carritos', 'App\Models\Carrito')
@inject('ventas', 'App\Models\Venta')
@inject('clientes', 'App\Models\Cliente')
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title> Factura </title>
</head>
<body>
	<center><h3>SUPERMERCADO, TODO AQUÍ LO ENCUENTRA</h3></center>
	<center><h5>Gracias por su preferencia</h5></center>
	@php
		$numero_venta = request()->route('id');

	@endphp

	@php
		$venta = $ventas::where('numero_venta', $numero_venta)->get();
	@endphp

	@foreach($venta as $venta)
		@php
			$id_cliente = $venta->id_cliente;
		@endphp
	<header>
		<style>
			.detalle-venta{
				float : right;
				margin-right: 230px;
				margin-top: -120px;

			}
		</style>
		<div class="container">
			<img src="https://previews.123rf.com/images/freaktor/freaktor2002/freaktor200200004/139383340-verduras-en-carro-de-compras-carro-supermercado-logo-icono-diseño-vector.jpg" height="150px" alt="Logo de la empresa">
		</div>
		<div class="detalle-venta">
		<h2>Detalle de venta</h2>
					<p>
						<strong>Número de venta:</strong> {{ $numero_venta }}<br>
						<strong>Fecha de venta:</strong> {{ $venta->fecha_registro }}<br>
					</p>
		</div>


	</header>
	@endforeach
	<hr>
	@php
		$cliente = $clientes::where('id', $id_cliente)->get();
	@endphp
	<section>
	<center><h4>Detalles del cliente</h4></center>

		<table class="table">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Dirección</th>
					<th>Teléfono</th>
					<th>Correo electrónico</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				@foreach($cliente as $cliente)
					<td>{{ $cliente->nombres}} {{$cliente->apellidos}}</td>
					<td>{{ $cliente->direccion }}</td>
					<td>{{ $cliente->telefono }}</td>
					<td>{{ $cliente->correo }}</td>
				@endforeach
				</tr>
			</tbody>
		</table>
	</section>


	<hr>

	<!--Sentencia para usar en el foreach y traer los datos del cliente-->
	<section>
	<center><h4>Productos comprados</h4></center>
	<table class="table">
					<thead>
						<tr>
							<th></th>
							<th>Productos</th>
							<th>Cantidad</th>
							<th>Precio unitario</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
							@php
                                $contador = 0;
                            @endphp
                            @foreach($carritos::where('numero_venta', $numero_venta)->get() as $carrito)
                            @php
                                $contador++;
                                $producto = $productos::where('id', $carrito->id_producto)->get();
                            @endphp
						 	@foreach($producto as $producto)
							<tr>
								<td>-</td>
								<td>{{ $producto->nombre }}</td>
								<td>{{ $carrito->cantidad }}</td>
								<td>$ {{ $producto->precio }}</td>
								<td>$ {{ $producto->precio * $carrito->cantidad }}</td>
							</tr>
							@endforeach
							@endforeach
							<tr>
								<br>
								<td colspan="4" class="text-end">Total a pagar: </td>
								<td> $ {{ $venta->precio_venta }}</td>
							</tr>
					</tbody>
				</table>
	</section>
				
	<hr>
	<footer>
	<p>
		<center><strong>Supermercado, Todo aquí lo encuentras</strong></center><br>
		<center><strong>Dirección:</strong> Calle 123, San Salvador, El Salvador | 
		<strong>Teléfono:</strong> (+503) 555-5555 </center> <br>
		<center><strong>Correo electrónico:</strong> info@example.com</center>
	</p>
	<p>
		<center>Todos los derechos reservados.</center>
	</p>
</footer>
</body>


</html>