<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                   Resultados de la Votación
                </h3>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-primary font-weight-bolder" id="btn-print-inscritos">
                        <i class="fa fa-print"></i>
                        Imprimir inscritos
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
            <div class="col-lg-6">
                <table class="table table-separate table-head-custom table-checkable" id="">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Curso</th>
                            <th>Votacion</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($votacion as $key => $curso) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $curso->nombre_curso_sorteo; ?></td>
                                <td><?php echo $curso->votacion; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <table class="table table-separate table-head-custom table-checkable" id=""">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Horario</th>
                            <th>Votación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($votacion_horario as $key => $curso) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $curso->hora_evento; ?></td>
                                <td><?php echo $curso->votacion; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </div>
</div>
