<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($total_course)) $total_course = 0; ?>
<?php if (empty($total_cursos)) $total_cursos = 0; ?>
<?php if (empty($total_user)) $total_user = 0; ?>
<?php if (empty($total_participantes)) $total_participantes = 0; ?>
<div class="container-fluid">
	<div class="row">

		<div class="col-lg-12">
			<div class="h3">Panel Principal</div>
		</div>

		<div class="col-xl-4">
			<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
				<div class="card-body">
					<span class="svg-icon svg-icon-primary svg-icon-2x">
						<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Selected-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M4.85714286,1 L11.7364114,1 C12.0910962,1 12.4343066,1.12568431 12.7051108,1.35473959 L17.4686994,5.3839416 C17.8056532,5.66894833 18,6.08787823 18,6.52920201 L18,19.0833333 C18,20.8738751 17.9795521,21 16.1428571,21 L4.85714286,21 C3.02044787,21 3,20.8738751 3,19.0833333 L3,2.91666667 C3,1.12612489 3.02044787,1 4.85714286,1 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M6.85714286,3 L14.7364114,3 C15.0910962,3 15.4343066,3.12568431 15.7051108,3.35473959 L20.4686994,7.3839416 C20.8056532,7.66894833 21,8.08787823 21,8.52920201 L21,21.0833333 C21,22.8738751 20.9795521,23 19.1428571,23 L6.85714286,23 C5.02044787,23 5,22.8738751 5,21.0833333 L5,4.91666667 C5,3.12612489 5.02044787,3 6.85714286,3 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?php echo $total_course; ?></span>
					<span class="font-weight-bold text-muted font-size-sm">Cursos Registrados</span><br>
					<span class="font-weight-bold text-muted font-size-sm"><?php echo $total_cursos; ?> cursos son utilizados para la generación de certificados.</span><br>
					<a class="btn btn-light-primary font-weight-bold mr-2 btn-sm" href="<?php echo base_url('cursos/ver_cursos'); ?>"><i class="fa fa-pencil-square"></i> Ver los Cursos</a>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
				<div class="card-body">
					<span class="svg-icon svg-icon-2x svg-icon-primary">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
					</span>
					<span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?php echo $total_user; ?></span>
					<span class="font-weight-bold text-muted font-size-sm">Usuarios Registrados</span><br>
					<span class="font-weight-bold text-muted font-size-sm"><?php echo $total_participantes; ?> usuarios son incluidos en la generación de certificados.</span>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
				<div class="card-body">
					<span class="svg-icon svg-icon-primary svg-icon-2x">
						<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) " />
								<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
					<span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">0</span>
					<span class="font-weight-bold text-muted font-size-sm">Calificaciones</span>
				</div>
			</div>
		</div>

		<!--begin::Advance Table Widget 4-->
		<div class="col-xl-12">
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 py-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label font-weight-bolder text-dark">Listado de estudiantes que más cursos han pasado</span>
						<span class="text-muted mt-3 font-weight-bold font-size-sm">Más de <?php echo $total_user; ?> estudiantes registrados</span>
					</h3>
					<div class="card-toolbar">
						<a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">Nuevos Reportes</a>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body pt-0 pb-3">
					<div class="tab-content">
						<!--begin::Table-->
						<div class="table-responsive">
							<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
								<thead>
									<tr class="text-left text-uppercase">
										<th style="min-width: 250px" class="pl-7">
											<span class="text-dark-75">Estudiante</span>
										</th>
										<th style="min-width: 100px">Cantidad</th>
										<th style="min-width: 100px">Tipo Participación</th>
										<!-- <th style="min-width: 80px">Acciones</th> -->
									</tr>
								</thead>
								<tbody>
									<?php
										if($estudiantes != null){
											foreach($estudiantes as $est){
												echo '<tr>
													<td class="pl-0 py-8">
														<div class="d-flex align-items-center">
															<div class="symbol symbol-50 symbol-light mr-4">
																<span class="symbol-label">
																	<img src="assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt="" />
																</span>
															</div>
															<div>
																<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">'.$est->usuario.'</a>
															</div>
														</div>
													</td>
													<td>
														<span class="text-dark-75 font-weight-bolder d-block font-size-lg">'.$est->cantidad.'</span>
													</td>
													<td>
														<span class="text-dark-75 font-weight-bolder d-block font-size-lg">PARTICIPANTE</span>
													</td>
												</tr>';
											}
										}
										// <span class="text-muted font-weight-bold d-block">HTML, JS, ReactJS</span>
									?>
								</tbody>
							</table>
						</div>
						<!--end::Table-->
					</div>
				</div>
				<!--end::Body-->
			</div>
		</div>
		<!--end::Advance Table Widget 4-->


	</div>
</div>