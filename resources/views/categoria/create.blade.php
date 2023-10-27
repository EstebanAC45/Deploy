<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h5>Complete los campos correctamente</h5>
        <form id="enviarCategoria" action="{{ url('/categoria') }}" method="post">
            @csrf
            
            <label for="nombre">Nombre categoría: </label><br>
            <input class="form-control" type="text" name="nombre" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" title="Solo se permiten un mínimo de 3 letras, no números" required><br>
        
            <label hidden for="activo">Activo: </label><br>
            <select hidden name="activo" id="activo">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select><br>
            <input class="btn btn-primary" type="submit" value="Agregar">

        </form>
        </div>
    </div>

</div>
