<style>
    .lbl-subir {
        padding: 8px 15px;
        background: #f39c12;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        margin-bottom: 10px;
        text-align: center;
    }

    .lbl-subir:hover {
        background: #00a65a;
        color: #fff;
    }

    #info {
        display: block;
        margin-top: 5px;
        font-size: 14px;
        color: #555;
    }

    .modal-header h4 {
        font-weight: bold;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #000;
        opacity: 0.7;
        position: absolute;
        top: 10px;
        right: 15px;
    }

    .btn-close:hover {
        opacity: 1;
    }
</style>

<!-- Modal Lectura Obligatoria -->
<div class="modal fade" id="modalLecturaObligatoria" tabindex="-1" role="dialog" aria-labelledby="tituloLecturaObligatoria">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-warning text-dark" style="position: relative;">
        <h4 class="modal-title" id="tituloLecturaObligatoria">⚠️ Autorización Basc</h4>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
      </div>

      <!-- Body -->
      <div class="modal-body" style="font-size: 17px;">

        <!-- Formulario -->
        <form id="frmCargarArchivo" method="post" enctype="multipart/form-data">
          <!-- Campos ocultos -->
          <input type="hidden" id="perfil_usuario" name="perfil_usuario" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']; ?>">
          <input type="hidden" id="bandera" name="bandera" value="<?= $_SESSION[constant('APP_NAME')]['user']['bandera_bash']; ?>">
          <input type="hidden" id="usuario" name="usuario" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']; ?>">
          <input type="hidden" id="id_empresa" name="id_empresa" value="<?= $_SESSION[constant('APP_NAME')]['user']['id_empresa']; ?>">
          <input type="hidden" id="primer_acceso" name="primer_acceso" value="<?= $_SESSION[constant('APP_NAME')]['user']['primer_acceso']; ?>">

          <!-- Checkbox autorización -->
          <div class="checkbox">
            <label>
              <input type="checkbox" id="checkLeidoLectura">
              Yo, usuario, autorizo a Prohumanos para el tratamiento de mis datos personales conforme a la Política de Privacidad.
            </label>
          </div>

          <!-- Subida de archivo -->
          <div class="row" style="margin-top: 15px;">
            <div class="col-sm-6">
              <label for="archivo" class="lbl-subir">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Firma
              </label>
              <input id="archivo" name="archivo" type="file" style="display:none;" accept=".jpg, .png, .pdf">
              <span id="info"></span>
            </div>
          </div>
        
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button id="btnCerrarLectura" type="button" class="btn btn-default" data-dismiss="modal">
          Cerrar
        </button>
                      <button id="btn-submit-adjuntos" type="submit" class="btn btn-primary">
                Guardar Autorización
              </button>
      </div>
      </form>
    </div>
  </div>
</div>
