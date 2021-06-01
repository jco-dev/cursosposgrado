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
                         <option value="CH">CH</option>
                         <option value="LP" selected>LP</option>
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
         <div class="card-body form-group pb-0">
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

     <br>
     <div class="card card-custom">
         <div class="card-body form-group pb-0">
             <label for="profesion_oficio"> Profesi&oacute;n u Ocupaci&oacute;n </label> <br>
             <select name="profesion_oficio" id="profesion_oficio" class="form-control">
                 <option value=""> Elige </option>
                 <?php
                    foreach ($profesiones_ocupaciones as $key => $value) {
                        echo "<option value='" . $value->id_profesion_oficio . "'>" . $value->descripcion . "</option>";
                    }
                    ?>
             </select>
         </div>
     </div>


 </div>
 <!--end: Wizard Step 1-->

 <!--begin: Wizard Step 4-->
 <div class="pb-5" data-wizard-type="step-content">
     <div class="card card-custom">
         <div class="card-header bg-info-o-5 border-0">
             <div class="card-title p-3" id="card-title-inscripcion">
                 <h3 class="card-label">Completado. Revise sus datos antes de enviar</h3>
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

                     <li class="list-group-item">
                         <strong>Profesi&oacute;n u Oficio: &nbsp;</strong>
                         <span id="m_profesion_oficio"></span>
                     </li>

                 </ul>
             </div>
             <!--end::Body-->
         </div>
     </div>
 </div>
 <!--end: Wizard Step 4-->