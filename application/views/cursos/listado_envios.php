<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Envío de certificados del curso: <?= $nombre_curso . " -> " . $nombre_corto ?>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="<?= base_url('cursos/ver_cursos') ?>" class="btn btn-primary btn-xs" id="btn_agregar_curso">
                    <span class="svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
            <button class="btn btn-info mb-2" id="agregar_participantes" data-id="<?= $id ?>">
                <i class="fa fa-plus"></i>
                Agregar participantes
            </button>
            <button class="btn btn-secondary mb-2" id="imprimir_envios" data-id="<?= $id ?>">
                <i class="fa fa-print"></i>
                Imprimir
            </button>
            <table id="tbl_envios" class="table table-separate table-head-custom table-checkable">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>remitente</th>
                        <th>nombre</th>
                        <th>celular</th>
                        <th>dirección</th>
                        <th>departamento</th>
                        <th>estado</th>
                        <th>acciones</th>
                    </tr>
                </thead>
            </table>
            <input type="hidden" id="id_curso_envio" name="id_curso_envio" value="<?= $id ?>">
        </div>
    </div>
</div>

<div class="modal fade" id="modal_estudiantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Estudiantes del curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <table id="tbl_estudiantes_envio" class="table table-separate table-head-custom table-checkable responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>acciones</th>
                                <th>ci</th>
                                <th>participante</th>
                                <th>celular</th>
                                <th>correo</th>
                                <th>departamento</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Agregar al envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="frm-guardar-envio" method="POST" action="/cursos/guardar_envio">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="required">Remitente </label>
                            <input type="text" class="form-control" id="remitente_persona_envio" name="remitente_persona_envio" value="POSGRADO UPEA" required />
                        </div>

                        <div class="form-group">
                            <label>Participante</label>
                            <input type="text" class="form-control" disabled="disabled" id="nombre_persona_envio" name="nombre_persona_envio" />
                            <input type="hidden" value="" name="id_envio_preinscripcion" id="id_envio_preinscripcion" />
                        </div>

                        <div class="form-group">
                            <label>Celular</label>
                            <input type="number" class="form-control" disabled="disabled" id="celular_persona_envio" name="celular_persona_envio" />
                        </div>

                        <div class="form-group">
                            <label for="editar_direccion">Dirección</label>
                            <textarea class="form-control" name="direccion_persona_envio" id="direccion_persona_envio" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Departamento</label>
                            <input type="text" class="form-control" disabled name="departamento_persona_envio" id="departamento_persona_envio" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Agregar</button>
                        <button type="button" id="clear-envio" class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_envio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Editar envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="frm-editar-envio" method="POST" action="/cursos/editar_envio">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="required">Remitente </label>
                            <input type="text" class="form-control" id="editar_remitente" name="editar_remitente" value="POSGRADO UPEA" required />
                        </div>

                        <div class="form-group">
                            <label>Participante</label>
                            <input type="text" class="form-control" disabled="disabled" id="editar_nombre" name="editar_nombre" />
                            <input type="hidden" value="" name="editar_id" id="editar_id" />
                        </div>

                        <div class="form-group">
                            <label>Celular</label>
                            <input type="number" class="form-control" disabled="disabled" id="editar_celular" name="editar_celular" />
                        </div>

                        <div class="form-group">
                            <label for="direccion_persona_envio">Dirección</label>
                            <textarea class="form-control" name="editar_direccion" id="editar_direccion" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Departamento</label>
                            <input type="text" class="form-control" disabled name="editar_departamento" id="editar_departamento" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>