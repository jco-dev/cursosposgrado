<!--begin: Wizard Step 1-->
<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

    <h4 class="mb-10 font-weight-bold text-dark">Datos Personales.</h4>

    <div class="card card-custom">
        <div class="card-body pb-0">
            <div class="form-group row">
                <div class="col-lg-9">
                    <label for="ci"> N&uacute;mero C.I. <span class="text-danger">(*)</span></label>
                    <input type="text" class="form-control" name="ci" id="ci" placeholder="Tu respuesta" />
                </div>
                <div class="col-lg-3">
                    <label for="ci"> Expedido <span class="text-danger">*</span></label>
                    <select name="expedido" id="expedido" class="form-control">
                        <option value=""> Elige </option>
                        <option value="QR"> Nueva cédula con código QR </option>
                        <option value="CH">Chuquisaca</option>
                        <option value="LP" selected>La Paz</option>
                        <option value="CB">Cochabamba</option>
                        <option value="OR">Oruro</option>
                        <option value="PT">Potosí</option>
                        <option value="TJ">Tarija</option>
                        <option value="SC">Santa Cruz</option>
                        <option value="BE">Beni</option>
                        <option value="PD">Pando</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class=" card card-custom">
        <div class="card-body form-group pb-0">
            <label for="correo"> Dirección de correo electrónico <span class="text-danger">(*)</span></label>
            <input type="email" class="form-control" name="correo" id="correo" placeholder="Tu direccion de correo electronico" />
        </div>
    </div>


    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="nombre"> Nombre(s) <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu respuesta" />
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="paterno"> Apellido Paterno </label>
            <input type="text" class="form-control" name="paterno" id="paterno" placeholder="Tu respuesta" />
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="materno"> Apellido Materno </label>
            <input type="text" class="form-control" name="materno" id="materno" placeholder="Tu respuesta" />
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body">
            <label for="materno"> Género </label>
            <div class="radio-list">
                <label class="radio">
                    <input type="radio" name="genero" id="genero" value="M" checked />
                    <span></span>Masculino
                </label>
                <label class="radio">
                    <input type="radio" name="genero" id="genero" value="F" />
                    <span></span>Femenino
                </label>
            </div>
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group row pb-0" id="fecha2">
            <div class="col-lg-12">
                <label for="celular"> Fecha de Nacimiento <span class="text-danger">(*)</span></label>
            </div>
            <div class="form-group col-lg-2 col-sm-12 col-md-2">
                <select name="anio2" id="anio2" style="width: 100%;">
                    <option value=""></option>
                    <?php
                    $anio = intval(date('Y')) - 10;
                    for ($i = 0; $i < 100; $i++) {
                        echo "<option value=" . $anio . ">" . $anio . "</option>";
                        $anio--;
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3 col-sm-12 col-md-3">
                <select name="mes2" id="mes2" style="width: 100%;">
                    <option value=""></option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="form-group col-lg-2 col-sm-12 col-md-2">
                <select name="dia2" id="dia2" style="width: 100%;">
                    <option value=""></option>
                </select>
            </div>
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="celular"> Número de celular (con WhatsApp) <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control" name="celular" id="celular" placeholder="Tu respuesta" />
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="ciudad_residencia"> Ciudad de residencia <span class="text-danger">(*)</span></label> <br>
            <select name="ciudad_residencia" id="ciudad_residencia" class="form-control">
                <option value=""> Elige </option>
                <?php
                foreach ($municipios as $key => $municipio) {
                    echo "<option value='" . $municipio->id_municipio . "'>" . $municipio->nombre_departamento . " - " . $municipio->nombre_municipio . "</option>";
                }
                ?>
            </select>
        </div>
    </div>


</div>
<!--end: Wizard Step 1-->
<!--begin: Wizard Step 2-->
<div class="pb-5" data-wizard-type="step-content">
    <h4 class="mb-10 font-weight-bold text-dark">Pago del Curso</h4>

    <div class="card card-custom">
        <div class="card-body pb-0">
            <label for="modalidad_inscripcion"> Modalidad de Inscripci&oacute;n <span class="text-danger">(*)</span></label>
            <div class="radio-list form-group">
                <label class="radio">
                    <input type="radio" name="modalidad_inscripcion_local" id="modalidad_inscripcion_local" value="TIGO MONEY" />
                    <span></span>Tigo Money
                </label>
                <label class="radio">
                    <input type="radio" name="modalidad_inscripcion_local" id="modalidad_inscripcion_local" value="DEPOSITO BANCARIO" />
                    <span></span>Depósito o transferencia bancaria
                </label>
                <label class="radio">
                    <input type="radio" name="modalidad_inscripcion_local" id="modalidad_inscripcion_local" value="PAGO EN OFICINA" />
                    <span></span>Pago en oficina
                </label>
            </div>
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="id_transaccion">ID de transacción(código de transación de tigo money, transación bancaria o el número recibo de su inscripción en oficina) <span class="text-danger">(*)</span></label>
            <input type="text" id="id_transaccion1" name="id_transaccion1" class="form-control" placeholder="Tu respuesta">
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="fecha_pago">Fecha Pago <span class="text-danger">(*)</span></label>
            <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" value="<?= date("Y-m-d") ?>" />
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="monto_pago">Monto Pago <span class="text-danger">(*)</span></label>
            <input type="number" id="monto_pago" name="monto_pago" class="form-control">
        </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label class="col-form-label text-lg-right">Respaldo de la transacción (Subir fotografía o captura del depósito o transacción) </label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="respaldo_transaccion" name="respaldo_transaccion" accept="image/jpeg,image/png" />
                <label class="custom-file-label" for="">Añadir archivo</label>
            </div>
            <div class="d-flex justify-content-center mt-3">

                <div class="container d-none text-center">
                    <div id="galley">
                        <ul class="pictures">
                            <li>
                                <img class="img img-thumbnail" data-original="<?= base_url('assets/img/default.jpg') ?>" src="" id="img-preview" />
                                <i class="fa fa-eye text-info"></i>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!--end: Wizard Step 2-->
<!--begin: Wizard Step 3-->
<div class="pb-5" data-wizard-type="step-content">
    <div class="card card-custom">
        <div class="card-header border-0 bg-info">
            <div class="card-title">
                <h3 class="card-label text-white">Recojo o envío de certificado</h3>
            </div>
        </div>
        <div class="card-body text-justify">Describa a continuación la forma de recojo de su certificado (Nota: Para acceder al certificado de aprobación será necesario obtener una nota mínima de 66 puntos) Para el envío de su certificado puede ser por flota o Currier con costo adicional dependiendo de la ciudad que reside </div>
    </div>

    <br>
    <div class="card card-custom">
        <div class="card-body form-group pb-0">
            <label for="tipo_certificado_solicitado">Solicite el tipo de certificado <span class="text-danger">(*)</span></label>
            <div class="radio-list form-group" id="error-certificado">
                <label class="radio">
                    <input type="radio" name="tipo_certificado_solicitado" id="tipo_certificado_solicitado" value="DIGITAL" />
                    <span></span>Digital
                </label>
                <label class="radio">
                    <input type="radio" name="tipo_certificado_solicitado" id="tipo_certificado_solicitado" value="FISICO" />
                    <span></span>F&iacute;sico
                </label>
                <label class="radio">
                    <input type="radio" checked name="tipo_certificado_solicitado" id="tipo_certificado_solicitado" value="AMBOS" />
                    <span></span>Ambos
                </label>
            </div>
        </div>
    </div>
</div>
<!--end: Wizard Step 3-->

<!--begin: Wizard Step 4-->
<div class="pb-5" data-wizard-type="step-content">
    <div class="card card-custom">
        <div class="card-header bg-info-o-5 border-0">
            <div class="card-title p-3" id="card-title-inscripcion">
                <h3 class="card-label">Revise sus datos antes de enviar</h3>
            </div>
            <!--begin::Body-->
            <div class="card-body">

                <ul class="list-group">
                    <li class="list-group-item active"><strong>1. DATOS PERSONALES</strong></li>
                    <li class="list-group-item">
                        <strong>Carnet de Identidad:&nbsp;</strong> <span id="m_ci"></span> <span id="m_expedido"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Correo:&nbsp;</strong>
                        <span id="m_correo"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Nombres:&nbsp;</strong> <span id="m_nombre"></span> <span id="m_paterno"></span> <span id="m_materno"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>G&eacute;nero: &nbsp;</strong>
                        <span id="m_genero">M</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Fecha Nacimiento (YYYY-MM-DD): </strong>
                        <span id="m_fecha_nacimiento"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>N&uacute;mero celular: &nbsp;</strong>
                        <span id="m_celular"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Ciudad residencia: &nbsp;</strong>
                        <span id="m_ciudad_residencia"></span>
                    </li>
                    <li class="list-group-item active">
                        <storng>2. PAGO DEL CURSO</storng>
                    </li>
                    <li class="list-group-item">
                        <strong>Modalidad Inscripci&oacute;n:</strong>&nbsp;
                        <span id="m_modalidad_inscripcion"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Id Transacci&oacute;n:</strong>&nbsp;
                        <span id="m_id_transaccion2"></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Fecha Pago: &nbsp;</strong>
                        <span id="m_fecha_pago"><?= date("Y-m-d") ?></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Monto Pago:&nbsp;</strong>
                        <span id="m_monto_pago"></span>
                    </li>
                    <li class="list-group-item active"><strong>3. RECOJO DEL CERTIFICADO</strong></li>
                    <li class="list-group-item">
                        <strong>Tipo certificado solicitado:</strong>
                        <span id="m_tipo_certificado_solicitado">Ambos</span>
                    </li>
                </ul>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
<!--end: Wizard Step 4-->