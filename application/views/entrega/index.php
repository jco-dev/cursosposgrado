<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Entrega de certificados
                </h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable display nowrap" id="tbl_entrega_certificado">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Estudiante</th>
                        <th>Curso</th>
                        <th>Nota</th>
                        <th>Tipo Pago</th>
                        <th>Monto Pago</th>
                        <th>Tipo</th>
                        <th>Recogido</th>
                        <th>Fecha Entrega</th>
                        <th>Entregado a</th>
                        <th>Observación</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_entrega" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-entrega"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_entrega" method="post">
                    <input type="hidden" id="id_inscripcion_curso_e" name="id_inscripcion_curso_e">

                    <div class="form-group row">
                        
                        <div class="col-lg-4">
                            <label for="fecha_entrega">Fecha Entrega: </label>
                            <input type="date" class="form-control" id="fecha_entrega_e" name="fecha_entrega_e" required/>
                            <span class="form-text text-muted">Ingrese la fecha de la entrega</span>
                        </div>

                        <div class="col-lg-4">
                            <label for="entregado_a">Certificado recogido: </label>
                            <select name="certificado_recogido_e" id="certificado_recogido_e" class="form-control" required >
                                <option value="">-- seleccione --</option>
                                <option value="si">si</option>
                                <option value="no">no</option>
                            </select>
                            <span class="form-text text-muted">Ingrese a la persona entregado</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="entregado_a">entregado a: </label>
                            <input type="text" class="form-control" id="entregado_a_e" name="entregado_a_e" required/>
                            <span class="form-text text-muted">Ingrese a la persona entregado</span>
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="observacion_entrega">Observaci&oacute;n de la entrega: </label>
                            <textarea name="observacion_entrega_e" class="form-control" id="observacion_entrega_e" rows="2"></textarea>
                            <span class="form-text text-muted">Ingrese si existe alguna observaci&oacute;n</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="nav-icon la la-edit"></i>
                                Entregar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>