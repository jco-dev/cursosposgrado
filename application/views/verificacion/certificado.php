<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($certificado)) $certificado = array(); ?>
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
									<h2>VERIFICACIÓN DE CERTIFICADOS</h2>
									<h4>CURSOS UPEA</h4>
								</div>
							</div>
							<div class="row bg-success text-white rounded">
								<div class="col-md-12 text-center">
									<label class="font-italic">Este certificado está emitido a:</label>
									<h6 class="font-weight-bold"><i class="fa fa-user"></i> <?php echo $certificado['nombre'] . ' ' . $certificado['apellido']; ?></h6>
									<label class="font-italic">Por su <label class="font-weight-bold"><?php echo($certificado['participacion_aprobacion'] === 'A' ? 'APROBACIÓN' : 'PARTICIPACIÓN'); ?></label> en el curso:</label>
									<h6 class="font-weight-bold"><i class="fa fa-graduation-cap"></i> <?php echo $certificado['nombre_curso']; ?></h6>
									<label class="font-italic">Realizado en fecha:</label>
									<h6 class="font-weight-bold"><i class="fa fa-calendar"></i> <?php echo fecha_literal($certificado['fecha_certificacion'], 1); ?></h6>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="mt-3">
										ID utilizado para la verificación:<br/>
										<h5><code class="text-dark"><?php echo $id; ?></code></h5>
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
