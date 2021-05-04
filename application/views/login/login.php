<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Login | PSG</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="assets/css/pages/login/classic/login-1.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
			<!--begin::Aside-->
			<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(assets/media/bg/bg-1.jpg);">
				<!--begin: Aside Container-->
				<div class="d-flex flex-row-fluid flex-column justify-content-between">
					<!--begin: Aside header-->
					<a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
						<img src="assets/media/logos/posgrado.png" class="max-h-70px" alt="" />
					</a>
					<!--end: Aside header-->
					<!--begin: Aside content-->
					<div class="flex-column-fluid d-flex flex-column justify-content-center">
						<h3 class="font-size-h2 mb-5 text-white">Bienvenido a PSG - SSL</h3>
						<p class="font-weight-lighter text-white opacity-80">
							Verificaci&oacute;n de certificados de cursos
						</p>

						<div class="separator separator-dashed"></div>

						<p class="font-weight-lighter text-white opacity-80 text-justify">
							Si necesita realizar consultas acerca de este verificador de certificados, contacte al:<br>
							<a target="_blank" classaction="<?php echo base_url('login/autenticar'); ?>" method="post" id="login"="text-white font-weight-bolder" href="https://wa.me/59176267636?text=UPEA.%20POSGRADO.%20VERIFICADOR%20DE%20CERTIFICADOS.">
								76267636 Ing. Erik Cuaquira.
							</a>
						</p>
					</div>
					<!--end: Aside content-->
					<!--begin: Aside footer for desktop-->
					<div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
						<div class="opacity-70 font-weight-bold text-white">© 2021 PSG - SSL</div>
						<div class="d-flex">
							<a href="https://plataformavirtual.upea.bo/" class="text-white ml-10">
								Ir a la plataforma
							</a>
						</div>
					</div>
					<!--end: Aside footer for desktop-->
				</div>
				<!--end: Aside Container-->
			</div>
			<!--begin::Aside-->
			<!--begin::Content-->
			<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
				<!--begin::Content header-->
				<div class="position-absolute top-0 right-0 text-right mt-5 mb-15 mb-lg-0 flex-column-auto justify-content-center py-5 px-10">
					<span class="font-weight-bold text-dark-50">¿Aún no tienes una cuenta?</span>
					<a href="javascript:;" class="font-weight-bold ml-2" id="kt_login_signup">Crear Cuenta</a>
				</div>
				<!--end::Content header-->
				<!--begin::Content body-->
				<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
					<!--begin::Signin-->
					<div class="login-form login-signin">
						<div class="text-center mb-10 mb-lg-20">
							<h3 class="font-size-h1">Iniciar Sesi&oacute;n</h3>
							<p class="text-muted font-weight-bold">Ingrese su nombre de usuario y contraseña</p>
						</div>
						<!--begin::Form-->
						<form class="form" novalidate="novalidate" action="<?php echo base_url('login/autenticar'); ?>" method="post" id="login">
							<div class="form-group">
								<input required class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Username" name="usuario" id="usuario" autocomplete="off" />
							</div>
							<div class="form-group">
								<input required class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
							</div>
							<!--begin::Action-->
							<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
								<a href="javascript:;" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">¿Has olvidado tu contraseña?</a>
								<button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Iniciar
									Sesi&oacute;n</button>
							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signin-->
					<!--begin::Signup-->
					<div class="login-form login-signup">
						<div class="text-center mb-10 mb-lg-20">
							<h3 class="font-size-h1">Crear Cuenta</h3>
							<p class="text-muted font-weight-bold">Ingrese sus datos para crear su cuenta</p>
						</div>
						<!--begin::Form-->
						<form class="form" novalidate="novalidate" id="kt_login_signup_form">
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
							</div>
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off" />
							</div>
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Password" name="password" autocomplete="off" />
							</div>
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
							</div>
							<div class="form-group">
								<label class="checkbox mb-0">
									<input type="checkbox" name="agree" />
									<span></span> &nbsp; Acepto
									<a href="#">&nbsp; los términos y condiciones</a></label>
							</div>
							<div class="form-group d-flex flex-wrap flex-center">
								<button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Registrarse</button>
								<button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancelar</button>
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signup-->
					<!--begin::Forgot-->
					<div class="login-form login-forgot">
						<div class="text-center mb-10 mb-lg-20">
							<h3 class="font-size-h1">¿Contraseña olvidada?</h3>
							<p class="text-muted font-weight-bold">Ingrese su correo electrónico para restablecer su
								contraseña</p>
						</div>
						<!--begin::Form-->
						<form class="form" novalidate="novalidate" id="kt_login_forgot_form">
							<div class="form-group">
								<input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off" />
							</div>
							<div class="form-group d-flex flex-wrap flex-center">
								<button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Enviar</button>
								<button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancelar</button>
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::Forgot-->
				</div>
				<!--end::Content body-->
				<!--begin::Content footer for mobile-->
				<div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
					<div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2021 PSG - SSL</div>
					<div class="d-flex order-1 order-sm-2 my-2">
						<a href="#" class="text-dark-75 text-hover-primary ml-4">Contacto</a>
					</div>
				</div>
				<!--end::Content footer for mobile-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="assets/js/pages/custom/login/login-general.js"></script>
	<!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>