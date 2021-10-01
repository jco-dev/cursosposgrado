<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Cursos Posgrado UPEA</title>
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
    <link rel="shortcut icon" href="<?= base_url('assets/img/img_send_certificate/posgrado.png') ?>" />
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

                                <div class="flex-row-fluid ml-lg-8">
                                    <!--begin::Notice-->
                                    <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                                        <div class="alert-icon">
                                            <span class="svg-icon svg-icon-primary svg-icon-4x">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000" />
                                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <div class="alert-text">
                                            <span class="h5"> Disponibilidad de Entrega de certificados</span>
                                            <p class="m-0 text-justify">Los certificados se generan 10 días hábiles después de la conclusión del curso</p>

                                            <div class="d-flex flex-row pt-2">


                                                <div class="bg-primary" style="width: 10px; height: 10px;"></div>
                                                <?php
                                                for ($i = 100; $i >= 0; $i = $i - 10) {
                                                    echo '<div class="bg-primary-o-' . $i . '" style="width: 10px; height: 10px; margin-left: 5px"></div>';
                                                }
                                                ?>


                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Notice-->
                                    <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <!--begin::List Widget 10-->
                                            <div class="card card-custom card-stretch gutter-b">

                                                <form id="frm-consulta-certificacion">
                                                    <div class="card-body">
                                                        <div class="result">

                                                        </div>
                                                        <div class="form-group">
                                                            <label>Carnet de Identidad
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="carnet_identidad" name="carnet_identidad" required />
                                                            <span class="form-text text-muted">Ingrese su Carnet de Identidad</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Celular
                                                                <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="nro_celular" name="nro_celular" required />
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <input type="hidden" name="code" id="code" value="" />
                                                                <label class="col-lg-12">Captcha <span class="text-danger">*</span></label>
                                                                <img src="" id="img-captcha" />
                                                            </div>
                                                            <div class="col-6">
                                                                <label> &nbsp;</label>
                                                                <input type="text" class="form-control" name="result" id="result" required />
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary mr-2">Consultar</button>
                                                            <button type="reset" class="btn btn-secondary">Limpiar</button>
                                                        </div>
                                                    </div>

                                                </form>

                                            </div>
                                            <!--end: Card-->
                                            <!--end: List Widget 10-->
                                        </div>
                                        <div class="col-lg-8" id="cursos-certificacion">

                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Content-->
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
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/custom/gmaps/gmaps.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/widgets.js') ?>"></script>
    <script src="<?= base_url('assets/js/oferta/oferta.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.expander.js') ?>"></script>
</body>

</html>