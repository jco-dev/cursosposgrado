 <!--begin: Wizard Step 1-->
 <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

     <h4 class="mb-10 font-weight-bold text-dark">Datos Personales.</h4>

     <div class="card card-custom">
         <div class="card-body pb-0">
             <div class="form-group row">
                 <div class="col-lg-9">
                     <label for="ci"> Carnet <span class="text-danger">(*)</span></label>
                     <input type="text" class="form-control" name="ci" id="ci" placeholder="Tu respuesta" />
                 </div>
                 <div class="col-lg-3">
                     <label for="ci"> Expedido <span class="text-danger">*</span></label>
                     <select name="expedido" id="expedido" class="form-control">
                         <option value=""> Elige </option>
                         <option value="CH">CH</option>
                         <option value="LP">LP</option>
                         <option value="CB">CB</option>
                         <option value="OR">OR</option>
                         <option value="PT">PT</option>
                         <option value="TJ">TJ</option>
                         <option value="SC">SC</option>
                         <option value="BE">BE</option>
                         <option value="PD">PD</option>
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
                     <input type="radio" name="genero" id="genero" value="M" />
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
         <div class="card-body">
             <label for="fecha_nacimiento"> Fecha Nacimiento </label>
             <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" />
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
                     <input type="radio" name="modalidad_inscripcion" id="modalidad_inscripcion" value="TIGO MONEY" />
                     <span></span>Tigo Money
                 </label>
                 <label class="radio">
                     <input type="radio" name="modalidad_inscripcion" id="modalidad_inscripcion" value="DEPOSITO BANCARIO" />
                     <span></span>Depósito o transferencia bancaria
                 </label>
                 <label class="radio">
                     <input type="radio" name="modalidad_inscripcion" id="modalidad_inscripcion" value="PAGO EFECTIVO" />
                     <span></span>Pago en oficina
                 </label>
             </div>
         </div>
     </div>

     <br>
     <div class="card card-custom">
         <div class="card-body form-group pb-0">
             <label for="id_transaccion">ID de transacción(código de transación de tigo money, transación bancaria o el número recibo de su inscripción en oficina) <span class="text-danger">(*)</span></label>
             <input type="text" id="id_transaccion" name="id_transaccion" class="form-control" placeholder="Tu respuesta">
         </div>
     </div>

     <br>
     <div class="card card-custom">
         <div class="card-body form-group pb-0">
             <label for="fecha_pago">Fecha Pago <span class="text-danger">(*)</span></label>
             <input type="date" id="fecha_pago" name="fecha_pago" class="form-control">
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
             <label class="col-form-label text-lg-right">Respaldo de la transacción (Subir fotografía o captura del depósito o transacción) <span class="text-danger">(*)</span></label>
             <div class="custom-file">
                 <input type="file" class="custom-file-input" id="respaldo_transaccion" name="respaldo_transaccion" accept="image/jpeg,image/png,application/pdf" />
                 <label class="custom-file-label" for="">Añadir archivo</label>
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
                     <input type="radio" name="tipo_certificado_solicitado" id="tipo_certificado_solicitado" value="AMBOS" />
                     <span></span>Ambos
                 </label>
             </div>
         </div>
     </div>
 </div>
 <!--end: Wizard Step 3-->