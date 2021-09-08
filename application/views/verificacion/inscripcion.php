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
								src="<?= base_url('assets/img/img_send_certificate/psg-sin-fondo.png')?>"
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
									<hr>

									<label class="font-italic">
											Inscrito correctamente al curso:
									</label>
									<h5 class="font-weight-bold">
										<i class="fa fa-check"></i> 
										<?= mb_convert_case(preg_replace('/\s+/', ' ', $participante->fullname), MB_CASE_UPPER); ?>
									</h5>
									<hr>

									<label class="font-italic">
										Que se realizará a partir de la fecha:
									</label>
									<h6 class="font-weight-bold">
										<i class="fa fa-calendar"></i>
										<?= date("d-m-Y", strtotime($participante->fecha_inicial)) ?> hasta <?= date("d-m-Y", strtotime($participante->fecha_final)) ?>
									</h6>
									<hr>
									<label class="font-italic">
										Con una carga horaria de:
									</label>
									<h6 class="font-weight-bold">
									<i class="fa fa-archive"></i>
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
