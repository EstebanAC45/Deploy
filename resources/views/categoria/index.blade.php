@inject('categoria', 'App\Models\Categoria')
@extends('layouts.parte1')

@section('contenido')
<br>
<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoria" ><i class="bi bi-bookmark-plus"> Crear Categoría</i></a>
<br><br>

<h2>Lista de categorías</h2>

@if(session('mensaje'))
    <script>
        Swal.fire(
            '¡Error!',
            'La categoría ya existe',
            'error'
        )
    </script>
@endif

@if(session('mensaje1'))
    <script>
        Swal.fire(
            '¡Éxito!',
            'Categoría agregada con éxito',
            'success'
        )
    </script>
@endif

@if(session('mensaje3'))
    <script>
        Swal.fire(
            '¡Error!',
            'La categoría ya existe',
            'error'
        )
    </script>
@endif

@if(session('mensaje4'))
    <script>
        Swal.fire(
            '¡Éxito!',
            'Categoría editada con éxito',
            'success'
        )
    </script>
@endif
<center>
<table id="categorias" class="table table-striped" style="width:90%">
    <thead class="thead-light">
       <tr>
       <center><th>#</th></center>
       <center><th>Nombre</th></center>
       <center><th>Acciones</th></center>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 0 ?>
        @foreach($categorias as $categoria)
        <?php $contador++ ?>
        <tr id="activoInactivo">
        <center><td><?php echo $contador;?></td></center>
        <center><td>{{ $categoria->nombre }}</td></center>
            
            <td>
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarCategoria-{{$categoria->id}}" ><i class="bi bi-pencil-fill">Editar</i></a>
                <form action="{{ url('/categoria/'.$categoria->id) }}" method="post" style="display:inline">
                    @csrf
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" id="categoria_elimiar_alert" type="submit"><i class="bi bi-trash-fill">Borrar</i></button>  
                </form>
            </td>
        </tr>
        
        <div class="modal fade" id="editarCategoria-{{$categoria->id}}" tabindex="-1" aria-labelledby="editarCategoria-{{$categoria->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color:#63D38B ">
                <h5 class="modal-title" id="exampleModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('categoria.edit')
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        @endforeach
    </tbody>
</table>
</center>
<br>


<!-- Modal -->
<div class="modal fade" id="crearCategoria" tabindex="-1" aria-labelledby="crearCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8DD3EC;">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @include('categoria.create')
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

        $('#categoria_elimiar_alert').on('click', function(e){
            e.preventDefault();
            Swal.fire({
            icon: 'success',
            title: 'Categoría eliminada exitosamente',
            text: 'Se ha eliminado la categoría exitosamente',
            timer: 3000,
            showConfirmButton: true,
            }).then(function() {
                $('#categoria_elimiar_alert').off('click').click();
            });
        });

        $('#categorias').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },
        });
    });   

</script>


@endsection
