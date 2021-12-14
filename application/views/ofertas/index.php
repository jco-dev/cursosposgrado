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
    <style>
        .btn-cupon {
            display: inline-block;
            margin-left: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            min-width: 100px;
            /* padding: 1px 10px; */
            padding: 0px 30px;
            /* font-family: 'Lobster', cursive; */
            font-size: 14px;
            line-height: 30px;
            text-decoration: none;
            color: #FFF;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.75);
            background: #A51214;
            outline: none;
            border-radius: 6px;
            border: .7px solid #800E10;


            position: relative;
            overflow: visible;
            /* IE9 & 10 */
            -webkit-transition: 500ms linear;
            -moz-transition: 500ms linear;
            -o-transition: 500ms linear;
            transition: 500ms linear;
        }

        .btn-cupon::before {
            content: '';
            display: block;
            position: absolute;
            top: -8px;
            left: -3px;
            right: 0;
            height: 19px;
            background:
                url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACsAAAAXCAYAAACS5bYWAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABFpJREFUeNrUV0tIo1cUvpkYjQ4xxSA6DxuNqG0dtaUKOgs3s6i0dFd3pSsXdjeIixakiGA34sZuXCkoONLFwJTK4GMYLYXg29gatTpiXurkbd7vv9/5ub+IxuhA7eiFQ5Kbc8/57ne/e87/ywRBYLdl3GG3aNwqsLJ0k0tLS+fmcnNzWUVFBVMoFGx2djarvLxcm5OTw+bm5iytra2xc4ExNjY27iqVyvvwK6CpeDzuCYVC1urq6qDA9UcfPp+PHR4esmAwKK6tr68/l5/8rgQ2Ozub1dbWyiYmJooaGxt/VqvV38jlchX9l0qlwoFA4DWS/RKLxRxFRUVf5+XlPcaaT2AP0sVPJBL2SCRiAPBpu93+vKamZo/Ae71eZjabWV1dXVqw7CKwp43ksrCw8Bhg7MJ/PLDZ5PHx8cz29vYT5JGD/bSYLgTrcDgYdk6siSc6NjZWDaAe4ZoHQL+cmZnRpZPnhWDpD8kw7uKo9ML/NMCsd2tr61vkzboMrEyv138M7TyLRqMWMBsX3sMgaZhMpp+AR5EJrCocDpuEGzKg4x8khs+CVWxubvZfR9JkMik4nU7BarUKLpeLmLsKuwIqTLynp4fqmIzASrqQT09Pf1VVVfX0KsWZ6uHBwQHTaDSsoKAgo6/H4xHLEcrVyRwuEisrKzs5XrrIVAVwiUVDKRRrL+YI32ewdVhMApuHWvcj6vids6J2u90MF4yBHUZNgKoEBaRBQalJqFSqtJfUYrGIlQX+ydXVVTN+u0tKSjQNDQ1axJVl2iTypebn55d7e3v/kqoDgZU1NTU9LCws/Py0M+2ekuGincxJ3yF+18jIyHJLS0slQJUWFxczrBeBE0vE5tHRkbixlZWVfSR8gTX/0P5gH7S1tX3Z3t7+BW8qAvwSfr8/jA0EIRM/qoFtampqbW9vTw+XA+ojUruVd3Z2tvb19T2TQFEim81GgVJoCvvj4+NLOJZgaWmpemdn5y3a6BbcnJDAw8HBwac6ne6eqCW5XDwB3qVSqM9/DAwMUNy/eVLabT7sI25qwgujThCBhWE+mAt2yNc4SQKSZrOQQE1HS22VJkmPAGTr7+//fX19fRk+Zgq0trbGeFAKEAQT98BSqKOj47vm5uaa/Px8JeIk4GcaHh6eWlxcfAU/A8xG67BxAX3fwdcbYUpSDJ06Z49Ak8ZC3OL8f3YiA4PBYKdLQ2AJ9OTk5GpXV9cQiCVh79M94QtlPLDUE/1gPNrd3f0W33W4cBoco48zQuy/IZYAMnGqlSc4c66L9JruQUaSARXeT8HGKzxAqFBekni6+h46+pMzGiJGMgTOJh1yU/KNEGDvZWvfBawkA9ppwGg0mrRa7SOI2g+gxOgbJIpdFpj72PnxSnPX8vqRxTURgBQWKisrH+GThOm+CtAzoK/9/Uiqq/6hoaHfdnd3jaOjo7/yY7yxbwqkWy3sQzpS2C6YirwvUJk0y7hurfyGRrnduPGvAAMASmo8wzeVwfsAAAAASUVORK5CYII=) no-repeat 0 0,
                url(data:image/png;base64,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) no-repeat 50% 0,
                url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAXCAYAAACFxybfAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAodJREFUeNrsVb1rWlEUv2pN/GqspKRSKFYXWzEloIWif0Fn6dJChQ7OQil0qd3EzcEpg0OgdHDr4CQODk7VRlLMEIVqApX4We0zflR9/Z1Ui4T34ksaaAYP/Hzc673n/M6550PG8zz73yKjn0wm83fDYDAwo9HINBrNnwOQg4MDs0ql2lQqlfdAWont7ng8Pjw+Ps44nc4G1pI9EXWaSOzt7TGO42aH5Pv7+08ajUZ0MBiUeXEZd7vdL5VK5fX29rZ+5tQiEmdxKrlcjsEYczgcynK5/BKKv/IXFNz/XiqVXkHdjUuRIA9SqdRD8or/R8Ez9fr9fqHVakUR4c2z0REjIQuHw2ZcrPBXLCA0RHTezEdHjIQqkUhEr9I4HOILhQLf6/VoOUFEvDMiQiToDx1Cdz+bzZ6bUFarlel0OkkVUK/XWbvdPoVer5fh3ntsfwJ+CJ2XA4p0Op1bpBgJyxDehQQ6nQ5DZXHBYDBZq9V+EhFUndnr9drEqoc2bwJbwGPgtohuVSwWe2Gz2TZMJpNgRKi6qtUqg2EWj8dTgUDgo0KhWPN4PC70EvXOzs67fD6/S6kiRIKeZA1YJ2MiJNbdbvfTUCjkV6vVK2hcDF8GI2w0GrGTkxM2HA5PDxaLxSOfz/cWEfk81X0XIMMFgJJ/srBjCgk8IdcfuVyuZ36//7nFYtkQyAMumUzuRiKRD0jMFLa+AZOpYwqgB/ziBVqmVBKUO7eAB/R0WG/Z7XaTVqtdbTabHJL6EK2djBaBPHA0NSqpbUsiMUeEBgpF4Q5AbZrmSJ/yEWgBTaBNHl9kdkgmMUeG7qwAq9PqovceTA3zlxlgsuswyuXsGsiSxJLEkoSY/BZgAEjRodi+uBruAAAAAElFTkSuQmCC) no-repeat 100% 0;

        }

        .btn-cupon:hover {
            background: #a61715;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.75), 0 0 40px #FFF;
            box-shadow:
                inset 1px 1px 0px rgba(255, 255, 255, 0.25),
                /* highlight */
                inset 0 0 6px #a23227,
                /* inner glow */
                inset 0 80px 80px -40px #a23227,
                /* gradient */
                1px 1px 3px rgba(0, 0, 0, 0.75);
            /* shadow */

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
                                <span class="text-muted font-weight-bold mr-4">Bienvenido</span>
                                <a href="<?= base_url('certificacion'); ?>" class="btn btn-light-primary font-weight-bolder btn-sm">Certificación</a>
                                <!-- Button cupón -->
                                <a class="btn-cupon" href="<?= base_url('cupon'); ?>">Obtener cupón</a>
                                <!-- End cupón -->
                                <?php if (isset($proximo_curso) && $proximo_curso != null) { ?>
                                    <a href="#proximoscursos" class="btn btn-light-primary font-weight-bolder btn-sm">Próximos cursos</a>
                                <?php } ?>
                                <!--end::Actions-->
                            </div>
                            <!--end::Info-->
                            <?php if ($this->session->userdata('id', TRUE) != null) : ?>

                                <div class="d-flex align-items-center">
                                    <a href="#" class="btn btn-primary btn-sm font-weight-bold font-size-base mr-1" data-titulo="FIPAZ" data-id="3" id="btn-fipaz">
                                        <i class="fa fa-bell"></i>
                                        FIPAZ
                                    </a>
                                    <!-- <a href="#" class="btn btn-primary btn-sm font-weight-bold font-size-base mr-1" data-titulo="EXPOCRUZ" data-id="2" id="btn-expo">
                                        <i class="fa fa-bell"></i>
                                        EXPOCRUZ
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm font-weight-bold font-size-base mr-1" data-titulo="FERIA DEL LIBRO" data-id="1" id="btn-libro">
                                        <i class="fa fa-bell"></i>
                                        FERIA DEL LIBRO
                                    </a> -->
                                </div>
                            <?php endif; ?>
                            <!--end::Toolbar-->
                        </div>
                    </div>
                    <div class="d-flex flex-column-fluid">
                        <div class="container-fluid px-lg-30">
                            <div class="alert p-3 alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                                <div class="alert-icon">
                                    <span class="svg-icon svg-icon-primary svg-icon-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <div class="alert-text">Cursos vigentes</div>
                            </div>
                            <div class="row" id="contenido_cursos"></div>

                            <?php if (isset($proximo_curso) && $proximo_curso != null) { ?>
                                <div class="alert p-3 alert-custom alert-white alert-shadow fade show gutter-b" role="alert" id="proximoscursos">
                                    <div class="alert-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-xl">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="alert-text">Próximos cursos</div>
                                </div>
                                <div class="row" id="contenido_cursos_proximos">

                                </div>
                            <?php } ?>

                            <!-- <div class="separator separator-solid separator-dark separator-border-3 mt-5"></div> -->
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-body">
                                                <iframe width="100%" height="350" src="https://www.youtube.com/embed/oSg0jT2Vr-0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-custom gutter-b">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h3 class="card-label">
                                                        Síguenos en nuestras redes sociales
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-body pt-5" height="330">
                                                <center>
                                                    <div class="fb-page" data-href="https://www.facebook.com/cursosposgradoupea" data-width="300" data-hide-cover="false" data-show-facepile="true"></div>
                                                </center>
                                                <center class="pt-3">
                                                    <div id="fb-root"></div>
                                                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v11.0" nonce="SaEqPZTT"></script>
                                                    <div class="fb-like pt-3" data-href="https://www.facebook.com/cursosposgradoupea" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="false"></div>
                                                </center>
                                                <div class="mt-2 d-flex justify-content-center">
                                                    <a class="btn btn-sm mt-2" href="https://api.whatsapp.com/send/?phone=59162332648&text=M%C3%A1s%20informaci%C3%B3n%20sobre%20:%20*Cursos%20-%20Posgrado*" style="background-color: #00e676; color: #272727; line-height: 20px !important; text-decoration: none;" target="_blank">
                                                        <span style="color: white;"> <img style="margin-bottom: 0px;" src="<?= base_url('assets/img/whatsapp.png') ?>" alt="" border="0" /> Contáctanos </span>
                                                    </a>
                                                    <a class="btn btn-sm mt-2 ml-1" href="https://api.whatsapp.com/send/?phone=59162332648&text=M%C3%A1s%20informaci%C3%B3n%20sobre%20:%20*Cursos%20-%20Posgrado*" style="background-color: #29b6f6; color: #272727; line-height: 20px !important; text-decoration: none;" target="_blank">
                                                        <span style="color: white; padding-left: 20px; padding-right: 20px;"> <img style="margin-bottom: 0px;" src="<?= base_url('assets/img/telegram1.png') ?>" alt="" border="0" /> Únite </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-footer p-5">
                                                <div class="d-flex justify-content-center">
                                                    <a class="" href="https://www.facebook.com/cursosposgradoupea" style="text-decoration: none;">
                                                        <img mc:edit="111" class="hover" src="assets/images/facebook1.png" alt="" width="20" border="0" />
                                                    </a>
                                                    <a class="ml-4" href="https://twitter.com/posgradoupea" style="text-decoration: none;">
                                                        <img mc:edit="112" class="hover" src="assets/images/twitter1.png" alt="" width="20" border="0" />
                                                    </a>
                                                    <a class="ml-4" href="https://www.instagram.com/cursosposgradoupea" style="text-decoration: none;">
                                                        <img mc:edit="113" class="hover" src="assets/images/instagram1.png" alt="" width="20" border="0" />
                                                    </a>
                                                </div>
                                                <div class="d-flex justify-content-center pt-2">
                                                    <td align="center" style="color: #555555; font-size: 14px;" width="100%" height="15">TEAM PSG</td>
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