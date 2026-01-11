<!--modal para la dimension de antecedentes academicos-->
<div id="modalAddDimensionLaboral" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formDimensionLaboraledit" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="14">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimensionFamilia">9. EVALUACIÓN DEL NIVEL DE CONFIABILIDAD LABORAL DEL EVALUADO</h4>
                </div>


                <div class="modal-body">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada la información del evaluado es totalmente confiable y se ajusta completamente a la realidad.<br>(Ajuste entre un 95% y 100%) 
                                    </p>
                                    </div>
                                    <a class="small-box-footer">0</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO BAJO</sup>

                                    <p style="font-size: 14px">En la variable analizada la información del evaluado es confiable y se ajusta en su gran mayoría a la realidad.<br>(Ajuste entre 90% y 95%) 
                                    </p>
                                    </div>
                                    <a class="small-box-footer">1</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INTERMEDIO</sup>

                                    <p style="font-size: 14px">En la variable analizada la información del evaluado es medianamente confiable y se ajusta en medio nivel a la realidad.<br>(Ajuste entre 80% y 90%)
                                    </p>
                                    </div>
                                    <a class="small-box-footer">2</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO ALTO</sup>

                                    <p style="font-size: 14px">En la variable analizada la información del evaluado es poco confiable y se ajusta poco a la realidad.<br>(Ajuste entre 70% y 80%)
                                    </p>
                                    </div>
                                    <a class="small-box-footer">3</a>
                                </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                    <!-- ENTRADA PARA EL VARIABLE A ANALIZAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="variableLaboralEdit" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableLaboralEdit" name="variableLaboralEdit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DESCRIPCION POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_edit" class="control-label">Informacion completa de variable a Analizar: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="descripcion_edit" name="descripcion_edit" readonly ></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA SEÑALES DE ALERTA  
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="senal_alerta" class="control-label">Señales de Alerta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="senal_alerta" name="senal_alerta" readonly>
*Maltrato Intrafamiliar (Psicólogico, Físico, Sexual, Negligencia etc).
*Separaciones de los padres o figuras representativas.
*Desarraigo. 
*Carencia de una red de apoyo.
*Inestabilidad afectiva varias relaciones de pareja, hijos de varias relaciones, por quienes debe asumir una responsabilidad económica.
*Antecedentes familiares en el consumo de alcohol y drogas.
*Problemas con exparejas, que pueden acarrear acoso, demandas, etc.
*Carencia de figuras de autoridad y pautas de crianza claras.
*Separaciones del evaluado o funcionario y su responsabilidad con sus obligaciones. (Demandas de alimentos).
*evaluado, que no asume sus dificultades y las evade o  no participan en la solución de las mismas.
*Dificultades o problemáticas que sobrepasan al evaluado y su familia y que afecta sus relaciones actualmente.
* Aficiones personales que interfieran su labor, o que puedan llevarlo a presentar ausentismos. (Juegos de video el línea, con apuestas, redes sociales etc aficiones a equipos de fútbol y por ir a los partidos falten al trabajo.) Con que frecuencia, ahondar en esta parte.
*Estudios actuales que puedan interferir con su horario laboral.
*Alto nivel de rotación laboral y motivos de retiro. Solicitar hoja de vida.
*Rol del evaluado: único proveedor, puede ser un riesgo, que puede llevarlo a actos de robo. Como lo reconocen en su núcleo familiar. En la visita debe estar un familiar.</textarea>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgoEdit" class="control-label">Nivel De Riesgo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_riesgoEdit" name="nivel_riesgoEdit" placeholder="Nivel de riesgo" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="respuestaEdit" class="control-label">Informe por Variable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="respuestaEdit" name="respuestaEdit"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-dimensionEditLaboral" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>