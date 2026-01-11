<div id="modalVwSubemp" class="modal fade" role="dialog"> 

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVwSubemp" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                <input type="hidden" id="id_empresa_vw_subemp" name="id_empresa_vw_subemp" value="">
                <!-- <input type="hidden" id="id_tercero" name="id_tercero" value=""> -->

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-vwsubemp">Datos Subempresas</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <table id="tbl-subemp" class="table table-striped dt-responsive tablas  table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Razon Social </th>
                                    <th>Identificación </th>
                                    <th>Representante </th>
                                    <th>Correo </th>
                                    <th>Ciudad </th>
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