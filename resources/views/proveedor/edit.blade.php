<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<form id="editarProveedor{{$proveedor->id}}" action="{{url ('/proveedor/'.$proveedor->id)}}" method="post">
    @csrf
    {{method_field('PATCH')}}
    @include('proveedor.form')
</form>

<script>
    $('#editarProveedor{{$proveedor->id}}').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Proveedor editado correctamente',
            showConfirmButton: false,
            timer: 1500
        }).then(function(){
            $('#editarProveedor{{$proveedor->id}}').off('submit').submit();
        });
    })
</script>