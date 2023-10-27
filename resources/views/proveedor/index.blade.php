@extends('layouts.parte1')
@section('contenido')
<br>
<h1>Proveedores</h1>
@if(session()->has('mensaje'))
<script>
    Swal.fire(
        'Error!',
        'Correo existente',
        'error'
    )
</script>
@endif

@if(session()->has('mensaje1'))
<script>
    Swal.fire(
        'Exito!',
        'Proveedor agregado correctamente',
        'success'
    )
</script>
@endif



<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProveedor">
    <i class="bi bi-file-plus-fill"> Agregar proveedor</i>
</a>
<br>
<br>

<!--Mandar el estado del proveedor para que se muestre en la tabla dependiendo si esta ac
tivo o no-->
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('proveedor.index')}}" class="btn btn-info">Todos</a>
    <a href="{{ route('proveedor.activos') }}" class="btn btn-primary">Activos</a>
    <a href="{{ route('proveedor.inactivos') }}" class="btn btn-secondary">Inactivos</a>
</div>
<br><br>

<table id="proveedor"  class="table table-striped" style="width:100%">
    <thead class="thead-light">
        <tr>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proveedors as $proveedor)
        <tr>
            <td>
                {{ $proveedor->nombre }}
            </td>
            <td>
                {{ $proveedor->direccion }}
            </td>
            <td>
                {{ $proveedor->telefono }}
            </td>
            <td>
                {{ $proveedor->email }}
            </td>
            <td>
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarProveedor-{{$proveedor->id}}" ><i class="bi bi-pencil-fill">Editar</i></a>
                <form hidden action="{{ url('/proveedor/'.$proveedor->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar">
                </form>
            </td>
        </tr>
        
        <!-- Modal para editar -->
        <div class="modal fade" id="editarProveedor-{{$proveedor->id}}" tabindex="-1" aria-labelledby="editarProveedor-{{$proveedor->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #63D38B;" >
                <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('proveedor.edit')
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>
        @endforeach
    </tbody>


</table>

<!-- Modal -->
<div class="modal fade" id="crearProveedor" tabindex="-1" aria-labelledby="crearProveedor" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8DD3EC;">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include('proveedor.create', ['modo'=>'Crear'])
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
   

        $('#proveedor').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },


        });
    });   

</script>
@endsection