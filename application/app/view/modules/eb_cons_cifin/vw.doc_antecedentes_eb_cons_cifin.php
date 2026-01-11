<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
    //print_r($solicitud);
?>

<style>

    .d-inline
    {
        display: inline-block;
      /*  color:blue; */
    }
</style>
<section class="content-header">
    <h1>evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> Datos Generales</a></li>
        <li class="active">Antecedentes Documentales</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">2.VERIFICACIÓN DE ANTECEDENTES Y DOCUMENTOS</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formDimensionFamilia" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="11">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                <input type="hidden" id="nombre_completo" name="nombre_completo" value="<?= $solicitud['nombre_candidato'] ?>">
                <input type="hidden" id="num_cedula" name="num_cedula" value="<?= $solicitud['numero_documento'] ?>">

            <div class="box-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es totalmente confiable y se ajusta totalmente a las necesidades del cargo.
A. Ajuste documental entre un 95% y 100%
B. Nivel de importancia del antecedente o reporte para la empresa cliente 
                                    </p>
                                    </div>
                                    <a class="small-box-footer">0</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO BAJO</sup>

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es confiable y se ajusta en un alto nivel a las necesidades del cargo.
A. Ajuste documental entre un 90% y 95%
B. Nivel de importancia del antecedente o reporte para la empresa cliente
                                    </p>
                                    </div>
                                    <a class="small-box-footer">1</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INTERMEDIO</sup>

                                    <p style="font-size: 14px">En la variable analizada la información documental o de antecedentes, es medianamente confiable y se ajusta en medio nivel a las necesidades del cargo. A. Ajuste documental entre un 85% y 90%
B. Nivel de importancia del antecedente o reporte para la empresa cliente
                                    </p>
                                    </div>
                                    <a class="small-box-footer">2</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO ALTO</sup>

                                    <p style="font-size: 14px">En la variable analizada la información documental o de antecedentes, es poco confiable y se ajusta poco a las necesidades del cargo. A. Ajuste documental entre un 80% y 85%
b. Nivel de importancia del antecedente o reporte para la empresa cliente
                                    </p>
                                    </div>
                                    <a class="small-box-footer">3</a>
                                </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->

                    <!-- ENTRADA PARA EL VARIABLE A ANALIZAR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="variableFamilia" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableFamilia" name="variableFamilia" placeholder="variables" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgo" class="control-label">Nivel De Riesgo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_riesgo" name="nivel_riesgo" placeholder="Nivel de riesgo" required>
                                </select>
                            </div>
                        </div>
                    </div>

            <!-- ################  ENTRADAS PARA LENAR LOS DATOS DE CADA UNA DE LAS FUENTES ONSULTADAS  ##############--> 
            <div class="col-xs-12 col-sm-12 center-block" id="contenedor" name="contenedor"> 

                    <!-- ENTRADA PARA NIVEL DE P_FECHA 1--> 
                    <div class="d-inline"  name="c_fecha" id="c_fecha" style="display: inline;">
                            <label class="d-inline"  name="t_fecha" id="t_fecha" style="display: inline;"></label>
                            <div class="d-inline">    
                                <input class="form-control input" type="date" name="p_fecha" id="p_fecha" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NOMBRE 2--> 
                    <div class="d-inline" name="c_nombre" id="c_nombre" style="display: inline;">
                            <label for="p_nombre" style="display: inline;" name="t_nombre" id="t_nombre"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nombre" id="p_nombre" style="display: inline; width: 250px;" readonly="readonly">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NUMCUPO 3--> 
                    <div class="d-inline" name="c_numcupo" id="c_numcupo" style="display: inline;">
                            <label for="p_numcupo" style="display: inline;" name="t_numcupo" id="t_numcupo"></label>
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_numcupo" id="p_numcupo" style="display: inline;" readonly="readonly">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_FECHA_EPS 4--> 
                    <div class="d-inline" name="c_fecha_eps" id="c_fecha_eps" style="display: inline;">
                            <label for="p_fecha_eps" style="display: inline;" name="t_fecha_eps" id="t_fecha_eps"></label> 
                            <div class="d-inline">
                                <input type="date" class="form-control input" name="p_fecha_eps" id="p_fecha_eps" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NOMBRE_EPS 5--> 
                    <div class="d-inline" name="c_nom_eps" id="c_nom_eps" style="display: inline;">
                            <label for="p_nom_eps" style="display: inline;" name="t_nom_eps" id="t_nom_eps"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nom_eps" id="p_nom_eps" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_TIPO_EPS 6--> 
                    <div class="d-inline" name="c_tipo_eps" id="c_tipo_eps" style="display: inline;">
                            <label for="p_tipo_eps" style="display: inline;" name="t_tipo_eps" id="t_tipo_eps"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_tipo_eps" id="p_tipo_eps" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE P_SELECCION 7--> 
                    <div class="d-inline" name="c_seleccion" id="c_seleccion" style="display: inline;">
                            <label for="p_seleccion" style="display: inline;" name="t_seleccion" id="t_seleccion"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_seleccion" id="p_seleccion" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE P_FECHA_RUNT 8--> 
                    <div class="d-inline" name="c_fecha_runt" id="c_fecha_runt" style="display: inline;">
                            <label for="p_fecha_runt" style="display: inline;" name="t_fecha_runt" id="t_fecha_runt"></label>
                            <div class="d-inline" >
                                <input type="date" class="form-control input" name="p_fecha_runt" id="p_fecha_runt" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_nombre_cand_runt 9--> 
                    <div class="d-inline" name="c_nombre_cand_runt" id="c_nombre_cand_runt" style="display: inline;">
                            <label for="p_nombre_cand_runt" style="display: inline;" name="t_nombre_cand_runt" id="t_nombre_cand_runt"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nombre_cand_runt" id="p_nombre_cand_runt" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_numcupo_runt 10--> 
                    <div class="d-inline" name="c_numcupo_runt" id="c_numcupo_runt" style="display: inline;">
                            <label for="p_numcupo_runt" style="display: inline;" name="t_numcupo_runt" id="t_numcupo_runt"></label> 
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_numcupo_runt" id="p_numcupo_runt" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_categoria 11--> 
                    <div class="d-inline" name="c_categoria" id="c_categoria" style="display: inline;">
                            <label for="p_categoria" style="display: inline;" name="t_categoria" id="t_categoria"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_categoria" id="p_categoria" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_estado 12--> 
                    <div class="d-inline" name="c_estado" id="c_estado" style="display: inline;">
                            <label for="p_estado" style="display: inline;" name="t_estado" id="t_estado"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_estado" id="p_estado" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_num_libreta 13--> 
                    <div class="d-inline" name="c_num_libreta" id="c_num_libreta" style="display: inline;">
                            <label for="p_num_libreta" style="display: inline;" name="t_num_libreta" id="t_num_libreta"></label> 
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_num_libreta" id="p_num_libreta" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE t_null 13--> 
                    <div class="d-inline">
                        <label  style="display: inline;" name="t_null" id="t_null"></label> 
                    </div>

            </div>  

            <!-- ################  FIN DE ENTRADAS PARA LENAR LOS DATOS DE CADA UNA DE LAS FUENTES ONSULTADAS  ##############-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <br>
                    </div>
                    <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="respuesta" class="control-label">Informe por Variable: *
                                <button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalPlantilla">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="respuesta" name="respuesta" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- el pie de pagina del form -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div style="color:red;">
                            Campos señalados con * son obligatorios
                        </div>                    

                        <div class="modal-footer">
                            <button id="btn-submit-dimensionFamilia" type="submit" class="btn btn-primary btnAddDimensionFamilia">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            <div class="box-header with-border">

                </div>

                <div class="box-body">

                    <table id="tbl-familiaDimension" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Variable a Analizar</th>
                                <th>Nivel De Riesgo</th>
                                <th>Informe por Variable</th>
                                <th>Texto Completo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.doc_antecedentes_eb_cons_cifin.modal.php' ?>
<?php include 'vw.plantilla_var_eb_cons_cifin.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/eb_cons_cifin/doc_antecedentes_eb_cons_cifin.js"></script>
