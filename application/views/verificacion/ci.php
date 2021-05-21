<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom example example-compact">
        <div class="card-header">
            <h3 class="card-title">Verificaci&oacute;n cursos por CI</h3>
        </div>
        <!--begin::Form-->
        <form class="form" id="verificar_cursos_por_ci">
            <div class="card-body p-5">
                <div class="form-group">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-icon">
                            <span class="svg-icon svg-icon-primary svg-icon-xl">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Info-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                        <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                        <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <div class="alert-text">Ingrese su ci del usuario para verificar que cursos pas&oacute; el usuario.</div>
                    </div>
                </div>
                <div class="form-group">
                    <label>CI</label>
                    <div class="input-icon input-icon-right">
                        <input type="text" id="ci" name="ci" class="form-control" placeholder="Ingrese CI..." />
                        <span>
                            <i class="flaticon2-search-1 icon-md"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Verificar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
            </div>

        </form>
        <!--end::Form-->

        <div class="card-footer">
            <div class="container">
                <div id="cursos_listado">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Nick</td>
                                <td>Stone</td>
                                <td>
                                    <span class="label label-inline label-light-primary font-weight-bold">
                                        Pending
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Ana</td>
                                <td>Jacobs</td>
                                <td>
                                    <span class="label label-inline label-light-success font-weight-bold">
                                        Approved
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
</div>