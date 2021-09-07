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
						<h2 class="card-header text-center"><img src="https://plataformavirtual.upea.bo/pluginfile.php/1/core_admin/logo/0x200/1608126776/PSG.png" class="img-fluid" title="MOODLE UPEA" alt="MOODLE UPEA"/></h2>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<h2>VERIFICACIÓN DE INSCRIPCIÓN</h2>
									<h4>CURSOS POSGRADO UPEA</h4>
								</div>
							</div>
							<div class="row bg-danger rounded text-white">
								<div class="col-md-12 text-center">
									<h6 class="font-weight-bold"><i class="fa fa-close"></i> VERIFICACI&Oacute;N INCORRECTA</h6>
									<h6 class="font-weight-bold"><i class="fa fa-warning"></i> El ID ingresado para verificar la inscripción es incorrecto.</h6>
									<label class="font-italic"><i class="fa fa-info-circle"></i> Verifique que el código QR de la boleta no tenga enmiendas ni raspaduras.</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="mt-3">
										ID utilizado para la verificación:<br/>
										<h5><code class="text-dark"><?php echo $id_inscripcion; ?></code></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
