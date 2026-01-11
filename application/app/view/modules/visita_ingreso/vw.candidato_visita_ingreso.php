<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
//print_r($solicitud);
?>
<section class="content-header">
    <h1>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato']?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> solicitud</a></li>
        <li class="active">Evaluado</li>
    </ol>
</section>

<section class="content-header">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">
            <div class="box box-primary">
                <!--<form id="formCandidato" role="form" method="post" enctype="multipart/form-data" autocomplete="off">-->

        
            <form id="formVisitaIngreso" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                    <input type="hidden" id="accion" name="accion" value="PUT">
                    <input type="hidden" id="id_candidato" name="id_candidato" value="">
                    <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                    

                    <div class="box-header" id="div-crear">
                        <h3 class="box-title">1.Datos Generales Visita Domiciliaria Ingreso</h3>
                        <!--<button class="btn btn-primary btnMenu pull-right" type="button">
                            <i class="fa fa-bars"></i>
                        </button>-->
                    </div>

                <div class="box-body">

                        <!-- ENTRADA PARA NOMBRE -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombres del Evaluado: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                    <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Ingrese el Nombre del Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA APELLIDO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="apellido" class="control-label">Apellidos del Evaluado: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                    <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Ingrese el Apellido del Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA TIPO DOCUMENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="tipo_id" class="control-label">Tipo Doc.: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <select class="form-control input select2" id="tipo_id" name="tipo_id" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA NRO DUCOMENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="numero_doc" class="control-label">Nro Doc.: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <input type="text" class="form-control input" name="numero_doc" id="numero_doc" placeholder="Ingrese el Número del Documento" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA PAIS NACIMIENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="pais_nacimiento" class="control-label">País Nacimiento: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                    <select class="form-control input select2" id="pais_nacimiento" name="pais_nacimiento" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA DEPARTAMENTO NACIMIENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="departamento_nacimiento" class="control-label">Departamento Nacimiento: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                    <select class="form-control input select2" id="departamento_nacimiento" name="departamento_nacimiento" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA CIUDAD NACIMIENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="id_ciudad_nac" class="control-label">Ciudad Nacimiento: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                    <select class="form-control input select2" id="id_ciudad_nac" name="id_ciudad_nac" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA FECHA DE NACIMIENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="fch_nacimiento" class="control-label">Fecha de Nacimiento: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <input type="text" class="form-control" name="fch_nacimiento" id="fch_nacimiento" placeholder="Ingrese la Fecha de Nacimiento" required>
                                </div>
                            </div>
                        </div> 

                        <!-- ENTRADA PARA PAIS -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="pais" class="control-label">País donde Vive: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                    <select class="form-control input select2" id="pais" name="pais" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA DEPARTAMENTO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="departamento" class="control-label">Departamento donde vive: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                    <select class="form-control input select2" id="departamento" name="departamento" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA CIUDAD -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="id_ciudad_act" class="control-label">Ciudad donde vive: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                    <select class="form-control input select2" id="id_ciudad_act" name="id_ciudad_act" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        


                        <!-- ENTRADA PARA EDAD -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="edad" class="control-label">Edad: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <input type="text" class="form-control input" name="edad" id="edad" placeholder="Ingrese la Edad" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA LIBRETA MILITAR-->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="libreta" class="control-label">Libreta Militar: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control input" name="libreta" id="libreta" placeholder="Segunda Clase etc.o colocar no tiene definida situación militar" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA ESTADO CIVIL -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="estado_civil" class="control-label">Estado Civil: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <select class="form-control input select2" id="estado_civil" name="estado_civil" required>
                                    </select>
                                </div>
                            </div>
                        </div>                      

                        <!-- ENTRADA PARA TELEFONO -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="telefono" class="control-label">Teléfono: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control input" name="telefono" id="telefono" placeholder="Ingrese el Teléfono del Evaluado" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA CORREO UNO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="emali1" class="control-label">Correo: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control input" name="emali1" id="emali1" placeholder="Ingrese el Correo del Evaluado" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA SALARIO A DEVENGAR-->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="salario_dev" class="control-label">Salario a Devengar: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="number" class="form-control input" name="salario_dev" id="salario_dev" placeholder="Ingrese salario a devengar" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA CORREO DOS
                        <div class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="emali2" class="control-label">Correo 2: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control input" name="emali2" id="emali2" placeholder="Ingrese el Correo del Evaluado" required>
                                </div>
                            </div>
                        </div>-->
                        <!-- ENTRADA PARA DIRECCION -->
                        <div class="col-xs-12 col-sm-3 center-block">
                            <div class="form-group">
                                <label for="direccion" class="control-label">Dirección: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                    <input type="text" class="form-control input" name="direccion" id="direccion" placeholder="Ingrese la Dirección del Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA BARRIO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="barrio" class="control-label">Barrio: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                    <input type="text" class="form-control input" name="barrio" id="barrio" placeholder="Ingrese el Barrio del Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA ESTRACTO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="estracto" class="control-label">Estrato: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                    <input type="number" class="form-control input" name="estracto" id="estracto" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="nivel_escolar" class="control-label">Nivel de Escolaridad: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <select class="form-control input select2" id="nivel_escolar" name="nivel_escolar" placeholder="Nivel de Escolaridad" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA CARGO QUE DESEMPEÑO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="cargo_desempeno" class="control-label">Cargo a desempeñar: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <input type="text" class="form-control input" name="cargo_desempeno" id="cargo_desempeno" placeholder="Cargo al que Ingreso el Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA NOMBRE QUE ATIENDE LA VISITA-->
                        <div class="col-xs-12 col-sm-8 center-block">
                            <div class="form-group">
                                <label for="persona_visita" class="control-label">Persona o personas que atienden la visita: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <input type="text" class="form-control input" name="persona_visita" id="persona_visita" placeholder="Es obligatorio que el Evaluado se encuentre en la visita y este acompañado de un familiar en lo posible" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL PARENTESCO -->
                        <div class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="parantesco_visita" class="control-label">Parentesco de quien atiende la visita: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <!-- <select class="form-control input select2" id="parantesco_visita" name="parantesco_visita" placeholder="Parentesco con el Evaluado" required>
                                    </select>-->
                                    <input type="text" class="form-control input" name="parantesco_visita" id="parantesco_visita" placeholder="Parentesco con el Evaluado" required>
                                </div>
                            </div>
                        </div>

                        <div style="color:red;">
                            Campos señalados con * son obligatorios
                        </div>                    

                        <div class="modal-footer">
                            <button id="btn-submit-candidato" type="submit" class="btn btn-primary btnEditCandidato">Guardar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
        </div>
        <!-- /.box -->


    </div>

        <!--  MODULO DE USUARIOS  --->
        <div class="col-md-2 hide" id="div-box-usuarios">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Menú</h3>
                    <h3 id="span-cliente-usuarios" style="color:#3c8dbc"></h3>

                    <div class="box-tools pull-right">
                        <button id="btnCollapseUsuarios" type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i> <!-- data-widget="collapse" -->
                        </button>
                    </div>

                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div style="padding: 2px;">
                        <button class="btn btn-primary pull-right" id="btnAddUsuarios2" data-target="#modalAgregarUsuarioCli">
                            + Agregar Usuarios
                        </button>
                    </div>


                    <form id="formVwUser" role="form" method="post" enctype="multipart/form-data" autocomplete="off">   
                    
                        <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                        <input type="hidden" id="id_empresa_vw_usuarios" name="id_empresa_vw_usuarios" value="">
                        <input type="hidden" id="empresaUsu" name="empresaUsu" value="">


                        <table id="tbl-usuarios2" class="table table-bordered table-striped dt-responsive  collapsed  tbl-text tablas" width="80%">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Perfil </th>
                                    <th>Nombre</th>
                                    <th>Tipo Id. </th>
                                    <th>Id. </th>
                        <!--            <th>Correo</th>   --->
                                    <th>Empresa</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                        </table>

                    </form>    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

</section>

<?php include 'vw.especificacion.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_ingreso/candidato_visita_ingreso.js"></script>
