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
<div id="modalAddEmpresa" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEmpresa" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_empresa" name="id_empresa" value=""> 
                <input type="hidden" id="nomLogo" name="nomLogo" value="">  

                <div class="modal-header" id="div-crear">
                    <button type="button" id="btn-xmodal" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-empresa">Datos Empresa</h4>
                </div>

                <div class="modal-body">

                <div class="row">
                    <!-- ENTRADA PARA RAZON SOCIAL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="razon_social" class="control-label">RAZÓN SOCIAL: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input" name="razon_social" id="razon_social" placeholder="Ingrese el nombre del Empresa">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NOMBRE REPRESENTANTE-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="rep_legal" class="control-label">REPRESENTANTE LEGAL: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input" name="rep_legal" id="rep_legal" placeholder="Ingrese el nombre del Representante Legal">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL TIPO IDENTIFICACIÓN -->
                    <div id="div-tipo_id" class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_id" class="control-label">TIPO IDENTIFICACIÓN: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input" id="tipo_id" name="tipo_id" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL No. IDENTIFICACIÓN -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="numero_doc" class="control-label">No. IDENTIFICACIÓN: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input solo-numero" name="numero_doc" id="numero_doc" placeholder="Ingresar numero identificacion" required>
                            </div>
                        </div>
                    </div>

            <div id=newEmpresa>          
                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input select2" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="id_dpto" class="control-label">DEPARTAMENTO: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="id_dpto" name="id_dpto" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="id_ciudad" class="control-label">CIUDAD: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="id_ciudad" name="id_ciudad" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>  <!-- FIn div id, newEmpresa -->
                
            
            <div id=editEmp>  
                <!-- ENTRADA PARA PAIS -->
                <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="paisEdit" class="control-label">País: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input select2" id="paisEdit" name="paisEdit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="id_dptoEdit" class="control-label">DEPARTAMENTO: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="id_dptoEdit" name="id_dptoEdit" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA LUGAR -->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="id_ciudadEdit" class="control-label">CIUDAD: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control input select2" id="id_ciudadEdit" name="id_ciudadEdit" required>
                                    <!-- <option value="">Seleccione un lugar </option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>  <!-- FIn div id, editEmpresa -->      
            



                    <!-- ENTRADA PARA LA EMAIL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="email_emp" class="control-label">E-MAIL: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                <input type="email" class="form-control input" name="email_emp" id="email_emp" placeholder="Ingresar e-mail" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DIRECCIÓN -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fire"></i></span>
                                <input type="text" class="form-control input " name="direccion" id="direccion" placeholder="Ingrese la dirección">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CELULAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="celular" class="control-label">Celular: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-numero" name="celular" id="celular" placeholder="Ingrese el número celular">
                            </div>
                        </div>
                    </div>

<!-- ENTRADA PARA LOGO -->
<div class="col-xs-12 col-sm-12 center-block div-archivo" id="infoEdit">
    <label class="control-label">Logo Guardado:</label>
    
    <!-- Enlace para abrir el logo -->
    <a id="enlaceDirectorioLogo" href="#" target="_blank">
        <span id="info-edit"></span>
    </a>

    <!-- Botón eliminar -->
    <a href="#" 
       id="btnEliminarLogo" 
       class="btn-eliminar-logo-solicitud pull-right" 
       style="margin-left:10px; display:none;">
        <i class="fa fa-trash text-danger" aria-hidden="true" title="Eliminar Logo"></i>
    </a>
</div>

<div class="col-xs-12 col-sm-12 center-block div-archivo">
    <label class="control-label">Logo - Archivo:</label>
    <span id="info"></span>
</div>

<div class="col-xs-12 col-sm-12 center-block div-archivo">
    <label for="archivo" class="lbl-subir">
        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
        <span id="lbl-archivo">Seleccionar Archivo</span>
    </label>
    <input id="archivo" name="archivo" class="archivo" type="file" style="display: none;"
           accept="image/*, .pdf, .doc, .docx, .xls, .xlsx, .txt" />
</div>

                    <?php
                       // print_r($_FILES);
                    ?>    
                    <!-- ESPACIO en BLANCO -->
                    <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                    <br>                                    
                    </div>
                   

                    <div class="col-xs-6 col-sm-6 form-group form-check">
                        <input type="checkbox" class="form-check-input" id="flag_subemp" name="flag_subemp" value="0">
                        <label class="form-check-label" for="flag_subemp">MANEJA SUBEMPRESA?</label>
                    </div>
                    
                    <div class="col-xs-6 col-sm-6 form-group form-check">
                        <input type="checkbox" class="form-check-input" id="flag_grup" name="flag_grup" value="0">
                        <label class="form-check-label" for="flag_grup">MANEJA GRUPO DE TERCEROS?</label>
                    </div>

                    <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
            </div>  

                <div class="modal-footer">
                    <button type="button" id="btn-cerrar-empresa" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-empresa" type="submit" class="btn btn-primary">Guardar Empresa</button>
                    <button id="btn-edit-empresa" type="submit" class="btn btn-primary">Editar Empresa</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
// print_r($_POST);
?>
