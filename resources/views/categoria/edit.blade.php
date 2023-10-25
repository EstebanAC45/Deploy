
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<h5>Categoría seleccionada:</h5>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <form id="editarCategoria{{$categoria->id}}"  action="{{ url('/categoria/'.$categoria->id) }}" method="post">
    @csrf
    {{method_field('PATCH')}}
    <label for="nombre">Nombre categoría: </label><br>
    <input type="text" class="form-control" name="nombre" value="{{isset($categoria->nombre)?$categoria->nombre:''}}" pattern="[a-zA-Z ]{3,254}" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
    
    <label for="activo">Activo: </label><br>
    <select class="form-select" name="activo" id="activo">
        <option value="1" {{isset($categoria->activo) && $categoria->activo==1?'selected':''}}>Sí</option>
        <option value="0" {{isset($categoria->activo) && $categoria->activo==0?'selected':''}}>No</option>
    </select><br>
            
    <hr>
    <input class="btn btn-primary" type="submit" value="Guardar">

</form>
        </div>
    </div>
</div>

<script>
    $('#editarCategoria{{$categoria->id}}').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
        icon: 'success',
        title: 'Categoría editada exitosamente',
        text: 'Se ha editado la categoría exitosamente',
        timer: 3000,
        showConfirmButton: true,
        }).then(function() {
            $('#editarCategoria{{$categoria->id}}').off('submit').submit();
        });
     });
</script>


</body>
