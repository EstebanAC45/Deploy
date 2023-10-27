@inject ('empleados', 'App\Models\Empleado')
@extends('layouts.parte1')

@section('contenido')
<br>
<!--Boton modal para agregar empleado-->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarEmpleado">
        <i class="bi bi-person"> Agregar empleado</i>
</button>

<h2>Empleados en el sistema</h2>


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
                'Empleado agregado con éxito',
                'success'
            )
        </script>
    @endif

    @if (session()->has('mensaje2'))
        <script>
            Swal.fire(
                '¡Éxito!',
                'Empleado editado con éxito',
                'success'
            )
        </script>
    @endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="empleados" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                        @foreach($empleados->get() as $empleado)
                        <tr>
                        <td>{{$empleado->nombres}}</td>
                        <td>{{$empleado->apellidos}}</td>
                        <td>{{$empleado->telefono}}</td>
                        <td>{{$empleado->direccion}}</td>
                        <td>{{$empleado->correo}}</td>
                        <td>
                        @if($empleado->id_rol == 1)
                        Empleado
                        @elseif($empleado->id_rol == 3)
                        Administrador
                        @endif
                        </td>
                        <td>
                        
                        @if($empleado->id_rol == 1)

                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <form action="{{route('empleado.destroy', $empleado->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarEmpleado{{$empleado->id}}" >Editar</button>
                        </div>
                        @endif
                        </td>
                 
                    </tr>

<div class="modal fade" id="editarEmpleado{{$empleado->id}}" tabindex="-1" aria-labelledby="editarEmpleado{{$empleado->id}}" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #63D38B;">
        <h5 class="modal-title" id="exampleModalLabel">Editar datos del empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <h6>Datos del empleado</h6>
                <form action="{{route('empleado.update', $empleado->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombres</label>
                            <input type="text"  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" name="nombres" id="nombres" class="form-control" value="{{$empleado->nombres}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellidos</label>
                            <input type="text"  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" name="apellidos" id="apellidos" class="form-control" value="{{$empleado->apellidos}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="number"  pattern="[0-9]+"  name="telefono" id="telefono" class="form-control" value="{{$empleado->telefono}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" name="direccion" id="direccion" class="form-control" value="{{$empleado->direccion}}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" name="correo" id="correo" class="form-control" value="{{$empleado->correo}}" readonly required>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" name="contrasena" id="contrasena" class="form-control" value="{{$empleado->contrasena}}" required>
                        </div>
                        <div class="col-md-6">

                            <input type="number" name="activo" id="activo" class="form-control" value="{{$empleado->activo}}" hidden required>
                        </div>

                            <input type="text" name="fecha_registro" id="fecha_registro" class="form-control" value="{{$empleado->fecha_registro}}" hidden>

                            <input type="number" name="id_rol" id="id_rol" class="form-control" value="{{$empleado->id_rol}}" hidden>

                            

                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Actualizar empleado</button>
                </form>
                        
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" aria-labelledby="modalAgregarEmpleado" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header" style="background-color: #8DD3EC;">
            <h5 class="modal-title" id="exampleModalLabel">Supermercado, Aquí todo encuentras - Agregar empleado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <h2>Complete los campos</h2>
                <form id="crearUsuario" action="{{route('empleado.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre">Nombres</label>
                            <input type="text" pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" name="nombres" id="nombres" class="form-control" placeholder="Ingrese nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido">Apellidos</label>
                            <input type="text"  pattern="^[a-zA-ZáéíóúñÑ\s]{3,254}$" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="number"  pattern="[0-9]+"  name="telefono" id="telefono" class="form-control" placeholder="Ingrese teléfono" required>
                        </div>
                        <div class="col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚ, ]+$" name="direccion" id="direccion" class="form-control" placeholder="Ingrese dirección" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingrese email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" name="contrasena" pattern="^[a-zA-Z0-9_]{4,}$" id="contrasena" class="form-control" placeholder="Ingrese contraseña" required>
                        </div>
                        <input type="number" name="activo" id="activo" value="1" hidden>
                        <input type="text" name="fecha_registro" id="fecha_registro" value="{{date('d-m-y')}}" hidden>
                        <input type="number" name="id_rol" id="id_rol" value="3" >
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Registrar empelado</button>
            </div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
    $('#empleados').DataTable({
        responsive: true,
        autoWidth: false,
        "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],

        "language": {
            "zeroRecords": "No se encontró nada",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            'search': 'Buscar:',
            'paginate': {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        }
    });
</script>

@endsection