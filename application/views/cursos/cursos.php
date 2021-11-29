<!-- <style>
    .chart {
        align-content: center;
        display: flex;
        justify-content: center;
    }
</style> -->
<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado de Cursos
                </h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_cursos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Curso</th>
                        <th>Nombre corto</th>
                        <th>Inscritos</th>
                        <th>Preinscritos</th>
                        <th>M&oacute;dulos</th>
                        <th>Fecha Registro</th>
                        <th>Informe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_imprimir_certificado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-certificado">Imprimir Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-certificado">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_imprimir_totales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-totales"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-totales">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="piechart_3d_inscritos"></div>
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">Recaudación Total</p>
                            <footer class="blockquote-footer" id="total_reacudacion_inscritos">
                            </footer>
                        </blockquote>
                    </div>
                    <div class="col-lg-6">
                        <div id="piechart_3d_preinscritos"></div>
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">Recaudación Total</p>
                            <footer class="blockquote-footer" id="total_reacudacion_preinscritos">
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" id="descargar_recaudacion_total" id-course="">
                    <i class="fa fa-print"></i>
                    Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Inscritos'],
        ['TIGO MONEY', 7],
        ['DEPÓSITO BANCARIO', 5],
        ['PAGO EFECTIVO', 4],
    ]);

    var options = {
        title: 'REPORTE ECONÓMICO TOTAL',
        is3D: true,
        chartArea: {
            height: '100%',
            width: '100%'
        },
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    }
</script> -->