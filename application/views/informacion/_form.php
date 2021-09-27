 <!--begin: Wizard Step 1-->
 <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

     <h4 class="mb-10 font-weight-bold text-dark">Ingrese sus datos.</h4>
     <div class="card card-custom">
         <div class="card-body form-group pb-0">

             <label for="celular"> Número de celular (con WhatsApp) <span class="text-danger">(*)</span></label>
             <div class="input-group">
                 <input type="text" class="form-control" minlength="8" maxlength="8" name="celular" id="celular" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="Tu respuesta" />
             </div>
         </div>
     </div>

     <br>
     <div class="card card-custom">
         <div class="card-body form-group pb-0">
             <label for="nombre"> Nombre(s) <span class="text-danger">(*)</span></label>
             <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu respuesta" />
         </div>
     </div>

 </div>
 <!--end: Wizard Step 1-->