<style>
    .tbl-text {
        padding: 5px 10px;
     /*   background: #f39c12;
        color: #fff;
        border: 0px solid #fff; */
        font-size: small;
    }

    .lbl-subir:hover {
        color: #fff;
        background: #00a65a;
    }
</style>
<section class="content-header">
    <h1>Empresas</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Empresas</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">

            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddEmpresa" data-toggle="modal" data-target="#modalAddEmpresa">
                        Agregar Empresa
                    </button>
                </div>

                <div class="box-body">
                    <table id="tbl-empresas" class="table table-bordered table-striped dt-responsive  collapsed tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Razon Social </th>
                                <th>Id. </th>
                                <th>Ciudad </th>
                                <th>Representante </th>
                                <th>Correo </th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    

        <!--  MODULO DE TERCEROS  --->
        <div class="col-md-5 hide" id="div-box-terceros">

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Empresa - Terceros</h3>
                    <h3 id="span-cliente-id" style="color:#3c8dbc"></h3>

                    <div class="box-tools pull-right">
                        <button id="btnCollapseTercero" type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i> <!-- data-widget="collapse" -->
                        </button>
                    </div>

                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div style="padding: 5px;">
                        <button class="btn btn-primary btnAdd-Terceros pull-right" data-toggle="modal" data-target="#modalAddTerceros">
                            + Agregar Tercero
                        </button>
                    </div>
                    

                    <form id="formVwTerceros" role="form" method="post" enctype="multipart/form-data" autocomplete="off">  
                    
                    <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                    <input type="hidden" id="id_empresa_vw_tercero" name="id_empresa_vw_tercero" value="">
                    <input type="hidden" id="id_tercero" name="id_tercero" value="">

                        <table id="tbl-terceros" class="table table-bordered table-striped dt-responsive  collapsed tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nombre Tercero</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                            </table>
                        </table>

                    </form>    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>


    <!--  MODULO DE SUBEMPRESAS  --->
        <div class="col-md-5 hide" id="div-box-subempresas">

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Empresa - Subempresas</h3>
                    <h3 id="span-cliente-subemp" style="color:#3c8dbc"></h3>

                    <div class="box-tools pull-right">
                        <button id="btnCollapseSubEmpresas" type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i> <!-- data-widget="collapse" -->
                        </button>
                    </div>

                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div style="padding: 5px;">
                        <button class="btn btn-primary btnAddSubemp pull-right" data-toggle="modal" data-target="#modalAddSubemp">
                            + Agregar SubEmpresa
                        </button>
                    </div>
                    

                    <form id="formVwSubemp" role="form" method="post" enctype="multipart/form-data" autocomplete="off">   
                    
                    <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                    <input type="hidden" id="id_empresa_vw_subemp" name="id_empresa_vw_subemp" value="">
                    <input type="hidden" id="empresaSub" name="empresaSub" value="">


                        <table id="tbl-subemp" class="table table-bordered table-striped dt-responsive  collapsed tablas" width="100%">
                            <thead>
                                <tr>
                                    <th>Razon social </th>
                                    <th>Id. </th>
                                    <th>Representante </th>
                                    <th>Ciudad </th>
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



        <!--  MODULO DE USUARIOS  --->
        <div class="col-md-5 hide" id="div-box-usuarios">

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Empresa - Usuarios</h3>
                    <h3 id="span-cliente-usuarios" style="color:#3c8dbc"></h3>

                    <div class="box-tools pull-right">
                        <button id="btnCollapseUsuarios" type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i> <!-- data-widget="collapse" -->
                        </button>
                    </div>

                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div style="padding: 5px;">
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
                                    <!--<th>Id. </th>
                                    <th>Correo</th>  
                                    <th>Empresa</th>-->
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>

                    </form>    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>


        <!--  MODULO DE COMBOS CLIENTE  --->
        <div class="col-md-5 hide" id="div-box-servicios">

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Empresa - Combos Servicios</h3>
                        <h3 id="span-cliente-servicios" style="color:#3c8dbc"></h3>

                        <div class="box-tools pull-right">
                            <button id="btnCollapseServicios" type="button" class="btn btn-box-tool" ><i class="fa fa-times"></i> <!-- data-widget="collapse" -->
                            </button>
                        </div>

                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div style="padding: 5px;">
                            <button class="btn btn-primary btnAdd-Servicios pull-right" data-toggle="modal" data-target="modalAddComboCliente">
                                + Agregar Combo
                            </button>
                        </div>
                        

                        <form id="formVwServicios" role="form" method="post" enctype="multipart/form-data" autocomplete="off">  
                        
                        <!-- <input type="hidden" id="accion" name="accion" value=""> -->
                        <input type="hidden" id="id_empresa_vw_servicios" name="id_empresa_vw_servicios" value="">
                        <input type="hidden" id="id_servicios" name="id_servicios" value="">
                        <br><br>
                        <table id="tbl-combosCli" class="table table-bordered table-striped dt-responsive tbl-text tablas" width="80%">
                            <thead>
                                <tr>
            <!--                        <th style="width:10px">Id</th>      
                                    <th>Empresa</th>                  -->           
                                    <th>Combo Servicio</th>
                                    <th>Valor Bogotá</th>
                                    <th>Valor Externo</th>
                                    <th>Estado</th>
                                    <th>Visible</th>
            <!--                         <th>Usuario Crea</th>
                                    <th>Fecha Crea</th>                         -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>

                        </form>    
                    </div>
                    <!-- /.box-body -->
                </div>
            <!-- /.box -->
        </div>

    </div>
</div>




</section>
<?php //include 'vw.tercero.modal.list.php' ?>
<?php //include 'vw.subemp.modal.list.php' ?>
<?php //include 'vw.usuario.modal.list.php' ?>

<?php include 'vw.tercero.modal.php' ?>
<?php include 'vw.subemp.modal.php' ?>
<?php include 'vw.empresa.modal.php' ?>
<!-- <?php //include 'vw.empresa.modalEdit.php' ?> -->
<?php include 'vw.usuario.modal.php' ?>
<?php include 'vw.ueditar.modal.php' ?>
<?php include 'vw.correo.modal.php' ?>
<?php include 'vw.comboCliente.modal.php' ?>
<?php include 'vw.especificaciones.modal.php' ?>

<script src="<?= constant('APP_URL') ?>app/js/cli/empresaser.js"></script>



