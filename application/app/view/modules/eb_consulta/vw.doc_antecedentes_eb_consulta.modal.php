<div id="modalAddDimensionFamilia" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formDimensionFamiliaedit" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="11">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimensionFamilia">2.VERIFICACIÓN DE ANTECEDENTES Y DOCUMENTOS</h4>
                </div>


                <div class="modal-body">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-6 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es totalmente confiable y se ajusta totalmente a las necesidades del cargo. A. Ajuste documental entre un 95% y 100% B. Nivel de importancia del antecedente o reporte para la empresa cliente 
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
                                    <sup style="font-size: 15px"> RIESGO BAJO</sup>

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es confiable y se ajusta en un alto nivel a las necesidades del cargo. A. Ajuste documental entre un 90% y 95% B. Nivel de importancia del antecedente o reporte para la empresa cliente 
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

                                    <p style="font-size: 14px">En la variable analizada la información documental o de antecedentes, es medianamente confiable y se ajusta en medio nivel a las necesidades del cargo. A. Ajuste documental entre un 85% y 90% B. Nivel de importancia del antecedente o reporte para la empresa cliente 
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
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="variableFamiliaEdit" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableFamiliaEdit" name="variableFamiliaEdit" required>
                                </select>
                            </div>
                        </div>
                    </div>
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
            <!-- ################  ENTRADAS PARA LENAR LOS DATOS DE CADA UNA DE LAS FUENTES ONSULTADAS  ##############--> 
            <div class="col-xs-12 col-sm-12 center-block" id="contenedor_edit" name="contenedor_edit"> 

                    <!-- ENTRADA PARA NIVEL DE P_FECHA 1--> 
                    <div class="d-inline"  name="c_fecha_edit" id="c_fecha_edit" style="display: inline;">
                            <label class="d-inline"  name="t_fecha_edit" id="t_fecha_edit" style="display: inline;"></label>
                            <div class="d-inline">    
                                <input class="form-control input" type="date" name="p_fecha_edit" id="p_fecha_edit" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NOMBRE 2--> 
                    <div class="d-inline" name="c_nombre_edit" id="c_nombre_edit" style="display: inline;">
                            <label for="p_nombre_edit" style="display: inline;" name="t_nombre_edit" id="t_nombre_edit"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nombre_edit" id="p_nombre_edit" style="display: inline; width: 250px;" readonly="readonly">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NUMCUPO 3--> 
                    <div class="d-inline" name="c_numcupo_edit" id="c_numcupo_edit" style="display: inline;">
                            <label for="p_numcupo_edit" style="display: inline;" name="t_numcupo_edit" id="t_numcupo_edit"></label>
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_numcupo_edit" id="p_numcupo_edit" style="display: inline;" readonly="readonly">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_FECHA_EPS 4--> 
                    <div class="d-inline" name="c_fecha_eps_edit" id="c_fecha_eps_edit" style="display: inline;">
                            <label for="p_fecha_eps_edit" style="display: inline;" name="t_fecha_eps_edit" id="t_fecha_eps_edit"></label> 
                            <div class="d-inline">
                                <input type="date" class="form-control input" name="p_fecha_eps_edit" id="p_fecha_eps_edit" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_NOMBRE_EPS 5--> 
                    <div class="d-inline" name="c_nom_eps_edit" id="c_nom_eps_edit" style="display: inline;">
                            <label for="p_nom_eps_edit" style="display: inline;" name="t_nom_eps_edit" id="t_nom_eps_edit"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nom_eps_edit" id="p_nom_eps_edit" style="display: inline;">
                            </div>
                    </div>

                    <!-- ENTRADA PARA NIVEL DE P_TIPO_EPS 6--> 
                    <div class="d-inline" name="c_tipo_eps_edit" id="c_tipo_eps_edit" style="display: inline;">
                            <label for="p_tipo_eps_edit" style="display: inline;" name="t_tipo_eps_edit" id="t_tipo_eps_edit"></label> 
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_tipo_eps_edit" id="p_tipo_eps_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE P_SELECCION 7--> 
                    <div class="d-inline" name="c_seleccion_edit" id="c_seleccion_edit" style="display: inline;">
                            <label for="p_seleccion_edit" style="display: inline;" name="t_seleccion_edit" id="t_seleccion_edit"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_seleccion_edit" id="p_seleccion_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE P_FECHA_RUNT 8--> 
                    <div class="d-inline" name="c_fecha_runt_edit" id="c_fecha_runt_edit" style="display: inline;">
                            <label for="p_fecha_runt_edit" style="display: inline;" name="t_fecha_runt_edit" id="t_fecha_runt_edit"></label>
                            <div class="d-inline" >
                                <input type="date" class="form-control input" name="p_fecha_runt_edit" id="p_fecha_runt_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_nombre_cand_runt 9--> 
                    <div class="d-inline" name="c_nombre_cand_runt_edit" id="c_nombre_cand_runt_edit" style="display: inline;">
                            <label for="p_nombre_cand_runt_edit" style="display: inline;" name="t_nombre_cand_runt_edit" id="t_nombre_cand_runt_edit"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_nombre_cand_runt_edit" id="p_nombre_cand_runt_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_numcupo_runt 10--> 
                    <div class="d-inline" name="c_numcupo_runt_edit" id="c_numcupo_runt_edit" style="display: inline;">
                            <label for="p_numcupo_runt_edit" style="display: inline;" name="t_numcupo_runt_edit" id="t_numcupo_runt_edit"></label> 
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_numcupo_runt_edit" id="p_numcupo_runt_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_categoria 11--> 
                    <div class="d-inline" name="c_categoria_edit" id="c_categoria_edit" style="display: inline;">
                            <label for="p_categoria_edit" style="display: inline;" name="t_categoria_edit" id="t_categoria_edit"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_categoria_edit" id="p_categoria_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_estado 12--> 
                    <div class="d-inline" name="c_estado_edit" id="c_estado_edit" style="display: inline;">
                            <label for="p_estado_edit" style="display: inline;" name="t_estado_edit" id="t_estado_edit"></label>
                            <div class="d-inline">
                                <input type="text" class="form-control input" name="p_estado_edit" id="p_estado_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE p_num_libreta 13--> 
                    <div class="d-inline" name="c_num_libreta_edit" id="c_num_libreta_edit" style="display: inline;">
                            <label for="p_num_libreta_edit" style="display: inline;" name="t_num_libreta_edit" id="t_num_libreta_edit"></label> 
                            <div class="d-inline">
                                <input type="number" class="form-control input solo-mayuscula" name="p_num_libreta_edit" id="p_num_libreta_edit" style="display: inline;">
                            </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE t_null_edit 13--> 
                    <div class="d-inline">
                        <label  style="display: inline;" name="t_null_edit" id="t_null_edit"></label> 
                    </div>

            </div>  

            <!-- ################  FIN DE ENTRADAS PARA LENAR LOS DATOS DE CADA UNA DE LAS FUENTES ONSULTADAS  ##############-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <br>
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
                    <button id="btn-submit-dimensionEditFamilia" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>