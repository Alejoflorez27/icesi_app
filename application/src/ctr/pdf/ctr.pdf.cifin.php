<?php
function infCifin($pdf, $id_solicitud, $id_servicio)
{

    //$pdf->AddPage();
    $Obligacion = CtrInfoOblFin::findAll($id_solicitud, $id_servicio);

    //COMPOSICIÓN FAMILIAR
    //$pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("CONFIABILIDAD FINANCIERA/CIFIN - CRÉDITOS Y OBLIGACIONES FINANCIERAS"), 0, 1, 'C', '0');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(21, 5, utf8_decode("Entidad"), 1, 0, 'C', 1);
    $pdf->Cell(25, 5, utf8_decode("Producto y clase"), 1, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode("Fch expedición"), 1, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode("Fch terminación"), 1, 0, 'C', 1);
    $pdf->Cell(15, 5, utf8_decode("Cupo inicial"), 1, 0, 'C', 1);
    $pdf->Cell(15, 5, utf8_decode("Saldo"), 1, 0, 'C', 1);
    $pdf->Cell(17, 5, utf8_decode("Pago minimo"), 1, 0, 'C', 1);
    $pdf->Cell(10, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
    $pdf->Cell(15, 5, utf8_decode("Calidad"), 1, 0, 'C', 1);
    $pdf->Cell(16, 5, utf8_decode("Vlr. Mora"), 1, 0, 'C', 1);
    $pdf->Cell(16, 5, utf8_decode("Edad Mora"), 1, 1, 'C', 1);


    $pdf->SetWidths(array(21, 25, 20, 20, 15, 15, 17, 10, 15, 16, 16));
    $pdf->SetAligns(array('L', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));

    foreach ($Obligacion['data'] as $row) {
        $pdf->SetFont('Arial', '', 7);
        $pdf->Row(array(
            utf8_decode(($row['entidad'])),
            utf8_decode(($row['producto_clase'])),
            utf8_decode(($row['fch_expedicion'])),
            utf8_decode(($row['fch_terminacion'])),
            utf8_decode(($row['cupo_inicial'])),
            utf8_decode(($row['saldo_pendiente'])),
            utf8_decode(($row['pago_minimo'])),
            utf8_decode(($row['descripcion_estado_obligacion'])),
            utf8_decode(($row['calidad'])),
            utf8_decode(($row['valor_mora'])),
            utf8_decode(($row['edad_mora']))
        ));
    }


    // Dimensión de confiabilidad
    $pdf->Ln(10);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DEL NIVEL DE CONFIABILIDAD FINANCIERA/CIFIN - CRÉDITOS Y OBLIGACIONES FINANCIERAS'), 0, 2, 'C', 0);
    $pdf->Ln(3);

    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 12);
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
    $y1 = $pdf->GetY();
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada sobre los compromisos y créditos financieros del evaluado, evidencia que el evaluado es totalmente confiable en el cumplimiento de sus obligaciones y créditos financieros. A. Cumplimiento en pagos entre 90% a 100%.'), 1, 'J', 1);

    
    $pdf->SetXY(57, $y1);
    $pdf->SetFillColor(0, 166, 90);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada sobre los compromisos y créditos financieros del evaluado, evidencia que el evaluado es confiable en el cumplimiento de sus obligaciones y créditos financieros. A. Cumplimiento en pagos entre 80% a 90%.'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(105, $y1);
    //  $pdf->SetXY(105,147);
    $pdf->SetFillColor(243, 156, 16);
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada sobre los compromisos y créditos financieros del evaluado, evidencia que el evaluado es medianamente confiable en el cumplimiento de sus obligaciones y créditos financieros. A. Cumplimiento en pagos entre 70% a 80%.'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(152, $y1);
    //$pdf->SetXY(152,147);
    $pdf->SetFillColor(221, 75, 57);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada sobre los compromisos y créditos financieros del evaluado, evidencia que el evaluado es poco confiable en el cumplimiento de sus obligaciones y créditos financieros. A. Cumplimiento en pagos entre 60% a 70%.'), 1, 'J', 1);

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

    $pdf->Ln(6);
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
    $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 12, $id_servicio);

    //print_r($dimFamiliar);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
    $pdf->Ln(5);

    $pdf->SetWidths(array(50, 35, 105));
    $pdf->SetAligns(array('L', 'C', 'L'));
    foreach ($dimFamiliar['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
    }

    //Firma de los proveedores
    $pdf->Ln(5);
    $solComboId = CtrSolSolicitud::qry_infSolicitudCombo($id_solicitud, $id_servicio);
    // Determinar datos del proveedor
    if ($solComboId['data'][0]['resultado'] == 1){
        $idProveedor = $solComboId['data'][0]['id_usuario_asig'];
        $nomProveedor = $solComboId['data'][0]['nombre_proveedor'];
        $registroProveedor = $solComboId['data'][0]['registro'];
    }
    // FIRMA DE PROVEEDOR
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    $firma_proveedor = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_asig']);
    $filename_proveedor = $firma_proveedor['directorio'] . $firma_proveedor['nombre_encr'];
    $y_firma = $pdf->GetY(); // Guardamos la posición Y para ambas firmas


    // Imprimir firma de proveedor al lado derecho de la firma de calidad
    $pdf->SetXY(20, $y_firma);
    if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
        $pdf->Image($filename_proveedor, 25, $y_firma, 30, 25, substr(strrchr($filename_proveedor, "."), 1));
    } else {
        // Mostrar mensaje si falta la firma
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(20, $y_firma + 10); // Ajustar posición para centrar el mensaje en el espacio de la firma
        $pdf->Cell(30, 5, "", 0, 0, 'C');
    }


    if ($solComboId['data'][0]['resultado'] == 1){
        // Nombre y Firma de Proveedor
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(20, $pdf->GetY()+30); // Posicionamos en la misma línea que calidad
        $pdf->Cell(80, 5, "Nombre y Firma del Analista de Riesgo", 0, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(20, $pdf->GetY() + 5);
        $pdf->Cell(80, 5, utf8_decode($nomProveedor), 0, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(20, $pdf->GetY() + 5);
        $pdf->Cell(80, 5, utf8_decode($registroProveedor), 0, 0, 'L');
    }
}
