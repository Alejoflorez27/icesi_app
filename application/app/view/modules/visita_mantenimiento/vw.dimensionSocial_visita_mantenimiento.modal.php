<div id="modalAddDimensionFamilia" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formDimensionSocialedit" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="2">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimensionFamilia">Dimension Social</h4>
                </div>


                <div class="modal-body">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada el evaluado evidencia un nivel
                                            muy bajo de riesgo en su entorno social y habitacional
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado no evidencia riesgo en su entorno social y habitacional.
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel medio de riesgo en su entorno social y habitacional. 
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel alto de riesgo en su entorno social y habitacional.
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
                            <label for="variableSocialEdit" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input" id="variableSocialEdit" name="variableSocialEdit" required>
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
                    <!-- ENTRADA SEÑALES DE ALERTA  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="senal_alerta" class="control-label">Señales de Alerta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="senal_alerta" name="senal_alerta" readonly>
*Condiciones de la estructura física de la vivienda que puedan afectar la salud del candidato y su familia.
(húmedad, hacinamiento, desaseo y malos olores).
*En cuanto a la distribución de la vivienda, utilización de espacios para otros fines que no son los previstos, por
ejemplo en la sala se ubica un espacio improvisado para una habitación.
*Condiciones precarias en términos de dotación que afecten la calidad de vida del grupo.
*Condiciones de higiene y aseo que pueden evidenciar situaciones emocionales y afectación de la salud.
*Cambios injustificados de vivienda y alto número de traslados.
*Dificulltades y demora en el desplazamiento del candidato a su lugar de trabajo como carencia de vías de acceso
y rutas de transporte, el lugar de trabajo este muy lejos de su lugar de residencia. Congestión vehícular y tener que
coger doble transporte.
*Traslados de ciudad recientes.
* Inseguridad y problemáticas del sector que puedan afectar al candidato (a) o evaluado (a). ( Horarios de llegada
a la casa, trabajos por turnos).
* Que residan en una habitación, que no es familiar, donde no lo conocen. Profundizar como llegó ahí y quien lo
recomendó, entrevistador al arrendador.
* Carencia de dotación de la vivienda, no tienen lo minimo para tener un buen nivel de vida o si tiene en exceso.
Profundizar y el porque, dependerá de la etapa del ciclo vital donde se encuentre.
* Quienes son sus amigos y que hacen, que actividades realizan.
* Falta de oferta de servicios básicos cerca a su vivienda.
*Hacinamiento, cuando viven en Inquilinatos que deben compartir espacios con otros residentes.
*Tiene conocimiento que en su barrio o cuadra, residen personas que esten vinculadas, con microtrafico, bandas,
grupos al margen de la ley.
*Es obligatorio hacer el vecino o arrendador.</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgoEdit" class="control-label">Nivel De Riesgo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="nivel_riesgoEdit" name="nivel_riesgoEdit" placeholder="Nivel de riesgo" required>
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
                                <textarea class="form-control input" id="respuestaEdit" name="respuestaEdit" placeholder='Se deben anotar las Señales de Alerta o Riesgos.'></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-dimensionEditSocial" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>