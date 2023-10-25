<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supermercado</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3082/3082031.png" type="image/x-icon">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

     <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>   
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

@php
 $rol = session('rol');
@endphp
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://localhost:8080/too/public/producto_proveedor"><i class="bi bi-shop-window"></i> Supermercado</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        @if (session('rol') == 2)
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost:8080/too/public/producto" hidden>Productos</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost:8080/too/public/producto">Productos</a>
        </li>
        @endif
        @if (session('rol') == 2)
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/proveedor" hidden>Proveedores</a>
        </li>
        @else 
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/proveedor">Proveedores</a>
        </li>
        @endif

        @if (session('rol') == 2)
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/categoria" hidden>Categorías</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/categoria" >Categorías</a>
        </li>
        @endif

        @if (session('rol') == 2)
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/cliente" hidden>Clientes</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/cliente">Clientes</a>
        </li>
        @endif

        @if (session('rol') == 2 || session('rol') == 1)
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="http://localhost:8080/too/public/empleado" hidden>Empleados</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="http://localhost:8080/too/public/empleado">Empleados</a>
        </li>
        @endif

        @if (session('rol') == 2)
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/venta" hidden>Ventas</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/too/public/venta">Ventas</a>
        </li>
        @endif

        <li class="nav-item ms-auto d-flex align-items-center" id="carrito">
          <a class="nav-link" href="http://localhost:8080/too/public/venta/create">
            <i class="bi bi-cart-fill">Ir a Carrito</i>
          </a>
        </li>
        
        <li class="nav-item ms-auto d-flex align-items-center" id="cerrar_sesion">
          <a  class="nav-link btn btn-danger" href="{{ route ('logout') }}">
          <i class="bi bi-file-earmark-person">Cerrar sesión</i>
          </a>
        </li>
      </ul>

    </div>
  </div>
  
</nav>

    <div class="container">
        @yield('contenido')
    </div>

@yield('scripts')
</body>
</html>