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
						<h2 class="card-header text-center"><img src="https://plataformavirtual.upea.bo/pluginfile.php/1/core_admin/logo/0x200/1608126776/PSG.png" class="img-fluid" title="MOODLE UPEA" alt="MOODLE UPEA" /></h2>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<h2>VERIFICACIÓN DE CERTIFICADOS</h2>
									<h4>CURSOS POSGRADO - UPEA</h4>
								</div>
							</div>
							<div class="row bg-success text-white rounded">
								<div class="col-md-12 text-center">
									<label class="font-italic">Este certificado está emitido a:</label>
									<h6 class="font-weight-bold"><i class="fa fa-user"></i> <?php echo $certificado['firstname'] . ' ' . $certificado['lastname']; ?></h6>
									<label class="font-italic">
										<?php if ($certificado['tipo_participacion'] == "EXPOSITOR") {
											echo 'Por haber participado en calidad de <strong>EXPOSITOR</strong> del curso: ';
										} elseif ($certificado['tipo_participacion'] == "ORGANIZADOR") {
											echo 'Por haber participado en calidad de <strong>ORGANIZADOR</strong> del curso: ';
										} else {
											$nota_aprobacion = 65;
											if (isset($certificado['nota_aprobacion']) && intval($certificado['nota_aprobacion']) > 0) {
												$nota_aprobacion = intval($certificado['nota_aprobacion']);
											}

											if (intval($certificado['calificacion_final']) >= $nota_aprobacion) {
												echo 'Por haber <strong>APROBADO SATISFACTORIAMENTE</strong> el curso: ';
											} else {
												echo 'Por haber PARTICIPADO del curso: ';
											}
										} ?>
									</label>
									<h6 class="font-weight-bold"><i class="fa fa-graduation-cap"></i>
										<?= mb_convert_case(preg_replace('/\s+/', ' ', $certificado['fullname']), MB_CASE_UPPER) ?>
									</h6>
									<?php if (intval($certificado['calificacion_final']) >= $nota_aprobacion) { ?>
										<label class="font-italic">
											Nota Final:
										</label>
										<h6 class="font-weight-bold text-success" style="background: white; ">
											<strong><?= $certificado['calificacion_final'] ?></strong>
										</h6>
									<?php } ?>

									<?php
									if ($certificado['fecha_inicial'] != "0000-00-00") { ?>
										<label class="font-italic">Realizado en fecha:</label>
										<h6 class="font-weight-bold"><i class="fa fa-calendar"></i>
											<?= strtolower(fecha_literal($certificado['fecha_certificacion'], 1)) ?>
										</h6>
									<?php } else { ?>
										<label class="font-italic">Realizado en fecha:</label>
										<h6 class="font-weight-bold"><i class="fa fa-calendar"></i>
											<?= strtolower(fecha_literal($certificado['fecha_registro'], 1)) ?>
										</h6>
									<?php } ?>

								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="mt-3">
										ID utilizado para la verificación:<br />
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