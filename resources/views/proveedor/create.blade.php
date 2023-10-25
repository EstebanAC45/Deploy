<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<form id="agregarProveedorSweet" action="{{ url('/proveedor') }}" method="post">
    @csrf
    <label for="nombre_proveedor">Nombre completo</label><br>
    <input type="text" class="form-control" name="nombre"  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>

    <label for="telefono_proveedor">Telefono Proveedor</label><br>
    <input type="text" class="form-control" name="telefono" pattern="[0-9]+" title="Solo se permiten números" required><br>

    <label for="direccion_proveedor">Direccion Proveedor</label><br>
    <input type="text" class="form-control" name="direccion" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" title="Por favor ingrese al menos 3 caracteres, ya sean letras o números." required><br>

    <label for="email_proveedor">Email Proveedor</label><br>
    <input type="email" class="form-control" name="email" required><br>
    <hr>
    <input class="btn btn-primary" type="submit" value="Guardar">

</form>

<script>
    $('#agregarProveedorSweet').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Proveedor agregado correctamente',
            showConfirmButton: false,
            timer: 1500
        }).then(function(){
            $('#agregarProveedorSweet').off('submit').submit();
        });
    })
</script>