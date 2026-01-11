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
<div id="modalAddSubemp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formSubemp" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accionSub" name="accionSub" value="">
                <input type="hidden" id="id_empresaSubemp" name="id_empresaSubemp" value="">
                <!-- <input type="hidden" id="id_tercero" name="id_tercero" value=""> -->

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-subemp">Datos Subempresas</h4>
                </div>

            <div class="modal-body">

                <div class="row">
                    <!-- ENTRADA PARA RAZON SOCIAL SUBEMPRESA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="sube_razon_social" class="control-label">Nombre Subempresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="sube_razon_social" id="sube_razon_social" placeholder="Ingrese el nombre de la subempresa">
                            </div>
                        </div>
                    </div>
                    
                    <!-- ENTRADA PARA NOMBRE REPRESENTANTE-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="sube_rep_legal" class="control-label">REPRESENTANTE LEGAL SUBEMPRESA: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="sube_rep_legal" id="sube_rep_legal" placeholder="Ingrese el nombre del Representante Legal">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL TIPO IDENTIFICACIÓN -->
                    <div id="div-tipo_id" class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sube_tipo_id" class="control-label">TIPO IDENTIFICACIÓN: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input" id="sube_tipo_id" name="sube_tipo_id" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL No. IDENTIFICACIÓN -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sube_numero_doc" class="control-label">No. IDENTIFICACIÓN: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input solo-numero" name="sube_numero_doc" id="sube_numero_doc" placeholder="Ingresar numero identificacion" required>
                            </div>
                        </div>
                    </div>


                  <div id=cambio>          
                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sube_pais" class="control-label">País: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input select2" id="sube_pais" name="sube_pais" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sube_id_dpto" class="control-label">DEPARTAMENTO: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="sube_id_dpto" name="sube_id_dpto" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sube_id_ciudad" class="control-label">CIUDAD: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="sube_id_ciudad" name="sube_id_ciudad" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                  </div>  <!-- FIn div id, newEmpresa -->

                    <!-- ENTRADA PARA LA EMAIL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="sube_email_emp" class="control-label">E-MAIL: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                <input type="sube_email" class="form-control input" name="sube_email_emp" id="sube_email_emp" placeholder="Ingresar e-mail" required>
                            </div>
                        </div>
                    </div> 


                     <!-- ENTRADA PARA DIRECCIÓN -->
                     <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fire"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="sube_direccion" id="sube_direccion" placeholder="Ingrese la dirección">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CELULAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="celular" class="control-label">Celular: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-numero" name="sube_celular" id="sube_celular" placeholder="Ingrese el número celular">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LOGO -->
                    <div class="col-xs-12 col-sm-12 center-block div-archivo" id="infoEditSub">
                            <label class="control-label">Logo Guardado: </label>
                            <span id="info-editSub"></span>
                     </div>
                    <div class="col-xs-12 col-sm-12 center-block div-archivo">
                            <label class="control-label">Logo - Archivo: </label>
                            <span id="infoSub"></span>
                        </div>
                    <div class="col-xs-12 col-sm-12  center-block div-archivo">
                            <label for="archivoSub" class="lbl-subir">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span id="lbl-archivoSub">Seleccionar Archivo</span>
                            </label>
                            <input id="archivoSub" name="archivoSub" class="archivoSub" type="file" style='display: none;' accept="image/*, .pdf, .doc, .docx, .xls, .xlsx, .txt" />
                    </div> 
                    <?php
                       // print_r($_FILES);
                    ?>    
                    <!-- ESPACIO en BLANCO -->
                    <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                    <br>                                    
                    </div>

                    <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
            </div>    
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-subempresas" type="submit" class="btn btn-primary">Guardar Subempresa</button>
                </div>
            </form>
        </div>
    </div>
</div>