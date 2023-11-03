
<label for="nombre_proveedor">Nombre completo</label><br>
    <input type="text" class="form-control" name="nombre" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required value="{{ isset($proveedor->nombre)?$proveedor->nombre:''}}"><br>

    <label for="telefono_proveedor">Telefono Proveedor</label><br>
    <input type="text" class="form-control" name="telefono" pattern="[0-9]+" title="Solo se permiten números" required value="{{ isset($proveedor->telefono)?$proveedor->telefono:''}}"><br>

    <label for="direccion_proveedor">Direccion Proveedor</label><br>
    <input type="text" class="form-control" name="direccion" pattern="^[a-zA-ZáéíóúñÑ\s, ]{3,254}$" title="Por favor ingrese al menos 3 caracteres, ya sean letras o números." required value="{{ isset($proveedor->direccion)?$proveedor->direccion:''}}" required><br>

    <label for="email_proveedor">Email Proveedor</label><br>
    <input type="email" class="form-control" name="email"  value="{{ isset($proveedor->email)?$proveedor->email:'' }}" required><br>

    <label for="activo">Activo</label><br>
    <select class="form-select" name="activo" id="activo">
        <option value="1" {{isset($proveedor->activo) && $proveedor->activo==1?'selected':''}}>Activo</option>
        <option value="0" {{isset($proveedor->activo) && $proveedor->activo==0?'selected':''}}>Inactivo</option>
    </select>

    <hr>
    <input type="submit" value="Guardar" class="btn btn-primary">
