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
                <a href="<?= base_url('cursos/ver_cursos') ?>" class="btn btn-primary btn-xs">
                    <span class="svg-icon">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Navigation\Arrow-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1" />
                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) " />
                            </g>
                        </svg>
                    </span>
                    Volver a Cursos
                </a>
                
                <button type="button" class="btn btn-success ml-5" id="btn_descargar_csv">
                    <i class="fa fa-file-excel"></i>
                    Descargar CSV
                </button>
            </div>
        </div>
        <div class="card-body">
        
            <input type="hidden" id="id_c" name="id_c" value="<?= $id ?>">
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