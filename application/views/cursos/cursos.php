<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado de Cursos
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="javascript:;" class="btn btn-primary font-weight-bolder" id="btn_agregar_curso">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>Nuevo Registro</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_cursos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Curso</th>
                        <th>Nombre corto</th>
                        <th>M&oacute;dulos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_inscripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Listado de Estudiantes del curso</h5>
                <button type="button" id="cerrar_modal_inscripcion" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table id="ver_inscripcion_curso" class="table table-separate table-head-custom table-checkable">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nombre</th>
                            <th>curso</th>
                            <th>nota</th>
                            <th>tipo pago</th>
                            <th>nro transaccion</th>
                            <th>monto pago</th>
                            <th>respaldo pago</th>
                            <th>tipo participacion</th>
                            <th>fecha entrega</th>
                            <th>entregado a</th>
                            <th>Observacion</th>
                            <th>fecha registro</th>
                            <th>Tipo Certificaci&oacute;n</th>
                            <th>Certificaci&oacute;n Curso</th>
                            <th>estado</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_inscripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-editar"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-editar-inscripcion">
                <form action="" id="frm_editar_inscripcion" role="form" method="post" enctype="multipart/form-data">

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="usuario">Nombres Estudiante: </label>
                            <input type="text" class="form-control" id="usuario" name="usuario" disabled="disabled" />
                            <span class="form-text text-muted">Nombres y apellidos del estudiante</span>
                        </div>
                        <div class="col-lg-2">
                            <label for="calificacion_final">Calificaci&oacute;n final: </label>
                            <input type="number" class="form-control" id="calificacion_final" name="calificacion_final" disabled="disabled" />
                            <span class="form-text text-muted">Nota Final</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="tipo_pago">Tipo Pago: </label>
                            <select id="tipo_pago" name="tipo_pago" class="form-control">
                                <option value="DEPOSITO BANCARIO">DEPOSITO BANCARIO</option>
                                <option value="TIGO MONEY">TIGO MONEY</option>
                                <option value="PAGO EFECTIVO">PAGO EFECTIVO</option>
                                <option value="SIN PAGO">SIN PAGO</option>
                            </select>
                            <span class="form-text text-muted">Seleccione tipo de pago</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="nro_transaccion">N&uacute;mero transacci&oacute;n: </label>
                            <input type="text" class="form-control" id="nro_transaccion" name="nro_transaccion" />
                            <span class="form-text text-muted">Nota Final</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="monto_pago">Monto pago: </label>
                            <input type="number" class="form-control" id="monto_pago" name="monto_pago" />
                            <span class="form-text text-muted">Monto pago</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="tipo_participacion">Tipo participante: </label>
                            <select id="tipo_participacion" name="tipo_participacion" class="form-control">
                                <option value="PARTICIPANTE">PARTICIPANTE</option>
                                <option value="EXPOSITOR">EXPOSITOR</option>
                                <option value="ORGANIZADOR">ORGANIZADOR</option>
                                <option value="OTRO">OTRO</option>
                            </select>
                            <span class="form-text text-muted">Selecciones tipo de participaci&oacute;n</span>
                        </div>
                    </div>
                    <input type="hidden" id="id_inscripcion_curso" name="id_inscripcion_curso">

                    <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <label for="respaldo_pago">Respaldo pago: </label><br>
                            <img class="img-thumbnail" id="img-preview" width="250" height="250" />
                            <div class="text-center" style="margin-top: 10px;">
                                <input type="file" id="respaldo_pago" name="respaldo_pago" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="tipo_certificacion_solicitado">Tipo certificacion solicitado: </label>
                            <select id="tipo_certificacion_solicitado" name="tipo_certificacion_solicitado" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="FISICO">FISICO</option>
                                <option value="DIGITAL">DIGITAL</option>
                                <option value="AMBOS">AMBOS</option>
                            </select>
                            <span class="form-text text-muted">Selecciones tipo de certificaci&oacute;n solicitado</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_entrega">Fecha Entrega: </label>
                            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" />
                            <span class="form-text text-muted">Ingrese la fecha de la entrega</span>
                        </div>
                        <div class="col-lg-5">
                            <label for="entregado_a">entregado a: </label>
                            <input type="text" class="form-control" id="entregado_a" name="entregado_a" />
                            <span class="form-text text-muted">Ingrese a la persona entregado</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="observacion_entrega">Observaci&oacute;n de la entrega: </label>
                            <textarea name="observacion_entrega" class="form-control" id="observacion_entrega" rows="2"></textarea>
                            <span class="form-text text-muted">Ingrese si existe alguna observaci&oacute;n</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="nav-icon la la-edit"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_imprimir_certificado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Imprimir Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-certificado">

            </div>
        </div>
    </div>
</div>