<div id="modalAddTerceros" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTerceros" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_empresaTercero" name="id_empresaTercero" value="">
                <input type="hidden" id="id_tercero" name="id_tercero" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-terceros">Datos Tercero</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA EL NOMBRE DEL TERCERO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nom_tercero" class="control-label">Nombre Tercero: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nom_tercero" id="nom_tercero" placeholder="Ingrese el nombre del Tercero">
                            </div>
                        </div>
                    </div>
                    

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-terceros" type="submit" class="btn btn-primary">Guardar Tercero</button>
                </div>
            </form>
        </div>
    </div>
</div>