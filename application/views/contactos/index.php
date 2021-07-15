<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Listado de Contactos
                </h3>

				<button class="btn btn-primary btn-sm" id="btn_agregar_contacto">
                    <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24"/>
							<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
							<path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
						</g>
					</svg><!--end::Svg Icon--></span>
					Agregar Contacto
				</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_contactos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Paterno</th>
                        <th>Materno</th>
                        <th>Celular</th>
						<th>Email</th>
						<th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_contacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-contacto"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="modal-body-contacto">
				<form action="" id="frm_agregar_contacto" role="form" method="post" enctype="multipart/form-data">

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="nombre">Nombres: </label>
							<input type="text" class="form-control" id="nombre" name="nombre" required/>
							<span class="form-text text-muted">Ingrese su nombre del contacto</span>
						</div>
						<div class="col-lg-6">
							<label for="paterno">Paterno: </label>
							<input type="text" class="form-control" id="paterno" name="paterno" required/>
							<span class="form-text text-muted">Ingrese su apellido paterno del contacto</span>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="materno">Materno: </label>
							<input type="text" class="form-control" id="materno" name="materno" />
							<span class="form-text text-muted">Ingrese su apellido materno del contacto</span>
						</div>
						<div class="col-lg-6">
							<label for="celular">Celular: </label>
							<input type="text" class="form-control" id="celular" name="celular" />
							<span class="form-text text-muted">Ingrese su n&uacute;mero de celular del contacto</span>
						</div>
					</div>
					<input type="hidden" id="id_contacto" name="id_contacto">

					<div class="form-group row">
						<div class="col-lg-12">
							<label for="email">Correo electr&oacute;nico: </label>
							<input type="email" name="email" id="email" class="form-control" />
							<span class="form-text text-muted">Ingrese su correo del contacto</span>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-3">
							<button type="submit" class="btn btn-info btn-block" id="btn_contacto_form">
							</button>
						</div>
					</div>

				</form>

			</div>
        </div>
    </div>
</div>
