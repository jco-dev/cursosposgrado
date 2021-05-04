<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($total_user)) $total_user = 0; ?>
<?php if (empty($total_participantes)) $total_participantes = 0; ?>
<?php if (empty($user)) $user = array(); ?>
<?php if (empty($participantes)) $participantes = array(); ?>
<style>
	div#participantes {
		font: italic 66%/2px Helvetica;
	}
	div#participantes table td{
		min-height: 66px;
		height: 66px;
		max-height: 66px;
		overflow: hidden;
	}
</style>
<div class="row">
	<div class="col-xs-12 text-center">
		<h1>Participantes</h1>
		<form method="post" action="<?php echo base_url('participantes/vincular'); ?>" id="form_vincular">
			<input type="hidden" id="id_participantes" name="id_participantes" value="">
			<input type="hidden" id="id_user" name="id_user" value="">
			<input type="submit" class="btn btn-primary" value="VINCULAR" />
		</form>
	</div>
</div>
<div class="row" id="participantes">
	<div class="col-xs-6" id="participantes1">
		<div class="panel panel-success">
			<div class="panel-heading">USERS REGISTRADOS EN LA PLATAFORMA</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed table-striped table-hover table-bordered">
						<thead>
						<tr class="bg-success">
							<th class="text-center">EMAIL</th>
							<th class="text-center">NOMBRE COMPLETO</th>
							<th class="text-center">ID</th>
							<th class="text-center">&nbsp;</th>
							<th class="text-center"><i class="fa fa-link"></i></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($user AS $u): ?>
							<tr>
								<td><?php echo $u['email']; ?></td>
								<td><?php echo $u['firstname'] . ' ' . $u['lastname']; ?></td>
								<td><?php echo $u['id']; ?></td>
								<td><?php if (!$u['vinculo']): ?><form method="post" action="<?php echo base_url('participantes/insertar'); ?>" id="form_insertar<?php echo $u['id']; ?>"><input type="hidden" name="in<?php echo $u['id']; ?>" value="<?php echo $u['id']; ?>" /><button type="submit" class="btn btn-primary"><i class="fa fa-copy"></i><i class="fa fa-arrow-right"></i></button></form><?php endif; ?></td>
								<td><?php if (!$u['vinculo']): ?><input type="radio" class="us" id="us<?php echo $u['id']; ?>" name="r-users"><?php endif; ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-6" id="participantes2">
		<div class="panel panel-success">
			<div class="panel-heading panel-primary">PARTICIPANTES REGISTRADOS PARA LA CERTIFICACIÓN</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed table-striped table-hover table-bordered">
						<thead>
						<tr class="bg-success">
							<th class="text-center"><i class="fa fa-link"></i></th>
							<th class="text-center">&nbsp;</th>
							<th class="text-center">ID</th>
							<th class="text-center">EMAIL</th>
							<th class="text-center">NOMBRE COMPLETO</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($participantes AS $p): ?>
							<tr>
								<td><?php if (!$p['id_moodle']): ?><input type="radio" class="pa" id="pa<?php echo $p['id']; ?>" name="r-participantes"><?php endif; ?></td>
								<td><?php if ($p['id_moodle']): ?><form method="post" action="<?php echo base_url('participantes/desvincular'); ?>" id="form_desvincular<?php echo $p['id']; ?>"><input type="hidden" name="de<?php echo $p['id']; ?>" value="<?php echo $p['id']; ?>" /><button type="submit" class="btn btn-danger" href="<?php echo base_url('participantes/desvincular'); ?>"><i class="fa fa-remove"></i></button></form><?php endif; ?></td>
								<td><?php echo $p['id_moodle']; ?></td>
								<td><?php echo $p['email']; ?></td>
								<td><?php echo $p['nombre'] . ' ' . $p['apellido']; ?></td>
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
			if ($("#participantes input[name='r-users']:radio").is(':checked') && $("#participantes input[name='r-participantes']:radio").is(':checked')) {
				$('#id_user').val($("#participantes input[name='r-users']:radio:checked").prop('id').substr(2));
				$('#id_participantes').val($("#participantes input[name='r-participantes']:radio:checked").prop('id').substr(2));
			} else {
				alert('Seleccione dos participantes para vincularlos.');
				return false;
			}
		});
	});
</script>
