<div id="modalAddFormacion" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formFormacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_formacion" name="id_formacion" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-formacion">Formación Academica</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nivel_escolaridad_edit" class="control-label">Nivel de Escolaridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="nivel_escolaridad_edit" name="nivel_escolaridad_edit" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE DE LA INSTITUCION -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nombre_institucion_edit" class="control-label">Nombre de la Institución: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_institucion_edit" id="nombre_institucion_edit" placeholder="Ingrese el Nombre de la Institucion del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PROGRAMA ACADEMICO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="programa_academico_edit" class="control-label">Programa Academico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="programa_academico_edit" id="programa_academico_edit" placeholder="Ingrese el Programa Academico del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE GRADUACIÓN -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="fch_grado_edit" class="control-label">Fecha de Graduacion: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_grado_edit" id="fch_grado_edit" placeholder="Ingrese Fecha de Graduación" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ACTA Y FOLIO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="acta_folio_edit" class="control-label">Acta y Folio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="acta_folio_edit" id="acta_folio_edit" placeholder="Ingrese Acta y Folio" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-formacionn" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>