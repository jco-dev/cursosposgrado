<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Pre - Inscripciones
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-success" id="btn_descargar_csv">
                    <i class="fa fa-file-excel"></i>
                    Descargar CSV
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_ver_inscripcion">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ci</th>
                        <th>Nombre</th>
                        <th>Municipio</th>
                        <th>celular</th>
                        <th>curso</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Inscripci&oacute;n</th>
                        <th>Estado</th>
                        <th>tipo pago</th>
                        <th>monto pago</th>
                        <th>transaccion</th>
                        <th>certificaci&oacute;n</th>
                        <th>respaldo</th>
                        <th>Cambiar estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_descargar_csv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descargar CSV de Usuarios Inscritos</h5>
                <button type="button" class="close" id="cerrar_modal" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-lg-9 mt-5">
                        <h6>Seleccione Curso</h6>
                        <select class="form-control select2" id="cursos" name="cursos">
                            <option value="">Seleccione Curso</option>
                            <?php foreach ($cursos as $curso) {
                                echo "<option value='$curso->id_course_moodle'>$curso->fullname</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 mt-5">
                        <h6>Seleccione Estado</h6>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">-- Seleccione --</option>
                            <option value="PREINSCRITO">PREINSCRITO</option>
                            <option value="INSCRITO">INSCRITO</option>
                            <!-- <option value="ANULADO">ANULADO</option> -->
                            <option value="TODOS">TODOS</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 mt-5">
                        <button type="button" class="btn btn-info btn-block" id="descagar_usuarios_moodle">
                            <i class="nav-icon flaticon-list-1"></i>
                            Descargar Estudiantes Para moodle
                        </button>
                    </div>
                    <div class="col-lg-6 mt-5">
                        <button type="button" class="btn btn-block" id="descargar_contactos_curso" style="background-color: #0EC244; color:white;">
                            <i class="nav-icon flaticon-whatsapp text-white"></i>
                            Descargar Contacto Usuarios
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>