<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado M&oacute;dulos de Cursos
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="javascript:;" class="btn btn-primary font-weight-bolder" id="btn_agregar_modulo">

                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000" />
                            </g>
                        </svg>
                        Nuevo M&oacute;dulo
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_modulos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Nombre</th>
                        <th>Fecha Inicial</th>
                        <th>Fecha Final</th>
                        <th>Carga Horaria</th>
                        <th>Fecha Certificaci&oacute;n</th>
                        <th>Creado el</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_modulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_modulo">Agregar M&oacute;dulo</h5>
                <button type="button" id="cerrar_modal_modulos" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frm_agregar_modulo" role="form">

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="id_curso">Curso: </label>
                            <input type="hidden" id="id_certificacion" name="id_certificacion">
                            <select id="id_curso" name="id_curso" class="form-control" required>
                            <option value=""></option>
                                <?php
                                    foreach ($cursos as $curso) {
                                        echo "<option value=".$curso->id.">".$curso->fullname."</option>";
                                    }
                                ?>
                            </select>
                            <span class="form-text text-muted">Seleccione el curso para agregar sus m&oacute;dulos</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="nro_transaccion">Nombre M&oacute;dulo</label>
                            <textarea name="nombre" id="nombre" class="form-control" rows="2" required></textarea>
                            <span class="form-text text-muted">Ingrese el nombre del m&oacute;dulo</span>
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="fecha_inicial">Fecha Inicial: </label>
                            <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial" required />
                            <span class="form-text text-muted">Ingrese fecha de incio</span>
                        </div>

                        <div class="col-lg-6">
                            <label for="fecha_final">Fecha Final: </label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final" required />
                            <span class="form-text text-muted">Ingrese fecha final</span>
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="carga_horaria">Carga Horaria: </label>
                            <input type="number" class="form-control" id="carga_horaria" name="carga_horaria" required />
                            <span class="form-text text-muted">Ingrese la carga horaria</span>
                        </div>

                        <div class="col-lg-6">
                            <label for="fecha_certificacion">Fecha Certificaci&oacute;n: </label>
                            <input type="date" class="form-control" id="fecha_certificacion" name="fecha_certificacion" required />
                            <span class="form-text text-muted">Ingrese La fecha de certificaci&oacute;n</span>
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3 float-right">
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="nav-icon la la-edit"></i>
                                <span id="btn_title"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>