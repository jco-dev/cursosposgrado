<style>
    .multimediaFisica4,
    .multimediaFisica4 * {
        box-sizing: border-box;
    }

    .multimediaFisica4 {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
    }

    .multimediaFisica4.dz-clickable {
        cursor: pointer;
    }

    .multimediaFisica4.dz-clickable * {
        cursor: default;
    }

    .multimediaFisica4.dz-clickable .dz-message,
    .multimediaFisica4.dz-clickable .dz-message * {
        cursor: pointer;
    }

    .multimediaFisica4.dz-started .dz-message {
        display: none;
    }

    .multimediaFisica4.dz-drag-hover {
        border-style: solid;
    }

    .multimediaFisica4.dz-drag-hover .dz-message {
        opacity: 0.5;
    }

    .multimediaFisica4 .dz-message {
        text-align: center;
        margin: 2em 0;
    }

    .multimediaFisica4 .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 16px;
        min-height: 100px;
    }

    .multimediaFisica4 .dz-preview:hover {
        z-index: 1000;
    }

    .multimediaFisica4 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica4 .dz-preview.dz-file-preview .dz-image {
        border-radius: 20px;
        background: #999;
        background: linear-gradient(to bottom, #eee, #ddd);
    }

    .multimediaFisica4 .dz-preview.dz-file-preview .dz-details {
        opacity: 1;
    }

    .multimediaFisica4 .dz-preview.dz-image-preview {
        background: white;
    }

    .multimediaFisica4 .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear;
    }

    .multimediaFisica4 .dz-preview .dz-remove {
        font-size: 14px;
        text-align: center;
        display: block;
        cursor: pointer;
        border: none;
    }

    .multimediaFisica4 .dz-preview .dz-remove:hover {
        text-decoration: underline;
    }

    .multimediaFisica4 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica4 .dz-preview .dz-details {
        z-index: 20;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        font-size: 13px;
        min-width: 100%;
        max-width: 100%;
        padding: 2em 1em;
        text-align: center;
        color: rgba(0, 0, 0, 0.9);
        line-height: 150%;
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px;
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-filename {
        white-space: nowrap;
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-filename:hover span {
        border: 1px solid rgba(200, 200, 200, 0.8);
        background-color: rgba(255, 255, 255, 0.8);
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-filename:not(:hover) {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-filename:not(:hover) span {
        border: 1px solid transparent;
    }

    .multimediaFisica4 .dz-preview .dz-details .dz-filename span,
    .multimediaFisica4 .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px;
    }

    .multimediaFisica4 .dz-preview:hover .dz-image img {
        -webkit-transform: scale(1.05, 1.05);
        -moz-transform: scale(1.05, 1.05);
        -ms-transform: scale(1.05, 1.05);
        -o-transform: scale(1.05, 1.05);
        transform: scale(1.05, 1.05);
        -webkit-filter: blur(8px);
        filter: blur(8px);
    }

    .multimediaFisica4 .dz-preview .dz-image {
        border-radius: 20px;
        overflow: hidden;
        width: 120px;
        height: 120px;
        position: relative;
        display: block;
        z-index: 10;
    }

    .multimediaFisica4 .dz-preview .dz-image img {
        display: block;
    }

    .multimediaFisica4 .dz-preview.dz-success .dz-success-mark {
        -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica4 .dz-preview.dz-error .dz-error-mark {
        opacity: 1;
        -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica4 .dz-preview .dz-success-mark,
    .multimediaFisica4 .dz-preview .dz-error-mark {
        pointer-events: none;
        opacity: 0;
        z-index: 500;
        position: absolute;
        display: block;
        top: 50%;
        left: 50%;
        margin-left: -27px;
        margin-top: -27px;
    }

    .multimediaFisica4 .dz-preview .dz-success-mark svg,
    .multimediaFisica4 .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px;
    }

    .multimediaFisica4 .dz-preview.dz-processing .dz-progress {
        opacity: 1;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        -ms-transition: all 0.2s linear;
        -o-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }

    .multimediaFisica4 .dz-preview.dz-complete .dz-progress {
        opacity: 0;
        -webkit-transition: opacity 0.4s ease-in;
        -moz-transition: opacity 0.4s ease-in;
        -ms-transition: opacity 0.4s ease-in;
        -o-transition: opacity 0.4s ease-in;
        transition: opacity 0.4s ease-in;
    }

    .multimediaFisica4 .dz-preview:not(.dz-processing) .dz-progress {
        -webkit-animation: pulse 6s ease infinite;
        -moz-animation: pulse 6s ease infinite;
        -ms-animation: pulse 6s ease infinite;
        -o-animation: pulse 6s ease infinite;
        animation: pulse 6s ease infinite;
    }

    .multimediaFisica4 .dz-preview .dz-progress {
        opacity: 1;
        z-index: 1000;
        pointer-events: none;
        position: absolute;
        height: 16px;
        left: 50%;
        top: 50%;
        margin-top: -8px;
        width: 80px;
        margin-left: -40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        overflow: hidden;
    }

    .multimediaFisica4 .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out;
    }

    .multimediaFisica4 .dz-preview.dz-error .dz-error-message {
        display: block;
    }

    .multimediaFisica4 .dz-preview.dz-error:hover .dz-error-message {
        opacity: 1;
        pointer-events: auto;
    }

    .multimediaFisica4 .dz-preview .dz-error-message {
        pointer-events: none;
        z-index: 1000;
        position: absolute;
        display: block;
        display: none;
        opacity: 0;
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        font-size: 13px;
        top: 130px;
        left: -10px;
        width: 140px;
        background: #be2626;
        background: linear-gradient(to bottom, #be2626, #a92222);
        padding: 0.5em 1.2em;
        color: white;
    }

    .multimediaFisica4 .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626;
    }
</style>
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
                        <th>Imagen Módulo</th>
                        <th>Nombre</th>
                        <th>Fecha Inicial</th>
                        <th>Fecha Final</th>
                        <th>Carga Horaria</th>
                        <th>Fecha Certificaci&oacute;n</th>
                        <th>Color Título</th>
                        <th>Posx imagen módulo</th>
                        <th>Posy imagen módulo</th>
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
                            <h6>Imagen del Módulo</h6>
                            <div class="multimediaFisica4 needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del módulo.

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="id_curso">Curso: </label>
                            <input type="hidden" id="id_certificacion" name="id_certificacion">
                            <select id="id_curso" name="id_curso" class="form-control" required>
                                <option value=""></option>
                                <?php
                                foreach ($cursos as $curso) {
                                    echo "<option value=" . $curso->id . ">" . $curso->fullname . "</option>";
                                }
                                ?>
                            </select>
                            <span class="form-text text-muted">Seleccione el curso para agregar sus m&oacute;dulos</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="nro_transaccion">Nombre M&oacute;dulo</label>
                            <textarea name="nombre" id="nombre" class="form-control" rows="1" required></textarea>
                            <span class="form-text text-muted">Ingrese el nombre del m&oacute;dulo</span>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="fecha_inicial">Fecha Inicial: </label>
                            <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial" required />
                            <span class="form-text text-muted">Ingrese fecha de incio</span>
                        </div>

                        <div class="col-lg-4">
                            <label for="fecha_final">Fecha Final: </label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final" required />
                            <span class="form-text text-muted">Ingrese fecha final</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="color_titulo">Color subtitulo <span class="text-danger">(*)</span>:</label>
                            <input type="color" class="form-control" id="color_titulo" name="color_titulo" />
                            <span class="form-text text-muted">Seleccione color para el titulo del módulo</span>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="posx_imagen_modulo">Posx imagen módulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_imagen_modulo" name="posx_imagen_modulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese posición x </span>
                        </div>
                        <div class="col-lg-6">
                            <label for="posy_imagen_modulo">Posy imagen módulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_imagen_modulo" name="posy_imagen_modulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese posición y</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="carga_horaria">Color título: </label>
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