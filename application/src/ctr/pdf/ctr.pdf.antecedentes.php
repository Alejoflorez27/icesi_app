<?php
function infAntecedentes($pdf, $id_solicitud, $id_servicio)
{
    //$pdf->AddPage();
   

    $pdf->Ln(5);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DEL NIVEL DE CONFIABILIDAD DE INFORMACIÓN, DOCUMENTACIÓN Y ANTECEDENTES ACADÉMICOS '), 0, 2, 'C', 0);
    //$pdf->Ln(3);

    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 11);
/*
    $y2 = $pdf->GetY();
    $pdf->SetXY(10, $y2);
    $pdf->SetFillColor(0, 192, 239);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(47, 5, utf8_decode("RIESGO INEXISTENTE"), 1, 0, 'C', 1);

    $pdf->SetFillColor(0, 166, 90);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(48, 5, utf8_decode("RIESGO BAJO"), 1, 0, 'C', 1);

    $pdf->SetFillColor(243, 156, 16);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(47, 5, utf8_decode("RIESGO INTERMEDIO"), 1, 0, 'C', 1);

    $pdf->SetFillColor(221, 75, 57);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(48, 5, utf8_decode("RIESGO ALTO"), 1, 0, 'C', 1);


    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetFillColor(0, 192, 239);
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada, la información documental o de antecedentes, es totalmente confiable y se ajusta totalmente a las necesidades del cargo. A. Ajuste documental entre un 95% y 100% B. Nivel de importancia del antecedente o reporte para la empresa cliente.'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(57, $y2 - 40);
    $pdf->SetFillColor(0, 166, 90);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada, la información documental o de antecedentes, es confiable y se ajusta en un alto nivel a las necesidades del cargo. A. Ajuste documental entre un 90% y 95% B. Nivel de importancia del antecedente o reporte para la empresa cliente .'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(105, $y2 - 35);
    //  $pdf->SetXY(105,147);
    $pdf->SetFillColor(243, 156, 16);
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada la información documental o de antecedentes, es medianamente confiable y se ajusta en medio nivel a las necesidades del cargo. A. Ajuste documental entre un 85% y 90% B. Nivel de importancia del antecedente o reporte para la empresa cliente .'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(152, $y2 - 40);
    //$pdf->SetXY(152,147);
    $pdf->SetFillColor(221, 75, 57);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada la información documental o de antecedentes, es poco confiable y se ajusta poco a las necesidades del cargo. A. Ajuste documental entre un 80% y 85% b. Nivel de importancia del antecedente o reporte para la empresa cliente .'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(10, $y2);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->SetFillColor(0, 173, 215);
    $pdf->Cell(47, 5, utf8_decode('Nivel de riesgo 0'), 1, 0, 'C', 1);
    $pdf->SetFillColor(0, 149, 81);
    $pdf->Cell(48, 5, utf8_decode('Nivel de riesgo 1'), 1, 0, 'C', 1);
    $pdf->SetFillColor(218, 149, 81);
    $pdf->Cell(47, 5, utf8_decode('Nivel de riesgo 2'), 1, 0, 'C', 1);
    $pdf->SetFillColor(199, 67, 51);
    $pdf->Cell(48, 5, utf8_decode('Nivel de riesgo 3'), 1, 2, 'C', 1);
    $pdf->Ln(0);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->SetFillColor(0, 173, 215);
    $pdf->Cell(47, 5, utf8_decode('Porcentaje Menor a 1'), 1, 0, 'C', 1);
    $pdf->SetFillColor(0, 149, 81);
    $pdf->Cell(48, 5, utf8_decode('Porcentaje entre 1-45'), 1, 0, 'C', 1);
    $pdf->SetFillColor(218, 149, 81);
    $pdf->Cell(47, 5, utf8_decode('Porcentaje entre 46-75'), 1, 0, 'C', 1);
    $pdf->SetFillColor(199, 67, 51);
    $pdf->Cell(48, 5, utf8_decode('Porcentaje entre 76-100'), 1, 2, 'C', 1);
*/

    //$pdf->Ln(4);
    $i = 0;
    foreach ($porcentaje['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(95, 5, utf8_decode($row['nombre_dimension']), 1, 0, 'L', 1);

        /*  $pdf->Cell(12,5,$row['porcentaje'].'%',1,0,'C',0); */
        // $pdf->Cell(2, 5, '', 0, 0, 'C', 0);
        if ($row['porcentaje'] <= 1) {
            $pdf->SetFillColor(0, 192, 239);
        } elseif ($row['porcentaje'] > 1 && $row['porcentaje'] <= 45) {
            $pdf->SetFillColor(0, 166, 90);
        } elseif ($row['porcentaje'] > 46 && $row['porcentaje'] <= 75) {
            $pdf->SetFillColor(243, 156, 16);
        } elseif ($row['porcentaje'] > 75 && $row['porcentaje'] <= 100) {
            $pdf->SetFillColor(221, 75, 57);
        }

        $tamSize = 95;

        $pdf->Cell($tamSize, 5, $row['porcentaje'] . '%', 1, 0, 'R', 1);

        $y2 = $pdf->GetY();
        $pdf->SetXY(10, $y2);
        $pdf->SetFont('Arial', '', 8);

        $pdf->Ln(2);
        $i = $i + 1;
    }

    $pdf->Ln(5);

    //$varXA = 0;
    //$varYA = 0;



/*$dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 11, $id_servicio);

// Establecer el formato inicial y las cabeceras
$pdf->SetFillColor(174, 214, 241);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode("TIPO DE LISTAS"), 1, 0, 'C', 1);
$pdf->Cell(140, 5, utf8_decode("FUENTE CONSULTADAS"), 1, 0, 'C', 1);
$pdf->Cell(20, 5, utf8_decode("HALLAZGOS"), 1, 0, 'C', 1);
$pdf->Ln(5);*/

// Definir la función personalizada
/*function pintarCeldaMulti($pdf, $x, $y, $ancho, $altura, $texto, $bordes = 1, $alineacion = 'L', $relleno = false) {
    // Guardar la posición inicial
    $pdf->SetXY($x, $y);
    // Dividir el texto en líneas si es necesario
    $pdf->MultiCell($ancho, 5, utf8_decode($texto), $bordes, $alineacion, $relleno);
    // Calcular la altura total de las líneas generadas por MultiCell
    $nueva_altura = $pdf->GetY() - $y;
    // Ajustar la altura de la celda si es menor que la altura proporcionada
    if ($nueva_altura < $altura) {
        $pdf->SetXY($x, $y + $nueva_altura);
        $pdf->Cell($ancho, $altura - $nueva_altura, '', $bordes, 0, $alineacion, $relleno);
    }
}

foreach ($dimFamiliar['data'] as $row) {
    // Obtener las fuentes consultadas para cada pregunta
    $fuenteConsultada = CtrDimRespuestas::fuentesConsultadas($id_solicitud, $id_servicio, $row['id_pregunta']);
    $fuente_array = [];
    $texto_completo_array = [];

    // Procesar cada fuente consultada
    foreach ($fuenteConsultada['data'] as $rowF) {
        $fuente_array[] = [
            'fuente' => $rowF['fuente'],
            'descripcion' => $rowF['descripcion']
        ];

        // Si no hay hallazgos, agregar texto completo a la lista
        if (strpos($rowF['texto_completo'], 'Sin hallazgo') === false) {
            $texto_completo_array[] = $rowF['texto_completo'];
        }
    }

    // Calcular la altura de la celda para las fuentes consultadas
    $altura_celda = max(count($fuente_array), 1) * 5;

    // Guardar la posición actual
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Renderizar la celda con el nombre de la pregunta usando la función personalizada
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 8);
    pintarCeldaMulti($pdf, $x, $y, 30, $altura_celda, $row['nombre_pregunta'], 1, 'L', 0);

    // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
    $current_y = $y;
    foreach ($fuente_array as $index => $fuente_row) {
        pintarCeldaMulti($pdf, $x + 30, $current_y, 140, 5, $fuente_row['fuente'], 1, 'L', 0);
        pintarCeldaMulti($pdf, $x + 170, $current_y, 20, 5, $fuente_row['descripcion'], 1, 'L', 0);
        $current_y += 5;
    }
    $pdf->SetY($current_y + 5); // Asegúrate de dejar un pequeño espacio entre cada sección
    // Mostrar el contenido concatenado del array de observaciones
    $texto_completo_concatenado = implode(", ", $texto_completo_array);
    pintarCeldaMulti($pdf, $x, $current_y, 190, 5, 'Observacion: ' . $texto_completo_concatenado, 1, 'J', 0);

    // Ajustar la posición Y para la próxima celda nombre_pregunta
    $pdf->SetY($current_y + 5); // Asegúrate de dejar un pequeño espacio entre cada sección
}*/
/*$dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 11, $id_servicio);

// Establecer el formato inicial y las cabeceras
$pdf->SetFillColor(174, 214, 241);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, utf8_decode("TIPO DE LISTAS"), 1, 0, 'C', 1);
$pdf->Cell(140, 5, utf8_decode("FUENTE CONSULTADAS"), 1, 0, 'C', 1);
$pdf->Cell(20, 5, utf8_decode("HALLAZGOS"), 1, 0, 'C', 1);
$pdf->Ln(5);

$fuenteConsultada = CtrDimRespuestas::fuentesConsultadas($id_solicitud, $id_servicio, $row['id_pregunta']);

$pdf->SetWidths(array(15, 15, 8, 20, 15, 15, 15, 15, 20,15, 16, 20));
$pdf->SetAligns(array('L', 'C', 'L'));
foreach ($fuenteConsultada['data'] as $row) {
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Row(array(utf8_decode($row['descripcion_parentesco']), 
                    utf8_decode($row['nombre']), 
                    utf8_decode($row['edad']), 
                    utf8_decode($row['telefono']),
                    utf8_decode($row['nombre_pais']),
                    utf8_decode(ucfirst(strtolower($row['descripcion_ciudad']))),
                    utf8_decode($row['descripcion_estado_civil']),
                    utf8_decode($row['empresa']),
                    utf8_decode($row['ocupacion']),
                    utf8_decode($row['descripcion_niv_escol']),
                    utf8_decode($row['descripcion_viv_candidato']),
                    utf8_decode($row['descripcion_depende_candidato']),
                ));
}
    $pdf->Ln(8);*/
    $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 11, $id_servicio);
    $pdf->SetFillColor(207, 207, 207);
    // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(190, 5, utf8_decode("TIPO DE LISTAS Y FUENTES CONSULTADAS"), 1, 0, 'C', 1);
    //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    foreach ($dimFamiliar['data'] as $row) {
        // Obtener las fuentes consultadas para cada pregunta
        $fuenteConsultada = CtrDimRespuestas::fuentesConsultadas($id_solicitud, $id_servicio, $row['id_pregunta']);
        $fuente_array = [];
        $texto_completo_array = [];

        // Procesar cada fuente consultada
        foreach ($fuenteConsultada['data'] as $rowF) {
            $fuente_array[] = [
                'fuente' => $rowF['fuente'],
                'descripcion' => $rowF['descripcion']
            ];

            // Si no hay hallazgos, agregar texto completo a la lista
            if (strpos($rowF['texto_completo'], 'Sin hallazgo') === false) {
                $texto_completo_array[] = $rowF['texto_completo'];
            }
        }

        // Guardar la posición actual
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        /*// Encabezado de la sección
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode($row['nombre_pregunta']), 0, 0, 'L', 0);
        $pdf->Ln(8);*/
        $pdf->SetFillColor(207, 207, 207);
        // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(150, 5, utf8_decode($row['nombre_pregunta']), 1, 0, 'C', 1);
        $pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 8);

        $pdf->SetWidths(array(150, 40));
        $pdf->SetAligns(array('L', 'C'));
        foreach ($fuente_array as $fuente_row) {
            /*$pdf->Cell(120, 5, utf8_decode($fuente_row['fuente']), 1, 0, 'L', 0);
            $pdf->Cell(70, 5, utf8_decode($fuente_row['descripcion']), 1, 0, 'L', 0);
            $pdf->Ln(5);*/
            $pdf->Row(array(
                utf8_decode($fuente_row['fuente']),
                utf8_decode($fuente_row['descripcion'])
            ));
        }

        // Mostrar el contenido concatenado del array de observaciones
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('Observación'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(190, 5, utf8_decode(implode(", ", $texto_completo_array)), 1, 'L', 0);

        // Ajustar la posición Y para la próxima sección
        //$pdf->SetY($pdf->GetY() + 10); // Espacio entre secciones
    }

    //Firma de los proveedores
    $pdf->Ln(10);
    $solComboId = CtrSolSolicitud::qry_infSolicitudCombo($id_solicitud, $id_servicio);
    // Determinar datos del proveedor
    if ($solComboId['data'][0]['resultado'] == 1){
        $idProveedor = $solComboId['data'][0]['id_usuario_asig'];
        $nomProveedor = $solComboId['data'][0]['nombre_proveedor'];
        $registroProveedor = $solComboId['data'][0]['registro'];
    }
    // FIRMA DE PROVEEDOR

    // Consultar datos del proveedor
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    $firma_proveedor = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_asig']);
    $filename_proveedor = $firma_proveedor['directorio'] . $firma_proveedor['nombre_encr'];

    // Altura requerida (firma + texto)
    $alturaFirma = 40; // Ajusta según diseño
    $posicionY = $pdf->GetY();
    $margenInferior = 10; // Margen inferior típico FPDF
    $alturaPagina = $pdf->GetPageHeight() - $margenInferior;

    // Si no hay espacio suficiente, crear nueva página
    if ($posicionY + $alturaFirma > $alturaPagina) {
        $pdf->AddPage();
        $posicionY = $pdf->GetY();
    }

    // Posicionar para la firma
    $pdf->SetXY(20, $posicionY);

    // Insertar imagen de la firma si existe
    if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
        $pdf->Image($filename_proveedor, 25, $posicionY - 8, 25, 20, substr(strrchr($filename_proveedor, "."), 1));
    } else {
        // Si no hay firma, dejar espacio (o mostrar mensaje opcional)
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(20, $posicionY + 20);
        $pdf->Cell(30, 5, "", 0, 0, 'C');
    }

    // Mostrar texto si aplica
    if ($solComboId['data'][0]['resultado'] == 1) {
        // Título
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->Cell(80, 5, "Nombre y Firma del Analista de Riesgo", 0, 1, 'L');

        // Nombre
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 5, utf8_decode($nomProveedor), 0, 1, 'L');

        // Registro
        $pdf->Cell(80, 5, utf8_decode($registroProveedor), 0, 1, 'L');
    }





}
