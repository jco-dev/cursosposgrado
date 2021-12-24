<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Cursos Posgrado | Obtener cupón</title>
    <meta name="description" content="Capacítate con nuestros Cursos Virtuales 100% prácticos" />
    <meta property="og:description" content="#EstudiaCursosPosgradoEnCasa" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta property="og:image" content="<?= base_url('assets/img/img_send_certificate/posgrado.png') ?>" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/layout/header/base/dark.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/layout/header/menu/dark.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/layout/brand/dark.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/layout/aside/dark.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/cupon/index.css') ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?= base_url('assets/img/img_send_certificate/posgrado.png') ?>" />
    <style>
        .contenedo-cupon {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* margin: 15px; */
        }

        img.cupon-image {
            width: 300px;
            height: 200px;
            padding: 5px;
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed page-loading">
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <a href="/">
            <h5 class="text-white font-weight-boldest">CURSOS PSG</h5>
        </a>
        <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>
            </button>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <div id="kt_header" class="header header-fixed">
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            <div class="header-logo">
                                <a href="/">
                                    <img alt="Logo" src="assets/img/posgrado1.png" style="width: 95px; height: 40px;" />
                                </a>
                            </div>
                            <?php include('menu.php') ?>
                        </div>
                        <?php include('header.php') ?>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <!--begin::Page Title-->
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Cursos Posgrado</h5>
                                <!--end::Page Title-->
                                <!--begin::Actions-->
                                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                                <span class="text-muted font-weight-bold mr-4">Certificación</span>

                                <?php if (isset($proximo_curso) && $proximo_curso != null) { ?>
                                    <a href="#proximoscursos" class="btn btn-light-primary font-weight-bolder btn-sm">Próximos cursos</a>
                                <?php } ?>
                                <!--end::Actions-->
                            </div>
                            <!--end::Info-->
                            <?php if ($this->session->userdata('id', TRUE) != null) : ?>

                                <div class="d-flex align-items-center">
                                    <a href="#" class="btn btn-primary btn-sm font-weight-bold font-size-base mr-1" data-titulo="EXPOCRUZ" data-id="2" id="btn-expo">
                                        <i class="fa fa-bell"></i>
                                        Fexpo Cruz
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm font-weight-bold font-size-base mr-1" data-titulo="FERIA DE LIBRO" data-id="1" id="btn-libro">
                                        <i class="fa fa-bell"></i>
                                        Feria de libro
                                    </a>
                                </div>
                            <?php endif; ?>
                            <!--end::Toolbar-->
                        </div>
                    </div>
                    <!--begin::Content-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">

                            <!--begin::Profile 2-->
                            <div class="d-flex flex-row">
                                <!--begin::Content-->
                                <div class="flex-row-fluid ml-lg-5">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!--begin::List Widget 10-->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <div class="row">

                                                    <div class="col-lg-7 p-10">
                                                        <div class="contenedo-cupon">
                                                            <img src="assets/img/img_send_certificate/cupon.jpg" class="cupon-image" alt="Imagen de cupón">
                                                            <h3 style="font-weight: bold;">¡Obtén tu descuento ahora!</h3>
                                                            <h6 style="text-align: center;">Consigue tus descuentos para tus próximas inscripciones en cualquiera de nuestros cursos.</h6>
                                                            <h6 style="text-align: center;">¿Qué tienes que hacer para conseguir tu cupón por fin de año?</h6>

                                                            <section style="padding-left: 5px;padding-right: 5px;">
                                                                <p>👉 Regístrate en el formulario.</p>
                                                                <p>💵 Obtén un cupón de descuento del <strong>30%</strong>.</p>
                                                                <p>🔄 Comparte esta noticia con tus amig@s para que obtengan su cupón por fin de año.</p>
                                                            </section>
                                                            <h5 style="font-weight: bold; text-align: center;">Cupón canjeable sólo en la inscripción de cualquiera de nuestros cursos validando el código.</h5>
                                                            <p>📆 Promoción válida hasta: <span style="font-weight: bold;">31/12/2021</span></p>
                                                            <div id="cupon-fecha-fin"></div>
                                                            <button class="btn button-cupon">¡OBTÉN TUS CUPONES AHORA!</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 p-10">
                                                        <div class="main-wrapper">
                                                            <div class="tree-container">
                                                                <div class="star"></div>
                                                                <div class="spiral-container">
                                                                    <ul class="spiral one">
                                                                        <li class="light-wrapper light-wrapper-1">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-2">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-3">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-4">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-5">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-6">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-7">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-8">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-9">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-10">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-11">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-12">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-13">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-14">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-15">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-16">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-17">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-18">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-19">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-20">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-21">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-22">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-23">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-24">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-25">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-26">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-27">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-28">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-29">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-30">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-31">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-32">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-33">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-34">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-35">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-36">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-37">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-38">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-39">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-40">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-41">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-42">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-43">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="spiral two">
                                                                        <li class="light-wrapper light-wrapper-1">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-2">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-3">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-4">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-5">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-6">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-7">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-8">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-9">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-10">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-11">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-12">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-13">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-14">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-15">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-16">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-17">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-18">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-19">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-20">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-21">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-22">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-23">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-24">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-25">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-26">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-27">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-28">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-29">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-30">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-31">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-32">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-33">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-34">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-35">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-36">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-37">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-38">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-39">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-40">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-41">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-42">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-43">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="spiral three">
                                                                        <li class="light-wrapper light-wrapper-1">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-2">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-3">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-4">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-5">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-6">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-7">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-8">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-9">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-10">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-11">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-12">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-13">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-14">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-15">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-16">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-17">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-18">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-19">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-20">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-21">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-22">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-23">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-24">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-25">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-26">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-27">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-28">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-29">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-30">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-31">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-32">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-33">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-34">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-35">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-36">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-37">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-38">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-39">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-40">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-41">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-42">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="light-wrapper light-wrapper-43">
                                                                            <div class="stabilise">
                                                                                <div class="light"></div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="text-container">
                                                                <h2 class="happy">Felices Fiestas</h2>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('footer.php') ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-suscribirse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_suscripcion"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-contacto">
                    <form action="" id="frm_suscripcion" role="form" method="post">

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="celular">Celular: </label>
                                <input type="text" class="form-control" id="celular" name="celular" />
                                <span class="form-text text-muted">Ingrese su n&uacute;mero de celular del contacto</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="nombre">Nombres: </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required />
                                <span class="form-text text-muted">Ingrese su nombre del contacto</span>
                            </div>

                        </div>

                        <input type="hidden" id="id_evento" name="id_evento" value="id_evento">

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button href="javascript:void(0)" class="btn text-white" style="background-color: #26CC64; border-radius: 2px;">
                                    <span>
                                        <i class="fab fa-whatsapp text-white"></i>
                                    </span>
                                    Registrar
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal animated bounceInDown" id="modal-cupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Regístrate en este formulario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-contacto">
                    <form action="/cupon/inscripcion" id="frm_inscripcion_cupon" role="form" method="post">

                        <div class="form-group row">
                            <div class="col-lg-9">
                                <label for="ci">Número de Documento: <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="ci_cupon" name="ci_cupon" required />
                                <span class="form-text text-muted">Ingrese su número de documento(C.I.)</span>
                            </div>
                            <div class="col-lg-3">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-secondary btn-block btn-buscar-ci">
                                    <i class="fas fa-search" id="icono-btn-buscar"></i>
                                    Registrar
                                </button>
                            </div>
                        </div>
                        <div id="form-inscripcion">
                            <div class="form-group row">
                                <input type="hidden" id="id_participante_cupon" name="id_participante_cupon" />
                                <div class="col-lg-12">
                                    <label for="nombre">Expedido: </label>
                                    <select name="expedido_cupon" id="expedido_cupon" class="form-control">
                                        <option value=""> Elige </option>
                                        <option value="QR"> Nueva cédula con código QR </option>
                                        <option value="CH">Chuquisaca</option>
                                        <option value="LP">La Paz</option>
                                        <option value="CB">Cochabamba</option>
                                        <option value="OR">Oruro</option>
                                        <option value="PT">Potosí</option>
                                        <option value="TJ">Tarija</option>
                                        <option value="SC">Santa Cruz</option>
                                        <option value="BE">Beni</option>
                                        <option value="PD">Pando</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="nombre">Nombre: <span class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control" id="nombre_cupon" name="nombre_cupon" required />
                                    <span class="form-text text-muted">Ingrese su nombre</span>
                                </div>
                                <div class="col-lg-4">
                                    <label for="paterno">Paterno: <span class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control" id="paterno_cupon" name="paterno_cupon" required />
                                    <span class="form-text text-muted">Apellido paterno</span>
                                </div>
                                <div class="col-lg-4">
                                    <label for="materno">Materno: </label>
                                    <input type="text" class="form-control" id="materno_cupon" name="materno_cupon" />
                                    <span class="form-text text-muted">Apellido materno</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="celular">Celular: <span class="text-danger">(*)</span></label>
                                    <input type="number" class="form-control" id="celular_cupon" name="celular_cupon" required />
                                    <span class="form-text text-muted">Número de celular</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button href="javascript:void(0)" class="btn button-cupon btn-block">
                                        <i class="fas fa-save text-white" style="padding-bottom: 5px;"></i>
                                        RESERVAR MI CUPÓN
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_imprimir_cupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-cupon">Cupón de descuento</h5>
                    <button type="button" class="close close-modal-cupon" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-cupon">
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-around">
                        <a href="#" id="descargar-cupon" title='cupon.pdf' download="cupon.pdf" class="btn btn-danger">
                            <i class="far fa-file-pdf"></i>
                            Descargar PDF
                        </a>
                        <a href="#" id="whatsapp" class="btn btn-success ml-2">
                            <i class="fab fa-whatsapp"></i>
                            Enviar a WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
        </span>
    </div>
    <script>
        var HOST_URL = "https://cursosposgrado.upea.bo";
    </script>
    <script>
        var KTAppSettings = {
            breakpoints: {
                sm: 576,
                md: 768,
                lg: 992,
                xl: 1200,
                xxl: 1400,
            },
            colors: {
                theme: {
                    base: {
                        white: "#ffffff",
                        primary: "#3699FF",
                        secondary: "#E5EAEE",
                        success: "#1BC5BD",
                        info: "#8950FC",
                        warning: "#FFA800",
                        danger: "#F64E60",
                        light: "#E4E6EF",
                        dark: "#181C32",
                    },
                    light: {
                        white: "#ffffff",
                        primary: "#E1F0FF",
                        secondary: "#EBEDF3",
                        success: "#C9F7F5",
                        info: "#EEE5FF",
                        warning: "#FFF4DE",
                        danger: "#FFE2E5",
                        light: "#F3F6F9",
                        dark: "#D6D6E0",
                    },
                    inverse: {
                        white: "#ffffff",
                        primary: "#ffffff",
                        secondary: "#3F4254",
                        success: "#ffffff",
                        info: "#ffffff",
                        warning: "#ffffff",
                        danger: "#ffffff",
                        light: "#464E5F",
                        dark: "#ffffff",
                    },
                },
                gray: {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32",
                },
            },
            "font-family": "Poppins",
        };
    </script>
    <script>
        //download.js v4.2, by dandavis; 2008-2016. [CCBY2] see http://danml.com/download.html for tests/usage
        // v1 landed a FF+Chrome compat way of downloading strings to local un-named files, upgraded to use a hidden frame and optional mime
        // v2 added named files via a[download], msSaveBlob, IE (10+) support, and window.URL support for larger+faster saves than dataURLs
        // v3 added dataURL and Blob Input, bind-toggle arity, and legacy dataURL fallback was improved with force-download mime and base64 support. 3.1 improved safari handling.
        // v4 adds AMD/UMD, commonJS, and plain browser support
        // v4.1 adds url download capability via solo URL argument (same domain/CORS only)
        // v4.2 adds semantic variable names, long (over 2MB) dataURL support, and hidden by default temp anchors
        // https://github.com/rndme/download

        (function(root, factory) {
            if (typeof define === 'function' && define.amd) {
                // AMD. Register as an anonymous module.
                define([], factory);
            } else if (typeof exports === 'object') {
                // Node. Does not work with strict CommonJS, but
                // only CommonJS-like environments that support module.exports,
                // like Node.
                module.exports = factory();
            } else {
                // Browser globals (root is window)
                root.download = factory();
            }
        }(this, function() {

            return function download(data, strFileName, strMimeType) {

                var self = window, // this script is only for browsers anyway...
                    defaultMime = "application/octet-stream", // this default mime also triggers iframe downloads
                    mimeType = strMimeType || defaultMime,
                    payload = data,
                    url = !strFileName && !strMimeType && payload,
                    anchor = document.createElement("a"),
                    toString = function(a) {
                        return String(a);
                    },
                    myBlob = (self.Blob || self.MozBlob || self.WebKitBlob || toString),
                    fileName = strFileName || "download",
                    blob,
                    reader;
                myBlob = myBlob.call ? myBlob.bind(self) : Blob;

                if (String(this) === "true") { //reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
                    payload = [payload, mimeType];
                    mimeType = payload[0];
                    payload = payload[1];
                }


                if (url && url.length < 2048) { // if no filename and no mime, assume a url was passed as the only argument
                    fileName = url.split("/").pop().split("?")[0];
                    anchor.href = url; // assign href prop to temp anchor
                    if (anchor.href.indexOf(url) !== -1) { // if the browser determines that it's a potentially valid url path:
                        var ajax = new XMLHttpRequest();
                        ajax.open("GET", url, true);
                        ajax.responseType = 'blob';
                        ajax.onload = function(e) {
                            download(e.target.response, fileName, defaultMime);
                        };
                        setTimeout(function() {
                            ajax.send();
                        }, 0); // allows setting custom ajax headers using the return:
                        return ajax;
                    } // end if valid url?
                } // end if url?


                //go ahead and download dataURLs right away
                if (/^data\:[\w+\-]+\/[\w+\-]+[,;]/.test(payload)) {

                    if (payload.length > (1024 * 1024 * 1.999) && myBlob !== toString) {
                        payload = dataUrlToBlob(payload);
                        mimeType = payload.type || defaultMime;
                    } else {
                        return navigator.msSaveBlob ? // IE10 can't do a[download], only Blobs:
                            navigator.msSaveBlob(dataUrlToBlob(payload), fileName) :
                            saver(payload); // everyone else can save dataURLs un-processed
                    }

                } //end if dataURL passed?

                blob = payload instanceof myBlob ?
                    payload :
                    new myBlob([payload], {
                        type: mimeType
                    });


                function dataUrlToBlob(strUrl) {
                    var parts = strUrl.split(/[:;,]/),
                        type = parts[1],
                        decoder = parts[2] == "base64" ? atob : decodeURIComponent,
                        binData = decoder(parts.pop()),
                        mx = binData.length,
                        i = 0,
                        uiArr = new Uint8Array(mx);

                    for (i; i < mx; ++i) uiArr[i] = binData.charCodeAt(i);

                    return new myBlob([uiArr], {
                        type: type
                    });
                }

                function saver(url, winMode) {

                    if ('download' in anchor) { //html5 A[download]
                        anchor.href = url;
                        anchor.setAttribute("download", fileName);
                        anchor.className = "download-js-link";
                        anchor.innerHTML = "downloading...";
                        anchor.style.display = "none";
                        document.body.appendChild(anchor);
                        setTimeout(function() {
                            anchor.click();
                            document.body.removeChild(anchor);
                            if (winMode === true) {
                                setTimeout(function() {
                                    self.URL.revokeObjectURL(anchor.href);
                                }, 250);
                            }
                        }, 66);
                        return true;
                    }

                    // handle non-a[download] safari as best we can:
                    if (/(Version)\/(\d+)\.(\d+)(?:\.(\d+))?.*Safari\//.test(navigator.userAgent)) {
                        url = url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
                        if (!window.open(url)) { // popup blocked, offer direct download:
                            if (confirm("Displaying New Document\n\nUse Save As... to download, then click back to return to this page.")) {
                                location.href = url;
                            }
                        }
                        return true;
                    }

                    //do iframe dataURL download (old ch+FF):
                    var f = document.createElement("iframe");
                    document.body.appendChild(f);

                    if (!winMode) { // force a mime that will download:
                        url = "data:" + url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
                    }
                    f.src = url;
                    setTimeout(function() {
                        document.body.removeChild(f);
                    }, 333);

                } //end saver




                if (navigator.msSaveBlob) { // IE10+ : (has Blob, but not a[download] or URL)
                    return navigator.msSaveBlob(blob, fileName);
                }

                if (self.URL) { // simple fast and modern way using Blob and URL:
                    saver(self.URL.createObjectURL(blob), true);
                } else {
                    // handle non-Blob()+non-URL browsers:
                    if (typeof blob === "string" || blob.constructor === toString) {
                        try {
                            return saver("data:" + mimeType + ";base64," + self.btoa(blob));
                        } catch (y) {
                            return saver("data:" + mimeType + "," + encodeURIComponent(blob));
                        }
                    }

                    // Blob but not URL support:
                    reader = new FileReader();
                    reader.onload = function(e) {
                        saver(this.result);
                    };
                    reader.readAsDataURL(blob);
                }
                return true;
            }; /* end download() */
        }));
    </script>
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/gmaps/gmaps.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/widgets.js') ?>"></script>
    <script src="<?= base_url('assets/js/oferta/oferta.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.expander.js') ?>"></script>
    <script src="<?= base_url('assets/js/simplyCountdown.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/cupon/index.js') ?>"></script>
</body>

</html>