<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado de Estudiantes del Curso: <?= $nombre_curso . " -> " . $nombre_corto ?>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="<?= base_url('cursos/ver_cursos') ?>" class="btn btn-primary btn-xs" id="btn_agregar_curso">
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
            </div>
        </div>
        <div class="card-body">
            <table id="ver_inscripcion_curso" class="table table-separate table-head-custom table-checkable">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>nombre</th>
                        <th>id curso</th>
                        <th>curso</th>
                        <th>nota</th>
                        <th>tipo pago</th>
                        <th>monto pago</th>
                        <th>respaldo pago</th>
                        <th>tipo participacion</th>
                        <th>Recogido</th>
                        <th>fecha entrega</th>
                        <th>entregado a</th>
                        <th>Observacion entrega</th>
                        <th>fecha registro</th>
                        <th>Tipo Certificaci&oacute;n</th>
                        <th>Certificaci&oacute;n Curso</th>
                        <th>estado</th>
                        <th>acciones</th>
                    </tr>
                </thead>
            </table>
            <input type="hidden" id="id" name="id" value="<?= $id ?>">
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
                        <div class="col-lg-6">
                            <label for="nro_transaccion">N&uacute;mero transacci&oacute;n: </label>
                            <input type="text" class="form-control" id="nro_transaccion" name="nro_transaccion" />
                            <span class="form-text text-muted">Nota Final</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="monto_pago">Monto pago: </label>
                            <input type="number" class="form-control" id="monto_pago" name="monto_pago" />
                            <span class="form-text text-muted">Monto pago</span>
                        </div>

                    </div>
                    <input type="hidden" id="id_inscripcion_curso" name="id_inscripcion_curso">

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="tipo_certificacion_solicitado">Tipo certificacion solicitado: </label>
                            <select id="tipo_certificacion_solicitado" name="tipo_certificacion_solicitado" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="FISICO">FISICO</option>
                                <option value="DIGITAL">DIGITAL</option>
                                <option value="AMBOS">AMBOS</option>
                            </select>
                            <span class="form-text text-muted">Selecciones tipo de certificaci&oacute;n solicitado</span>
                        </div>
                        <div class="col-lg-6">
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

                    <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <label for="respaldo_pago">Respaldo pago: </label><br>
                            <img class="img-thumbnail" id="img-preview" width="200" height="200" />
                            <div class="text-center" style="margin-top: 10px;">
                                <input type="file" id="respaldo_pago" name="respaldo_pago" accept="image/*" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-lg-4">
                            <label for="fecha_entrega">Fecha Entrega: </label>
                            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" />
                            <span class="form-text text-muted">Ingrese la fecha de la entrega</span>
                        </div>

                        <div class="col-lg-4">
                            <label for="entregado_a">Certificado recogido: </label>
                            <select name="certificado_recogido" id="certificado_recogido" class="form-control">
                                <option value="no">no</option>
                                <option value="si">si</option>
                            </select>
                            <span class="form-text text-muted">Ingrese a la persona entregado</span>
                        </div>
                        <div class="col-lg-4">
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