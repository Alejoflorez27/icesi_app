<?php
function infVerAcademica($pdf, $id_solicitud, $id_servicio, $pintaActituComromiso)
{
    //$pdf->AddPage();
    $forAcedemica = CtrSolFormacion::findAllEstudioConfiabilidad($id_solicitud);

    $pdf->SetX(10);
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetTextColor(000, 000, 000);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('DESARROLLO ACADÉMICO Y PROFESIONAL DEL CANDIDATO'), 0, 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Ln(6);
    $pdf->Cell(190, 5, utf8_decode('FORMACIÓN ACADÉMICA'), 0, 0, 'L', 0);
    $pdf->Ln(7);

    foreach ($forAcedemica['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(41, 5, utf8_decode("Institución Académica"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(90, 5, utf8_decode($row['nombre_institucion']), 1, 0, 'L', 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, utf8_decode("Nivel educativo"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(39, 5, utf8_decode($row['descripcion_niv_escol']), 1, 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(41, 5, utf8_decode("Programa Académico"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($row['programa_academico']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(41, 5, utf8_decode("Fecha Grado y Acta / Folio"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($row['fch_grado']." / ".$row['acta_folio']), 1, 0, 'L', 0);

        /*$pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 5, utf8_decode("Acta / Folio"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(30, 5, utf8_decode($row['acta_folio']), 1, 0, 'L', 0);*/
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(41, 5, utf8_decode("Nombre de quien verifica y cargo"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($row['nom_funcionario']), 1, 1, 'L', 0);
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(41, 5, utf8_decode("Teléfono o correo de contacto"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($row['tel_funcionario']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->MultiCell(0, 5, utf8_decode('Observación: ' . $row['obs_academica']), 1, 'J', 0);
        $pdf->Ln(3);
    }

    $pdf->Ln(10);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('DIMENSIÓN CONFIABILIDAD ACADÉMICA '), 0, 2, 'C', 0);
    $pdf->Ln(3);

    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 13);
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
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada la información del Evaluado es totalmente confiable y se ajusta completamente a la realidad. (Ajuste entre un 95% y 100%).'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(57, $y2 - 20);
    $pdf->SetFillColor(0, 166, 90);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada la información del Evaluado es confiable y se ajusta en su gran mayoría a la realidad. (Ajuste entre 90% y 95%).'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(105, $y2 - 20);
    //  $pdf->SetXY(105,147);
    $pdf->SetFillColor(243, 156, 16);
    $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada la información del Evaluado es medianamente confiable y se ajusta en medio nivel a la realidad. (Ajuste entre 80% y 90%).'), 1, 'J', 1);

    $y2 = $pdf->GetY();
    $pdf->SetXY(152, $y2 - 20);
    //$pdf->SetXY(152,147);
    $pdf->SetFillColor(221, 75, 57);
    $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada la información del Evaluado es poco confiable y se ajusta poco a la realidad. (Ajuste entre 70% y 80%).'), 1, 'J', 1);

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
    $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 13, $id_servicio);

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

    if ($pintaActituComromiso == 'ACADÉMICA') {
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DE LA ACTITUD Y COMPROMISO DEL EVALUADO CON EL PROCESO'), 0, 2, 'C', 0);
        $pdf->Ln(3);

        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 5);

        $pdf->Ln(6);
        $i = 0;
        foreach ($porcentaje['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(95, 5, utf8_decode($row['nombre_dimension']), 1, 0, 'L', 1);

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

            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell($tamSize, 5, $row['porcentaje'] . '%', 1, 0, 'R', 1);
            $pdf->Cell(85 - $tamSize, 5, '', 0, 2, 'L', 0);

            $y2 = $pdf->GetY();
            $pdf->SetXY(10, $y2);
            $pdf->SetFont('Arial', '', 8);

            $pdf->Ln(2);
            $i = $i + 1;
        }

        $pdf->Ln(5);

        $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 5, $id_servicio);

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

        $pdf->Ln(10);
    }

    $refPersona = CtrRefPersonales::findSinSrvAll($id_solicitud);
    //print_r($refPersona['data'][0]);
    if ($refPersona['data'][0] != null || $refPersona['data'][0] != '') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('REFERENCIAS PERSONALES Y OBSERVACIÓN ADICIONAL'), 0, 2, 'C', 0);
        $pdf->Ln(3);
    
        
    
        foreach ($refPersona['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, utf8_decode("Nombre"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(50, 5, utf8_decode($row['nombre']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(45, 5, utf8_decode("Teléfono"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(45, 5, utf8_decode($row['telefono']), 1, 0, 'L', 0);
            $pdf->Ln(5);
            $pdf->MultiCell(0, 5, utf8_decode('Concepto: ' . $row['concepto']), 1, 'J', 0);
            $pdf->Ln(3);
        }
        //referencia adicional
        $obsRefPersona = CtrObservaciones::observacionSinSrvById($id_solicitud, 'obs_referencia');
        if ($obsRefPersona['data'] != null) {
            $pdf->Cell(190, 5, utf8_decode("Observación Adicional"), 1, 1, 'L', 1);
            //print_r($obsRefPersona['data']['observacion']);
            $pdf->MultiCell(0, 5, utf8_decode($obsRefPersona['data']['observacion']), 1, 'J', 0);
        }

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
