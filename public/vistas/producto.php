
<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"
        integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">

    <!-- jQuery UI JS -->
    <script src="//code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    
</head>

<body>
    <script>
        var vId;
        $(document).ready(function () {
            var contenidoURL = "http://localhost:8080/too/public/producto/create";

    // Carga el contenido en el div
    $("#iframeContainer").load(contenidoURL);
            
            datosInicio();
            /* $('#example').DataTable({
                 dom: 'Bfrtip',
                 buttons: [
                     'copy', 'csv', 'excel', 'pdf', 'print'
                 ],
                 "columnDefs": [
                     { "type": "date", "targets": 4 }
                 ],
                 "order": [[4, "desc"]],
                 "language": {
                     "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                 }
             });*/
             $("#df2").dialog({
                height: 600,
                modal: true,
                autoOpen: false,
                
            });
            $("#df").dialog({
                height: 600,
                modal: true,
                autoOpen: false,
                buttons: {
                    Ok: function () {


                        if (confirm("SSeguro que desea editar el registro?")) {

                            var formData = new FormData($(".formuploadajax2")[0]); // Crear un objeto FormData a partir del formulario
          //console.log(11, formData)
          formData.forEach(function (value, key) {
              console.log(key + ": " + value);
          });
                            $.ajax({
                                url: 'http://localhost:8080/too/public/producto/' + vId,
                                type: "POST",
                                contentType: "text/plain",
                                data: formData,
                                processData: false, // Evitar la conversión de datos en una cadena de consulta
                                 contentType: false, // Evitar la configuración del tipo de contenido (se establece automáticamente como multipart/form-data)
                                 async: false,
                                beforeSend: function (xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'))
                                },
                                success: function (data) {
                                    console.log(data);
                                    alert(data);
                                    var json = JSON.parse(data);
                                    location.reload();
                                },
                                error: function (error) {
                                    //console.log(error);
                                    alert(error);
                                }
                            });
                            $(this).dialog("close");
                        }
                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                }
            });

            
            $('#activo').click(function () {
        if ($(this).is(':checked')) {
            var table = $('#example').DataTable();
table.destroy();

            getDatos(gjson);

        }
    });

    $('#inactivo').click(function () {
        var table = $('#example').DataTable();
table.destroy();

        if ($(this).is(':checked')) {
            getDatos(gjson);

        }
    });
        });


        function getDatos(json) {
            ////console.log(json);
            let arr = new Array();

            for (var i = 0; i < json.length; i++) {
                let element = json[i];

                let array = new Array();

                if ($("#activo").is(":checked")) {
                        if(element.activo == 1){
                            
                            //console.log(65, element.activo);
                            array.push(element.codigo);
                            //console.log(71, element.codigo);
                            array.push(element.nombre);
                            array.push(element.categoria);
                            array.push(element.descripcion);
                            array.push(element.imagen);
                            array.push(element.precio);
                            array.push(element.stock);
                            array.push(element.fecha_vencimiento);
                            //console.log(array);
                            array.push('<a href="#" onclick="editar( ' + element.id + ')">Editar</a>');
                            arr.push(array);
                        }
                    }else if ($("#inactivo").is(":checked")) {
                        if(element.activo == 0){
                            //console.log(65, element.activo);
                            array.push(element.codigo);
                            //console.log(71, element.codigo);
                            array.push(element.nombre);
                            array.push(element.categoria);
                            array.push(element.descripcion);
                            array.push(element.imagen);
                            array.push(element.precio);
                            array.push(element.stock);
                            array.push(element.fecha_vencimiento);
                            //console.log(array);
                            array.push('<a href="#" onclick="editar( ' + element.id + ')">Editar</a>');
                            arr.push(array);
                        }
                    }else{
                        //console.log(65, element.activo);
                        array.push(element.codigo);
                        //console.log(71, element.codigo);
                        array.push(element.nombre);
                        array.push(element.categoria);
                        array.push(element.descripcion);
                        array.push(element.imagen);
                        array.push(element.precio);
                        array.push(element.stock);
                        array.push(element.fecha_vencimiento);
                        //console.log(array);
                        array.push('<a href="#" onclick="editar( ' + element.id + ')">Editar</a>');
                        arr.push(array);
                    }
			
            }
            //console.log(arr);
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columnDefs": [
                    { "type": "date", "targets": 4 }
                ],
                "order": [[4, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },
                data: arr,
            });
        }

        function editar(vCodigo) {
            vId = vCodigo;
            document.frn.id.value = vId;
            $("#df").dialog("open");
        }
function nuevo() {
            $("#df2").dialog("open");
        }

        function datosInicio() {    
            $.ajax({
                url: 'http://localhost:8080/too/public/producto',
                type: "GET",
                contentType: "text/plain",
                success: function (data) {
                    //console.log(data);
                    //alert(data);
                    var json = JSON.parse(data);
                    getDatos(json);
                    gjson=json;
                },
                error: function (error) {
                    //console.log(error);
                    alert(error);
                }
            });
        }
        let gjson;
    </script>
    <h1>PRODUCTOS</h1>
    <a href="./producto.php"></a>
    <a href="#" onclick="nuevo()">Nuevo</a>
    <input class='rButton' type="radio" name="estado" id="activo" value="activosf" checked>Activos
    <input class='rButton' type="radio" name="estado" id="inactivo" value="inactivos" >Inactivos
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr id="fila">
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fecha de Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>

        

    </table>
    <div id="df" title="Motivo de la anulacion:">
        <form action="" class="formuploadajax2" name="frn">
            <fieldset>
                
                <input type="hidden" name="_token" id="token" value="e2OV0kfZXB7Ms9Vdsgp6sQRxbPel9m06qcjhus4f">

                <input type="hidden" name="_method" value="PATCH">

                <input type="text" name="id" value="">
                <br>
                <label for="">Nombre</label><br>
                <input type="text" name="nombre" id="nombre"><br>

                <label for="">Categoria</label><br>
                <select name="id_categoria" id="id_categoria">
                    <option value="1">Categoria 1</option>
                    <option value="2">Categoria 2</option>
                    <option value="3">Categoria 3</option>
                    <option value="4">Categoria 4</option>
                    <option value="5">Categoria 5</option>
                </select><br>

                <label for="">Imagen</label><br>
                <input type="file" name="imagen" id="imagen"><br>

                <label for="">Precio</label><br>
                <input type="number" name="precio" id="precio"><br>

                <label for="">Stock</label><br>
                <input type="number" name="stock" id="stock"><br>

                <label for="">Fecha de Vencimiento</label><br>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"><br>

                <label for="">Activo</label><br>
                <input type="number" name="activo" id="activo"><br>

                <label for="">Descripcion</label><br>
                <textarea type="text" name="descripcion" id="descripcion"> </textarea><br>



            </fieldset>
        
    </div>
    <div id="df2" title="Agregar nuevo producto:">
    
    <div id="iframeContainer"></div>
    </div>
</body>

</html>