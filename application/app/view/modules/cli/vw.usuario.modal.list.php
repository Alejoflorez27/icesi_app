<div id="modalVwUsuarios" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVwUsuarios" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                <input type="hidden" id="id_empresa_vw_usuarios" name="id_empresa_vw_usuarios" value="">
                <!-- <input type="hidden" id="id_tercero" name="id_tercero" value=""> -->

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-vwusuarios">Datos Usuarios</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <table id="tbl-usuarios" class="table table-bordered table-striped dt-responsive  collapsed tablas" width="100%">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Perfil </th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Tipo Doc. </th>  
                                    <th>No. Doc. </th>
                                    <th>Correo</th>
                                    <th>Empresa</th>
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