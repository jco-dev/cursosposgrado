<div class="col-lg-4 col-md-6 col-xs-12">

    <div class="card card-custom gutter-b">
        <!--begin::Body-->
        <div class="card-body p-0 pb-3">
            <!--begin::Image-->
            <div class="">
                <img src="<?= base_url($curso->banner_curso) ?>" class="img-fluid rounded-top" alt="">
            </div>
            <!--end::Image-->

            <div class="p-2">
                <p class="text-dark-75 font-size-lg font-weight-boldest text-center mb-2">
                    <?= mb_convert_case(preg_replace('/\s+/', ' ', trim($curso->detalle_curso)), MB_CASE_UPPER) ?>
                </p>

                <div class="separator separator-solid mt-0 mb-0"></div>

                <ul class="navi navi-hover pb-3 p-2">
                    <li class="navi-item p-1">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="flaticon2-calendar-9"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold">Inicio: &nbsp;</span>
                            <span class="font-size-md font-weight-normal"><?= $curso->fecha_inicial ?></span>
                        </a>
                    </li>
                    <li class="navi-item">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="flaticon2-crisp-icons-1"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold">Horarios: &nbsp;</span>
                            <span class="font-size-md font-weight-normal">Plataforma habilitado 24/7</span>
                        </a>
                    </li>
                    <li class="navi-item">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="flaticon2-layers-1"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold">Carga Horaria: &nbsp;</span>
                            <span class="font-size-md font-weight-normal"><?= $curso->carga_horaria ?> Horas</span>
                        </a>
                    </li>
                    <li class="navi-item">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="flaticon-price-tag"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold">Inversi&oacute;n: &nbsp;</span>
                            <span class="font-size-md font-weight-normal">Bs. <?= $curso->inversion ?></span>
                        </a>
                    </li>

                    <li class="navi-item">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="navi-icon flaticon2-phone"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold">Celular Ref.: &nbsp;</span>
                            <span class="font-size-md font-weight-normal"><?= $curso->celular_referencia ?></span>
                        </a>
                    </li>
                    <?php if (date('d-m-Y') <= $curso->fecha_fin_descuento && $curso->descuento > 0) { ?>
                        <li class="navi-item">
                            <a href="#" class="navi-link py-1">
                                <span class="navi-icon">
                                    <i class="navi-icon flaticon2-chronometer"></i>
                                </span>
                                <span class="font-size-lg font-weight-bold">Descuento: &nbsp;</span>
                                <span class="font-size-md font-weight-normal"> <span class="label label-warning label-inline"><?= $curso->descuento ?>%</span> hasta <span class="label label-warning label-inline"><?= $curso->fecha_fin_descuento ?></span></span>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="navi-item">
                        <a href="#" class="navi-link py-1">
                            <span class="navi-icon">
                                <i class="flaticon2-calendar-4 text-danger"></i>
                            </span>
                            <span class="font-size-lg font-weight-bold text-danger">L&iacute;mite de Inscripci&oacute;n: &nbsp;</span>
                            <span class="font-size-md font-weight-normal text-danger"><?= $curso->fecha_inicial ?></span>
                        </a>
                    </li>

                </ul>

                <div class="d-flex justify-content-around">
                    <a href="<?= base_url($curso->url_pdf) ?>" target="_blank" class="btn btn-info btn-shadow-hover font-size-sm btn-sm font-weight-bold">
                        <i class="fa fa-eye icon-sm"></i>
                        Detalles
                    </a>
                    <!-- <a href="javascript:;" data-id="<?= base64_encode($this->encryption->encrypt($curso->id_course_moodle)) ?>" id="descargar_pdf_curso" name="descargar_pdf_curso" class="btn btn-info btn-shadow-hover font-size-sm btn-sm font-weight-bold">
                        <i class="fa fa-eye icon-sm"></i>
                        Detalles
                    </a> -->

                    <a href="<?= base_url('informacion/index/' . base64_encode($this->encryption->encrypt($curso->id_course_moodle))) ?>" data-id="<?= $this->encryption->encrypt($curso->id_course_moodle) ?>" class="btn btn-primary btn-shadow-hover font-size-sm btn-sm font-weight-bold" target="_blank">
                        <i class="fa fa-th-list icon-sm"></i>
                        Informaci&oacute;n
                    </a>

                    <a href="<?= base_url('inscripcion/curso/' . base64_encode($this->encryption->encrypt($curso->id_course_moodle))) ?>" data-id="<?= $this->encryption->encrypt($curso->id_course_moodle) ?>" class="btn btn-success btn-shadow-hover font-size-sm btn-sm font-weight-bold px-4" target="_blank">
                        <i class="fa fa-check icon-sm"></i>
                        Inscribirse
                    </a>
                </div>
            </div>

        </div>
        <!--end::Body-->
    </div>
</div>