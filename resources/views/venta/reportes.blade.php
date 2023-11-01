@inject ('productos', 'App\Models\Producto')
@inject ('ventas', 'App\Models\Venta')
@inject ('clientes', 'App\Models\Cliente')
@extends ('layouts.parte1')

@section ('contenido')

<h1>Reportes</h1>



<form method="POST" action="{{ route('venta.ventaPorDia') }}" id="miFormulario">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
        </div>
        <div class="col-md-4">
            <label for="fecha_fin">Fecha de fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
        </div>
        <div class="col-md-4">
            <label for="tipo_reporte">Tipo de reporte</label>
            <select class="form-select" id="tipo_reporte" name="tipo_reporte" required>
                <option value="1">Ventas por día</option>
                <option value="2">Ventas por semana</option>
                <option value="3">Ventas por mes</option>
            </select>
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary"><i class="bi bi-bar-chart-fill"> Generar reporte</i></button>
</form>

<script>
    $function(){
        $('#fecha_inicio').datepicker({
            dateFormat: 'dd-mm-yy'
        }
        );
    };
    $function (){
        $('#fecha_fin').datepicker({
            dateFormat: 'dd-mm-yy'
        }
        );
    };
</script>




<div class="contaiener">
    <div class="row">
        <div class="col-md-4">
            <!--Gráfica de Productos más vendidos-->
            <canvas id="clienteConMasCompras" width="400" height="400"></canvas>
        </div>
        <div class="col-md-4">
            <!--Ventas Diarias-->
            <canvas id="ventasDiarias" width="400" height="400"></canvas>

            @if (isset($ventasPorDia))
            <!--Graficos de ventas por dia con los datos consultados en el form-->
            <script>
                var ctx = document.getElementById('ventasDiarias').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $ventasPorDia->pluck('dia') !!}, // Ajusta este valor según tu modelo
                        datasets: [{
                            label: 'Dinero recibido el día ' + {!! $ventasPorDia->pluck('dia')  !!},
                            data: {!! $ventasPorDia->pluck('total_ventas') !!}, // Ajusta este valor según tu modelo
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 0.8
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                title : {
                                    display: true,
                                    text: 'Total de generado en ventas'
                                },
                                //no permitir decimales en el eje Y
                                ticks: {
                                    stepSize: 1
                                },
                                beginAtZero: true
                            },
                            x: {
                                title : {
                                    display: true,
                                    text: 'Día'
                                },
                                //no permitir decimales en el eje Y
                                ticks: {
                                    stepSize: 1
                                },
                                beginAtZero: true
                            }
                            
                        },
                        barThickness: 50

                    }
                });
            </script>
            @endif
        </div>
        <div class="col-md-4">
            <!--total de compras realizadas-->
            <canvas id="totalCompras" width="400" height="400"></canvas>

            @if (isset($ventasPorDia))
            <!--Graficos de ventas por dia con los datos consultados en el form-->
            <script>
                var ctx = document.getElementById('totalCompras').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $ventasPorDia->pluck('dia') !!}, // Ajusta este valor según tu modelo
                        datasets: [{
                            label: 'Total de compras realizadas el día ' + {!! $ventasPorDia->pluck('dia')  !!},
                            data: {!! $ventasPorDia->pluck('cantida_compras') !!}, // Ajusta este valor según tu modelo
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 0.8
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                staked: true,
                                title : {
                                    display: true,
                                    text: 'Total de compras realizadas'

                                },
                                //no permitir decimales en el eje Y
                                ticks: {
                                    stepSize: 1
                                },
                                beginAtZero: true
                            },
                            x: {
                                title : {
                                    display: true,
                                    text: 'Día'
                                },
                                //no permitir decimales en el eje Y
                                ticks: {
                                    stepSize: 1
                                },
                                beginAtZero: true
                            }
                            
                        },
                        barThickness: 50

                    }

                });
            </script>
            @endif
            
    </div>
</div>




<script>
    var ctx = document.getElementById('clienteConMasCompras').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $clientes->pluck('nombres') !!}, // Ajusta este valor según tu modelo
            datasets: [{
                label: 'Compras realizadas por cliente',
                data: {!! $clientes->pluck('compras_realizadas') !!}, // Ajusta este valor según tu modelo
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    //no permitir decimales en el eje Y
                    ticks: {
                        stepSize: 1
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection