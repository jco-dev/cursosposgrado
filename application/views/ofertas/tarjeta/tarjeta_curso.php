<div class="col-lg-4 col-md-6 col-xs-12">
    <div class="card card-custom gutter-b">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between flex-column h-100">

                <img class="img-fluid" style="height: 165px; border-radius: 6px 6px 0px 0px;" src="<?= base_url($curso->banner_curso) ?>" alt="Banner curso">

                <div class="p-3">
                    <div class="h-100">

                        <div class="d-flex flex-column flex-center">
                            <div class="expander">
                                <p class="text-justify">
                                    <?= mb_convert_case(preg_replace('/\s+/', ' ', trim($curso->detalle_curso)), MB_CASE_UPPER) ?>
                                </p>
                            </div>
                        </div>

                        <div class="separator separator-solid separator-border-2"></div>
                        <div class="pt-3">

                            <!-- Fecha Inicio -->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M4,7 L20,7 L20,19.5 C20,20.3284271 19.3284271,21 18.5,21 L5.5,21 C4.67157288,21 4,20.3284271 4,19.5 L4,7 Z M10,10 C9.44771525,10 9,10.4477153 9,11 C9,11.5522847 9.44771525,12 10,12 L14,12 C14.5522847,12 15,11.5522847 15,11 C15,10.4477153 14.5522847,10 14,10 L10,10 Z" fill="#000000" />
                                                    <rect fill="#000000" opacity="0.3" x="2" y="3" width="20" height="4" rx="1" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">Inicio:</a>
                                </div>
                                <span class="font-weight-bold min-w-45px"><?= $curso->fecha_inicial ?></span>
                            </div>
                            <!--end:: Fecha Inicio -->

                            <!--begin::Horarios -->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#000000" opacity="0.3" />
                                                    <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">Horarios:</a>
                                </div>
                                <span class="font-weight-bold min-w-45px">Plataforma habilitado 24/7</span>
                            </div>
                            <!--end::Horarios-->

                            <!--begin::Carga Horaria-->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">Carga
                                        Horaria:</a>
                                </div>
                                <span class="font-weight-bold min-w-45px"><?= $curso->carga_horaria ?> horas académicas</span>
                            </div>
                            <!--end::Carga Horaria-->

                            <!--begin::Inversión -->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) " />
                                                    <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">Inversión:</a>
                                </div>
                                <?php if (strtotime(date('d-m-Y')) >= strtotime($curso->fecha_inicio_descuento) && strtotime(date('d-m-Y')) <= strtotime($curso->fecha_fin_descuento) && $curso->descuento > 0) { ?>
                                    <span class="font-size-md font-weight-normal"><del class="text-danger">Bs. <?= intval($curso->inversion) ?></del> &nbsp; <span class="font-weight-bold">Bs. <?= intval(($curso->inversion) - ($curso->inversion * $curso->descuento / 100)) ?></span> </span>
                                <?php } else { ?>
                                    <span class="font-size-md label label-light-success label-inline font-weight-normal"><span class="font-weight-bold">Bs. <?= intval($curso->inversion) ?></span> </span>
                                <?php } ?>
                            </div>
                            <!--end::Inversión-->

                            <!--begin::Celular -->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M11.613922,13.2130341 C11.1688026,13.6581534 10.4887934,13.7685037 9.92575695,13.4869855 C9.36272054,13.2054673 8.68271128,13.3158176 8.23759191,13.760937 L6.72658218,15.2719467 C6.67169475,15.3268342 6.63034033,15.393747 6.60579393,15.4673862 C6.51847004,15.7293579 6.66005003,16.0125179 6.92202169,16.0998418 L8.27584113,16.5511149 C9.57592638,16.9844767 11.009274,16.6461092 11.9783003,15.6770829 L15.9775173,11.6778659 C16.867756,10.7876271 17.0884566,9.42760861 16.5254202,8.3015358 L15.8928491,7.03639343 C15.8688153,6.98832598 15.8371895,6.9444475 15.7991889,6.90644684 C15.6039267,6.71118469 15.2873442,6.71118469 15.0920821,6.90644684 L13.4995401,8.49898884 C13.0544207,8.94410821 12.9440704,9.62411747 13.2255886,10.1871539 C13.5071068,10.7501903 13.3967565,11.4301996 12.9516371,11.8753189 L11.613922,13.2130341 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="https://api.whatsapp.com/send/?phone=59162332648&text=M%C3%A1s%20informaci%C3%B3n%20sobre%20el%20curso%20de:%20*<?= $curso->fullname ?>%20-%20UPEA*" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">
                                        Celular Ref.:
                                    </a>
                                </div>
                                <a href="https://api.whatsapp.com/send/?phone=59162332648&text=M%C3%A1s%20informaci%C3%B3n%20sobre%20el%20curso%20de:%20*<?= $curso->fullname ?>%20-%20UPEA*" class="font-weight-bold text-dark min-w-45px"><?= $curso->celular_referencia ?></a>
                            </div>
                            <!--end::Celular-->

                            <!--begin::Descuento-->
                            <?php if (strtotime(date('d-m-Y')) >= strtotime($curso->fecha_inicio_descuento) && strtotime(date('d-m-Y')) <= strtotime($curso->fecha_fin_descuento) && $curso->descuento > 0) { ?>
                                <div class="d-flex align-items-center pb-2">
                                    <div class="symbol symbol-30 symbol-light mr-4">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-1x svg-icon-dark-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) " />
                                                        <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">Descuento:</a>
                                    </div>
                                    <span class="font-weight-bold min-w-45px">
                                        <span class="label label-warning label-inline"><?= $curso->descuento ?>%</span>
                                        <span class="text-warning font-weight-boldest">hasta</span>
                                        <span class="label label-warning label-inline"><?= $curso->fecha_fin_descuento ?></span>
                                    </span>
                                </div>
                            <?php } ?>
                            <!--end::Descuento-->

                            <!--begin::Límite de inscripción-->
                            <div class="d-flex align-items-center pb-2">
                                <div class="symbol symbol-30 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-danger svg-icon-1x">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M4,7 L20,7 L20,19.5 C20,20.3284271 19.3284271,21 18.5,21 L5.5,21 C4.67157288,21 4,20.3284271 4,19.5 L4,7 Z M10,10 C9.44771525,10 9,10.4477153 9,11 C9,11.5522847 9.44771525,12 10,12 L14,12 C14.5522847,12 15,11.5522847 15,11 C15,10.4477153 14.5522847,10 14,10 L10,10 Z" fill="#000000" />
                                                    <rect fill="#000000" opacity="0.3" x="2" y="3" width="20" height="4" rx="1" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-danger mb-1 font-size-lg font-weight-bolder">
                                        L&iacute;mite de Inscripci&oacute;n: &nbsp;
                                    </a>
                                </div>
                                <span class="text-danger font-weight-bold min-w-45px"><span><?= $curso->limite_inscripcion ?></span>
                            </div>
                            <!--end::Límite de inscripción-->

                        </div>

                    </div>

                    <!-- Acciones -->
                    <div class="d-flex justify-content-around pt-3">
                        <a href="<?= base_url($curso->url_pdf) ?>" target="_blank" class="btn btn-primary btn-shadow-hover font-size-sm btn-sm font-weight-bold">
                            <i class="fa fa-eye icon-sm"></i>
                            Contenido
                        </a>
                        <a href="<?= base_url('informacion/index/?id=' . base64_encode($this->encryption->encrypt($curso->id_course_moodle)) . "&uijkikij=jfadskjl") ?>" data-id="<?= $this->encryption->encrypt($curso->id_course_moodle) ?>" class="btn btn-primary btn-shadow-hover font-size-sm btn-sm font-weight-bold" target="_blank">
                            M&aacute;s informaci&oacute;n
                        </a>
                        <a href="<?= base_url('inscripcion/curso/' . base64_encode($this->encryption->encrypt($curso->id_course_moodle))) ?>" data-id="<?= $this->encryption->encrypt($curso->id_course_moodle) ?>" class="btn btn-primary btn-shadow-hover font-size-sm btn-sm font-weight-bold px-4" target="_blank">
                            <i class="fa fa-check icon-sm"></i>
                            Inscribirse
                        </a>
                    </div>
                    <!-- Fin acciones -->
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $('div.expander').expander();
</script>