<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<form id="editarElCliente{{$cliente->id}}" action="{{ url('/cliente/'.$cliente->id) }}" method = "post">
    @csrf
    {{method_field('PATCH')}}
    <label for="nombres">{{'Nombres'}}</label><br>
    <input type="text" name="nombres" class="form-control" id="nombres" value="{{$cliente->nombres}}"  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
    <label for="apellidos">{{'Apellidos'}}</label><br>
    <input type="text" name="apellidos" class="form-control" id="apellidos" value="{{$cliente->apellidos}}" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
    <label for="direccion">{{'Dirección'}}</label><br>
    <input type="text" name="direccion" class="form-control" id="direccion" value="{{$cliente->direccion}}" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
    <label for="telefono">{{'Teléfono'}}</label><br>
    <input type="text" name="telefono" class="form-control" id="telefono" value="{{$cliente->telefono}}" pattern="[0-9]+" required title="solo se permiten números"><br>
    <label for="correo">{{'Correo'}}</label><br>
    <input type="email" name="correo" class="form-control" id="correo" value="{{$cliente->correo}}" required><br>
    <label for="compras_realizadas">{{'Compras realizadas'}}</label><br>
    <input type="number" class="form-control" name="compras_realizadas" id="compras_realizadas" value="{{$cliente->compras_realizadas}}"><br>
    <label for="activo">{{'Activo'}}</label><br>
    <select class="form-select" name="activo" id="activo">
        <option value="1" {{$cliente->activo==1?'selected':''}}>Sí</option>
        <option value="0" {{$cliente->activo==0?'selected':''}}>No</option>
    </select><br>
    <label for="tarjeta_fidelidad">{{'Tarjeta de fidelidad'}}</label><br>
    <select name="tarjeta_fidelidad" id="tarjeta_fidelidad" class="form-select">
        <option value="1" {{$cliente->tarjeta_fidelidad==1?'selected':''}}>Sí</option>
        <option value="0" {{$cliente->tarjeta_fidelidad==0?'selected':''}}>No</option>
    </select><br>
    <label for="fecha_registro">{{'Fecha de registro'}}</label><br>
    <input type="date" name="fecha_registro" id="fecha_registro" class="form-control" value="{{$cliente->fecha_registro}}"><br>

    <input type="submit" class="btn btn-primary" value="Guardar">
</form>

<script>
    $('#editarElCliente{{$cliente->id}}').on('submit', function(e){
        e.preventDefault();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Cliente editado correctamente',
            showConfirmButton: false,
            timer: 1500
        }).then(function(){
            $('#editarElCliente{{$cliente->id}}').off('submit').submit();
        });
    })
</script>