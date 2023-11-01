@extends('layouts.parte1')

@section('contenido')


@if (session()->has('mensaje'))
        <script>
            Swal.fire(
                '¡Error!',
                'El correo ya existe',
                'error'
            )
        </script>
    @endif

    @if (session()->has('mensaje1'))
        <script>
            Swal.fire(
                '¡Éxito!',
                'Cliente agregado con éxito',
                'success'
            )
        </script>
    @endif

    @if (session()->has('mensaje9'))
        <script>
            Swal.fire(
                '¡Error!',
                'Las contraseñas no coinciden',
                'error'
            )
        </script>
    @endif

    @if (session()->has('mensaje12'))
        <script>
            Swal.fire(
                '¡Éxito!',
                'Cliente editado con éxito',
                'success'
            )
        </script>
    @endif

    @if (session()->has('mensaje10'))
        <script>
            Swal.fire(
                'Error!',
                'Las contraseñas no coinciden',
                'error'
            )
        </script>
    @endif
    


@php
$rol = session()->get('rol');
@endphp

@if($rol == 1 || $rol == 3)

<h1>Listado de clientes</h1>

<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCliente" ><i class="bi bi-bookmark-plus"> Agregar Cliente</i></a><br><br>


<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('cliente.index') }}" class="btn btn-info">Todos</a>
    <a href="{{ route('cliente.activos') }}" class="btn btn-primary">Activos</a>
    <a href="{{ route('cliente.inactivos') }}" class="btn btn-secondary">Inactivos</a>
</div>
    <br><br>
<table id="cliente"class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Compras realizadas</th>
            <th>Tarjeta de fidelidad</th>
            <th>Fecha de registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $contador = 0;
        @endphp
        @foreach ($clientes as $cliente)
        @php 
            $contador++;
        @endphp
            <tr>
                <td>{{ $contador }}</td>
                <td>{{ $cliente->nombres }}</td>
                <td>{{ $cliente->apellidos }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->correo }}</td>
                <td>{{ $cliente->compras_realizadas }}</td>
                <td>
                    @if ($cliente->tarjeta_fidelidad == 1)
                        Sí
                    @else
                        No
                    @endif
              </td>
                <td>{{ $cliente->fecha_registro }}</td>
                <td>
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarCliente{{$cliente->id}}" ><i class="bi bi-pencil-fill"> Editar</i></a>
                    <!--<form action="{{ url('/cliente/'.$cliente->id) }}" method="post" class="d-inline" hidden>
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" onclick="return confirm('¿Quieres borrar?')" class="btn btn-danger" value="Borrar">
                    </form>-->
                </td>
            </tr>
            <!-- Modal editar cliente-->
        <div class="modal fade" id="editarCliente{{$cliente->id}}" tabindex="-1" aria-labelledby="editarCliente{{$cliente->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #63D38B;">
                <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('cliente.edit')
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        @endforeach 
    </tbody>
</table>


<!-- Modal crear cliente-->
<div class="modal fade" id="crearCliente" tabindex="-1" aria-labelledby="crearCliente" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8DD3EC;">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include('cliente.create')
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

@else
    <!--mostrar los datos del cliente logueado-->

    <table class="table">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Compras realizadas</th>
                <th>Fecha de registro</th>
                <th>Cambiar datos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                @php
                    $correo = session()->get('email');
                @endphp
                @if ($cliente->correo == $correo)
            <tr>
                <td>{{ $cliente->nombres }}</td>
                <td>{{ $cliente->apellidos }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->correo }}</td>
                <td>{{ $cliente->compras_realizadas }}</td>
                <td>{{ $cliente->fecha_registro }}</td>
                <td>
                    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarCliente{{$cliente->id}}" ><i class="bi bi-pencil-fill"> Editar</i></a>
                </td>
            </tr>

            <!-- Modal editar cliente-->
        <div class="modal fade" id="editarCliente{{$cliente->id}}" tabindex="-1" aria-labelledby="editarCliente{{$cliente->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #63D38B;">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <form id="crearUsuario" action="{{route('cliente.updateCliente', $cliente->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombres" id="nombres" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" class="form-control" placeholder="Ingrese nombre" value ="{{$cliente->nombres}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellidos" id="apellidos" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" class="form-control" placeholder="Ingrese apellido" value ="{{$cliente->apellidos}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="number" name="telefono" id="telefono" pattern="[0-9]+" class="form-control" placeholder="Ingrese teléfono" value="{{$cliente->telefono}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" class="form-control" placeholder="Ingrese dirección" value="{{$cliente->direccion}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingrese email" value="{{$cliente->correo}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" name="contrasena" id="contrasena" class="form-control" placeholder="Ingrese contraseña" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmar_contrasena">Confirmar contraseña</label>
                            <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control" placeholder="Confirme contraseña" required>
                        </div>
                        <input type="number" name="compras_realizadas" id="compras_realizadas" value="{{$cliente->compras_realizadas}}" hidden>
                        <input type="number" name="activo" id="activo" value="1" hidden>
                        <input type="number" name="tarjeta_fidelidad" value="0" hidden>
                        <input type="text" name="fecha_registro" id="fecha_registro" value="{{date('d-m-y')}}" hidden>
                        <input type="number" name="id_rol" id="id_rol" value="2" hidden>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">
                        Actualizar datos
                    </button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>



                @endif
            @endforeach
        </tbody>
    </table>
@endif
@endsection

@section('scripts')
<script>

$(document).ready(function() {
     

     $('#cliente').DataTable({
         "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
         "language": {
             "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
         },



     });
 });   
</script>
@endsection
