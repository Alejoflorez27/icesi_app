<?php
function infPoligrafiaPre($pdf, $id_solicitud, $id_servicio)
{
    $candidato = CtrSolCandidato::findById_candidato_poligrafia($id_solicitud);
    foreach ($candidato['data'] as $row) {

        if (isset($row['nombre_foto'])) {
            $perfil = $row['directorio'] . '/' . $row['nombre_encr'];
        }
        // FOTO CANDIDATO
        $pdf->Ln(10);
        $pdf->SetX(85);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $perfil;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(42, 45, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 40, 43);
        }
    }
    //$pdf->AddPage();
    $pdf->Ln(5);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);

    //print_r($solicitud);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(45);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("PROPOSITO DEL EXAMEN"), 0, 0, 'C', 1);
    $pdf->SetX(10);
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("La empresa ". utf8_decode($solicitud['data'][0]['razon_social'])." solicita evaluación poligráfica con el propósito de determinar si ". ($candidato['data'][0]['nombre'])." ".($candidato['data'][0]['apellido']).
                                        " cumple con el perfil de confiabilidad para desempeñarse en el cargo de: ". 
                                        utf8_decode($candidato['data'][0]['cargo_desempeno'])), 0, 'J', 0);


    $preSalud = CtrPreguntaSaludPolPre::respByCategoria('tipo_pregunta_salud_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("REVISIÓN DE SITUACIÓN MÉDICO - PSICOLÓGICA- IDONEIDAD"), 0, 0, 'C', 1);
    $pdf->SetX(10);
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("El Poligrafista diligenció el formato de antecedentes Médico-Psicológicos con las respuestas del evaluado (a), como condición indispensable para conocer su estado actual y prevenir la intervención de factores externos no controlables en la confiabilidad del resultado; por otra parte se estableció el nivel de sensibilidad psicofisiológica de "
                                        . utf8_decode($candidato['data'][0]['nombre'])." ".utf8_decode($candidato['data'][0]['apellido']).
                                        "  ante la evaluación."), 0, 'J', 0);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(4);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("REPORTE DE LA ENTREVISTA"), 0, 0, 'C', 1);
    $pdf->SetX(6);
    $pdf->Ln(7);

    //$pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('HISTORIA MEDICA '), 0, 0, 'C', 0);
    $pdf->Ln(6);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Pregunta Verificación"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($preSalud['data'] as $row) {
        if ($row['codigo_pregunta'] != 'J') {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                (utf8_decode($row['pregunta'])),
                utf8_decode(ucfirst(strtolower($row['respuesta'])))
            ));
        }

    }
    $pdf->Ln(3);
    $obsSalud = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_salud_pol_pre');

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('Observación General de Verificación de Salud'), 0, 0, 'L', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln(5);
    $pdf->MultiCell(190, 4, utf8_decode($obsSalud['data']['observacion']), 0, 'J', 0);

    //COMPOSICIÓN FAMILIAR
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('HISTORIA FAMILIAR '), 0, 0, 'C', 0);

    $pdf->Ln(6);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(0, 5, utf8_decode("Composición Familiar"), 1, 1, 'C', '1');
    $pdf->Ln(1);
    $pdf->Cell(45, 5, utf8_decode("Parentesco"), 1, 0, 'C', 1);
    $pdf->Cell(45, 5, utf8_decode("Nombre"), 1, 0, 'C', 1);
    $pdf->Cell(45, 5, utf8_decode("Apellido"), 1, 0, 'C', 1);
    $pdf->Cell(15, 5, utf8_decode("Edad"), 1, 0, 'C', 1);
    //$pdf->Cell(16, 5, utf8_decode("Estado Civil"), 1, 0, 'C', 1);
    //$pdf->Cell(25, 5, utf8_decode("Nivel Escolaridad"), 1, 0, 'C', 1);
    $pdf->Cell(40, 5, utf8_decode("Ocupación"), 1, 1, 'C', 1);
    //$pdf->Cell(26, 5, utf8_decode("Depende de evaluado"), 1, 0, 'C', 1);
    //$pdf->Cell(24, 5, utf8_decode("Ciudad residencia"), 1, 1, 'C', 1);


    $pdf->SetWidths(array(45, 45, 45, 15, 40));
    $pdf->SetAligns(array('L', 'L', 'L', 'C', 'L', 'C', 'C', 'C', 'L'));


    $familia = CtrSolFamiliar::descripcionFamiliar($id_solicitud);
    

    foreach ($familia['data'] as $row) {
        
        //arreglo de tildes en mayusculas
        $ciudad = $row['descripcion_ciudad'];
        $ciudad = mb_strtolower($ciudad, 'UTF-8');
        $ciudad = mb_strtoupper(mb_substr($ciudad, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($ciudad, 1, null, 'UTF-8');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Row(array(
            utf8_decode(($row['descripcion_parentesco'])),
            utf8_decode(($row['nombre'])),
            utf8_decode(($row['apellido'])),
            utf8_decode(($row['edad'])),
            //utf8_decode(($row['descripcion_estado_civil'])),
            //utf8_decode(($row['descripcion_niv_escol'])),
            utf8_decode(($row['ocupacion'])),
            //utf8_decode(($row['descripcion_depende_candidato'])),
            //utf8_decode(($ciudad))
        ));
    }

    $obsFamilia = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_familia');

    if ($obsFamilia['data'] != NULL) {
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('Observación General de Composición Familiar'), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(6);
        $pdf->MultiCell(190, 4, utf8_decode($obsFamilia['data']['observacion']), 0, 'J', 0);
    }

    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ASPECTO FINANCIERO (INGRESOS- EGRESOS-PATRIMONIO)'), 0, 0, 'C', 0);
    $pdf->Ln(6);

    $ingresos = CtrVivIngresos::findAll($id_solicitud, $id_servicio);
    $egresos = CtrVivEgresos::findAll($id_solicitud, $id_servicio);

    //$pdf->Cell(40, 5, utf8_decode("Integrante de la Familia"), 1, 0, 'C', 1);
    $pdf->Cell(35, 5, utf8_decode("Valor de Ingreso"), 1, 0, 'C', 1);
    $pdf->Cell(60, 5, utf8_decode("Donde Proviene"), 1, 0, 'C', 1);
    //$pdf->Ln(5);
    $pdf->Cell(35, 5, utf8_decode("Valor Egreso"), 1, 0, 'C', 1);
    $pdf->Cell(60, 5, utf8_decode("Concepto"), 1, 1, 'C', 1);
    //$pdf->Cell(30, 5, utf8_decode("Responsable"), 1, 1, 'C', 1);
    $varXA = $pdf->GetX();
    $varYA = $pdf->GetY();

    // Configuración de las columnas: primera para Ingresos y segunda para Egresos
    $pdf->SetWidths(array(35, 60, 35, 60)); // Dos pares de columnas: Valor Ingreso y Proveniencia, Valor Egreso y Concepto
    $pdf->SetAligns(array('C', 'L', 'C', 'L')); // Alineación: Centro para valores numéricos, Izquierda para textos

    $totalIng = 0;
    $totalEg = 0;

    // Determinar el mayor número de filas entre ingresos y egresos
    $maxRows = max(count($ingresos['data']), count($egresos['data']));

    // Unificar el bucle para ambas columnas
    for ($i = 0; $i < $maxRows; $i++) {
        $pdf->SetFont('Arial', '', 7);

        // Obtener datos de Ingresos (Pasivos) e imprimir si existe fila
        $valorIngreso = isset($ingresos['data'][$i]) ? utf8_decode('$ ' . number_format($ingresos['data'][$i]['valor_ingreso'])) : '';
        $provenienciaIngreso = isset($ingresos['data'][$i]) ? utf8_decode($ingresos['data'][$i]['ingreso_proveniente']) : '';
        
        if (isset($ingresos['data'][$i])) {
            $totalIng += $ingresos['data'][$i]['valor_ingreso'];
        }

        // Obtener datos de Egresos (Activos) e imprimir si existe fila
        $valorEgreso = isset($egresos['data'][$i]) ? utf8_decode('$ ' . number_format($egresos['data'][$i]['valor_egreso'])) : '';
        $conceptoEgreso = isset($egresos['data'][$i]) ? utf8_decode($egresos['data'][$i]['otros']) : '';
        
        if (isset($egresos['data'][$i])) {
            $totalEg += $egresos['data'][$i]['valor_egreso'];
        }

        // Imprimir la fila con los datos de Ingresos y Egresos en la misma fila
        $pdf->Row(array($valorIngreso, $provenienciaIngreso, $valorEgreso, $conceptoEgreso));
    }

/*
    $varYN = 0;
    // print_r($varYDR);
    if ($varYD < $varYDR) {
        //  $varYN = $varYDR - $varYD;
        $pdf->SetXY(10, $varYDR + 4);
    } else
         if ($varYDR < $varYD) {
        //$varYN = $varYD - $varYDR;
        $pdf->SetXY(10, $varYD + 4);
    }
*/
    $pdf->Ln(1);
    // $pdf->SetX(10, $varYN); 
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(125, 206, 160);
    $pdf->Cell(40, 5, utf8_decode("Total valor ingresos"), 1, 0, 'C', 1);
    $pdf->Cell(55, 5, utf8_decode('$ ' . number_format($totalIng)), 1, 0, 'C', 0);
    //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
    $pdf->Cell(40, 5, utf8_decode("Total valor egresos"), 1, 0, 'C', 1);
    $pdf->Cell(55, 5, utf8_decode('$ ' . number_format($totalEg)), 1, 0, 'C', 0);
    //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('Observación General del Aspecto Financiero del evaluado (a)'), 0, 0, 'C', 0);
    $pdf->Ln(6);

    //$pdf->SetFillColor(207, 207, 207);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    // En esta parte va lo de avtivos y pasivos
    $ingresos = CtrVivPasivos::findAllCandidato($id_solicitud, $id_servicio);
    $egresos = CtrVivActivos::findAllCandidato($id_solicitud, $id_servicio);

    //$pdf->Cell(40, 5, utf8_decode("Integrante de la Familia"), 1, 0, 'C', 1);
    $pdf->Cell(95, 5, utf8_decode("Pasivos"), 1, 0, 'C', 1);
    $pdf->Cell(95, 5, utf8_decode("Activos"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    //$pdf->Cell(35, 5, utf8_decode("Valor Egreso"), 1, 0, 'C', 1);
    //$pdf->Cell(60, 5, utf8_decode("Concepto"), 1, 1, 'C', 1);
    //$pdf->Cell(30, 5, utf8_decode("Responsable"), 1, 1, 'C', 1);
    $varXA = $pdf->GetX();
    $varYA = $pdf->GetY();

    // Configuración de columnas y alineación
    $pdf->SetWidths(array(95, 95)); // Dos columnas de 95 cada una: Pasivos y Activos
    $pdf->SetAligns(array('L', 'L')); // Alineación izquierda para ambas

    $totalIng = 0;
    $totalEg = 0;

    // Determinar el mayor número de filas entre ingresos y egresos
    $maxRows = max(count($ingresos['data']), count($egresos['data']));

    // Unificar el bucle para ambas columnas
    for ($i = 0; $i < $maxRows; $i++) {
        $pdf->SetFont('Arial', '', 7);

        // Obtener datos de Pasivos e imprimir si existe fila
        $pasivo = isset($ingresos['data'][$i]) ? utf8_decode($ingresos['data'][$i]['otros']) : '';

        // Obtener datos de Activos e imprimir si existe fila
        $activo = isset($egresos['data'][$i]) ? utf8_decode($egresos['data'][$i]['otros']) : '';

        // Imprimir la fila con datos de Pasivos y Activos en la misma fila
        $pdf->Row(array($pasivo, $activo));
    }
/*    $varYDb = $pdf->GetY();
    if ($varYDa > $varYDb) {
        $pdf->SetY($varYDa);
    } else {
        $pdf->SetY($varYDb);
    }
*/
    //bloque de reportes financieros
    $pdf->Ln(3);
    
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ANALISIS DE REPORTES EN CENTRALES DE RIESGO FINANCIERO'), 0, 0, 'C', 0);

    $pdf->Ln(6);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(90, 5, utf8_decode("Aspecto Consultado"), 1, 0, 'C', 1);
    $pdf->Cell(25, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
    $pdf->Cell(75, 5, utf8_decode("Observaciones"), 1, 0, 'C', 1);
    $pdf->Ln(5);

    $pdf->SetWidths(array(90, 25, 75));
    $pdf->SetAligns(array('L', 'C', 'L'));


    $familia = CtrVivRiesgosFinanciero::findAllPolPre($id_solicitud, $id_servicio);
    

    foreach ($familia['data'] as $row) {
        
        //arreglo de tildes en mayusculas
        /*$ciudad = $row['descripcion_ciudad'];
        $ciudad = mb_strtolower($ciudad, 'UTF-8');
        $ciudad = mb_strtoupper(mb_substr($ciudad, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($ciudad, 1, null, 'UTF-8');*/

        $pdf->SetFont('Arial', '', 7);
        $pdf->Row(array(
            utf8_decode(($row['descripcion_tipo_financiero'])),
            utf8_decode(utf8_decode($row['estado'])),
            utf8_decode($row['descripcion_financiero']),
        ));
    }

    // pedazo de academico y laboral

    $validacionCombo = CtrSrvComboServicios::verificacionCombo($id_solicitud);
    //print_r($validacionCombo['data']);
    $countAcademico = 0;
    $countlaboral = 0;
    foreach ($validacionCombo['data'] as $row) {

        if ($row['id_servicio'] == 6) {
            $countlaboral++;
        } else if($row['id_servicio'] == 7) {
            $countAcademico++;
        }
        

    }
    //print_r($countAcademico);
    if ($countAcademico < 1) {
        //Academico
        $academico = CtrSolFormacion::findAllEstudioConfiabilidad($id_solicitud);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('TRAYECTORIA ACADÉMICA'), 0, 0, 'C', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(56, 5, utf8_decode("Nivel escolaridad"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(49, 5, utf8_decode("Nombre Institución"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(37, 5, utf8_decode("Programa Academico"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(26, 5, utf8_decode("Fecha de graduación"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(22, 5, utf8_decode("Acta y Folio"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(56, 49, 37, 26, 22));
        $pdf->SetAligns(array('L', 'C', 'C', 'C'));
        foreach ($academico['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                ucfirst(strtolower(utf8_decode($row['descripcion_niv_escol']))),
                utf8_decode(($row['nombre_institucion'])),
                utf8_decode(ucfirst(strtolower($row['programa_academico']))),
                utf8_decode(ucfirst(strtolower($row['fch_grado']))),
                utf8_decode(ucfirst(strtolower($row['acta_folio'])))
            ));
            //$pdf->Ln(5);
            $pdf->multiCell(190, 5, utf8_decode("Observación: ".$row['obs_academica']), 1, 'L', 0);
        }
        $cursos = CtrObservaciones::observacionById($id_solicitud, $id_servicio, "obs_cursos_pol_pre");
        if ($cursos['data']['observacion']!='') {
            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode('Cursos requeridos por la empresa solicitante:'), 0, 0, 'L', 0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 8);
            $pdf->multiCell(190, 5, utf8_decode($cursos['data']['observacion']), 0, 'L', 0);
        }
        

        //print_r($comentario);
        $comentario = CtrObservaciones::observacionById($id_solicitud, $id_servicio, "obs_formacion_pol_pre");

        //Admiciones por cada Area Academico
        $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Trayectoria Académica');
        $admitio = '';
        if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
            $admitio = "Admitio: ".$admisiones['data']['resumen'];
        }else{
            $admitio = '';
        }

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('Comentarios del examinador:'), 0, 0, 'L', 0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 8);
        $pdf->multiCell(190, 5, utf8_decode($comentario['data']['observacion']."\n".$admitio), 0, 'L', 0);
    }


    if ($countlaboral < 1) {
        //Laboral
        $laboral = CtrSolLaboral::descripcionLaboral_pol_pre($id_solicitud, $id_servicio);

        //$pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('TRAYECTORIA LABORAL '), 0, 0, 'C', 0);
        $pdf->Ln(5);
        foreach ($laboral['data'] as $row) {

            //ßprint_r($row);
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(46, 5, utf8_decode("Empresa"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(0, 5, utf8_decode($row['nombre_empresa']), 1, 1, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(46, 5, utf8_decode("Cargo inicial desempeñado/Área"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['cargo_ingreso']), 1, 0, 'L', 0);

            //$pdf->Ln(5);
            
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(46, 5, utf8_decode("Último cargo desempeñado/Área"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(48, 5, utf8_decode($row['cargo_finalizo']), 1, 1, 'L', 0);

            

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Fecha de Ingreso"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(21, 5, utf8_decode($row['fch_ingreso']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Fecha de Retiro"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(25, 5, utf8_decode($row['fch_retiro']), 1, 0, 'L', 0);

            //$pdf->Ln(5);
            
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(46, 5, utf8_decode("Tiempo total laborado"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(48, 5, utf8_decode($row['tmp_total_laborado']), 1, 1, 'L', 0);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(46, 5, utf8_decode("Ciudad"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(144, 5, utf8_decode($row['id_ciudad_act']), 1, 1, 'L', 0);
            $pdf->Cell(25, 5, utf8_decode("Motivo de Retiro"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(0, 5, utf8_decode($row['tipo_retiro']), 1, 0, 'L', 0);
            

            $pdf->Ln(5);

            $pdf->multiCell(190, 5, utf8_decode("Principales actividades o responsabilidades del cargo: ".$row['funciones_desarrolladas']), 1, 'L', 0);
            $pdf->multiCell(190, 5, utf8_decode("Observación: ".$row['observaciones']), 1, 'L', 0);
            $pdf->Ln(3);
        }
        
    }

    //$pdf->Ln(3);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('BRECHAS O INACTIVIDAD LABORAL'), 0, 2, 'C', 0);
    $pdf->Ln(2);


    $brecha = CtrLaboralBrechas::findAll($id_solicitud, $id_servicio);
    $brechaPeriodo = CtrLaboralPeriodos::descripcionLaboral_periodo($id_solicitud, $id_servicio);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('J'));
    $pdf->SetFont('Arial', '', 7);
    $brecha_rep = "";
    if ($brecha['data'][0]['pregunta_uno'] == 'si') {
        $brecha_rep = "Si";
    }else {
        $brecha_rep = "No aplica";
    }

    $pdf->Row(array(utf8_decode("1. Se encontrarón en la historia laboral del evaluado, brechas o tiempos laborales de inactividad superiores a 6 meses (Si la respuesta es SI, escriba en la casillas que se activaran, cuáles fueron las brechas o periodos de inactividad encontrados, los tiempos aproximados y las fechas aproximadas?"), (utf8_decode($brecha_rep))));
    //$pdf->Row(array(utf8_decode("2. Se validó información ante base de datos de seguridad social y se confirma que los periodos de inactividad corresponden a la realidad."), (utf8_decode($brecha['data'][0]['pregunta_uno']))));
    if ($brecha['data'][0]['pregunta_uno'] == 'si') {
        $pdf->Ln(3);
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


    //Areas de Riesgo
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(3);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ÁREAS DE RIESGO'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //ilicitos
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 1: ILÍCITOS EN EMPLEOS"), 1, 'L', 1);

    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $ilicitos = CtrPreguntaSaludPolPre::respByCategoria('tipo_pregunta_ilicitos_pol_pre', $id_solicitud, $id_servicio);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($ilicitos['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }

    //FIN DE TABLA DE AREA DE SI Y NO

/*
    $ilicitos = CtrPreguntaSaludPolPre::findAllByCombo('tipo_pregunta_ilicitos_pol_pre', $id_solicitud, $id_servicio);
    $descripcionIlicitos= '';

    foreach ($ilicitos['data'] as $row) {
        $descripcionIlicitos .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionIlicitos)));
*/

    $comentariosIlicitos = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_ilicito_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'admisión ilícitos');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosIlicitos['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //alcohol
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 2: CONSUMO DE ALCOHOL"), 1, 'L', 1);

/*
    $alcohol = CtrPreguntaSaludPolPre::findAllByCombo('tipo_pregunta_alcohol_pol_pre', $id_solicitud, $id_servicio);
    $descripcionAlcohol= '';

    foreach ($alcohol['data'] as $row) {
        $descripcionAlcohol .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionAlcohol)));
*/
    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $alcohol = CtrPreguntaSaludPolPre::respByCategoria('tipo_pregunta_alcohol_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($alcohol['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosAlcohol = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_alcohol_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'consumo de alcohol');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosAlcohol['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //consumo de Marihuana
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 3: CONSUMO DE MARIHUANA"), 1, 'L', 1);

/*
    $marihuana = CtrPreguntaSaludPolPre::findAllByCombo('tipo_pregunta_marihuna_pol_pre', $id_solicitud, $id_servicio);
    $descripcionMarihuana= '';

    foreach ($marihuana['data'] as $row) {
        $descripcionMarihuana .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionMarihuana)));
*/
    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $marihuana = CtrPreguntaSaludPolPre::respByCategoria('tipo_pregunta_marihuna_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    $preguntasMari = "";
    $countMari = 0;
    foreach ($marihuana['data'] as $row) {
        //print_r($row['codigo_pregunta']);
        if ($row['codigo_pregunta'] == 'A') {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                (utf8_decode($row['pregunta'])),
                utf8_decode(ucfirst(strtolower($row['respuesta'])))
            ));
            //print_r($row['respuesta']);
            if ($row['respuesta'] == "NO") {
                $countMari++;
            }
        }else{
            // Tomamos la pregunta
            $pregunta = $row['pregunta'];

            // Si empieza con número. => le agregamos * delante
            $pregunta = preg_replace('/^(\d+\.)/', "* ", $pregunta);

            // Le agregamos salto de línea al final
            $preguntasMari .= $pregunta . "\n";
        }

    }
    if ($countMari == 1) {
        $preguntasMari = "";
    }
    
    //$pdf->MultiCell(190, 5, utf8_decode($preguntasMari), 0, 'L');
    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosMarihuana = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_marihuna_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'consumo de marihuna');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    
    $pdf->multiCell(190, 4, utf8_decode(/*$preguntasMari.*/"Comentarios del Examinador: ".($comentariosMarihuana['data']['observacion'])."\n".$admitio), 1, 'L', 0);
    //producción de drogas
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 4: PRODUCCIÓN - ALMACENAMIENTO- TRANSPORTE- VENTA DE DROGAS ILEGALES TODAS INCLUYENDO MARIHUANA"), 1, 'L', 1);

/*
    $produccion = CtrPreguntaSaludPolPre::findAllByCombo('tipo_produccion_pol_pre', $id_solicitud, $id_servicio);
    $descripcionProduccion= '';

    foreach ($produccion['data'] as $row) {
        $descripcionProduccion .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionProduccion)));
*/
    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $produccion = CtrPreguntaSaludPolPre::respByCategoria('tipo_produccion_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
/*
    foreach ($produccion['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
*/

    $preguntasPro = "";
    $countPro = 0;
    foreach ($produccion['data'] as $row) {
        //print_r($row['codigo_pregunta']);
        if ($row['codigo_pregunta'] == 'A' || $row['codigo_pregunta'] == 'B' || $row['codigo_pregunta'] == 'C' || $row['codigo_pregunta'] == 'D') {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                (utf8_decode($row['pregunta'])),
                utf8_decode(ucfirst(strtolower($row['respuesta'])))
            ));
            //print_r($row['respuesta']);
            if (($row['respuesta'] == "SI") && (in_array($row['codigo_pregunta'], ['A', 'B', 'C', 'D']))) {
                $countPro++;
            }
        }else{
            // Tomamos la pregunta
            $pregunta = $row['pregunta'];

            // Si empieza con número. => le agregamos * delante
            $pregunta = preg_replace('/^(\d+\.)/', "* ", $pregunta);

            // Le agregamos salto de línea al final
            $preguntasPro .= "* ".$pregunta . "\n";
        }

    }
    //print_r($countPro);
        if ($countPro == 0 ) {
            $preguntasPro = "";
        }










    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosProduccion = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_produccion_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'producción y ventas de drogas ilegales');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode(/*$preguntasPro.*/"Comentarios del examinador: ".($comentariosProduccion['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //ludopatia
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 5: LUDOPATIA"), 1, 'L', 1);

    /*
    $ludopatia = CtrPreguntaSaludPolPre::findAllByCombo('tipo_ludopatia_pol_pre', $id_solicitud, $id_servicio);
    $descripcionLudopatia= '';

    foreach ($ludopatia['data'] as $row) {
        $descripcionLudopatia .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionLudopatia)));
*/

    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $ludopatia = CtrPreguntaSaludPolPre::respByCategoria('tipo_ludopatia_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($ludopatia['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    //FIN DE TABLA DE AREA DE SI Y NO

    $comentariosLudopatia = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_ludopatia_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'ludopatia');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosLudopatia['data']['observacion'])."\n".$admitio), 1, 'L', 0);


    //Vínculo con personas al margen de la ley
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 6: VÍNCULOS ILÍCITOS CON PERSONAS AL MARGEN DE LA LEY"), 1, 'L', 1);
    
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(102, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(88, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);

    $vinculoPersonas = CtrPreguntaPersIlegalesPolPre::personasIlegalesPolPreById($id_solicitud, $id_servicio);
    //ha participado
    $vinculoParticipo = '';
    if ($vinculoPersonas['data']['pregunta_tres'] == 'A') {
        $vinculoParticipo = 'Aceptó';
    } else {
        $vinculoParticipo = 'Negó';
    }
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetWidths(array(102,88));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->Row(array(utf8_decode("¿Ha participado usted en actividades ilícitas con personas al margen de la ley?"), utf8_decode($vinculoParticipo)));
        
    //tiene vinculos
    $vinculoPersonas = CtrPreguntaPersIlegalesPolPre::personasIlegalesPolPreById($id_solicitud, $id_servicio);
    $pdf->SetWidths(array(102,88));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $vinculoResp = '';
    if ($vinculoPersonas['data']['pregunta_tres'] == 'A') {
        $vinculoResp = 'Aceptó';
        //print_r(1);
        //$pdf->Row(array(utf8_decode("Ha tenido usted vinculo con personas al margen de la Ley"), utf8_decode($vinculoResp)));

        //tipo de vinculos
        $tipoVinculos = CtrPreguntaSaludPolPre::findAllByCombo('tipo_vinculo_personas_ilegales', $id_solicitud, $id_servicio);

        //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO



        $textoConcatenado = '';

        foreach ($tipoVinculos['data'] as $row) {
            $textoConcatenado .= ucfirst(strtolower(utf8_decode($row['descripcion']))) . ', ';
        }

        // Quitar la última coma y espacio
        $textoConcatenado = rtrim($textoConcatenado, ', ');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetWidths(array(102,88));
        $pdf->SetAligns(array('L', 'L'));
        $pdf->Row(array(utf8_decode("¿Con quien tiene vinculos?"), utf8_decode($textoConcatenado)));

        //$getXa = $pdf->GetX();
        //FIN DE TABLA DE AREA DE SI Y NO
        //lista de vinculos
        $pdf->SetFillColor(174, 214, 241);
        $tipoGrupos = CtrPreguntaSaludPolPre::findAllByCombo('tipo_vinculo_grupos_ilegales', $id_solicitud, $id_servicio);
        
        $textoConcatenado = '';

        foreach ($tipoGrupos['data'] as $row) {
            $textoConcatenado .= ucfirst(strtolower(utf8_decode($row['descripcion']))) . ', ';
        }

        // Quitar la última coma y espacio
        $textoConcatenado = rtrim($textoConcatenado, ', ');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetWidths(array(102,88));
        $pdf->SetAligns(array('L', 'L'));
        $pdf->Row(array(utf8_decode("¿Que clase de vinculos?"), utf8_decode($textoConcatenado)));
        
        //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
        
        //$pdf->SetY($y2);
        //$pdf->SetX($x2);
        /*
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(95, 5, utf8_decode("Clase de vinculos"), 1, 0, 'C', 1);
        $pdf->Ln(5);
        $pdf->SetWidths(array(95));
        $pdf->SetAligns(array('L'));
        foreach ($tipoGrupos['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(105);
            $pdf->Row(array(ucfirst(strtolower(utf8_decode($row['descripcion'])))
            ));
        }*/
        /*$getYb= $pdf->GetY();
        //$getXb = $pdf->GetX();

        if ($getYa > $getYb) {
            $pdf->SetY($getYa);
            //$pdf->Ln(5);
        }else{
            $pdf->SetY($getYb);
            //$pdf->Ln(5);
        }*/

        if ($vinculoPersonas['data']['pregunta_dos'] != null || $vinculoPersonas['data']['pregunta_dos'] != '') {
            $pdf->Row(array(utf8_decode("La ultima vez que tuvo contacto"), utf8_decode($vinculoPersonas['data']['pregunta_dos'])));
        }
    } else {
        $vinculoResp = 'Negó';
    }
    


    //print_r($getYb ."-". $getYa);
    //FIN DE TABLA DE AREA DE SI Y NO
    //ultimo contacto
    //$vinculoPersonas = CtrPreguntaPersIlegalesPolPre::personasIlegalesPolPreById($id_solicitud, $id_servicio);


    //comentarios del examinado
    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Vínculo con personas al margen de la ley');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($vinculoPersonas['data']['pregunta_cuatro'])."\n".$admitio), 1, 'L', 0);


    //comision de delitos
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 7: COMISIÓN DE DELITOS"), 1, 'L', 1);

/*/
    $comision = CtrPreguntaSaludPolPre::findAllByCombo('tipo_comision_pol_pre', $id_solicitud, $id_servicio);
    $descripcionComision= '';

    foreach ($comision['data'] as $row) {
        $descripcionComision .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionComision)));
*/

    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $comision = CtrPreguntaSaludPolPre::respByCategoria('tipo_comision_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($comision['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            utf8_decode($row['pregunta']),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosComision = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_comision_delitos_pol_pre');

    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Comisión de delitos');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosComision['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //Antecedentes
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 8: ANTECEDENTES"), 1, 'L', 1);

/*
    $antecedentes = CtrPreguntaSaludPolPre::findAllByCombo('tipo_antecedentes_pol_pre', $id_solicitud, $id_servicio);
    $descripcionAntecedentes= '';

    foreach ($antecedentes['data'] as $row) {
        $descripcionAntecedentes .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionAntecedentes)));
*/
    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $antecedentes = CtrPreguntaSaludPolPre::respByCategoria('tipo_antecedentes_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($antecedentes['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosAntecedentes = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_antecedentes_pol_pre');
    //Admiciones por cada Area Academico
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Antecedentes');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosAntecedentes['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //informacion falsa
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 9: INFORMACION FALSA "), 1, 'L', 1);
    
    //presento info falsa
    $infoFalsa = CtrPreguntaInfoFalsaPolPre::infoFalsaPolPreById($id_solicitud, $id_servicio);
    $pdf->SetWidths(array(160,30));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 8);
    $infoResp = '';
    if ($infoFalsa['data']['pregunta_uno'] == 'A') {
        $infoResp = 'Aceptó';
    } else {
        $infoResp = 'Negó';
    }
    
    $pdf->Row(array(utf8_decode("Presentó usted en la información de su solicitud de empleo información, falsa, adulterada, imprecisa o con omiciones intencionales"), utf8_decode($infoResp)));

    if ($infoFalsa['data']['pregunta_uno'] == 'A') {
            //conductas
    $conducta = CtrPreguntaSaludPolPre::findAllByCombo('tipo_conducta_info_falsa', $id_solicitud, $id_servicio);
    $descripcionConducta= '';

    foreach ($conducta['data'] as $row) {

        $descripcionConducta .= $row['descripcion']. ', ' ;

        
    }

    if ($descripcionConducta == "") {
        $descripcionConducta= "Mencionó que no realizó ninguna falsificación en su documentación para ingresar a la empresa \n"
                               .utf8_decode($solicitud['data'][0]['razon_social']).", "."que todos los documentos y soportes son auténticos y se pueden validar ante las entidades emisoras.\n"
                               ."Aseguro que no ha adulterado documentos para obtener beneficios ilícitos o para ingresar a sus empleos anteriores.\n"
                               ."Garantizó entender que al presentar documentos falsos se comete el delito de Falsedad en Documento Público y que al detectar esa\n"
                               ."situación las instituciones podrían compulsan copias a la fiscalía general de la Nación.";
    }

    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 8);
    $pdf->Row(array(utf8_decode("Seleccione las conductas que apliquen"), utf8_decode($descripcionConducta)));
    } 

    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Información falsa');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }

    //comentarios del examinado
    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($infoFalsa['data']['pregunta_dos'])."\n".$admitio), 1, 'L', 0);


    //Infiltracion
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 10: INFILTRACIÓN"), 1, 'L', 1);

/*
    $infiltracion = CtrPreguntaSaludPolPre::findAllByCombo('tipo_infiltracion_pol_pre', $id_solicitud, $id_servicio);
    $descripcionInfiltracion= '';

    foreach ($infiltracion['data'] as $row) {
        $descripcionInfiltracion .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Redacción complementaria"), utf8_decode($descripcionInfiltracion)));
*/
    //ESTO ES CAMBIAR SEPARADO DE COMAS POR SI Y NO
    $infiltracion = CtrPreguntaSaludPolPre::respByCategoria('tipo_infiltracion_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(140, 5, utf8_decode("Preguntas"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Respuesta"), 1, 0, 'C', 1);
    $pdf->Ln(5);
    $pdf->SetWidths(array(140, 50));
    $pdf->SetAligns(array('L', 'C'));
    foreach ($infiltracion['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode($row['pregunta'])),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    //FIN DE TABLA DE AREA DE SI Y NO
    $comentariosInfiltracion = CtrObservaciones::observacionById($id_solicitud, $id_servicio,'obs_infiltracion_pol_pre');

    $admisiones = CtrAdmisionesPolPre::admisionesPolPreByIdItem($id_solicitud, $id_servicio,'Infiltración');
    $admitio = '';
    if (($admisiones['data']['resumen']!= '') && ($admisiones['data']['admitio'] == 1)) {
        $admitio = "Admitio: ".$admisiones['data']['resumen'];
    }else{
        $admitio = '';
    }


    $pdf->multiCell(190, 4, utf8_decode("Comentarios del examinador: ".($comentariosInfiltracion['data']['observacion'])."\n".$admitio), 1, 'L', 0);

    //En esta parte va lo de como llego la hoja de vida
    $hojaVida = CtrpreguntaComoHojaVidaPolPre::comoHojaVidaPolPreById($id_solicitud, $id_servicio);

    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('¿Información complementaria?'), 0, 0, 'L', 0);
    $pdf->Ln(5);

    //ßprint_r($row);
    //$pdf->SetFillColor(207, 207, 207);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(90, 5, utf8_decode("¿Cómo se enteró del proceso de selección, en esta empresa?"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->multiCell(100, 5, utf8_decode($hojaVida['data']['pregunta_uno']), 1, 'L', 0);
    //$pdf->Cell(100, 5, utf8_decode($hojaVida['data']['pregunta_uno']), 1, 0, 'L', 0);
    //$pdf->Ln(5);
    $conoce ='';
    if ($hojaVida['data']['pregunta_uno'] == 'A') {
        $conoce ='Aceptó';
    } else {
        $conoce ='Negó';
    }
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(90, 5, utf8_decode("¿Conoce a alguien que trabaje en la empresa?"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(100, 5, utf8_decode($conoce), 1, 0, 'L', 0);

    $pdf->Ln(5);
    
    if ($hojaVida['data']['pregunta_uno'] == 'A') {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(90, 5, utf8_decode("Nombre de la persona que trabaja en la empresa"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(100, 5, utf8_decode($hojaVida['data']['pregunta_tres']), 1, 0, 'L', 0);

        $pdf->Ln(5);
/*
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(90, 5, utf8_decode("Cargo de la persona que trabaja en la empresa"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(100, 5, utf8_decode($hojaVida['data']['pregunta_cuatro']), 1, 0, 'L', 0);

        $pdf->Ln(5);
*/
    }
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(90, 5, utf8_decode("Cargo de la persona que trabaja en la empresa"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(100, 5, utf8_decode($hojaVida['data']['pregunta_cuatro']), 1, 0, 'L', 0);

        $pdf->Ln(5);
    


    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(90, 5, utf8_decode("¿Es la primera vez que se postula a esta empresa? "), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(100, 5, utf8_decode($hojaVida['data']['pregunta_siete']), 1, 0, 'L', 0);

    $pdf->Ln(5);
    $trabajSector ='';
    if ($hojaVida['data']['pregunta_cinco'] == 'A') {
        $trabajSector ='Aceptó';
    } else {
        $trabajSector ='Negó';
    }
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(165, 5, utf8_decode("¿Tiene algún vínculo con alguien (familiar o amigo) que trabaje en una empresa del mismo sector (empresas de la competencia)?"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(25, 5, utf8_decode($trabajSector), 1, 0, 'L', 0);
        $kaizen = CtrSrvServicio::findById($id_solicitud);

        if ($kaizen['data']['id_empresa'] == 64) {
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetWidths(array(90, 100));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->Row(array(
                utf8_decode("¿Usted ha trabajado con empresas, o tiene familiares que trabajen con empresas y con actividades similares a proyectos de metalmecánica, proyectos hidráulicos y demás?"),
                utf8_decode($hojaVida['data']['pregunta_kaizen']),
            ));
        }else {
            $pdf->Ln(5);
        }

    if ($hojaVida['data']['pregunta_cinco'] == 'A') {
        //$pdf->Ln(5);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(46, 5, utf8_decode("Nombre de la persona"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, utf8_decode($hojaVida['data']['pregunta_seis']), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(24, 5, utf8_decode("Cargo"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(70, 5, utf8_decode($hojaVida['data']['pregunta_ocho']), 1, 0, 'L', 0);
    }

    
    $pdf->Ln(5);

    //Tecnica de poligrafia
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('TECNICA POLIGRAFICA EMPLEADA'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //print_r($solicitud['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    $pdf->multiCell(190, 5, utf8_decode("El examen de polígrafo fue numéricamente evaluado por "
                                        .($solicitud['data'][0]['proveedor'])
                                        ." quien fue asignado para realizar este examen. "
                                        .($solicitud['data'][0]['proveedor'])
                                        ." , es Poligrafista certificado y miembro de la Asociación Americana de Poligrafistas APA."), 1, 'L', 0);
                                        $pdf->Ln(5);

    //En esta parte va la tecnica de poligrafia
    $tecnica = CtrtecnicaPolPre::tecnicaPolPreById($id_solicitud, $id_servicio);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(140, 5, utf8_decode("El examen de Polígrafo se administró empleando una serie de una tecnica conocida como "), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(50, 5, utf8_decode($tecnica['data']['descripcion_pregunta_uno']), 1, 0, 'L', 0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(140, 5, utf8_decode("El equipo empleado en el examen fue el Sistema de Poligrafo Computarizado de la marca "), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(50, 5, utf8_decode($tecnica['data']['descripcion_pregunta_dos']), 1, 0, 'L', 0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(140, 5, utf8_decode("Tipo de pregunta comparativa utilizada "), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(50, 5, utf8_decode($tecnica['data']['descripcion_pregunta_tres']), 1, 0, 'L', 0);
    $pdf->Ln(5);


    //Tecnica de poligrafia
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(4);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('REVISIÓN DE PREGUNTAS'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //print_r($solicitud['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    $pdf->multiCell(190, 5, utf8_decode("El examinador procedió a explicar y repasar con la persona evaluada, todas y cada una de las preguntas que se le harían en este examen. "
                                        .$candidato['data'][0]['nombre']." ".$candidato['data'][0]['apellido']
                                        .", manifestó comprenderlas claramente."), 1, 'L', 0);
                                        $pdf->Ln(5);

    //En esta parte va la revision de las preguntas
    $preguntasRelevantes = CtrPreguntasRelevantesPolPre::findAll($id_solicitud, $id_servicio);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetWidths(array(10, 100, 40, 40));
    $pdf->SetAligns(array('C', 'C', 'C', 'C'));
    $pdf->Row(array(
        utf8_decode("#"),
        utf8_decode("PREGUNTA"),
        utf8_decode("RESPUESTA CANDIDATO"),
        utf8_decode("CALIFICACIÓN DE LA PREGUNTA CON EL POLÍGRAFO")

    ));
    //$pdf->Ln(5);
    $pdf->SetWidths(array(10, 100, 40, 40));
    $pdf->SetAligns(array('C', 'L', 'C', 'L'));
    $count = 0;
    foreach ($preguntasRelevantes['data'] as $row) {
        $respuesta = "";
        if ($row['calificacion'] >= -15 && $row['calificacion'] <= -3) {
            $respuesta = "S.R - Respuestas significativas de engaño";
            $count++;
        }else if($row['calificacion'] == null || $row['calificacion'] == '') {
            $respuesta = "N.O - No opinion";
        }else if($row['calificacion'] >= -2 && $row['calificacion'] <= 0) {
            $respuesta = "I.N.C -Inconcluso";
        }else if($row['calificacion'] >= 1 && $row['calificacion'] <= 15) {
            $respuesta = "N.S.R - No reaccion significativa";
        }
        $pdf->Row(array(
            utf8_decode(ucfirst(strtolower($row['descripcion_tipo_rn']))),
            utf8_decode($row['pregunta']),
            utf8_decode(ucfirst(strtolower($row['resp_candidato']))),
            utf8_decode(($respuesta)),
        ));
    }
    if ($count > 0) {
        $respuestaResul = "S.R - Respuestas significativas de engaño";
    }else{
        $respuestaResul = "N.S.R - No reaccion significativa";
    }
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(4);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('RESULTADO'), 0, 2, 'C', 1);
    $pdf->Ln(3);
    $resultado_pol_pre = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'resultado_pol_pre');
    //print_r($resultado_pol_pre['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    //$pdf->multiCell(190, 5, utf8_decode($resultado_pol_pre['data']['observacion']), 1, 'J', 0);
    /*$pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode(""), 1, 'L', 0);*/
    //En esta parte va el resultado de la poligrafia
    $pdf->multiCell(190, 5, utf8_decode(/*'Después de analizar cuidadosamente, estudiar y evaluar los resultados y las gráficas arrojadas por el sistema de Polígrafo computarizado, es la opinión del examinador que: '
                            . utf8_decode($candidato['data'][0]['nombre'])." ".utf8_decode($candidato['data'][0]['apellido'])
                            .", ".$respuestaResul.", ".*/
                            $resultado_pol_pre['data']['observacion']), 1, 'L', 0);

    // En esta Parte va el PostTest si aplica

    $posTest = CtrPosTestPolPre::posTestPolPreById($id_solicitud, $id_servicio);
    //print_r($posTest['data']['aplica']);
    if ($posTest['data']['aplica'] == 1) {
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Ln(4);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('POST-TEST'), 0, 2, 'C', 1);
        $pdf->Ln(3);
    
        //print_r($solicitud['data'][0]);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode($posTest['data']['post_test']), 1, 'L', 0);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->Ln(4);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('CALIDAD DE LOS DATOS (GRÁFICAS)'), 0, 2, 'C', 1);
        $pdf->Ln(3);
    
        //print_r($solicitud['data'][0]);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode('El comportamiento del evaluado durante aplicación de la prueba con el polígrafo (gráficas) fue:'), 1, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode($posTest['data']['comportamiento']), 1, 'L', 0);

        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode('Por lo tanto, en los datos fisiológicos obtenidos durante esta evaluación se observó que los registros (gráficos) seconsideran:'), 1, 'L', 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode($posTest['data']['descripcion_datos']), 1, 'L', 0);
        //$pdf->Ln(5);
    }

    // en esta parte van las admisiones
    $admisiones = CtrAdmisionesPolPre::admisionesPolPreById($id_solicitud, $id_servicio);
    if ($admisiones['data']['resumen'] != null) {
        $descripcionAdmisiones= 'No Aplica';
    }
    

    foreach ($admisiones['data'] as $row) {
        $descripcionAdmisiones .= $row['resumen']. '. ' ;
    }
    
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(4);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ADMISIONES Y COMENTARIOS DE INTERES'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //print_r($solicitud['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    $pdf->multiCell(190, 5, utf8_decode($descripcionAdmisiones), 1, 'L', 0);
    $pdf->Ln(3);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, utf8_decode('ACTITUD FRENTE AL PROCESO DE EVALUACION POLIGRAFICA'), 0, 0, 'C', 1);
    $pdf->Ln(8);
    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 5);
/*    // Se le quita lo del riesgo
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
*/
    $pdf->SetFillColor(174, 214, 241);
    //$pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
    $pdf->Ln(5);

    $dimActitud = CtrDimRespuestas::descripcionCompromisodimensionPolPre($id_solicitud, 5, $id_servicio);
    $pdf->SetWidths(array(50, 35, 105));
    $pdf->SetAligns(array('L', 'C', 'L'));

    foreach ($dimActitud['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
    }

    $pdf->Ln(5);

// Nombre del Profesional a Cargo
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(190, 5, utf8_decode("Nombre del Profesional a Cargo\n" . $solicitud['data'][0]['proveedor']), 1, 'L', 0);
$pdf->Ln(5);

// Firma del proveedor
$solComboId = CtrSolSolicitud::qry_infSolicitudCombo($id_solicitud, $id_servicio);

if ($solComboId['data'][0]['resultado'] == 1) {
    $idProveedor = $solComboId['data'][0]['id_usuario_asig'];
    $nomProveedor = $solComboId['data'][0]['nombre_proveedor'];
    $registroProveedor = $solComboId['data'][0]['registro'];

    // Obtener firma del proveedor
    $firma_proveedor = CtrUsuario::consultar($idProveedor);
    $filename_proveedor = $firma_proveedor['directorio'] . $firma_proveedor['nombre_encr'];

    $y_firma = $pdf->GetY(); // Guardamos la posición Y actual
    $h_disponible = $pdf->GetPageHeight() - $y_firma - 20; // Espacio restante en la página

    // Si no hay suficiente espacio, pasar a la siguiente página
    if ($h_disponible < 60) { // 60 ≈ altura estimada de la firma + textos
        $pdf->AddPage();
        $y_firma = $pdf->GetY();
    }

    // Mostrar imagen o dejar espacio
    $pdf->SetXY(20, $y_firma);
    if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
        $extension = strtolower(pathinfo($filename_proveedor, PATHINFO_EXTENSION));
        $pdf->Image($filename_proveedor, 25, $y_firma, 30, 25, $extension);
    } else {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(20, $y_firma + 10);
        $pdf->Cell(30, 5, "(Firma no disponible)", 0, 0, 'C');
    }

    // Mostrar nombre y registro bajo la firma
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(20, $y_firma + 30);
    $pdf->Cell(80, 5, "Nombre y Firma del Poligrafista", 0, 0, 'L');

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY(20, $y_firma + 35);
    $pdf->Cell(80, 5, utf8_decode($nomProveedor), 0, 0, 'L');

    $pdf->SetXY(20, $y_firma + 40);
    $pdf->Cell(80, 5, utf8_decode($registroProveedor), 0, 0, 'L');
}




    //Fotos de Poligrafia pre
    $fotos = CtrSolAdjuntos::descripcionAdjuntos($id_solicitud);

    $fotoAutorizacion = '';
    $fotoCalificacion = '';
    $fotoEvaluacion = '';


    foreach ($fotos['data'] as $row) {

        if ($row['descripcion'] == 'AUTORIZACIÓN DEL EXAMEN') {
            $fotoAutorizacion = $row['directorio'] . '/' . $row['nombre_encr'];
        }else if ($row['descripcion'] == 'HOJA DE CALIFICACIÓN') {
            $fotoCalificacion = $row['directorio'] . '/' . $row['nombre_encr'];
        }else if ($row['descripcion'] == 'FORMATO DEL BUEN TRATO DEL EXAMEN') {
            $fotoEvaluacion = $row['directorio'] . '/' . $row['nombre_encr'];
        } 
    }

    if ($id_servicio == 8) {
        $imagenesEspeciales = [
            [$fotoAutorizacion, 'AUTORIZACIÓN DEL EXAMEN']
            //[$fotoCalificacion, 'HOJA DE CALIFICACIÓN'],
            //[$fotoEvaluacion, 'FORMATO DEL BUEN TRATO DEL EXAMEN']
        ];

        foreach ($imagenesEspeciales as [$archivo, $titulo]) {
            if (!empty($archivo) && file_exists($archivo)) {
                insertarImagenCompleta($pdf, $archivo, $titulo);
                //$pdf->AddPage();
            }
            $obj_solSolicitud = new SolSolicitud($id_solicitud);
            $id_combo = $obj_solSolicitud->getIdCombo('id_combo');
            //print_r($id_combo);
            //$rutina = CtrSrvCombos::findAllByComboRutina($id_combo);
            if ($id_combo != 10) {
                $pdf->AddPage();
            }
        }
    }
/*    if ($id_servicio == 8) {
    //Siguiente pagina //FOTO AUTORIZACION

        if ($fotoAutorizacion != NULL) {
            $pdf->SetX(25);
            $pdf->AddPage();
            $pdf->Ln(2);
        
            $pdf->SetX(25);
            $getx = $pdf->GetX();
            $pdf->Cell(165, 5, utf8_decode('AUTORIZACIÓN DEL EXAMEN'), 0, 2, 'C', 0);
            $pdf->Cell(0, 2, "", 0, 2, 'C', 0);
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoAutorizacion, $getx + 1, $getY, 163, 218);
            $pdf->Ln(113);
        }
        //Siguiente pagina //FOTO CALIFICACIÓN

        if ($fotoCalificacion != NULL) {
            $pdf->SetX(25);
            $pdf->AddPage();
            $pdf->Ln(2);
        
            $pdf->SetX(25);
            $getx = $pdf->GetX();
            $pdf->Cell(165, 5, utf8_decode('HOJA DE CALIFICACIÓN'), 0, 2, 'C', 0);
            $pdf->Cell(0, 2, "", 0, 2, 'C', 0);
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoCalificacion, $getx + 1, $getY, 163, 218);
            $pdf->Ln(113);
        }
        //Siguiente pagina //FOTO BUEN TRATO

        if ($fotoEvaluacion != NULL) {
            $pdf->SetX(25);
            $pdf->AddPage();
            $pdf->Ln(2);
        
            $pdf->SetX(25);
            $getx = $pdf->GetX();
            $pdf->Cell(165, 5, utf8_decode('FORMATO DEL BUEN TRATO DEL EXAMEN'), 0, 2, 'C', 0);
            $pdf->Cell(0, 2, "", 0, 2, 'C', 0);
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoEvaluacion, $getx + 1, $getY, 163, 218);
            $pdf->Ln(113);
        }

    }*/

}
function insertarImagenCompleta($pdf, $filename, $titulo) {
    $pdf->AddPage();
    $pdf->SetX(25);
    $pdf->Ln(2);

    $pdf->SetX(25);
    $getx = $pdf->GetX();

    // Título
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(165, 5, utf8_decode($titulo), 0, 2, 'C');
    $pdf->Cell(0, 2, "", 0, 2, 'C');

    // Marco negro
    $pdf->SetFillColor(0, 0, 0);
    $pdf->Cell(165, 220, '', 1, 0, '', 1);

    // Imagen
    $getY = $pdf->GetY() + 1;
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if ($extension === 'pdf') {
        try {
            $pdf->setSourceFile($filename);
            $tpl = $pdf->importPage(1);
            $pdf->useTemplate($tpl, $getx + 1, $getY, 163, 218);
        } catch (Exception $e) {
            $pdf->SetXY($getx + 1, $getY + 100);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(163, 5, 'Error al insertar PDF: ' . $e->getMessage(), 0, 0, 'C');
        }
    } else {
        $pdf->Image($filename, $getx + 1, $getY, 163, 218);
    }
    //$pdf->AddPage();
    //$pdf->Ln(113); // Espacio final si deseas mantenerlo
}
