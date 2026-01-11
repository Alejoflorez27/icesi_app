<?php

$usuario = CtrUsuario::getUsuarioApp();
$respuesta_usr = CtrUsuario::consultar($usuario);
$empresa = $respuesta_usr['id_empresa'];

$usr_empresa = CtrUsuario::findByUsrXEmpresa($empresa);

$tcr_empresa = CtrTrcEmpresa::findById($empresa);



    //print_r($tcr_empresa);
?>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #000;
        /*margin: 20px;*/
    }

    .header-page {
        background: #ffc107;
        color: #000;
        padding: 15px;
        font-size: 22px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #000;
        opacity: 0.7;
        cursor: pointer;
    }

    .btn-close:hover {
        opacity: 1;
    }

.content-page {
    padding: 20px;
    margin: 20px auto; /* centrado con margen arriba/abajo */
    max-width: 1000px; /* opcional, para limitar el ancho */
    background: #ffffff;
}

    .footer-page {
        padding: 15px 20px;
        text-align: right;
        background: #f8f9fa;
        border-top: 1px solid #ddd;
        margin-top: 30px;
    }

    .header {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .header img {
        width: 120px;
        display: block;
        margin: 0 auto;
    }

    .section-title {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    td, th {
        border: 1px solid #000;
        padding: 6px;
    }

    ol, ul {
        margin-left: 20px;
    }

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

    .signature-block {
        margin-top: 40px;
        text-align: left;
        padding-top: 20px;
    }

    .signature-line {
        display: inline-block;
        width: 60%;
        border-bottom: 1px solid #000;
        height: 20px;
        margin-bottom: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: #fff;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #fa0101ff;
        border: none;
        color: #fff;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: #d42222ff;
    }
</style>

<!-- Pantalla completa -->
<div style="width: 100%; margin: 0 auto;">

    <!-- Encabezado 
    <div class="header-page">
        <h4>⚠️ Autorización Bash</h4>
        <button type="button" class="btn-close" onclick="window.history.back();">&times;</button>
    </div>-->

    <!-- Contenido -->
    <div class="content-page">

        <form id="frmCargarArchivo" method="post" enctype="multipart/form-data">
            <!-- Inputs ocultos -->
            <input type="hidden" id="perfil_usuario" name="perfil_usuario" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']; ?>">
            <input type="hidden" id="bandera" name="bandera" value="<?= $_SESSION[constant('APP_NAME')]['user']['bandera_bash']; ?>">
            <input type="hidden" id="usuario" name="usuario" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']; ?>">
            <input type="hidden" id="id_empresa" name="id_empresa" value="<?= $_SESSION[constant('APP_NAME')]['user']['id_empresa']; ?>">
            <input type="hidden" id="primer_acceso" name="primer_acceso" value="<?= $_SESSION[constant('APP_NAME')]['user']['primer_acceso']; ?>">
            <input type="hidden" id="id_auto" name="id_auto" value="">

            <!-- Checkbox 
            <div class="checkbox" style="margin-bottom: 20px;">
                <label>
                    <input type="checkbox" id="checkLeidoLectura">
                    Yo, usuario, autorizo a Prohumanos para el tratamiento de mis datos personales conforme a la Política de Privacidad.
                </label>
            </div>-->

            <!-- Encabezado formulario -->
            <div class="header">
                <img src="/upload/image/sitio/logolargoProhumanos.png" class="img-responsive" alt="Prohumanos App">
                <p>SOLICITUD ACCESO A USUARIOS A LAS TIC PROHUMANOS</p>
                <p><b>CÓDIGO:</b> FMIT-005 | <b>FECHA:</b> 11/02/2025, V2</p>
            </div>


                <?php
                $tcr_empresa = CtrTrcEmpresa::findById($empresa);

                if ($tcr_empresa['status'] == 'success' && !empty($tcr_empresa['data'])) {
                    $empresaData = $tcr_empresa['data'];
                ?>

            <!-- Fecha -->
            <?php
            setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'spanish'); 
            $fecha_actual = strftime("%d de %B de %Y");
            ?>
            <p><b>FECHA:</b> _____ <?php echo ucfirst($fecha_actual); ?>____</p>


            <!-- Datos empresa -->
            <table border="1" style="width:100%; border-collapse:collapse; margin-bottom:15px;">
                <tr>
                    <td><b>NOMBRE DE LA EMPRESA:</b> <?php echo htmlspecialchars($empresaData['razon_social']); ?></td>
                    <td><b>NIT:</b> <?php echo htmlspecialchars($empresaData['numero_doc']); ?></td>
                </tr>
                <tr>
                    <td><b>REPRESENTANTE LEGAL:</b> <?php echo htmlspecialchars($empresaData['rep_legal']); ?></td>
                    <td><b>DIRECCIÓN/CIUDAD:</b> <?php echo htmlspecialchars($empresaData['direccion'] . ' / ' . $empresaData['nombre_ciudad']); ?></td>
                </tr>
                <tr>
                    <td><b>TELÉFONO:</b> <?php echo htmlspecialchars($empresaData['celular']); ?></td>
                    <td><b>CORREO PRINCIPAL:</b> <?php echo htmlspecialchars($empresaData['email_emp']); ?></td>
                </tr>
            </table>

            <?php
            } else {
                echo '<p>No se encontraron datos de la empresa.</p>';
            }
            ?>


            <!-- Instrucciones -->
            <div class="section-title">INSTRUCCIONES PARA DILIGENCIAR EL FORMATO</div>
            <ol>
                <li><b>Vo.Bo.</b> La autorización debe ser otorgada por el gerente general o representante legal  de 
la empresa con quien se firma el contrato de prestación de servicios o el funcionario que 
vigila el acuerdo de servicios. </li>
                <li><b>USUARIO AUTORIZADO:</b> Relacionar los datos completos de los usuarios a los que se 
les va a dar acceso y el perfil correspondiente para cada uno.</li>
                <li><b>PERFILES:</b></li>
            </ol>

            <!-- Perfiles -->
            <div class="section-title">PERFILES:</div>
            <p><b>3.1 USUARIO ADMINISTRADOR:</b></p>
            <ul>
                <li>Tiene privilegios para acceder a todos los informes de los procesos solicitados por los 
diferentes usuarios creados para la compañía.</li>
                <li>Tiene acceso a los procesos activos e históricos</li>
                <li>Hacer seguimiento a los analistas (Usuarios operativos) que se encuentren activos </li>
                <li>Puede generar solicitudes de procesos nuevos, los cuales los analistas (usuario 
operativo) no tendrán acceso o conocimiento de estos.  </li>
            </ul>

            <p><b>3.2 SOLICITANTE CON INFORME (ANALISTA):</b></p>
            <ul>
                <li>Generar las solicitudes de procesos</li>
                <li>Realizar seguimiento de estos. </li>
                <li>Descargar los informes y documentos generados de cada proceso.</li>
            </ul>

            <p><b>3.3 SOLICITANTE SIN INFORME:</b></p>
            <ul>
                <li>Generar las solicitudes de procesos. </li>
                <li>Realizar seguimiento de estos.</li>
                <li>No Descargar los informes y documentos generados de cada proceso.</li>
            </ul>



            <?php
            $usr_empresa = CtrUsuario::findByUsrXEmpresa($empresa);

            if ($usr_empresa['status'] == 'success' && !empty($usr_empresa['data'])) {
                foreach ($usr_empresa['data'] as $index => $usuario) {
                    $usuario_num = $index + 1;

                    // Verificación del perfil para marcar casilla
                    $perfil_admin = ($usuario['perfil_desc'] == 'Administrador' || $usuario['perfil_desc'] == 'Cliente Administrador') ? '_X_' : '___';
                    $perfil_informe = ($usuario['perfil_desc'] == 'Cliente Con Informe') ? '_X_' : '___';
                    $perfil_sin_informe = ($usuario['perfil_desc'] == 'Cliente Sin Informe') ? '_X_' : '___';
                    
                    echo '<table border="1" style="width:100%; margin-bottom:10px; border-collapse:collapse;">';
                    echo '<tr><th colspan="2">USUARIO ' . $usuario_num . '</th></tr>';
                    echo '<tr><td colspan="2">Administrador ' . $perfil_admin . '  Con Informe ' . $perfil_informe . '  Sin Informe ' . $perfil_sin_informe . '</td></tr>';
                    echo '<tr><td>Tipo y Número de Identificación:</td><td>' . htmlspecialchars($usuario['tipo_identificacion'] . ' ' . $usuario['numero_identificacion']) . '</td></tr>';
                    echo '<tr><td>Nombres y Apellidos:</td><td>' . htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) . '</td></tr>';
                    echo '<tr><td>Correo Corporativo:</td><td>' . htmlspecialchars($usuario['correo']) . '</td></tr>';
                    echo '<tr><td>Cargo:</td><td>' . htmlspecialchars($usuario['cargo']) . '</td></tr>';
                    echo '<tr><td>Teléfono:</td><td></td></tr>';
                    echo '<tr><td>Firma:</td><td></td></tr>';        
                    echo '</table>';
                }
            } else {
                echo '<p>No se encontraron usuarios para esta empresa.</p>';
            }
            ?>


            <!-- Subir firma -->
            <div style="margin-top: 15px;">
                <label for="archivo" class="lbl-subir">
                    <i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Firma
                </label>
                <input id="archivo" name="archivo" type="file" style="display:none;" accept=".jpg, .png, .pdf">
                <span id="info"></span>
            </div>

            <!-- Bloque de firma final -->
            <div class="signature-block">
                <p><span class=""></span><br><strong>Firma Autorizado por:</strong></p>
                <p><span class=""></span><br><strong>Nombre:</strong> <?= $_SESSION[constant('APP_NAME')]['user']['nombres']." ".$_SESSION[constant('APP_NAME')]['user']['apellidos']; ?></p>
                <p><b>Representante legal y/o funcionario que vigila el acuerdo de servicios.</b></p>
            </div>

    </div>

    <!-- Footer -->
    <div class="footer-page">

        <button type="button" 
                class="btn btn-danger btnIrPdf" 
                id_empresa="<?= $_SESSION[constant('APP_NAME')]['user']['id_empresa']; ?>">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF
        </button>



        <button id="btnCancelar" type="button" class="btn btn-secondary" onclick="window.history.back();">
            Salir
        </button>
        <button id="btn-submit-adjuntos" type="submit" class="btn btn-primary">
            Guardar Autorización
        </button>
    </div>
    </form>
</div>

<script src="<?= constant('APP_URL') ?>app/js/ini/auto_bash.js?v=<?= time() ?>"></script>
