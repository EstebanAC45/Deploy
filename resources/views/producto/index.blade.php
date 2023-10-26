@inject('producto_proveedor', 'App\Models\Producto_Proveedor')
@inject('producto', 'App\Models\Producto')
@inject('proveedors', 'App\Models\Proveedor')
@extends('layouts.parte1')

@section('contenido')
<br>
<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearProducto">
    <i class="bi bi-file-plus-fill"> Agregar Producto</i>
</a>
<br><br>
<h2>Lista de Productos</h2>

   <input class='rButton' type="radio" name="estado" id="activo" value="activosf">Activos
    <input class='rButton' type="radio" name="estado" id="inactivo" value="inactivos" >Inactivos

<br><br>
<table id="productos" class="table table-striped" style="width:100%">
    <thead class="thead-light">
        
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio Venta</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Stock</th>
            <th>Fecha de Vencimiento</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
   
        @foreach ($productos as $producto)
         @php
            $proveedores = $producto_proveedor::where('id_producto', $producto->id)->get();

        @endphp

        <tr id="activoInactivo" >
            <td>{{ $producto->codigo }}</td>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->categoria }}</td>
            <td>$ {{ $producto->precio }}</td>
            <td>{{ $producto->descripcion }}
            <input type="number" id="activarOinactivar" value="{{$producto->activo}}" hidden>

            </td>
            <td>
                <img src="{{ asset('storage').'/'.$producto->imagen }}" alt="" width="100">
            </td>
            <td>{{ $producto->stock }}</td>
            <td>{{ $producto->fecha_vencimiento }}</td>
            <td>
                @foreach($proveedores as $proveedor)
                @php
                    $proveedor = $proveedors::where('id', $proveedor->id_proveedor)->get();
                @endphp
                @foreach($proveedor as $proveedor)
                {{ $proveedor->nombre }}<br>
                @endforeach
                @endforeach
            </td>
            <td>
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editarProducto-{{$producto->id}}" ><i class="bi bi-pencil-fill">Editar</i></a>
                <form hidden action="{{ url('/producto/'.$producto->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" onclick="return confirm('¿Desea borrar el producto?')" value="Borrar">
                </form>
                </td>
        </tr>
        
              
        <!-- Modal para editar -->
        <div class="modal fade" id="editarProducto-{{$producto->id}}" tabindex="-1" aria-labelledby="editarProducto-{{$producto->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #63D38B;">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        @include('producto.edit')
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
        </div>

        @endforeach
    </tbody>
</table>

<!-- Modal para crear -->
<div class="modal fade" id="crearProducto" tabindex="-1" aria-labelledby="crearProducto" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8DD3EC;">
        <h5 class="modal-title" id="exampleModalLabel" >Agregar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                @include('producto.create')
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('input[type=radio][name=estado]').change(function() {
            if (this.value == 'activosf') {
                $('#productos tbody tr').show();
                $('#productos tbody tr').each(function(index, element) {
                    if($(element).find('#activarOinactivar').val() == 0){
                        $(element).hide();
                    }
                });
                
            }
            else if (this.value == 'inactivos') {
                $('#productos tbody tr').hide();
                $('#productos tbody tr').each(function(index, element) {
                    if($(element).find('#activarOinactivar').val() == 0){
                        $(element).show();
                    }
                });
            }
        });

        



        $('#productos').DataTable({
            "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Todos"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },


        });
    });   

</script>
@endsection