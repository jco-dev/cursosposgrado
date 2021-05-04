<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($total_course)) $total_course = 0; ?>
<?php if (empty($total_cursos)) $total_cursos = 0; ?>
<?php if (empty($course)) $course = array(); ?>
<?php if (empty($cursos)) $cursos = array(); ?>
<style>
	div#cursos {
		font: italic 66%/2px Helvetica;
	}
	div#cursos table td{
		min-height: 66px;
		height: 66px;
		max-height: 66px;
		overflow: hidden;
	}
</style>
<div class="row">
	<div class="col-xs-12 text-center">
		<h1>Cursos</h1>
		<form method="post" action="<?php echo base_url('cursos/vincular'); ?>" id="form_vincular">
			<input type="hidden" id="id_cursos" name="id_cursos" value="">
			<input type="hidden" id="id_course" name="id_course" value="">
			<input type="submit" class="btn btn-primary" value="VINCULAR" />
		</form>
	</div>
</div>
<div class="row" id="cursos">
	<div class="col-xs-6" id="cursos1">
		<div class="panel panel-success">
			<div class="panel-heading">COURSES REGISTRADOS EN LA PLATAFORMA</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed table-striped table-hover table-bordered">
						<thead>
						<tr class="bg-success">
							<th class="text-center">SIGLA</th>
							<th class="text-center">CURSO</th>
							<th class="text-center">ID</th>
							<th class="text-center">&nbsp;</th>
							<th class="text-center"><i class="fa fa-link"></i></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($course AS $c): ?>
							<tr>
								<td><?php echo $c['fullname']; ?></td>
								<td><?php echo $c['shortname']; ?></td>
								<td><?php echo $c['id']; ?></td>
								<td><?php if (!$c['vinculo']): ?><form method="post" action="<?php echo base_url('cursos/insertar'); ?>" id="form_insertar<?php echo $c['id']; ?>"><input type="hidden" name="in<?php echo $c['id']; ?>" value="<?php echo $c['id']; ?>" /><button type="submit" class="btn btn-primary"><i class="fa fa-copy"></i><i class="fa fa-arrow-right"></i></button></form><?php endif; ?></td>
								<td><?php if (!$c['vinculo']): ?><input type="radio" class="co" id="co<?php echo $c['id']; ?>" name="r-courses"><?php endif; ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-6" id="cursos2">
		<div class="panel panel-success">
			<div class="panel-heading panel-primary">CURSOS REGISTRADOS PARA LA CERTIFICACIÓN</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed table-striped table-hover table-bordered">
						<thead>
						<tr class="bg-success">
							<th class="text-center"><i class="fa fa-link"></i></th>
							<th class="text-center">&nbsp;</th>
							<th class="text-center">ID</th>
							<th class="text-center">SIGLA</th>
							<th class="text-center">CURSO</th>
							<th class="text-center">CERT</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($cursos AS $c): ?>
							<tr>
								<td><?php if (!$c['id_moodle']): ?><input type="radio" class="cu" id="cu<?php echo $c['id']; ?>" name="r-cursos"><?php endif; ?></td>
								<td><?php if ($c['id_moodle']): ?><form method="post" action="<?php echo base_url('cursos/desvincular'); ?>" id="form_desvincular<?php echo $c['id']; ?>"><input type="hidden" name="de<?php echo $c['id']; ?>" value="<?php echo $c['id']; ?>" /><button type="submit" class="btn btn-danger" href="<?php echo base_url('cursos/desvincular'); ?>"><i class="fa fa-remove"></i></button></form><?php endif; ?></td>
								<td><?php echo $c['id_moodle']; ?></td>
								<td><?php echo $c['nombre_corto']; ?></td>
								<td><?php echo $c['nombre_curso']; ?></td>
								<td><i class="fa <?php echo (is_file(FCPATH .'img/cert/' . $c['imagen_certificado'] . '.jpg') ? 'fa-check' : 'fa-remove'); ?>"></i></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#form_vincular').submit(function(){
			if ($("#cursos input[name='r-courses']:radio").is(':checked') && $("#cursos input[name='r-cursos']:radio").is(':checked')) {
				$('#id_course').val($("#cursos input[name='r-courses']:radio:checked").prop('id').substr(2));
				$('#id_cursos').val($("#cursos input[name='r-cursos']:radio:checked").prop('id').substr(2));
			} else {
				alert('Seleccione dos cursos para vincularlos.');
				return false;
			}
		});
	});
</script>
