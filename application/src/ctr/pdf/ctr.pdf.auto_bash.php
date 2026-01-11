<?php

function generarSolicitudAccesoPDF($usuarioSesion, $id_empresa_tabla, $id_auto)
{
    //print_r($id_empresa_tabla);
    $id_empresa_list = null;
    // Obtener usuario de la app
    $usuario = CtrUsuario::getUsuarioApp();
    $respuesta_usr = CtrUsuario::consultar($usuario);
    $id_empresa = $respuesta_usr['id_empresa'];

    if ($id_empresa_tabla != null) {
        $id_empresa_list = $id_empresa_tabla;
    }else{
        $id_empresa_list = $id_empresa;
    }
    

    // Consultar datos de la empresa
    $tcr_empresa = CtrTrcEmpresa::findById($id_empresa_list);
    $empresaData = $tcr_empresa['data'];

    // Consultar usuarios
    $usr_empresa = CtrUsuario::findByUsrXEmpresa($id_empresa_list);

    $auto = CtrTrcEmpresa::findByAutoBashAnos($id_empresa_list, $id_auto);

    //print_r($auto);

    $fecha_auto = $auto['data']['fch_cliente_auto'];

    // Crear PDF con márgenes
    $pdf = new FPDF();
    $pdf->SetMargins(20, 15, 20); // Márgenes: Izq, Sup, Der
    $pdf->AddPage();
    //$pdf->Ln(10);

    if (file_exists('upload/image/sitio/logoedsalud.png')) {
        $pdf->Image('upload/image/sitio/logoedsalud.png', 20, 10, 30);
    }

    // Encabezado centrado
    $pdf->SetXY(60, 20);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(130, 6, utf8_decode("SOLICITUD ACCESO A USUARIOS A LAS TIC PROHUMANOS\nCÓDIGO: FMIT-005 | FECHA: 11/02/2025, V2"), 0, 'C');
    $pdf->Ln(10);

    // Fecha actual en español
    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'spanish');
    $fecha_actual = utf8_encode(strftime("%d de %B de %Y"));
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, utf8_decode('FECHA: ' . $fecha_auto), 0, 1);
    $pdf->Ln(3);

    // Tabla de datos de la empresa
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(240, 240, 240);


 $pdf->SetFont('Arial', 'B', 8);

// Ancho total de la página (A4 con márgenes)
$anchoTotal = 190;

// Anchos de cada columna
$col1 = 40;
$col2 = 50;
$col3 = 35;
$col4 = 55;

// Altura de cada fila
$alto = 10;

// Primera fila
$pdf->Cell($col1, $alto, utf8_decode('NOMBRE DE LA EMPRESA:'), 1, 0, 'L');
$pdf->Cell(0, $alto, utf8_decode($empresaData['razon_social']), 1, 1, 'L');
$pdf->Cell($col1, $alto, utf8_decode('REPRESENTANTE LEGAL:'), 1, 0, 'L');
$pdf->Cell(0, $alto, utf8_decode($empresaData['rep_legal']), 1, 1, 'L');
$pdf->Cell($col1, $alto, 'NIT:', 1, 0, 'L');
$pdf->Cell($col3, $alto, utf8_decode($empresaData['numero_doc']), 1, 0, 'L');

// Segunda fila

$pdf->Cell($col3, $alto, utf8_decode('DIRECCIÓN/CIUDAD:'), 1, 0, 'L');
$pdf->Cell(0, $alto, utf8_decode($empresaData['direccion']) , 1, 1, 'L');

// Tercera fila
$pdf->Cell($col1, $alto, utf8_decode('TELÉFONO:'), 1, 0, 'L');
$pdf->Cell($col3, $alto, utf8_decode($empresaData['celular']), 1, 0, 'L');
$pdf->Cell($col3, $alto, utf8_decode('CORREO PRINCIPAL:'), 1, 0, 'L');
$pdf->Cell(0, $alto, utf8_decode($empresaData['email_emp']), 1, 1, 'L');


    // Instrucciones
$pdf->Ln(10); // Salto de línea antes de empezar la sección
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, utf8_decode('INSTRUCCIONES PARA DILIGENCIAR EL FORMATO'), 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, utf8_decode("1. Vo.Bo. La autorización debe ser otorgada por el gerente general o representante legal de la empresa con quien se firma el contrato de prestación de servicios o el funcionario que vigila el acuerdo de servicios."));
$pdf->MultiCell(0, 5, utf8_decode("2. USUARIO AUTORIZADO: Relacionar los datos completos de los usuarios a los que se les va a dar acceso y el perfil correspondiente para cada uno."));
$pdf->MultiCell(0, 5, utf8_decode("3. PERFILES:"), 0, 1);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, utf8_decode('PERFILES:'), 0, 1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 6, utf8_decode('3.1 USUARIO ADMINISTRADOR:'), 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->SetX(30);
$pdf->MultiCell(0, 5, utf8_decode("* Tiene privilegios para acceder a todos los informes de los procesos solicitados por los diferentes usuarios creados para la compañía.\n* Tiene acceso a los procesos activos e históricos\n* Hacer seguimiento a los analistas (Usuarios operativos) que se encuentren activos\n* Puede generar solicitudes de proceso nuevos, los cuales los analistas (usuario operativo) no tendrán acceso o conocimiento de estos."));

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 6, utf8_decode('3.2 SOLICITANTE CON INFORME (ANALISTA):'), 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->SetX(30);
$pdf->MultiCell(0, 5, utf8_decode("* Generar las solicitudes de proceso.\n* Realizar seguimiento de estos.\n* Descargar los informes y documentos generados de cada proceso."));

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 6, utf8_decode('3.3 SOLICITANTE SIN INFORME:'), 0, 1);

$pdf->SetFont('Arial', '', 9);
$pdf->SetX(30);
$pdf->MultiCell(0, 5, utf8_decode("* Generar las solicitudes de proceso.\n* Realizar seguimiento de estos.\n* No Descargar los informes y documentos generados de cada proceso."));

    $pdf->Ln(10);

    // Usuarios en tablas
    if ($usr_empresa['status'] == 'success') {
        foreach ($usr_empresa['data'] as $index => $usuario) {
            $usuario_num = $index + 1;

            $perfil_admin = ($usuario['perfil_desc'] == 'Administrador' || $usuario['perfil_desc'] == 'Cliente Administrador') ? 'X' : '';
            $perfil_informe = ($usuario['perfil_desc'] == 'Cliente Con Informe') ? 'X' : '';
            $perfil_sin_informe = ($usuario['perfil_desc'] == 'Cliente Sin Informe') ? 'X' : '';

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(80, 8, utf8_decode("USUARIO $usuario_num"), 1, 0, 'C');

            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 8, utf8_decode("Administrador [$perfil_admin]  Con Informe [$perfil_informe]  Sin Informe [$perfil_sin_informe]"), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Tipo y Número de Identificación:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode($usuario['tipo_identificacion'] . ' ' . $usuario['numero_identificacion']), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Nombres y Apellidos:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode($usuario['nombres'] . ' ' . $usuario['apellidos']), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Correo Corporativo:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode($usuario['correo']), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Cargo:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode($usuario['cargo']), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Teléfono:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode(''), 1, 1);
            $pdf->Cell(80, 8, utf8_decode('Firma:'), 1, 0);
            $pdf->Cell(95, 8, utf8_decode(''), 1, 1);
            $pdf->Ln(5);
        }
    } else {
        $pdf->Cell(0, 8, utf8_decode('No se encontraron usuarios para esta empresa.'), 0, 1);
    }

// Verificar si hay espacio suficiente antes de imprimir el bloque de firmas
if ($pdf->GetY() > 230) { // Si está cerca del final (230mm de altura)
    $pdf->AddPage(); // Añadir una nueva página
}

$pdf->Ln(10);
$auto = CtrTrcEmpresa::findByAutoBashAnos($id_empresa_list, $id_auto);

//print_r($auto['data']);

if ($auto['data'] != null) {
    // FIRMA DE USUARIO
    $filename_proveedor = $auto['data']['directorio']."/".$auto['data']['nombre_encr'];
    // Guardar coordenadas después del texto
    $x_firma = $pdf->GetX() + 3; // un pequeño espacio de separación
    $y_firma = $pdf->GetY() - 4; // subir un poco para que quede alineado
    // Llamada a la función (x = 20, y = $y_firma, tamaño ya definido en la función)
    insertarImagenOPDF2($pdf, $filename_proveedor, "", $x_firma, $y_firma);
/*    
    $y_firma = $pdf->GetY(); // Guardamos la posición Y para ambas firmas

    // Imprimir firma de proveedor al lado derecho
    $pdf->SetXY(20, $y_firma);
    if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
        $pdf->Image($filename_proveedor, 25, $y_firma-10, 30, 25, substr(strrchr($filename_proveedor, "."), 1));
    } else {
        // Mostrar espacio si no hay firma
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(20, $y_firma);
        $pdf->Cell(30, 5, "", 0, 0, 'C');
    }
*/
}

// Bloque de firma
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 10, utf8_decode('Firma Autorizado por:'), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Nombre: ' . $auto['data']['nombres'] . " " . $auto['data']['apellidos']), 0, 1);
$pdf->MultiCell(0, 8, utf8_decode('Representante legal y/o funcionario que vigila el acuerdo de servicios.'), 0, 'L');


    // Salida del PDF
    $pdf->Output();
}




