@extends('layouts.parte1')

@section('contenido')

<h1>Listado de clientes</h1>

<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCliente" ><i class="bi bi-bookmark-plus"> Agregar Cliente</i></a><br><br>

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
