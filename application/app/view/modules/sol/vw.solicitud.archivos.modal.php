<style>
    .lbl-subir {
        padding: 5px 10px;
        background: #f39c12;
        color: #fff;
        border: 0px solid #fff;
    }

    .lbl-subir:hover {
        color: #fff;
        background: #00a65a;
    }
</style>

<div id="modalCargarArchivo" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cargar Archivo</h4>
            </div>


            <div class="modal-body">

                <div class="box-body">
                    <form id="frmCargarArchivo" role="form" method="post" enctype="multipart/form-data">

                        <input type="hidden" id="api-recurso">
                        <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?=  $_GET['id_solicitud'] ?>">
                        <input type="hidden" name="servicio_archivo" id="servicio_archivo">
                        <input type="hidden" name="tipo-archivo" id="tipo-archivo" value="archivo">

                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="observaciones" class="control-label">Descripción Archivo: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                    <input type="text" class="form-control input solo-mayuscula" name="observacion" id="observacion" placeholder="Ingrese una descripcion">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 center-block div-archivo">
                            <label class="control-label">Archivo : </label>
                            <span id="info"></span>
                        </div>


                        <div class="col-xs-12 col-sm-12  center-block div-archivo">
                            <label for="archivo" class="lbl-subir">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span id="lbl-archivo">Seleccionar Archivo</span>
                            </label>
                            <input id="archivo" name="archivo" type="file" style='display: none;' accept="image/*, .pdf, .doc, .docx, .xls, .xlsx, .txt" />
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button id="btnCargarArchivo" type="button" class="btn btn-primary pull-right">Cargar Archivo</button>
            </div>

        </div>
    </div>

</div>