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
                <h3 class="card-label border-left-info">
                    <?= $data[0]->detalle_curso ?>
                </h3>
                <!-- <button class="btn btn-success" id="imprimir">Imprimir</button> -->
                <span class="text-danger">(*) Obligatorio</span>
            </div>
        </div>
        <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
            <div class="wizard-nav d-none">
                <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">

                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
                                <span>1.</span>Datos personales
                            </h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>

                    <div class="wizard-step" data-wizard-type="step">
                        <div class="wizard-label">
                            <h3 class="wizard-title">
                                <span>4.</span>Completado
                            </h3>
                            <div class="wizard-bar"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row justify-content-center py-10 py-lg-12">
                <div class="col-lg-12">
                    <!--begin: Wizard Form-->
                    <form class="form" id="frm_curso_informacion">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <?php include('_curso_id.php'); ?>
                        <?php include("_form.php"); ?>
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
    <script src="<?= base_url('assets/js/pages/custom/wizard/wizard-informacion.js') ?>"></script>
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