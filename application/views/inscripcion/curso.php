<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Cursos posgrado | PSG</title>
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?= base_url("assets/img/posgrado1.ico") ?>" sizes="16x16 24x24 36x36 48x48">

    <?php include('_style.php'); ?>

</head>

<body>
    <div class="container-fluid pt-2" id="padding-container">
        <div class="card card-custom p-0" style="border: 2px solid #000000;">
            <div class="card-body p-0">
                <img src="<?= base_url($data[0]->banner_curso) ?>" alt="Banner del curso" class="img-fluid rounded" style="width: 900px;height: 157px;">
            </div>
        </div>

        <br>
        <div class="card card-custom" style=" border-top: 7px solid #0F1761;">
            <div class="card-body">
                <h2 class="card-label border-left-info text-justify text-uppercase">
                    <?= $data[0]->detalle_curso ?>
                </h2>
                <br>
                <!-- <?= var_dump($data) ?> -->
                <h5 class="text-justify font-size-lg font-weight-normal">
                    EL PLAZO DE INSCRIPCIÓN DEL CURSO DE GESTIÓN Y ADMINISTRACIÓN DE HERRAMIENTAS PARA LA EDUCACIÓN VIRTUAL, ES HASTA EL SABADO 10 DE ABRIL
                </h5>
                <hr>
                <h5 class="text-justify font-size-lg font-weight-normal">
                    💰 OPCIONES DE PAGO:<br>&nbsp;
                    <ol>
                        <li>TRANSFERENCIA BANCARIA O DEPÓSITO DE 100 Bs AL SIGUIENTE NÚMERO DE CUENTA:
                            10000029978464 (SERGIO AUGUSTO PÉREZ GIRONDA - 6046358 LP) - BANCO UNIÓN</li>
                        <li>TRANSFERENCIA A TIGO MONEY DE 100 Bs AL NÚMERO (INCLUIR COMISIÓN 4 Bs):
                            📲 76209205 (BRAYAN CONDORI CHOQUE)</li>
                        <li>HACIENDO EL PAGO DIRECTAMENTE EN NUESTRA OFICINA: EDIFICIO EMBLEMÁTICO UPEA, 3ER PISO, OFICINA 3 DE POSGRADO - AV. SUCRE S/N ZONA VILLA ESPERANZA :: CIUDAD DE EL ALTO - BOLIVIA</li>
                    </ol>
                </h5>
                <hr>
                <h5 class="text-justify font-size-lg font-weight-normal">
                    POSTERIORMENTE 👉 ACCEDER AL FORMULARIO DE INSCRIPCIÓN, ✍️ REGISTRAR SUS DATOS PERSONALES Y SUBIR EL COMPROBANTE DE SU PAGO (FOTOGRAFÍA O CAPTURA DE PANTALLA) 🏞️
                </h5>
                <hr>
                <h5 class="text-justify font-size-lg font-weight-normal">
                    EL CURSO INICIA EL SÁBADO 10 DE ABRIL 2021 - DURARÁ DOS SEMANAS. <br><br>

                    LA MODALIDAD DEL CURSO SERÁ TOTALMENTE VIRTUAL, LOS CONTENIDOS ESTARÁN COLGADOS EN NUESTRA PLATAFORMA MOODLE PARA QUE USTED PUEDA DESARROLLARLO SEGÚN SU DISPONIBILIDAD DE TIEMPO, TAMBIÉN HABRÁ ACOMPAÑAMIENTO AL PROCESO DE FORMACIÓN CON DOCENTE EN VIVO VÍA ZOOM, DOS VECES POR SEMANA <br><br>

                    🕛 HORARIO DE LAS SESIONES EN VIVO: SÁBADO Y DOMINGO DESDE LAS 7 P.M.
                </h5>

                <hr>
                <h5 class="text-justify font-size-lg font-weight-normal">
                    📃EL CERTIFICADO SERÁ EMITIDO POR LA DIRECCIÓN DE POSGRADO DE LA UNIVERSIDAD PÚBLICA DE EL ALTO, CON UNA CARGA HORARIA DE 180 ACADÉMICAS.<br><br>

                    PODEMOS ENVIARLE SU CERTIFICADO VIA DIGITAL O FÍSICA.<br><br>

                    SI TUVIERA DUDAS NO DUDE EN ESCRIBIRNOS O LLAMARNOS.<br><br>

                    *Este formulario servirá tanto para la inscripción al curso y posterior para la elaboración de los certificados, por lo que todos los datos deben ser ingresados de manera correcta. <br><br>

                    **La institución no se hará responsable si se registraron los datos de manera incorrecta.
                    El nombre y la foto asociados a tu cuenta de Google se registrarán cuando subas archivos y envíes este formulario
                </h5>
                <br>
                <span class="text-danger">(*) Obligatorio</span>
            </div>
        </div>
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
                    <form class="form" id="frm_curso_inscripcion">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <?php include('_curso_id.php'); ?>
                        <?php include('_form.php'); ?>
                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
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
    </div>
    <?php include('_script.global.php'); ?>
    <script src="<?= base_url('assets/js/pages/custom/wizard/wizard-inscripcion.js') ?>"></script>
    <script src='https://www.google.com/recaptcha/api.js?render=6LeBuM4aAAAAAGtVv_eeqnR4n0l0GONpqz-U4OyU'></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LeBuM4aAAAAAGtVv_eeqnR4n0l0GONpqz-U4OyU', {
                    action: 'homepage'
                })
                .then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                });
        });
    </script>
</body>

</html>