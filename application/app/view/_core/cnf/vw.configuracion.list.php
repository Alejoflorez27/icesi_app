<?php $p = $router->param('p') ? $router->param('p') : 'all' ?>
<?php $parametros = CtrConfiguracion::consultarTodosCategoria("configuracion") ?>

<section class="content-header">
    <h1>Listar Tipos / Maestros</h1>
    <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Maestros</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="box">


        <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                    <tr>
                        <th style="width:10px">id</th>
                        <th>Codigo</th>
                        <th>Valor</th>
                        <th>Observación</th>
                        <th>Estado</th>
                        <th>Fecha Modificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parametros as $key => $value) : ?>
                        <?php if ($p == $value["codigo"] || $p == "all") : ?>
                            <tr>
                                <td><b><?= ($key + 1) ?></b><i class="fa fa-circle"></i></td>
                                <td><b><?= $value["codigo"] ?></b></td>
                                <td><b><?= $value["descripcion"] ?></b></td>
                                <td><b><?= $value["observacion"] ?></b></td>
                                <td><b><?= $value["estado"] ?></b></td>
                                <td><b><?= $value["fecha_sistema"] ?></b></td>
                                <td>
                                    <!-- <div class="btn-group"> -->
                                    <button class="btn btn-xs btn-warning btnEditarParametro" categoria="<?= $value["categoria"] ?>" codigo="<?= $value["codigo"] ?>" descripcion="<?= $value["descripcion"] ?>" observacion="<?= $value["observacion"] ?>" estado="<?= $value["estado"] ?>" data-toggle="modal" data-target="#modalAgregarParametro"><i class="fa fa-pencil"></i> Editar</button>
                                    <button class="btn btn-xs  btn-danger btnEliminarParametro" categoria="<?= $value["categoria"] ?>" codigo="<?= $value["codigo"] ?>"><i class="fa fa-times"></i> Eliminar</button>
                                    <button class="btn btn-xs btn-primary btnAgregarParametro" categoria="<?= $value["categoria"] ?>" codigo="<?= $value["codigo"] ?>" data-toggle="modal" data-target="#modalAgregarParametro"><i class="fa fa-plus"></i> Agregar</button>
                                    <!-- </div> -->
                                </td>
                            </tr>
                            <?php $parametrosHijos = CtrConfiguracion::consultarTodosCategoria($value["codigo"]) ?>

                            <?php foreach ($parametrosHijos as $keyH => $valueH) : ?>
                                <tr>
                                    <td><?= ($key + 1) . "." . ($keyH + 1) ?></td>
                                    <td><?= $valueH["categoria"] . "/" . $valueH["codigo"] ?></td>
                                    <td><code><?= $valueH["descripcion"] ?></code></td>
                                    <td><?= $valueH["observacion"] ?></td>
                                    <td><?= $valueH["estado"] ?></td>
                                    <td><?= $valueH["fecha_sistema"] ?></td>
                                    <td>
                                        <!-- <div class="btn-group"> -->
                                        <button class="btn btn-xs btn-warning btnEditarParametro" categoria="<?= $valueH["categoria"] ?>" codigo="<?= $valueH["codigo"] ?>" descripcion="<?= $valueH["descripcion"] ?>" observacion="<?= $valueH["observacion"] ?>" estado="<?= $valueH["estado"] ?>" data-toggle="modal" data-target="#modalAgregarParametro" F><i class="fa fa-pencil"></i> Editar</button>
                                        <button class="btn btn-xs btn-danger btnEliminarParametro" categoria="<?= $valueH["categoria"] ?>" codigo="<?= $valueH["codigo"] ?>"><i class="fa fa-times"></i> Eliminar</button>
                                        <!-- </div> -->
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

    </div>

</section>

<?php include 'vw.configuracion.modal.php' ?>


<script src="<?= constant('APP_URL') ?>app/js/_core/cnf/configuracion.js?v=<?= time() ?>"></script>