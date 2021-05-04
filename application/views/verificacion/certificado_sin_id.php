<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($id)) $id = ''; ?>

<section id="region-main" class="col-12" aria-label="Contenido">
	<span class="notifications" id="user-notifications"></span>
	<div role="main"><span id="maincontent"></span>
		<div class="my-1 my-sm-5"></div>
		<div class="row justify-content-center">
			<div class="col-xl-6 col-sm-8 ">
				<div class="card">
					<div class="card-block">
						<h2 class="card-header text-center"><img src="https://plataformavirtual.upea.bo/pluginfile.php/1/core_admin/logo/0x200/1608126776/PSG.png" class="img-fluid" title="MOODLE UPEA" alt="MOODLE UPEA" /></h2>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<h2>VERIFICACIÓN DE CERTIFICADOS</h2>
									<h4>CURSOS UPEA</h4>
								</div>
							</div>
							<div class="row bg-secondary rounded">
								<div class="col-md-12 text-center">
									<form method="get" action=".">
										<div class="form-group">
											<label class="form-label" for="id">Escriba el ID del Certificado. Puede que necesite un decodificador QR.</label>
											<input type="text" class="form-control text-center" id="id" name="id" placeholder="Ej.: 76d2huh2u3hu2h3uh23ubu23bbj23bj2" maxlength="32" required>
										</div>
										<div class="form-group">
											<button class="btn btn-primary" type="submit"><i class="ki-check"></i> VERIFICAR</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

					<div class="flex-column-fluid d-flex justify-content-center">
						<center>
							<p class="font-weight-lighter opacity-80 text-justify">
								Si necesita realizar consultas acerca de este verificador de certificados, contacte al:<br>
								<a target="_blank" classaction="<?php echo base_url('login/autenticar'); ?>" method="post" id="login"="text-white font-weight-bolder" href="https://wa.me/59176267636?text=UPEA.%20POSGRADO.%20VERIFICADOR%20DE%20CERTIFICADOS.">
									76267636 Ing. Erik Cuaquira.
								</a>
							</p>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>