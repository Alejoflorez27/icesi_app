<!-- Modal para ver servicios -->
<div class="modal fade" id="modalServicios" tabindex="-1" role="dialog" aria-labelledby="modalServiciosLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-titulo-solicitud">Servicios de la Solicitud</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> 
                    Servicios seleccionados: <strong id="contador-servicios">0</strong>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tabla-servicios-modal">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all-servicios"> Todos
                                </th>
                                <th>Servicio</th>
                                <th>Estado Proceso</th>
                                <th>Usuario Proveedor</th>
                                <th>Usuario Calidad</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los servicios se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnAsignarDesdeModal">
                    <i class="fa fa-check"></i> Asignar Servicios Seleccionados
                </button>
            </div>
        </div>
    </div>
</div>