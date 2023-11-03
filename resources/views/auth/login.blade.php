@inject ('clientes', 'App\Models\Cliente')
<!DOCTYPE html>
<html>

<head>
    <title>Inicio de sesión</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3082/3082031.png" type="image/x-icon">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

     <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>   
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .login-container {
            text-align: center;
            width: 500px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container #acceder {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    
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

    @if (session()->has('mensaje3'))
        <script>
            Swal.fire(
                '¡Error!',
                'Datos no válidos',
                'error'
            )
        </script>
@endif  

@if (session()->has('mensaje8'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Usted se encuentra desactivado, contacte con el administrador',
            footer: 'Contactanos al 7145-9710',
            })
            
        </script>
@endif


@if (session()->has('mensaje9'))
        <script>
            Swal.fire(
                '¡Error!',
                'Las contraseñas no coinciden',
                'error'
            )
        </script>
@endif
    <div class="login-container">
        <img src="https://cdn-icons-png.flaticon.com/512/3082/3082031.png" alt="Logo">
        <h1>Aquí todo encuentras</h1>
        <h2>Iniciar sesión</h2>
        <form action="{{route('login.post')}}" method="post">
            @csrf
        <input type="text" name="email" id="email" placeholder="Email" required />
        <input type="password" name="password" id="password" placeholder="Contraseña" required />
        <button id="acceder" type="submit">Iniciar sesión</button>
        <hr>
        </form>
        <!--boton modal para llamar formulario de cliente-->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCliente">
        <i class="bi bi-person"> Registrarse</i>
        </button>

        <!-- Modal -->

    <div class="modal fade" id="crearCliente" tabindex="-1" aria-labelledby="crearCliente" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Supermercado, Aquí todo encuentras - Registro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <h2>Complete los campos</h2>
                <form id="crearUsuario" action="{{route('cliente.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombres" id="nombres" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellidos" id="apellidos" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" class="form-control" placeholder="Ingrese apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="number" name="telefono" id="telefono" pattern="[0-9]+" class="form-control" placeholder="Ingrese teléfono" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" class="form-control" placeholder="Ingrese dirección" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingrese email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" name="contrasena" id="contrasena" class="form-control" placeholder="Ingrese contraseña" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmar_contrasena">Confirmar contraseña</label>
                            <input type="password" pattern="^[a-zA-Z0-9_]{6,}$" name="confirmar_contrasena" id="confirmar_contrasena" class="form-control" placeholder="Confirme contraseña" required>
                        </div>
                        <input type="number" name="compras_realizadas" id="compras_realizadas" value="0" hidden>
                        <input type="number" name="activo" id="activo" value="1" hidden>
                        <input type="number" name="tarjeta_fidelidad" value="0" hidden>
                        <input type="text" name="fecha_registro" id="fecha_registro" value="{{date('d-m-y')}}" hidden>
                        <input type="number" name="id_rol" id="id_rol" value="2" hidden>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
            </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
    </div>
    </div>
</body>
</html>

