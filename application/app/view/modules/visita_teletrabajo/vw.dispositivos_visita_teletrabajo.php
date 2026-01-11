<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
$resp_menu = CtrMenuFormatos::findAll($servicioId);
//print_r($resp_menu);

$servicio = null;
if (Result::isSuccess($resp_menu))
    $servicio = Result::getData($resp_menu);
//print_r($servicio);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>
  <section class="content-header">
    <div class="row">
      <div class="col-xs-12 col-sm-8">
        <h3>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h3>
      </div>

      <div class="col-xs-12 col-sm-4">
        <div class="box box-primary collapsed-box" style="position: absolute; top: 0; right: 0; z-index: 9999;">
          <div class="box-header with-border">
            <h3 class="box-title">MENÚ <?= $servicio[0]['nom_servicio'] ?></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool btn-primary" data-widget="collapse"><i class="fa fa-bars"></i></button>
              <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
            </div>
          </div>

          <div class="box-body">
            <!-- Contenido de tu tabla -->
            <ul>
              <!-- <h1></h1>  -->
              <?php 
                foreach ($servicio as $file) : ?>
                    

                    <li style="margin-left:0px;">
                        <a href="<?= $file['url']. '?id_solicitud='.$solicitudId.'&id_servicio='.$servicioId ?>"><?= $file['nombre'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

          </div>

          <div class="box-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-left" data-widget="collapse">Cerrar</a>
            <button id="btn-submit-solicitud" type="submit" class="btn btn-sm btn-success btnSolicitudVolver">Solicitud</button>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="row">
    <div class="col-xs-6 col-sm-12 center-block">
        <!-- Dispositivos de teletrabajo-->
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 center-block">
                        <h4 class="box-title">7. DISPOSITIVOS O HERRAMIENTAS DE TRABAJO </h4>
                    </div>
                    <div class="col-xs-12 col-sm-6 center-block">
                        <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                        <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                    </div>
                </div>
            </div>
            <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_dispositivo" name="id_dispositivo" value="">
                        <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

                    <div class="box-body">

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="computador" class="control-label">Computador: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="computador" name="computador" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="personal" class="control-label">Personal: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="personal" name="personal" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="compartido" class="control-label">Compartido: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="compartido" name="compartido" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="num_persona" class="control-label">No. de personas que hacen uso del equipo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input solo-numero" name="num_persona" id="num_persona">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="camara" class="control-label">Cámara: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="camara" name="camara" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="marca" class="control-label">Tipo PC</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input" name="marca" id="marca">
                                    </div>
                                </div>
                            </div>

                            <!--internet-->

                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="internet" class="control-label">Internet: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="internet" name="internet" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="megas" class="control-label">No. Megas</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input solo-numero" name="megas" id="megas">
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="fijo" class="control-label">Fijo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="fijo" name="fijo" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="movil" class="control-label">Movil: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="movil" name="movil" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="limitado" class="control-label">Limitado: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="limitado" name="limitado" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="ilimitado" class="control-label">Ilimitado: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="ilimitado" name="ilimitado" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="paquete" class="control-label">Paquete: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="paquete" name="paquete" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="individual" class="control-label">Individual: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="individual" name="individual" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="modem" class="control-label">Modem: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="modem" name="modem" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-1 center-block">
                                <div class="form-group">
                                    <label for="banda_ancha" class="control-label">Banda Ancha:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="banda_ancha" name="banda_ancha" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>-->
                            

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="linea_tele_local" class="control-label">Línea Telefonica local</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <select class="form-control input select2" id="linea_tele_local" name="linea_tele_local" required>
                                            <option value="NO">NO</option>
                                            <option value="SI">SI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 center-block" id="ocultar">
                                <div class="form-group">
                                    <label for="numero" class="control-label">Número</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input solo-numero" name="numero" id="numero">
                                    </div>
                                </div>
                            </div>
                            
                            <!--<div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <h4>En caso afirmativo:</h4>
                                    <label for="linea_tele_p1" class="control-label">¿Tiene plan ilimitado a fijos locales?</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <select class="form-control input select2" id="linea_tele_p1" name="linea_tele_p1" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <br><br>
                                    <label for="linea_tele_p2" class="control-label">¿Tiene plan ilimitado a fijos nacionales?</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <select class="form-control input select2" id="linea_tele_p2" name="linea_tele_p2" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <br><br>
                                    <label for="linea_tele_p3" class="control-label">¿El teléfono se encuentra cerca al computador?</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <select class="form-control input select2" id="linea_tele_p3" name="linea_tele_p3" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <h4>Sistema (Propiedades del Sistema)</h4> 
                            </div>
                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="empresa_herramientas" class="control-label">¿La empresa brinda los elementos de trabajo?</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        
                                        <!--<select class="form-control input select2" id="empresa_herramientas" name="empresa_herramientas" required>
                                            <option value="NO">NO</option>
                                            <option value="SI">SI</option>
                                        </select>-->
                                        <input type="text" class="form-control input" name="empresa_herramientas" id="empresa_herramientas">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="windows" class="control-label">Edición de Windows</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input" name="windows" id="windows">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="ram" class="control-label">Memoria Instalada (RAM):</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input" name="ram" id="ram">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="procesador" class="control-label">Procesador:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input" name="procesador" id="procesador">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-6 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="sistema" class="control-label">Tipo de sistema:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <input type="text" class="form-control input" name="sistema" id="sistema">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="seguridad" class="control-label">Seguridad de la información (manejo de la información, archivos, medios fisicos y magneticos)</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                        <textarea class="form-control input" name="seguridad" id="seguridad"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 center-block">
                                <div style="color:red;">
                                    Campos señalados con * son obligatorios
                                </div>  
                                <div class="modal-footer">
                                    <button id="btn-submit-vivDristribucion" type="submit" class="btn btn-primary btnAddVivDistribucion">Guardar</button>
                                </div>  
                            </div>



                        </form>
                    </div>
                    <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>
</div>

<script src="<?= constant('APP_URL') ?>app/js/visita_teletrabajo/dispositivos_visita_teletrabajo.js"></script>
