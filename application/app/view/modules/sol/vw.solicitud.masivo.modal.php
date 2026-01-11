<?php require_once 'common.solicitud.php'; ?>

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

<div id="modalCargarArchivoMasivo" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Cargar Archivo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <div class="modal-body">

                    <form id="frmCargarArchivoMasivo" role="form" method="post" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="cliente" class="control-label">Cliente:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                <select name="cliente" id="idCliente" class="form-control select2">
                                    <?php /*foreach ($clientes_enrol as $cli) : ?>
                                        <option value="<?= $cli['id'] ?>"><?= ($cli['cliente_padre'] ? $cli['consorcio_desc'] . ' - ' : '') . $cli['nombre_completo'] ?></option>*/
                                    //<?php /*endforeach; */?>
                                </select>
                            </div>
                        </div>

                    <!-- ENTRADA PARA SUB-EMPRESA -->
                    <!--       <div class="div-subempresa">      -->
                    <div class="form-group" id="div-subempresa">
                        <label for="subEmpresa" class="control-label">Sub-Empresa: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select id="subEmpresa" name="subEmpresa" class="form-control select2">
                                </select>
                            </div>
                    </div>       
            

            
          
                <!-- ENTRADA PARA TERCERO -->
                <!--    <div class="div-tercero">   -->
                        <div class="form-group" id="div-tercero">
                            <label for="tercero" class="control-label">Tercero: </label>    
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                <select id="id_tercero" name="id_tercero" class="form-control select2">
                                </select>
                            </div>
                        </div>
                <!--     </div>    -->
               

                    <!-- ENTRADA PARA USUARIO -->
                    <div class="form-group">
                        <label for="responsable" class="control-label">usuario Cliente: *</label>
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                <select class="form-control select2" id="responsable" name="responsable" required>
                                </select>
                        </div>
                    </div>


                        <div class="form-group">
                            <label class="control-label">Archivo : </label>
                            <span id="info"></span>
                        </div>

                        <div class="form-group">
                            <label for="cargue" class="lbl-subir">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span id="lbl-archivo">Seleccionar Archivo</span>
                            </label>
                            <input id="cargue" name="cargue" type="file" style='display: none;' accept=".csv" />
                        </div>

                        <div class="box-header with-border ">
                        <a href="<?= constant('APP_URL') ?>upload/template/plantilla.xlsx" download="plantilla.xlsx">
                                Descargar Plantilla Carga de Solicitudes
                            </a>
                        </div>
                    </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button id="btnCargarArchivoMasivo" type="button" class="btn btn-primary pull-right">Cargar Archivo</button>
            </div>
        </div>
    </div>
</div>