<?php
function infVerLaboral($pdf, $id_solicitud, $id_servicio, $pintaActituComromiso)
{
    //$pdf->AddPage();
    //$pdf->Ln(2);
    $forLaboral = CtrSolLaboral::descripcionLaboral_visitas($id_solicitud, $id_servicio);

    $pdf->SetX(10);
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetTextColor(000, 000, 000);
    //$pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('VERIFICACIÓN DE CONFIABILIDAD Y COHERENCIA DE LA INFORMACIÓN E HISTORIA LABORAL'), 0, 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Ln(6);

    $pdf->SetWidths(array(30, 160));
    $pdf->SetAligns(array('L','L'));

    foreach ($forLaboral['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Empresa"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['nombre_empresa']), 1, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Nombre funcionario"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['nom_funcionario_valida']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Cargo funcionario"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['cargo_funcionario_valida']), 1, 0, 'L', 0);
        //$pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Telefono"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['telefono_empresa']), 1, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Estado de la empresa"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['estado_empresa']), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Horario trabajo"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['horario_trabajo']), 1, 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Cargo inicial desempeñado"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['cargo_ingreso']), 1, 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Cargo final desmpeñado"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['cargo_finalizo']), 1, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Tipo de contrato"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['tipo_contrato']), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Motivo retiro"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(55, 5, utf8_decode($row['tipo_retiro']), 1, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Fecha Ingreso"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(34, 5, utf8_decode($row['fch_ingreso']), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Fecha Retiro"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 5, utf8_decode($row['fch_retiro']), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Tiempo total"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 5, utf8_decode($row['tmp_total_laborado']), 1, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetWidths(array(30, 160));
        $pdf->SetAligns(array('L','L'));
        $pdf->Row(array(utf8_decode('Observación:'), (utf8_decode($row['observaciones']))));
        //$pdf->Row(array(utf8_decode('Concepto desempeño laboral:'), (utf8_decode($row['concepto']))));
        //$pdf->Ln(3);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('Verificación por parte del jefe'), 0, 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, utf8_decode("Nombre del jefe que valida la información"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['jefe_inmediato']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, utf8_decode("Cargo del jefe que valida la información"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['cargo_jefe']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, utf8_decode("Número Jefe Inmediato:"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, utf8_decode($row['numero_jefe']), 1, 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('J','J'));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            utf8_decode("Principales actividades o responsabilidades del cargo:"), (utf8_decode($row['funciones_desarrolladas']))));

        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode("Concepto de desempeño laboral:"), 0, 0, 'L', 0);

        
        $pdf->Ln(4);
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('J','J'));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row3(array(
            utf8_decode("Criterios evaluados: \n1. Principales aspectos que destaca del Evaluado.
2. Manejo de información de información confidencial.
3. Nivel de confiabilidad del Evaluado (valores, cumplimiento de las normas, ética profesional).
4. Capacidad de aprendizaje.
5. Capacidad de adaptación al cargo.
6. Relaciones con jefes y pares.
7. Aspectos a mejorar y observaciones."), (utf8_decode("Concepto: \n".$row['concepto']))));

    //$pdf->Ln(5);
    }


    //$pdf->Ln(10);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('BRECHAS O INACTIVIDAD LABORAL'), 0, 2, 'C', 0);
    $pdf->Ln(3);


    $brecha = CtrLaboralBrechas::findAll($id_solicitud, $id_servicio);
    $brechaPeriodo = CtrLaboralPeriodos::descripcionLaboral_periodo($id_solicitud, $id_servicio);

    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('J'));
    $pdf->SetFont('Arial', '', 8);

    $pdf->Row(array(utf8_decode("1. Se encontrarón en la historia laboral del candidato, brechas o tiempos laborales de inactividad superiores a 2 meses (Si la respuesta es SI, escriba en la casillas que se activaran, cuáles fueron las brechas o periodos de inactividad encontrados, los tiempos aproximados y las fechas aproximadas?"), (utf8_decode($brecha['data'][0]['pregunta_uno']))));
    $pdf->Row(array(utf8_decode("2. Se validó información ante base de datos de seguridad social y se confirma que los periodos de inactividad corresponden a la realidad."), (utf8_decode($brecha['data'][0]['pregunta_uno']))));
    $pdf->Ln(3);

    if($brechaPeriodo['data'] != null){
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 5, utf8_decode("Periodo"), 1, 0, 'C', 1);
        $pdf->Cell(50, 5, utf8_decode("Tiempo Aprox del periodo"), 1, 0, 'C', 1);
        $pdf->Cell(100, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
        $pdf->Ln(5);
        $pdf->SetWidths(array(40, 50, 100));
        $pdf->SetAligns(array('C', 'C', 'J'));
        foreach ($brechaPeriodo['data'] as $row) {
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['periodo']))),
                utf8_decode(ucfirst(strtolower($row['tmp_periodo']))),
                utf8_decode(ucfirst(strtolower($row['descripcion'])))
            ));
        }
    }



    $pdf->Ln(5);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DEL NIVEL DE CONFIABILIDAD LABORAL DEL EVALUADO'), 0, 2, 'C', 0);
    //$pdf->Ln(3);

    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 14);
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

    $pdf->Ln(4);
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
    $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 14, $id_servicio);

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

    if ($pintaActituComromiso == 'LABORAL') {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DE LA ACTITUD Y COMPROMISO DEL EVALUADO CON EL PROCESO'), 0, 2, 'C', 0);
        //$pdf->Ln(3);

        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 5);


        $pdf->Ln(4);
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
    }


    $refPersona = CtrRefPersonales::findSinSrvAll($id_solicitud);

    if ($refPersona['data'] != null) {
        $pdf->Ln(10);
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
    
        $obsRefPersona = CtrObservaciones::observacionSinSrvById($id_solicitud, 'obs_referencia');
        if ($obsRefPersona['data'] != null) {
            $pdf->Cell(190, 5, utf8_decode("Observación Adicional"), 1, 2, 'L', 1);
            $pdf->MultiCell(0, 5, utf8_decode($obsRefPersona['data']['observacion']), 1, 'J', 0);
        }
    }

        //Firma de los proveedores
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
