<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<section id="region-main" class="col-12" aria-label="Contenido">
	<span class="notifications" id="user-notifications"></span>
	<div role="main">
		<span id="maincontent"></span>
		<div class="my-1 my-sm-5"></div>
		<div class="row justify-content-center">
			<div class="col-xl-6 col-sm-8">
				<div class="card">
					<div class="card-block">
						<h2 class="card-header text-center">
							<img
								src="https://plataformavirtual.upea.bo/pluginfile.php/1/core_admin/logo/0x200/1608126776/PSG.png"
								class="img-fluid"
								title="MOODLE UPEA"
								alt="MOODLE UPEA"
							/>
						</h2>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<h2>VERIFICACIÓN DE INSCRIPCIÓN</h2>
									<h4>CURSOS POSGRADO - UPEA</h4>
								</div>
							</div>
							<div class="row bg-success text-white rounded">
								<div class="col-md-12 text-center">
									<label class="font-italic"> Participante:</label>
									<h6 class="font-weight-bold">
										<i class="fa fa-user"></i>
										<?php echo $participante->participante; ?>
									</h6>

									<h6 class="font-weight-bold">
										<i class="fa fa-check"></i> Inscrito correctamente
										al curso: <br />
										<?php
										echo mb_convert_case(preg_replace('/\s+/', ' ', $participante->fullname),
										MB_CASE_UPPER); ?>
									</h6>
									<h6 class="font-weight-bold">
										<i class="fa fa-calendar"></i> Que se realizará a partir de la fecha: <br />
										<?= $participante->fecha_inicial?> hasta <?= $participante->fecha_final?>
									</h6>
									<h6 class="font-weight-bold">
										<i class="fa fa-archive"></i> Con una cargar horaria de: <br />
										<?= $participante->carga_horaria?> horas académicas
									</h6>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
									<div class="mt-3">
										ID utilizado para la verificación de inscripción:<br />
										<h5>
											<code class="text-dark"
												><?php echo $id_inscripcion; ?></code
											>
										</h5>
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
