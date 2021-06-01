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
                <select class="form-control" id="cursos" name="cursos">
                    <option value="">-- Descargar CSV --</option>
                    <option value="all">Ver todos</option>
                    <?php foreach ($cursos as $curso) {
                        echo "<option value='$curso->id_course_moodle'>$curso->fullname</option>";
                    } ?>
                </select>
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
                        <th>tipo pago</th>
                        <th>monto pago</th>
                        <th>transaccion</th>
                        <th>certificaci&oacute;n</th>
                        <th>Estado</th>
                        <th>respaldo</th>
                        <th>Cambiar estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_conf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-conf"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizar_configuracion" method="post" enctype="multipart/form-data">
                    <!-- imagen curso -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <h6>Imagen del certificado</h6>
                            <div class="multimediaFisica needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del certificado.

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h6>Banner del Curso</h6>
                            <div class="multimediaFisica1 needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del banner del curso.

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="nota_aprobacion">Nota Aprobaci&oacute;n <span class="text-danger">(*)</span>: </label>
                            <input type="number" class="form-control" id="nota_aprobacion" name="nota_aprobacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese la nota de aprobacion</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_inicial">Fecha Inicio: </label>
                            <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial" />
                            <span class="form-text text-muted">Ingrese fecha de Inicio del curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_final">Fecha Final: </label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final" />
                            <span class="form-text text-muted">Ingrese fecha Fin del curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="carga_horaria">Carga Horaria <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="carga_horaria" name="carga_horaria" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese carga horaria del curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="fecha_certificacion">Fecha Certificaci&oacute;n <span class="text-danger">(*)</span>: </label>
                            <input type="datetime" class="form-control" id="fecha_certificacion" name="fecha_certificacion" />
                            <span class="form-text text-muted">Ingrese la fecha de certificacion curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="fecha_creacion">Fecha Creaci&oacute;n: </label>
                            <input type="datetime" class="form-control" id="fecha_creacion" name="fecha_creacion" />
                            <span class="form-text text-muted">Ingrese la fecha de creacion curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="posx_nombre_participante">X nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_nombre_participante" name="posx_nombre_participante" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x nombre del participante</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="posy_nombre_participante">Y nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_nombre_participante" name="posy_nombre_participante" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y nombre del participante</span>
                        </div>
                        <input type="hidden" id="id_configuracion_curso" name="id_configuracion_curso" />
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="posx_bloque_texto">X bloque texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_bloque_texto" name="posx_bloque_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x bloque texto</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_bloque_texto">Y bloque texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_bloque_texto" name="posy_bloque_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y bloque texto</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posx_nombre_curso">X nombre curso:</label>
                            <input type="number" class="form-control" id="posx_nombre_curso" name="posx_nombre_curso" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x nombre curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_nombre_curso">Y nombre curso:</label>
                            <input type="number" class="form-control" id="posy_nombre_curso" name="posy_nombre_curso" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y nombre curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="posx_qr">X qr <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_qr" name="posx_qr" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x QR</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_qr">Y qr <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_qr" name="posy_qr" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y QR</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posx_tipo_participacion">X tipo participaci&oacute;n:</label>
                            <input type="number" class="form-control" id="posx_tipo_participacion" name="posx_tipo_participacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x tipo participacion</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_tipo_participacion">Y tipo participaci&oacute;n:</label>
                            <input type="number" class="form-control" id="posy_tipo_participacion" name="posy_tipo_participacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y tipo participacion</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="fuente_pdf">Fuente PDF</label>
                            <input type="text" class="form-control" id="fuente_pdf" name="fuente_pdf" />
                            <span class="form-text text-muted">Ingrese fuente pdf</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_titulo">Tamano Titulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_titulo" name="tamano_titulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio titulo</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_subtitulo">Tamano subtitulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_subtitulo" name="tamano_subtitulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio subtitulo</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_texto">Tamano texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_texto" name="tamano_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio texto</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="color_nombre_participante">Color nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="color" class="form-control" id="color_nombre_participante" name="color_nombre_participante" />
                            <span class="form-text text-muted">Seleccione color nombre participante</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="color_subtitulo">Color subtitulo <span class="text-danger">(*)</span>:</label>
                            <input type="color" class="form-control" id="color_subtitulo" name="color_subtitulo" />
                            <span class="form-text text-muted">Seleccione color para tipo de participacion y fecha</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="detalle_curso">Detalle Curso <span class="text-danger">(*)</span>:</label>
                            <textarea name="detalle_curso" id="detalle_curso" rows="2" class="form-control"></textarea>
                            <span class="form-text text-muted">Ingrese detalle del curso</span>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="inversion">Inversi&oacute;n <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="inversion" name="inversion" />
                            <span class="form-text text-muted">Ingrese la inversi&oacute;n del curso</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="url_pdf">URL pdf <span class="text-danger">(*)</span>:</label>
                            <input type="file" class="form-control" id="url_pdf" name="url_pdf" accept=".pdf, .doc, .docx" />
                            <span class="form-text text-muted">Suba descripcion del curso formato pdf del curso</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="celular_referencia">Numero de Referencia <span class="text-danger">(*)</span>:</label>
                            <input type="text" class="form-control" id="celular_referencia" name="celular_referencia" />
                            <span class="form-text text-muted">Ingrese numero referencia del curso</span>
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