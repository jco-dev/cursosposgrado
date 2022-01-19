<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Agregar Docente
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form id="frm-guardar-docente-curso" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="course">Curso <span class="text-danger">(*)</span>:</label>
                        <select name="course" id="course" class="form-control" required>
                            <option></option>
                        </select>
                        <span class="form-text text-muted">Seleccione curso</span>
                    </div>

                    <div class="col-lg-12 mt-10">
                        <label for="user">Seleccione Usuario <span class="text-danger">(*)</span>:</label>
                        <select name="user" id="user" class="form-control" required>
                            <option></option>
                        </select>
                        <span class="form-text text-muted">Seleccione usuario</span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-info btn-block">
                            <i class="fa fa-plus"></i>
                            Guardar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>