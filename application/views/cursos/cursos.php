<style>
    .modal.modal-fullscreen .modal-dialog {
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        max-width: none;
    }

    .modal.modal-fullscreen .modal-content {
        height: auto;
        height: 100vh;
        border-radius: 0;
        border: none;
    }

    .modal.modal-fullscreen .modal-body {
        overflow-y: auto;
    }
</style>
<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado de Cursos
                </h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_cursos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Curso</th>
                        <th>Nombre corto</th>
                        <th>Certificado</th>
                        <th>Inscritos</th>
                        <th>Preinscritos</th>
                        <th>M&oacute;dulos</th>
                        <th>Fecha Registro</th>
                        <th>Informe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen" id="modal_imprimir_certificado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-certificado">Imprimir Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-certificado">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-certificate-type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-add-certificate">Agregar Tipo de Certificado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body p-15">
                <form class="form" id="frm-save-tipo-certificate">
                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        <div class="w-100">
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                    <span class="required">Tipo Certificado</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione el tipo de certificado para el curso"></i>
                                </label>
                                <input type="hidden" id="id_course" name="id_course" />
                                <!--end::Label-->
                                <!--begin:Options-->
                                <div class="fv-row">
                                    <?php
                                    foreach ($certificate_types as $key => $value) {
                                        echo '<!--begin:Option-->
                                <label class="d-flex flex-stack mb-5 cursor-pointer">
                                    <!--begin:Label-->
                                    <span class="d-flex align-items-center">
                                        <!--begin:Icon-->
                                        <div class="symbol symbol-90 mr-3" style="width: 100px;">
                                            <img src="' . base_url($value->imagen) . '" />
                                        </div>
                                        <!--end:Icon-->
                                        <!--begin:Info-->
                                        <span class="d-flex flex-column p-5">
                                            <span class="fw-bolder fs-6">' . $value->metodo . '</span>
                                        </span>
                                        <!--end:Info-->
                                    </span>
                                    <!--end:Label-->
                                    <!--begin:Input-->
                                    <span class="form-check form-check-custom form-check-solid d-flex align-items-center">
                                        <input class="form-check-input m-2" type="radio" name="id_tipo_certificado" value="' . $value->id_tipo_certificado . '" required/>
                                    </span>
                                    <!--end:Input-->
                                </label>
                                <!--end::Option-->';
                                    }
                                    ?>

                                </div>
                                <!--end:Options-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex flex-stack pt-10">
                        <!--begin::Wrapper-->
                        <div>

                            <button type="submit" class="btn btn-lg btn-primary">
                                Guardar
                            </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_imprimir_totales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-totales"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-totales">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="piechart_3d_inscritos"></div>
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">Recaudación Total</p>
                            <footer class="blockquote-footer" id="total_reacudacion_inscritos">
                            </footer>
                        </blockquote>
                    </div>
                    <div class="col-lg-6">
                        <div id="piechart_3d_preinscritos"></div>
                        <blockquote class="blockquote text-center">
                            <p class="mb-0">Recaudación Total</p>
                            <footer class="blockquote-footer" id="total_reacudacion_preinscritos">
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" id="descargar_recaudacion_total" id-course="">
                    <i class="fa fa-print"></i>
                    Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>