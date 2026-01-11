<section class="content-header">

    <h1>Opciones de Menu por Perfil</h1>

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="#">Peril</a></li>
        <li class="active">Menu</li>
    </ol>

</section>

<section class="content">

    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">

                <div class="box-body">

                    <div class="div-perfil">
                        <label for="perfil" class="control-label">PERFIL: *</label>
                        <div>
                            <select class="me-edit-info form-control input-sm select2" id="perfil" name="perfil">
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->


            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->


        <div class="col-md-9">
            <div class="box box-primary">

                <div class="box-body">
                    <table id="tbl-menu" class="tablas table table-condensed dt-responsive" width="100%">
                        <!--data-order='[[2,"asc"],[1,"asc"],[0,"asc"]]'-->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Menu</th>
                            </tr>
                        </thead>

                    </table>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->


    </div>

</section>

<script src="<?= constant('APP_URL') . "app/js/_core/usr/perfil.menu.js" ?>"></script>