<?php
function autorizacionPdf($pdf, $id_solicitud, $id_servicio)
{
    // Configuración básica del PDF
    
    $auto = CtrSolCandidato::SolAutoById($id_solicitud);

    if ($auto['data'][0] != null) {

    $pdf->AddPage();
    
    $resp = CtrSolSolicitud::findById($id_solicitud);
    $solicitud = null;
    if (Result::isSuccess($resp))
        $solicitud = Result::getData($resp);
    //print_r($solicitud);

    //data de autorizacion
    //$auto = CtrSolCandidato::SolAutoById($id_solicitud);
    
    
    // Inicializamos
    $contactar_empleador = "SI ___   NO ___";
    $grabacion           = "SI ___   NO ___";
    $registro_foto       = "SI ___   NO ___";
    $acepto              = "SI ___   NO ___";

    // Contactar empleador
    if (isset($auto['data'][0]['contactar_empleador']) && $auto['data'][0]['contactar_empleador'] == 'S') {
        $contactar_empleador = "SI  X    NO ___";
    } else if (isset($auto['data'][0]['contactar_empleador']) && $auto['data'][0]['contactar_empleador'] == 'N') {
        $contactar_empleador = "SI ___   NO  X";
    }

    // Grabación
    if (isset($auto['data'][0]['grabacion']) && $auto['data'][0]['grabacion'] == 'S') {
        $grabacion = "SI  X    NO ___";
    } else if (isset($auto['data'][0]['grabacion']) && $auto['data'][0]['grabacion'] == 'N') {
        $grabacion = "SI ___   NO  X";
    }

    // Registro fotográfico
    if (isset($auto['data'][0]['registro_foto']) && $auto['data'][0]['registro_foto'] == 'S') {
        $registro_foto = "SI  X    NO ___";
    } else if (isset($auto['data'][0]['registro_foto']) && $auto['data'][0]['registro_foto'] == 'N') {
        $registro_foto = "SI ___   NO  X";
    }

    // Acepto
    if (isset($auto['data'][0]['acepto']) && $auto['data'][0]['acepto'] == 'S') {
        $acepto = "SI  X    NO ___";
    } else if (isset($auto['data'][0]['acepto']) && $auto['data'][0]['acepto'] == 'N') {
        $acepto = "SI ___   NO  X";
    }


    // Título
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 10, utf8_decode('FORMATO DE AUTORIZACIÓN ESTUDIO DE CONFIABILIDAD'), 0, 1, 'C');
    
    // Subtítulo (Código y Fecha)
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, utf8_decode('CÓDIGO: FMEC-03'), 0, 1, 'C');
    $pdf->Cell(0, 6, utf8_decode('FECHA: Marzo 31 de 2025; V4'), 0, 1, 'C');
    $pdf->Ln(0);

    // Fecha dinámica
    $pdf->SetFont('Arial', 'B', 8);
    $fecha = '';
    if (!empty($auto['data'][0]['fch_candidato_auto'])) {
        $fecha = date("d-m-Y", strtotime($auto['data'][0]['fch_candidato_auto']));
    }

    $pdf->Cell(0, 10, utf8_decode('Fecha: ' . $fecha), 0, 1, 'L');
    $pdf->Ln(0);

    // Contenido del documento
    $pdf->SetFont('Arial', '', 8);
    $texto = utf8_decode("Yo ".$solicitud['nombre_candidato']. " Identificado(a) con Cédula de Ciudadanía No. ".$solicitud['numero_documento']. " expedida en ".$solicitud['ciudad_exp']." ".$solicitud['fch_expedicion'].", dando conformidad con la ley 1581 de 2012, el decreto reglamentario 1377 de 2013 y la Ley 1266 de 2008 modificada por la Ley 2157 de 2021, autorizo a la empresa PROHUMANOS ALIADOS ESTRATEGICOS LTDA., para que le dé el tratamiento respectivo a mis datos personales y demás información suministrada o requerida para realizar el estudio de confiabilidad de ingreso a la empresa " .$solicitud['cliente_desc']." , así como durante la vigencia de la relación laboral en caso de ser contrato o la vinculación laboral ya existente, la compañía pueda solicitar, recolectar, recaudar, almacenar, usar, circular, suprimir, procesar, compilar, intercambiar, dar tratamiento, actualizar, conservar, remitir a la Entidad y disponer de los datos que han sido suministrados y los asociados en distintas bases o bancos de datos tales como son Administradores del Sistema de Seguridad Social, Centrales de Riesgo Financiero (si es el caso), autoridades judiciales de Policía, la Procuraduría General de la República, la Contraloría General de la Nación o cualquier otra fuente de información legalmente constituida. De igual forma, autorizo a la empresa para que adelante los procesos de verificación de información de la hoja de vida (experiencia laboral y formación académica), realización de visita domiciliaria e indagar con mi círculo social y/o aquellas personas que puedan dar fe que me conocen, con el fin de confirmar la información suministrada durante el proceso, para corroborar el objeto de la presente autorización.");
    $pdf->MultiCell(0, 6, $texto);

    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, utf8_decode("Confirmo y acepto por medio del presente escrito, que he tenido acceso, he leído y he comprendido las políticas para el tratamiento de datos personales de la empresa PROHUMANOS ALIADOS ESTRATEGICOS LTDA.; así mismo confirmo que para el caso de la visita domiciliaria el profesional presentó carta de presentación o carné que lo acredita como funcionario de la empresa PROHUMANOS ALIADOS ESTRATEGICOS LTDA."));
    $pdf->Ln(5);

    $pdf->Cell(0, 5, utf8_decode('	Si no marca la anterior opción, damos por entendido que se verificarán todas las experiencias laborales de los últimos 5 años.'), 0, 1);
    $pdf->Cell(0, 5, utf8_decode('	A realizar la validación académica en las siguientes instituciones: '.$auto['data'][0]['instituciones']), 0, 1);
    // Opciones SI / NO
    $pdf->Cell(0, 5, utf8_decode('Contactar a mi actual empleador (Área de recursos humanos y jefe inmediato), '. $contactar_empleador), 0, 1);

    $pdf->Cell(0, 5, utf8_decode('	Se realice grabación de la visita domiciliaria '.$grabacion), 0, 1);
    $pdf->Cell(0, 5, utf8_decode('	Registro fotográfico del interior y exterior de la vivienda '.$registro_foto), 0, 1);


    //$pdf->Ln(5);

/*
        // FIRMA DE USUARIO
        $auto['data'][0]['directorio'];

        $filename_proveedor = $auto['data'][0]['directorio']."/".$auto['data'][0]['nombre_encr'];
        $y_firma = $pdf->GetY(); // Guardamos la posición Y para ambas firmas


        // Imprimir firma de proveedor al lado derecho de la firma de calidad
        $pdf->SetXY(20, $y_firma);
        //print_r($auto['data'][0]['directorio']."/".$auto['data'][0]['nombre_encr']);
        if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
            
            $pdf->Image($filename_proveedor, 25, $y_firma-25, 30, 25, substr(strrchr($filename_proveedor, "."), 1));
        } else {
            // Mostrar mensaje si falta la firma
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(20, $y_firma); // Ajustar posición para centrar el mensaje en el espacio de la firma
            $pdf->Cell(30, 5, "", 0, 0, 'C');
        }
*/

    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);

    // Texto "Firma:" sin salto de línea
    $pdf->Cell(20, 8, utf8_decode('Firma:'), 0, 0, 'L');

    // FIRMA DE USUARIO
    $filename_proveedor = $auto['data'][0]['directorio'] . "/" . $auto['data'][0]['nombre_encr'];
    // Guardar coordenadas después del texto
    $x_firma = $pdf->GetX() + 3; // un pequeño espacio de separación
    $y_firma = $pdf->GetY() - 4; // subir un poco para que quede alineado
    // Llamada a la función (x = 20, y = $y_firma, tamaño ya definido en la función)
    insertarImagenOPDF2($pdf, $filename_proveedor, "", $x_firma, $y_firma);


    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 8);

    $pdf->MultiCell(0, 6, utf8_decode("Dar clic en el cuadro de acepto y comprendo la información anteriormente relacionada, autorizo a la empresa PROHUMANOS ALIADOS ESTRATEGICOS LTDA., en el uso de mis datos personales y documentos proporcionados para el desarrollo del estudio de confiabilidad."));
    $pdf->Ln(5);

    $pdf->Cell(0, 8, utf8_decode('Acepto y comprendo '.$acepto), 0, 1);

    // Pie de página
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 6, utf8_decode('Dirección: Calle 66 # 11 50, Oficina 311. Bogotá- Colombia'), 0, 1, 'C');
    $pdf->Cell(0, 6, utf8_decode('Teléfono: 7330717 Celular: 3143324470; www.prohumanos.com'), 0, 1, 'C');
}
}
function insertarImagenOPDF2($pdf, $filename, $titulo, $x, $y) {
    if (!empty($filename) && file_exists($filename)) {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        try {
            if ($extension === 'pdf') {
                // Cargar PDF y extraer primera página
                $pdf->setSourceFile($filename);
                $tpl = $pdf->importPage(1);
                $pdf->useTemplate($tpl, $x, $y, 30, 25); // Firma en PDF
            } else {
                // Insertar imagen
                $pdf->Image($filename, $x, $y, 30, 25);
            }
        } catch (Exception $e) {
            // Mostrar error
            //$pdf->SetXY($x, $y + 20);
            //$pdf->SetFont('Arial', '', 7);
            //$pdf->SetTextColor(255, 0, 0);
            //$pdf->Cell(82, 5, 'Error: ' . $e->getMessage(), 0, 0, 'C');
        }

        // Título debajo de la firma
        $pdf->SetXY($x, $y + 30);
        $pdf->SetFont('Arial', 'B', 7);
    }
}
