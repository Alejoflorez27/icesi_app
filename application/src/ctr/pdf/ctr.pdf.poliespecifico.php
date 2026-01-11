<?php
function infPoligrafiaEspecifico($pdf, $id_solicitud, $id_servicio)
{
    $candidato = CtrSolCandidato::findById_candidato_poligrafia($id_solicitud);
    foreach ($candidato['data'] as $row) {

        if (isset($row['nombre_foto'])) {
            $perfil = $row['directorio'] . '/' . $row['nombre_encr'];
        }
        // FOTO CANDIDATO
        $pdf->Ln(15);
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
    $pdf->Ln(50);

    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("PROPOSITO DEL EXAMEN"), 0, 0, 'C', 1);
    $pdf->SetX(10);
    $pdf->Ln(6);

    $proposito = CtrPropositoPolEspecifico::propositoPolEspecificoById($id_solicitud, $id_servicio);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("La empresa ". utf8_decode($solicitud['data'][0]['razon_social'])." solicita evaluación poligráfica con el propósito de determinar si tuvo ".
                                        utf8_decode($proposito['data']['proposito'])), 0, 'J', 0);
    

    $preSalud = CtrPreguntaSaludPolPre::respByCategoria('tipo_pregunta_salud_pol_pre', $id_solicitud, $id_servicio);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("REVISIÓN DE SITUACIÓN MÉDICO - PSICOLÓGICA- IDONEIDAD"), 0, 0, 'C', 1);
    $pdf->SetX(10);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("El Poligrafista diligenció el formato de antecedentes Médico-Psicológicos con las respuestas del evaluado, como condición indispensable para conocer su estado actual y prevenir la intervención de factores externos no controlables en la confiabilidad del resultado; por otra parte se estableció el nivel de sensibilidad psicofisiológica de "
                                        . utf8_decode($candidato['data'][0]['nombre'])." ".utf8_decode($candidato['data'][0]['apellido']).
                                        "  ante la evaluación."), 0, 'J', 0);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(6);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("REPORTE DE LA ENTREVISTA"), 0, 0, 'C', 1);
    $pdf->SetX(6);
    $pdf->Ln(6);

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
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            ucfirst(strtolower(utf8_decode($row['pregunta']))),
            utf8_decode(ucfirst(strtolower($row['respuesta'])))
        ));
    }
    $pdf->Ln(4);
    $obsSalud = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_salud_pol_pre');

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('Observación General de Verificación de Salud'), 0, 0, 'L', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln(6);
    $pdf->MultiCell(190, 5, utf8_decode($obsSalud['data']['observacion']), 0, 'J', 0);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, utf8_decode("RELATO DE LOS HECHOS"), 0, 0, 'C', 1);
    $pdf->SetX(10);
    $pdf->Ln(6);

    $relato = CtrRelatoPolEspecifico::relatoPolEspecificoById($id_solicitud, $id_servicio);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("El día ". utf8_decode($solicitud['data'][0]['fecha_programacion'])." , el señor(a) "
                            .$candidato['data'][0]['nombre']." ".$candidato['data'][0]['apellido']." identificado con C.C. ".$candidato['data'][0]['numero_doc']
                            ." se presentó voluntariamente a las instalaciones de la firma PROHUMANOS ALIADOS ESTRATÉGICOS SAS, ubicada en la Calle 140 NO 10a- 48 oficina 301 con el fin de que se le administrara un examen de poligrafía.\n"
                            ."Al entrevistar al evaluado sobre los hechos, este manifiesta textualmente lo siguiente: ".$relato['data']['relato']
                            ), 0, 'J', 0);

//	PREGUNTAS DE VALIDACION Y PROFUNDIZACION

$pdf->SetFillColor(174, 214, 241);
$pdf->Ln(6);
$pdf->SetX(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, utf8_decode("PREGUNTAS DE VALIDACION Y PROFUNDIZACION"), 0, 0, 'C', 1);
$pdf->SetX(6);
$pdf->Ln(6);

$preValidacion = CtrPregValPolEspecifico::findAll($id_solicitud, $id_servicio);

$pdf->SetFont('Arial', '', 9);

foreach ($preValidacion['data'] as $row) {
    // Pregunta
    $pdf->MultiCell(0, 4, utf8_decode(ucfirst(strtolower($row['pregunta']))), 0, 'L');
    $pdf->Ln(0);

    // Respuesta
    $pdf->MultiCell(0, 4, utf8_decode("R/ " . ucfirst(strtolower($row['respuesta']))), 0, 'L');
    $pdf->Ln(3); // Espaciado entre preguntas
}

// Frase final
//$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 6, utf8_decode("Para finalizar, el evaluado (a) asegura no tener más información que agregar a la presente entrevista."), 0, 'L');



/*
//Areas de Riesgo
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(10);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ÁREAS DE RIESGO'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //Vínculo con personas al margen de la ley
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode("ÁREA 1: VINCULOS O RELACION CON GRUPOS DELICTIVOS"), 1, 'L', 1);

    //lista de vinculos
    $tipoGrupos = CtrPreguntaSaludPolPre::findAllByCombo('tipo_vinculo_grupos_ilegales', $id_solicitud, $id_servicio);
    $descripcionGrupo= '';

    foreach ($tipoGrupos['data'] as $row) {
        $descripcionGrupo .= $row['descripcion']. ', ' ;
    }
    $pdf->SetWidths(array(50,140));
    $pdf->SetAligns(array('L', 'L'));
    $pdf->SetFont('Arial', '', 9);
    $pdf->Row(array(utf8_decode("Lista de Vinculos"), utf8_decode($descripcionGrupo)));


    //comentarios del examinado
    //$comentarios = CtrPreguntaSaludPolPre::findAllByCombo('obs_vinculos_pol_rutina', $id_solicitud, $id_servicio);
    $comentarios = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_vinculos_pol_rutina');
    $pdf->multiCell(190, 5, utf8_decode("Comentarios del examinador: ".($comentarios['data']['observacion'])), 1, 'L', 0);
*/

    //Tecnica de poligrafia
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(3);
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
    $pdf->Ln(5);
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
    $totalCalificaciones = 0; // Variable para acumular las calificaciones
    $contador = 0; // Contador para las calificaciones válidas
    
    foreach ($preguntasRelevantes['data'] as $row) {
        $respuesta = "";
    
        // Procesar la calificación y sumar si es válida
        if ($row['calificacion'] !== null && $row['calificacion'] !== '') {
            $totalCalificaciones += $row['calificacion'];
            $contador++;
        }
    
        if ($row['calificacion'] >= -15 && $row['calificacion'] <= -3) {
            $respuesta = "D.I - indicio de engaño";
        } else if ($row['calificacion'] == null || $row['calificacion'] == '') {
            $respuesta = "N.O - No opinion";
        } else if ($row['calificacion'] >= -2 && $row['calificacion'] <= 0) {
            $respuesta = "I.N.C - Inconcluso";
        } else if ($row['calificacion'] >= 1 && $row['calificacion'] <= 15) {
            $respuesta = "N.D.I - No hay indicios de engaño";
        }
    
        // Generar fila en el PDF
        $pdf->Row(array(
            utf8_decode(ucfirst(strtolower($row['descripcion_tipo_rn']))),
            utf8_decode($row['pregunta']),
            utf8_decode(ucfirst(strtolower($row['resp_candidato']))),
            utf8_decode(($respuesta)),
        ));
    }
    
    // Verificar si se sumaron calificaciones válidas
    if ($contador > 0) {
        // Dividir la suma total entre 4 (o el número de calificaciones válidas)
        $promedioCalificaciones = $totalCalificaciones / 4;
        //echo "El promedio de las calificaciones es: " . $promedioCalificaciones;
    }

    $respuesta = "";
    if ($promedioCalificaciones >= -15 && $promedioCalificaciones <= -3) {
        $respuesta = "S.R - Respuestas significativas de engaño";
    } else if ($promedioCalificaciones == null || $promedioCalificaciones) {
        $respuesta = "N.O - No opinion";
    } else if ($promedioCalificaciones >= -2 && $promedioCalificaciones <= 0) {
        $respuesta = "I.N.C - Inconcluso";
    } else if ($promedioCalificaciones >= 1 && $promedioCalificaciones <= 15) {
        $respuesta = "N.S.R - No reaccion significativa";
    }
    
    $pdf->SetFillColor(174, 214, 241);
    $pdf->Ln(5);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('RESULTADO'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //print_r($solicitud['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    $pdf->multiCell(190, 5, utf8_decode('Después de analizar cuidadosamente, estudiar y evaluar los resultados y las gráficas arrojadas por el sistema de Polígrafo computarizado, es la opinión del examinador que: '. utf8_decode($candidato['data'][0]['nombre'])." ".utf8_decode($candidato['data'][0]['apellido']).", ".$respuesta), 1, 'L', 0);
    /*$pdf->SetFont('Arial', 'B', 9);
    $pdf->multiCell(190, 5, utf8_decode(""), 1, 'L', 0);*/
    //En esta parte va el resultado de la poligrafia

    // En esta Parte va el PostTest si aplica

    $posTest = CtrPosTestPolPre::posTestPolPreById($id_solicitud, $id_servicio);
    //print_r($posTest['data']['aplica']);
    if ($posTest['data']['aplica'] == 1) {
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Ln(5);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('POST-TEST'), 0, 2, 'C', 1);
        $pdf->Ln(3);
    
        //print_r($solicitud['data'][0]);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode($posTest['data']['post_test']), 1, 'L', 0);
        $pdf->Ln(5);


        $pdf->SetFillColor(174, 214, 241);
        $pdf->Ln(5);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('CALIDAD DE LOS DATOS (GRÁFICAS)'), 0, 2, 'C', 1);
        $pdf->Ln(3);
    
        //print_r($solicitud['data'][0]);
        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode('El comportamiento del evaluado durante aplicación de la prueba con el polígrafo (gráficas) fue:'), 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->multiCell(190, 5, utf8_decode($posTest['data']['comportamiento']), 1, 'L', 0);

        $pdf->SetFont('Arial', '', 9);
        $pdf->multiCell(190, 5, utf8_decode('Por lo tanto, en los datos fisiológicos obtenidos durante esta evaluación se observó que los registros (gráficos) seconsideran:'), 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 9);
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
    $pdf->Ln(5);
    //$pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('ADMISIONES Y COMENTARIOS DE INTERES'), 0, 2, 'C', 1);
    $pdf->Ln(3);

    //print_r($solicitud['data'][0]);
    $pdf->SetFont('Arial', '', 9);
    $pdf->multiCell(190, 5, utf8_decode($descripcionAdmisiones), 1, 'L', 0);
    $pdf->Ln(5);

    //$pdf->Ln(5);

    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, utf8_decode('ACTITUD Y COMPROMISO DEL CANDIDATO CON EL PROCESO'), 0, 0, 'C', 1);
    $pdf->Ln(8);
    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 5);
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

    $pdf->Ln(9);

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

        // Mostrar imagen o dejar espacio
        $pdf->SetXY(20, $y_firma);
        if (!empty($filename_proveedor) && file_exists($filename_proveedor)) {
            $extension = strtolower(pathinfo($filename_proveedor, PATHINFO_EXTENSION));
            $pdf->Image($filename_proveedor, 25, $y_firma, 30, 25, $extension);
        } else {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(20, $y_firma + 10);
            $pdf->Cell(30, 5, "", 0, 0, 'C');//mensaje de firma
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
    //$fotoCalificacion = '';
    //$fotoEvaluacion = '';


    foreach ($fotos['data'] as $row) {

        if ($row['descripcion'] == 'AUTORIZACIÓN') {
            $fotoAutorizacion = $row['directorio'] . '/' . $row['nombre_encr'];
        }
    }

if ($id_servicio == 10) {
    $imagenesEspeciales = [
        [$fotoAutorizacion, 'AUTORIZACIÓN DEL EXAMEN']
    ];

    foreach ($imagenesEspeciales as [$archivo, $titulo]) {
        if (!empty($archivo) && file_exists($archivo)) {
            insertarImagenCompleta($pdf, $archivo, $titulo);
        }
    }
}

}
/*function insertarImagenCompleta($pdf, $filename, $titulo) {
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

    // Imagen o PDF
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

    $pdf->Ln(113);
}*/