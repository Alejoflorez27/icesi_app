<div id="modalVwTerceros" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVwTerceros" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                <input type="hidden" id="id_empresa_vw_tercero" name="id_empresa_vw_tercero" value="">
                <input type="hidden" id="id_tercero" name="id_tercero" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-vwterceros">Datos Tercero</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <table id="tbl-terceros" class="table table-condensed dt-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>Nombre Tercero</th>
                                    <th>Estado</th>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-terceros" type="submit" class="btn btn-primary">Guardar Tercero</button> -->
                </div>
            </form>
        </div>
    </div>
</div>