<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<form id="agregarElCliente" action="{{ url ('/cliente') }}" method="post">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <label for="nombres">{{'Nombres'}}</label><br>
                 <input type="text" name="nombres" id="nombres" class="form-control" value=""  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
                
                 <label for="direccion">{{'Dirección'}}</label><br>
                <input type="text" name="direccion" id="direccion" class="form-control" value="" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>

                <label for="correo">{{'Correo'}}</label><br>
                 <input type="email" name="correo" id="correo" class="form-control" value="" required><br>

                 <label for="activo">{{'Activo'}}</label><br>
                <select class="form-select" name="activo" id="activo">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select><br>

                <label  for="fecha_registro">{{'Fecha de registro'}}</label><br>
                <input class="form-control" type="date" name="fecha_registro" id="fecha_registro" value="" required><br>

                <label for="tarjeta_fidelidad">{{'Tarjeta de fidelidad'}}</label><br>
                <select class="form-select" name="tarjeta_fidelidad" id="tarjeta_fidelidad">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select><br>
            </div>
            <div class="col-md-6">
                <label for="apellidos">{{'Apellidos'}}</label><br>
                <input type="text" name="apellidos" id="apellidos" class="form-control" value=""  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>

                <label for="telefono">{{'Teléfono'}}</label><br>
                <input type="text" name="telefono" id="telefono" class="form-control" value="" pattern="[0-9]+" title="Solo se permiten números" required><br>

                <label for="contrasena">{{'Contraseña'}}</label><br>
                <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" title="Solo letras, números y _, un mínimo de 6 caracteres" name="contrasena" id="contrasena" class="form-control" value="" required><br>

                <label for="confirmar_contrasena">{{'Confirmar contraseña'}}</label><br>
                <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" title="Solo letras, números y _, un mínimo de 6 caracteres" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control" value="" required><br>

                <label for="compras_realizadas">{{'Compras realizadas'}}</label><br>
                 <input type="number" name="compras_realizadas" id="compras_realizadas" class="form-control" value="0" min="0" required><br>

                <br>
                <input class="form-control" type="number" name="id_rol" id="id_rol" value="2" hidden>
                <input class="btn btn-primary" type="submit" value="Agregar">

            </div>
        </div>
    </div>


   

 



</form>

