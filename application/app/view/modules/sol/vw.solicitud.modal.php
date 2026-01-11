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

    .lds-dual-ring {
        display: inline-block;
        width: 60px;
        height: 60px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 50px;
        height: 50px;
        margin: 2px;
        border-radius: 50%;
        border: 8px solid black;
        border-color: red transparent red transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

        /* Estilos para el modal */
    .modal-content {
    max-height: 100vh; /* Altura máxima del cuerpo del modal */
    overflow-y: auto; /* Habilitar desplazamiento vertical */
    }
</style>

<div id="modalAddSolicitud" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formSolicitud" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_solicitud" name="id_solicitud" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-solicitud">Solicitud</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group" id="div-subtitulo">
                        <h4 class="modal-title" id="titulo-modal-candidato">Datos del Cliente</h4>
                    </div>
                    <!-- ENTRADA PARA CLIENTE -->
                    <div class="col-xs-12 col-sm-6 center-block" id="ocultar" style="display: none;">
                        <div class="form-group">
                            <h3 class="control-label" id="cliente_descripcion">Cliente:</h3>
                            <h3 class="control-label">Responsable: <?= $_SESSION[constant('APP_NAME')]['user']['nombres'] ." ". $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></h3>

                        </div>
                    </div>

                    <!-- ENTRADA PARA CLIENTE -->
                    <div class="col-xs-12 col-sm-6 center-block" id="ocultar_empresa">
                        <div class="form-group">
                            <label for="cliente" class="control-label">Cliente: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select class="form-control input select2" id="cliente" name="cliente" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA SUB-EMPRESA -->
                    <div class="div-subempresa hide" id="ocultar_sub_empresa">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="subEmpresa" class="control-label">Sub-Empresa: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                    <select class="form-control input" id="subEmpresa" name="subEmpresa">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TERCERO -->
                    <div class="div-tercero hide">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="tercero" class="control-label">Tercero: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                    <select class="form-control input" id="tercero" name="tercero">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA USUARIO -->
                    <div class="col-xs-12 col-sm-6 center-block" id="ocultar_responsable">
                        <div class="form-group">
                            <label for="responsable" class="control-label">Responsable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                <select class="form-control input" id="responsable" name="responsable" required>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA CANAL RECEPCION -->
                    <div class="col-xs-12 col-sm-6 center-block" id="canal_rep">
                        <div class="form-group">
                            <label for="combo" class="control-label">Canal Recepción: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                <select class="form-control input" id="canal_recepcion" name="canal_recepcion" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr style="width:100%;background:#000">
                    <div class="form-group" id="div-subtitulo">
                        <h4 class="modal-title" id="titulo-modal-candidato">Servicios</h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 center-block" style="
                                padding : 4px;
                                width : 100%;
                                height : 200px;
                                overflow-y : scroll; ">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <table class="table table-bordered table-striped " width="90%">
                                <thead>
                                    <tr>
                                        <th colspan="2">Productos</th>
                                        <th colspan="2">Servicios</th>
                                    </tr>
                                </thead>
                                <tbody id="productos"> </tbody>
                            </table>
                        </div>
                    </div>

                    <hr style="width:100%;background:#000">
                    <div class="form-group" id="div-subtitulo">
                        <h4 class="modal-title" id="titulo-modal-candidato">Datos del Candidato</h4>
                    </div>

                    <!-- ENTRADA PARA TIPO DOCUMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_id" class="control-label">Tipo Doc.: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_id" name="tipo_id" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NRO DUCOMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="numero_doc" class="control-label">Nro Doc.: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="numero_doc" id="numero_doc" placeholder="Ingrese el Número del Documento" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Ingrese el Nombre del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA APELLIDO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellido: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-header"></i></span>
                                <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Ingrese el Apellido del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DEPARTAMENTO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="departamento" name="departamento" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Ciudad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="id_ciudad_act" name="id_ciudad_act" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LOCALIDAD -->
                    <div class="div-localidad hide">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="localidad" class="control-label">Localidad:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-anchor"></i></span>
                                    <input type="text" class="form-control input solo-mayuscula" name="localidad" id="localidad" placeholder="Ingrese la Localidad">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CORREO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="email" class="control-label">Correo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                <input type="text" class="form-control input" name="email" id="email" placeholder="Ingrese el Correo del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TELEFONO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Teléfono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="telefono" id="telefono" placeholder="Ingrese el Teléfono del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DIRECCION -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="direccion" id="direccion" placeholder="Ingrese la Dirección del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CARGO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_desempeno" class="control-label">Cargo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_desempeno" id="cargo_desempeno" placeholder="Ingrese el Cargo del Candidato" required>
                            </div>
                        </div>
                    </div>

                    <hr style="width:100%;background:#000">
                    <div class="form-group" id="div-subtitulo">
                        <h4 class="modal-title" id="titulo-modal-candidato">Adjunto</h4>
                    </div>

                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Descripción Archivo: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="descripcion" id="descripcion" placeholder="Ingrese una descripcion">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 center-block div-archivo">
                        <label class="control-label">Archivo : </label>
                        <span id="info" name="info"></span>
                    </div>

                    <div class="col-xs-12 col-sm-4  center-block div-archivo">
                        <label for="archivo" class="lbl-subir">
                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                            <span id="lbl-archivo">Seleccionar Archivo</span>
                        </label>
                        <input id="archivo" name="archivo" type="file" style='display: none;' accept="image/*, .pdf, .doc, .docx, .xls, .xlsx, .txt" />
                    </div>

                    <hr style="width:100%;background:#000">

                    <!-- ENTRADA PARA OBSERVACION -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="observacion" class="control-label">Observación:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                    <textarea class="form-control input" name="observacion" id="observacion" placeholder="Ingresar una Observación" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CENTRAL DE COSTOS -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="centro_costo" class="control-label">Central de Costos:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                    <textarea class="form-control input" name="centro_costo" id="centro_costo" placeholder="Ingresar una Observación" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-solicitud" type="submit" class="btn btn-primary">Guardar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>