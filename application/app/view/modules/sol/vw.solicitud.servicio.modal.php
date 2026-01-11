<div id="modalAddServicio" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formServicioSolicitud" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-header hide div-agregar-servicio">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-servicio">Acción Servicio</h4>
                </div>

                <div class="modal-body">

                    <div class="box-body">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="idServicio" name="idServicio" value="">
                        <input type="hidden" id="idServicioAdicional" name="idServicioAdicional" value="">
                        <input type="hidden" name="perfil_campo" id="perfil_campo" class="form-control" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil'] ?>">
                        <input type="hidden" name="username" id="username" class="form-control" value="<?= $_SESSION[constant('APP_NAME')]['user']['username'] ?>">
                        <div class="box-header">
                            <!-- ENTRADA PARA SERVICIO -->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-agregar">
                                <div class="form-group">
                                    <label for="servicio" class="control-label">Servicio:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                        <select name="servicio" id="servicio" class="form-control select2">
                                            <option value=''>Seleccione..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ASIGNAR-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide  div-asignar">
                                <div class="form-group">
                                    <label for="asignado" class="control-label">Asignado:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                        <select name="asignado" id="asignado" class="form-control select2">
                                            <option value=''>Seleccione..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA PROGRAMA-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide  div-programar">
                                <div class="form-group">
                                    <label for="fecha_programacion" class="control-label">Fecha Programación: *</label>
                                    <div class="input-group-group">
                                        <input type="text" id="fecha_programacion" name="fecha_programacion" class="form-control solo-fecha-hora" autocomplete="off" placeholder="AAAA-MM-DD HH:MI" data-toggle="tooltip" data-placement="top" title="Seleccione la Fecha de programación">
                                    </div><span class="help-block" hidden=""></span>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ASISTIÓ -->
                            <div class="col-xs-12 hide col-sm-12 center-block hide  div-asistio">
                                <div class="form-group">
                                    <label for="asistio" class="control-label">Asistió: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                        <select class="form-control input" id="asistio" name="asistio">
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mensaje_modal" class="control-label">Observacion:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                        <input class="form-control" name="observacion_asistio" id="observacion_asistio"></input>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA PROCESO -->
                            <div class="col-xs-12 hide col-sm-12 center-block hide  div-proceso">
                                <div class="form-group">
                                    <label for="cont_proceso" class="control-label">Continuar Proceso: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                        <select class="form-control input" id="cont_proceso" name="cont_proceso">
                                            <option value="S">Continuar Proceso</option>
                                            <!--<option value="N">Cerrar y Generar Informe</option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CONCEPTO-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-concepto">
                                <div class="form-group">
                                    <label for="concepto" class="control-label">Concepto:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                        <select name="concepto" id="concepto" class="form-control select2">
                                            <option value=''>Seleccione..</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA OBSERVACION-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-observacion">
                                <div class="form-group">
                                    <label for="observacion_modal" class="control-label">Observacion / Novedad:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                        <textarea class="form-control" name="observacion_modal" id="observacion_modal" rows="3" style="width:100%;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA MENSAJE-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-mensaje">

                                <div class="form-group">
                                    <label for="para" class="control-label">Para:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                        <select name="para" id="para" class="form-control select2">
                                            <option value=''>Seleccione..</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mensaje_modal" class="control-label">Mensaje:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                        <textarea class="form-control" name="mensaje_modal" id="mensaje_modal" rows="3" style="width:100%;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA FINALIZAR-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-finalizar">

                                <div class="form-group">
                                    <label for="para" class="control-label">Estado:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                        <select class="form-control input" id="estado_calidad" name="estado_calidad">
                                            <option value="6">Aprobado con Alcance Externo</option>
                                            <option value="7">Aprobado Totalmente</option>
                                            <option value="9">Rechazado y Devuelto al Proveedor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mensaje_modal" class="control-label">Mensaje:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                        <textarea class="form-control" name="mensaje_calidad" id="mensaje_calidad" rows="3" style="width:100%;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA VALOR ADICIONAL-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-valor-adicional">
                                <div class="form-group">
                                    <label for="para" class="control-label">Valor Adicional:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                        <input type="text" class="form-control input solo-numero" name="valor_adicional_s" id="valor_adicional_s" placeholder="Ingrese el valor adicional">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mensaje_modal" class="control-label">Observacion:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-commenting"></i></span>
                                        <textarea class="form-control" name="observacion_adicional_s" id="observacion_adicional_s" rows="3" style="width:100%;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CALIFICACIÓN SERVICIO-->
                            <div class="col-xs-12 hide col-sm-12 center-block hide div-calificacion">
                                <div class="form-group">
                                    <label for="para" class="control-label">Oportunidad y entrega del servicio</label>
                                    <select class="form-control input" id="1" name="1">
                                        <option value="0"></option>
                                        <option value="1">Bajo</option>
                                        <option value="2">Medio</option>
                                        <option value="3">Alto</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="para" class="control-label">Calidad y contenido de la información diligenciada</label>
                                    <select class="form-control input" id="2" name="2">
                                        <option value="0"></option>
                                        <option value="1">Bajo</option>
                                        <option value="2">Medio</option>
                                        <option value="3">Alto</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="para" class="control-label">Calidad de la documentación anexada</label>
                                    <select class="form-control input" id="3" name="3">
                                        <option value="0"></option>
                                        <option value="1">Bajo</option>
                                        <option value="2">Medio</option>
                                        <option value="3">Alto</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="para" class="control-label">Actitud y compromiso con el servicio</label>
                                    <select class="form-control input" id="4" name="4">
                                        <option value="0"></option>
                                        <option value="1">Bajo</option>
                                        <option value="2">Medio</option>
                                        <option value="3">Alto</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                        <button id="btn-submit-servicio" type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
</div>