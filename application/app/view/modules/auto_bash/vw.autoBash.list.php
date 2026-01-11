<section class="content-header">
    <h1>Autorizaciones BASC</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Indicadores</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <input type="hidden" id="accion" name="accion" value="">
                    <input type="hidden" id="username" name="username" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                    <input type="hidden" id="perfil" name="perfil" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']?>">
                    <input type="hidden" id="id_empresa" name="id_empresa" value="">
                    <table id="tbl-srvfin" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th>Fecha autorización</th>
                                <th>Acciones</th> 
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/autorizacion/auto.bash.list.js"></script>