<div id="modalListResumen" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Resumen de Servicios</h4>
            </div>

            <div class="modal-body">
            

                <div class="box-body">

                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>Solicitud:</td>
                            <th id="resumen-solicitud"></th>
                        </tr>
                        <tr>
                            <td>Fecha Solicitud:</td>
                            <td id="resumen-fecha"></td>
                        </tr>
                        <tr>
                            <td>Cliente:</td>
                            <th id="resumen-cliente"></th>
                        </tr>
                        <tr>
                            <td>Nombre Candidato:</td>
                            <td id="resumen-candidato"></td>
                        </tr>
                    </table>
                    <br>

                    <table id="resumen-servicios" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th colspan="12" style="text-align: center; background-color: #d2d6de;">SERVICIOS</th>
                            </tr>
                            <tr>
                                <th>Id</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th>Observación</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

            <div class="modal-footer  ">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button id="btn-resumen-ir-solicitud" type="button" class="btn btn-primary btnDetalleSolicitud" solicitud="" cliente="" >Ver más detalles</button>
            </div>

        </div>
    </div>
</div>