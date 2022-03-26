<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Cursos posgrado | PSG</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?= base_url("assets/img/posgrado1.ico") ?>" sizes="16x16 24x24 36x36 48x48">
    <style>
        .grecaptcha-badge {
            visibility: hidden;
        }
    </style>
    <?php include('_style.php'); ?>

</head>

<body>
    <div class="container-fluid pt-2" id="padding-container">
        <div class="card card-custom p-0" style="border: 2px solid #000000;">
            <div class="card-body p-0">
                <img src="<?= base_url($data[0]->banner_curso) ?>" alt="Banner del curso" class="img-fluid rounded" style="width: 100%; height: 157px;">
            </div>
        </div>

        <br>
        <div class="card card-custom" style=" border-top: 7px solid #0F1761;">
            <div class="card-body">
                <h4 class="card-label border-left-info text-justify text-uppercase">
                    <?= $data[0]->detalle_curso ?>
                </h4>
                <hr>
                <h5 class="text-justify font-size-lg font-weight-normal">
                    &nbsp;🪙 INVERSIÓN:<?php if (strtotime(date('d-m-Y')) >= strtotime($datos[0]->fecha_inicio_descuento) && strtotime(date('d-m-Y')) <= strtotime($datos[0]->fecha_fin_descuento) && $datos[0]->descuento > 0) { ?>
                    <span class="font-size-md font-weight-normal"><del class="text-danger">Bs. <?= intval($datos[0]->inversion) ?></del> <span class="font-weight-bold">Bs. <?= intval(($datos[0]->inversion) - ($datos[0]->inversion * $datos[0]->descuento / 100)) ?></span> </span>
                <?php } else { ?>
                    <span class="font-size-md font-weight-normal"><span class="font-weight-bold">Bs. <?= intval($datos[0]->inversion) ?></span> </span>
                <?php } ?>
                <?php if (strtotime(date('d-m-Y')) >= strtotime($datos[0]->fecha_inicio_descuento) && strtotime(date('d-m-Y')) <= strtotime($datos[0]->fecha_fin_descuento) && $datos[0]->descuento > 0) { ?>
                    <span class="font-size-md font-weight-normal text-primary"> (descuento de <span class="text-primary font-weight-bold"><?= $datos[0]->descuento ?>% </span> hasta <?= date('d-m-Y', strtotime($datos[0]->fecha_fin_descuento)) ?>) </span>
                <?php } ?> <br>&nbsp;
                ▶️ OPCIONES DE PAGO:
                <ol>
                    <li>Transferencia bancaria o depósito de a los siguientes números de cuenta:
                        <ul>
                            <li>10000044162084 (Iván Jhonny Mejia Baltazar - 9061397 LP) - Banco Unión.</li>
                            <li>4071112506 (Iván Jhonny Mejia Baltazar - 9061397 LP) - Banco Mercantil Santa Cruz</li>
                        </ul>
                    </li>
                    <li>Transferencia a Tigo Money
                        <?php if (strtotime(date('d-m-Y')) >= strtotime($datos[0]->fecha_inicio_descuento) && strtotime(date('d-m-Y')) <= strtotime($datos[0]->fecha_fin_descuento) && $datos[0]->descuento > 0) { ?>
                            <span class="font-size-md font-weight-normal"> <span class="font-weight-bold">Bs. <?= intval(($datos[0]->inversion) - ($datos[0]->inversion * $datos[0]->descuento / 100)) ?></span> </span>
                        <?php } else { ?>
                            <span class="font-size-md font-weight-normal"><span class="font-weight-bold">Bs. <?= intval($datos[0]->inversion) ?></span> </span>
                        <?php } ?>
                        al número (Incluir comisión 4 Bs):
                        📲 76209205 (Brayan Condori Choque).
                    </li>
                    <li>Haciendo el pago directamente en nuestra oficina: Edificio Emblemático U.P.E.A., 3er piso, Oficina 3 de POSGRADO - Av. Sucre S/N Zona Villa Esperanza
                        :: Ciudad de El Alto - Bolivia.</li>
                </ol>
                </h5>
                <span class="text-danger">(*) Obligatorio</span>
            </div>
        </div>

        <?php
        if ($datos[0]->fecha_inicial >= date('Y-m-d')) { ?>
            <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
                <!--begin: Wizard Nav-->
                <div class="wizard-nav d-none">
                    <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-label">
                                <h3 class="wizard-title">
                                    <span>1.</span>Datos personales
                                </h3>
                                <div class="wizard-bar"></div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-label">
                                <h3 class="wizard-title">
                                    <span>2.</span>Detalles de pago
                                </h3>
                                <div class="wizard-bar"></div>
                            </div>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-label">
                                <h3 class="wizard-title">
                                    <span>3.</span>Tipo de certificaci&oacute;n solicitado
                                </h3>
                                <div class="wizard-bar"></div>
                            </div>
                        </div>
                        <!--end::Wizard Step 3 Nav-->

                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-label">
                                <h3 class="wizard-title">
                                    <span>4.</span>Completado
                                </h3>
                                <div class="wizard-bar"></div>
                            </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->

                    </div>
                </div>
                <!--end: Wizard Nav-->
                <!--begin: Wizard Body-->
                <div class="row justify-content-center py-10 py-lg-12">
                    <div class="col-lg-12">
                        <!--begin: Wizard Form-->
                        <form class="form" id="frm_curso_inscripcion" enctype="multipart/form-data">
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <?php include('_curso_id.php'); ?>
                            <?php include('_form.php'); ?>
                            <!--begin: Wizard Actions-->
                            <div class="d-flex justify-content-between border-top mt-0 pt-1">
                                <div class="mr-2">
                                    <button type="button" class="btn btn-secondary btn-sm font-weight-bolder px-9 py-4" data-wizard-type="action-prev"> Atr&aacute;s</button>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-info btn-sm font-weight-bolder px-9 py-4 submit" data-wizard-type="action-submit"> Enviar</button>
                                    <button type="button" class="btn btn-secondary btn-sm font-weight-bolder px-9 py-4" data-wizard-type="action-next"> Siguiente</button>
                                </div>
                            </div>
                            <!--end: Wizard Actions-->
                        </form>
                        <!--end: Wizard Form-->
                    </div>
                </div>
                <!--end: Wizard Body-->
            </div>
        <?php } else { ?>
            <div class="alert alert-custom alert-warning mt-10" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">La inscripción al curso ha terminado por favor comuníquese con los encargados del curso. Celular de referencia: <?= $datos[0]->celular_referencia ?></div>
            </div>
        <?php } ?>
    </div>
    <?php include('_script.global.php'); ?>
    <script src="<?= base_url('assets/js/pages/custom/wizard/wizard-inscripcion4.js') ?>"></script>
</body>

</html>