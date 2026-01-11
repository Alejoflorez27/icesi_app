<?php
function infConceptoFinal($pdf, $id_solicitud, $id_servicio, $id_combo)
{
    //print_r($id_combo);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    $conceptoSol  = CtrSolSolicitud::findById($id_solicitud);

    if ($id_combo == 'null') {

        if (($id_servicio == 4) || ($id_servicio == 3)) {
            $pdf->Ln(5);
            //$pdf->SetX(10);
            $obj_solSolicitud = new SolSolicitud($id_solicitud);
            $id_combo_izq = $obj_solSolicitud->getIdCombo('id_combo');

            $mantenimiento = CtrSrvCombos::findAllByComboMantenimiento($id_combo_izq);
            $pdf->SetFont('Arial', 'B', 9);
            if ($mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
                $pdf->Cell(190, 5, utf8_decode('INFORME CONSOLIDADO DEL FUNCIONARIO'), 0, 2, 'C', 0);
            }else{
                $pdf->Cell(190, 5, utf8_decode('INFORME CONSOLIDADO DEL CANDIDATO'), 0, 2, 'C', 0);
            }
            $pdf->Ln(3);

            $porcentaje = CtrDimRespuestas::PorcentajeDimension($id_solicitud, $id_servicio);

                $pdf->Ln(3);

                $y2 = $pdf->GetY();
                $pdf->SetXY(10, $y2);
                $pdf->SetFillColor(0, 192, 239);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(47, 4, utf8_decode("RIESGO INEXISTENTE"), 1, 0, 'C', 1);

                $pdf->SetFillColor(0, 166, 90);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(48, 4, utf8_decode("RIESGO BAJO"), 1, 0, 'C', 1);

                $pdf->SetFillColor(243, 156, 16);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(47, 4, utf8_decode("RIESGO INTERMEDIO"), 1, 0, 'C', 1);

                $pdf->SetFillColor(221, 75, 57);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(48, 4, utf8_decode("RIESGO ALTO"), 1, 0, 'C', 1);

                $pdf->Ln(4);
                $pdf->SetFont('Arial', '', 7);
                $pdf->SetFillColor(0, 192, 239);
                $pdf->MultiCell(47, 4, utf8_decode('No se evidencian hallazgos que generen riesgos para la organización y/o el desempeño del cargo.                                                                                                                                 '), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(57, $y2 - 20);
                $pdf->SetFillColor(0, 166, 90);
                $pdf->MultiCell(48, 4, utf8_decode('Se evidencian hallazgos que generan un riesgo bajo, para la organización y/o el desempeño del cargo lo cual indica que pueden ser controlados y su impacto es mínimo.'), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(105, $y2 - 20);
                //  $pdf->SetXY(105,147);
                $pdf->SetFillColor(243, 156, 16);
                $pdf->MultiCell(47, 4, utf8_decode('Se encontraron hallazgos, los cuales, generan un riesgo intermedio para la organización y/o el desempeño del cargo, lo cual afecta el nivel de confiabilidad del evaluado.'), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(152, $y2 - 20);
                //$pdf->SetXY(152,147);
                $pdf->SetFillColor(221, 75, 57);
                $pdf->MultiCell(48, 4, utf8_decode('Se encontraron hallazgos, los cuales, generan un alto riesgo para la organización y/o el desempeño del cargo, lo cual indica un resultado no confiable.                     '), 1, 'J', 1);
                //$pdf->Ln(5);
                $y2 = $pdf->GetY();
                $pdf->SetXY(10, $y2);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetFillColor(0, 173, 215);
                $pdf->Cell(47, 4, utf8_decode('Nivel de riesgo 0'), 1, 0, 'C', 1);
                $pdf->SetFillColor(0, 149, 81);
                $pdf->Cell(48, 4, utf8_decode('Nivel de riesgo 1'), 1, 0, 'C', 1);
                $pdf->SetFillColor(218, 149, 81);
                $pdf->Cell(47, 4, utf8_decode('Nivel de riesgo 2'), 1, 0, 'C', 1);
                $pdf->SetFillColor(199, 67, 51);
                $pdf->Cell(48, 4, utf8_decode('Nivel de riesgo 3'), 1, 2, 'C', 1);
                $pdf->Ln(0);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetFillColor(0, 173, 215);
                $pdf->Cell(47, 4, utf8_decode('Porcentaje Menor a 1'), 1, 0, 'C', 1);
                $pdf->SetFillColor(0, 149, 81);
                $pdf->Cell(48, 4, utf8_decode('Porcentaje entre 1-45'), 1, 0, 'C', 1);
                $pdf->SetFillColor(218, 149, 81);
                $pdf->Cell(47, 4, utf8_decode('Porcentaje entre 46-75'), 1, 0, 'C', 1);
                $pdf->SetFillColor(199, 67, 51);
                $pdf->Cell(48, 4, utf8_decode('Porcentaje entre 76-100'), 1, 1, 'C', 1);
                
                $pdf->Ln(6); //salto de linea alto(6)
            $i = 0;

                    $nomServicio = CtrSrvServicio::findByIdServicio($id_servicio);
                    //print_r($nomServicio['data']['nom_servicio']);
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->Cell(190, 4, utf8_decode($nomServicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(5);
            foreach ($porcentaje['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', 'B', 7);
                //$pdf->Cell(dimX, dimY, utf8_decode($row['nombre_dimension']), borde(1), 0, 'ubicacion texto', 1);
                if ($id_servicio == 4 || $mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
                    $nombre_original = $row['nombre_dimension'];
                    $nombre = str_replace('CANDIDATO', 'FUNCIONARIO', $nombre_original);
                    $pdf->Cell(95, 5, utf8_decode($nombre), 1, 0, 'L', 1);
                } else {
                    $pdf->Cell(95, 5, utf8_decode($row['nombre_dimension']), 1, 0, 'L', 1);
                }
                
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
                $pdf->Cell($tamSize, 5, $row['porcentaje'] . '%', 1, 1, 'R', 1);
            //  $y2 = $pdf->GetY();
            //  $pdf->SetXY(10, $y2);
                $pdf->SetFont('Arial', '', 8);
                //$pdf->Ln(2);
                $i = $i + 1;
            }

            $concepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('CONCEPTO FINAL'), 0, 0, 'C', 1);
            $pdf->Ln(7);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(50, 5, utf8_decode("Por lo tanto el candidato es:"), 0, 0, 'L', 0);
            $pdf->Cell(140, 5, utf8_decode($concepto['data']['des_concepto']), 0, 1, 'L', 0);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('J', 'L'));
            $pdf->Row(array(
            // utf8_decode('Observacion: '),
                (utf8_decode(ucfirst(strtolower($conceptoSol['data']['obs_calidad']))))
            ));
        }
        if (($id_servicio == 6) || ($id_servicio == 7) || ($id_servicio == 1) || ($id_servicio == 11)) {
            $concepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);

            $pdf->Ln(8);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('CONCEPTO FINAL SEVICIO'), 0, 0, 'C', 1);
            $pdf->Ln(7);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(50, 5, utf8_decode("Por lo tanto el candidato es:"), 0, 0, 'L', 0);
            $pdf->Cell(140, 5, utf8_decode($concepto['data'][0]['des_concepto']), 0, 1, 'L', 0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetWidths(array(50, 140));
            $pdf->SetAligns(array('J', 'L'));
            $pdf->Row(array(
                utf8_decode('Observacion: '),
                (utf8_decode(ucfirst(strtolower($concepto['data'][0]['observacion']))))
            ));
        }
        if ($id_servicio != 8) {
            if ($id_servicio != 12) {
                // FIRMA DE CALIDAD
                $pdf->Ln(8);
                $firma = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_calidad']);
                $filename_calidad = $firma['directorio'] . $firma['nombre_encr'];

                //$y_firma = $pdf->GetY(); // Guardamos la posición Y para ambas firmas



                // Margen inferior fijo
                $margenInferior = 10; 
                $alturaFirma = 50; // Imagen + texto
                $posicionY = $pdf->GetY();
                $alturaPagina = $pdf->GetPageHeight() - $margenInferior;

                // Si no hay espacio suficiente para la firma y el texto, saltar a nueva página
                if ($posicionY + $alturaFirma > $alturaPagina) {
                    $pdf->AddPage();
                    $posicionY = $pdf->GetY();
                }

                // ---- Imprimir firmas ----
                if ($solicitud['data'][0]['perfil_proveedor'] == 10) {
                    // FIRMA DE CALIDAD
                    $pdf->SetXY(20, $posicionY);
                    if (!empty($filename_calidad)) {
                        $pdf->Image($filename_calidad, 20, $posicionY, 30, 25, substr(strrchr($filename_calidad, "."), 1));
                    }

                } else {
                    // SOLO FIRMA DE CALIDAD
                    $pdf->SetXY(20, $posicionY);
                    if (!empty($filename_calidad)) {
                        $pdf->Image($filename_calidad, 20, $posicionY, 30, 25, substr(strrchr($filename_calidad, "."), 1));
                    }
                }

                // ---- Texto debajo de las firmas ----
                if ($id_servicio != 5) {
                    $pdf->Ln(25);
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->SetXY(30, $pdf->GetY());
                    $pdf->Cell(30, 5, "Nombre y Firma Verificador Calidad", 0, 0, 'C');

                    $pdf->SetFont('Arial', '', 8);
                    $pdf->SetXY(30, $pdf->GetY() + 5);
                    $pdf->Cell(30, 5, utf8_decode($solicitud['data'][0]['usr_calidad']), 0, 0, 'C');

                }

            }


        }
    } else {
        $mantenimiento = CtrSrvCombos::findAllByComboMantenimiento($id_combo);
        if (/*$id_combo != 3 ||*/ ($id_combo != 5)) {
            if (!in_array($id_combo, [3, 10, 11, 12])) {
                
                //print_r($mantenimiento);
                $pdf->Ln(5);
                //$pdf->SetX(10);
                $pdf->SetFont('Arial', 'B', 9);
                //print_r($id_servicio);
                if ($mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
                    $pdf->Cell(190, 5, utf8_decode('INFORME CONSOLIDADO DEL FUNCIONARIO'), 0, 2, 'C', 0);
                }else{
                    $pdf->Cell(190, 5, utf8_decode('INFORME CONSOLIDADO DEL CANDIDATO'), 0, 2, 'C', 0);
                }
                
                $pdf->Ln(3);

                $y2 = $pdf->GetY();
                $pdf->SetXY(10, $y2);
                $pdf->SetFillColor(0, 192, 239);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(47, 4, utf8_decode("RIESGO INEXISTENTE"), 1, 0, 'C', 1);

                $pdf->SetFillColor(0, 166, 90);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(48, 4, utf8_decode("RIESGO BAJO"), 1, 0, 'C', 1);

                $pdf->SetFillColor(243, 156, 16);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(47, 4, utf8_decode("RIESGO INTERMEDIO"), 1, 0, 'C', 1);

                $pdf->SetFillColor(221, 75, 57);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(48, 4, utf8_decode("RIESGO ALTO"), 1, 0, 'C', 1);

                $pdf->Ln(4);
                $pdf->SetFont('Arial', '', 7);
                $pdf->SetFillColor(0, 192, 239);
                $pdf->MultiCell(47, 4, utf8_decode('No se evidencian hallazgos que generen riesgos para la organización y/o el desempeño del cargo.                                                                                                                                 '), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(57, $y2 - 20);
                $pdf->SetFillColor(0, 166, 90);
                $pdf->MultiCell(48, 4, utf8_decode('Se evidencian hallazgos que generan un riesgo bajo, para la organización y/o el desempeño del cargo lo cual indica que pueden ser controlados y su impacto es mínimo.'), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(105, $y2 - 20);
                //  $pdf->SetXY(105,147);
                $pdf->SetFillColor(243, 156, 16);
                $pdf->MultiCell(47, 4, utf8_decode('Se encontraron hallazgos, los cuales, generan un riesgo intermedio para la organización y/o el desempeño del cargo, lo cual afecta el nivel de confiabilidad del evaluado.'), 1, 'J', 1);

                $y2 = $pdf->GetY();
                $pdf->SetXY(152, $y2 - 20);
                //$pdf->SetXY(152,147);
                $pdf->SetFillColor(221, 75, 57);
                $pdf->MultiCell(48, 4, utf8_decode('Se encontraron hallazgos, los cuales, generan un alto riesgo para la organización y/o el desempeño del cargo, lo cual indica un resultado no confiable.                     '), 1, 'J', 1);
                //$pdf->Ln(5);
                $y2 = $pdf->GetY();
                $pdf->SetXY(10, $y2);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetFillColor(0, 173, 215);
                $pdf->Cell(47, 4, utf8_decode('Nivel de riesgo 0'), 1, 0, 'C', 1);
                $pdf->SetFillColor(0, 149, 81);
                $pdf->Cell(48, 4, utf8_decode('Nivel de riesgo 1'), 1, 0, 'C', 1);
                $pdf->SetFillColor(218, 149, 81);
                $pdf->Cell(47, 4, utf8_decode('Nivel de riesgo 2'), 1, 0, 'C', 1);
                $pdf->SetFillColor(199, 67, 51);
                $pdf->Cell(48, 4, utf8_decode('Nivel de riesgo 3'), 1, 2, 'C', 1);
                $pdf->Ln(0);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->SetFillColor(0, 173, 215);
                $pdf->Cell(47, 4, utf8_decode('Porcentaje Menor a 1'), 1, 0, 'C', 1);
                $pdf->SetFillColor(0, 149, 81);
                $pdf->Cell(48, 4, utf8_decode('Porcentaje entre 1-45'), 1, 0, 'C', 1);
                $pdf->SetFillColor(218, 149, 81);
                $pdf->Cell(47, 4, utf8_decode('Porcentaje entre 46-75'), 1, 0, 'C', 1);
                $pdf->SetFillColor(199, 67, 51);
                $pdf->Cell(48, 4, utf8_decode('Porcentaje entre 76-100'), 1, 1, 'C', 1);
                
                $pdf->Ln(6); //salto de linea alto(6)




                /* FOR para validar los servicios del combo*/
$combo = CtrSrvCombos::findAllByComboOrden($id_combo);
$mantenimiento = CtrSrvCombos::findAllByComboMantenimiento($id_combo);

$procesados = []; // <-- aquí guardamos servicios ya tratados

foreach ($combo['data'] as $row) {
    if (!in_array($row['id_servicio'], [8, 9, 10])) {
        $servicio = $row['id_servicio'];

        // evitar duplicados
        if (in_array($servicio, $procesados)) {
            continue; // si ya se procesó, saltamos
        }
        $procesados[] = $servicio;

        $dimenciones = CtrDimRespuestas::dimencionXservicio($servicio);
        $nomServicio = CtrSrvServicio::findByIdServicio($servicio);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 4, utf8_decode($nomServicio['data']['nom_servicio']), 0, 0, 'C', 0);
        $pdf->Ln(5);

        foreach ($dimenciones['data'] as $rowD) {
            $dimencion = $rowD['id_dimension'];

            $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $servicio, $dimencion);

            foreach ($porcentaje['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', 'B', 7);

                if ($servicio == 4 || $mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
                    $nombre_original = $row['nombre_dimension'];
                    $nombre = str_replace('CANDIDATO', 'FUNCIONARIO', $nombre_original);
                    $pdf->Cell(95, 5, utf8_decode($nombre), 1, 0, 'L', 1);
                } else {
                    $pdf->Cell(95, 5, utf8_decode($row['nombre_dimension']), 1, 0, 'L', 1);
                }

                // Colorear celda por rango
                if ($row['porcentaje'] <= 1) {
                    $pdf->SetFillColor(0, 192, 239);
                } elseif ($row['porcentaje'] > 1 && $row['porcentaje'] <= 45) {
                    $pdf->SetFillColor(0, 166, 90);
                } elseif ($row['porcentaje'] > 46 && $row['porcentaje'] <= 75) {
                    $pdf->SetFillColor(243, 156, 16);
                } elseif ($row['porcentaje'] > 75 && $row['porcentaje'] <= 100) {
                    $pdf->SetFillColor(221, 75, 57);
                }

                $pdf->Cell(95, 5, $row['porcentaje'] . '%', 1, 1, 'R', 1);
                $pdf->SetFont('Arial', '', 8);
            }
        }
    }
}

                //concepto_final
                //$concepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
                $rutina = CtrSrvCombos::findAllByComboRutina($id_combo);
                //print_r($rutina);

                if ($rutina['data'][0]['tiene_rutina'] != "1") {

                    $pdf->Ln(5);
                    //$pdf->AddPage();
                    //print_r($conceptoSol);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->SetFillColor(174, 214, 241);
                    $pdf->Cell(190, 5, utf8_decode('CONCEPTO CONSOLIDADO DEL ESTUDIO'), 0, 0, 'C', 1);
                    $pdf->Ln(7);
                    $pdf->SetFont('Arial', 'B', 9);
                    if ($mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
                        $pdf->Cell(50, 5, utf8_decode("Por lo tanto el funcionario es:"), 0, 0, 'L', 0);
                    }else{
                        $pdf->Cell(50, 5, utf8_decode("Por lo tanto el candidato es:"), 0, 0, 'L', 0);
                    }
                    
                    $pdf->Cell(140, 5, utf8_decode($conceptoSol['data']['des_concepto']), 0, 1, 'L', 0);
                    $pdf->Ln(3);
                    $pdf->Cell(50, 5, utf8_decode("Observación:"), 0, 0, 'L', 0);
                    
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(190, 4, utf8_decode(capitalizarOraciones($conceptoSol['data']['obs_calidad'])), 1, 'J');

                    // OBTENER INFORMACIÓN DE LA SOLICITUD
                    //print_r($id_solicitud);
                    $solCombo = CtrSolSolicitud::qry_infSolicitud($id_solicitud);
                    //$solComboId = CtrSolSolicitud::qry_infSolicitudCombo($id_solicitud);
                    //print_r($solCombo['data'][0]);

                    // Determinar datos de calidad
                    if ($id_combo == 'null') {
                        $idCalidad = $solicitud['data'][0]['id_usuario_calidad'];
                        $nomCalidad = $solicitud['data'][0]['usr_calidad'];
                    } else {
                        $idCalidad = $solCombo['data'][0]['id_calidad'];
                        $nomCalidad = $solCombo['data'][0]['evaluador_calidad'];
                    }

                    /*// Determinar datos del proveedor
                    if ($id_combo == 'null') {
                        $idProveedor = $solicitud['data'][0]['id_usuario_asig'];
                        $nomProveedor = $solicitud['data'][0]['proveedor'];
                    } else if ($solComboId['data'][0]['resultado'] == 1){
                        $idProveedor = $solComboId['data'][0]['id_usuario_asig'];
                        $nomProveedor = $solComboId['data'][0]['nombre_proveedor'];
                        $registroProveedor = $solComboId['data'][0]['registro'];
                    }*/

                    // POSICIÓN INICIAL
                    $pdf->Ln(5);
                    $y_firma = $pdf->GetY();

                    // Margen inferior
                    $margenInferior = 10;
                    $alturaFirma = 50; // Imagen (25) + texto (25)
                    $alturaPagina = $pdf->GetPageHeight() - $margenInferior;

                    // ✅ Verificar espacio disponible
                    if ($y_firma + $alturaFirma > $alturaPagina) {
                        $pdf->AddPage();
                        $y_firma = $pdf->GetY();
                    }

                    // FIRMA DE CALIDAD
                    $firma_calidad = CtrUsuario::consultar($idCalidad);
                    $filename_calidad = $firma_calidad['directorio'] . $firma_calidad['nombre_encr'];

                    // Imprimir firma de calidad
                    $pdf->SetXY(20, $y_firma);
                    if (!empty($filename_calidad) && file_exists($filename_calidad)) {
                        $pdf->Image($filename_calidad, 20, $y_firma, 30, 25, substr(strrchr($filename_calidad, "."), 1));
                    }

                    // TEXTO DE LOS NOMBRES Y TÍTULOS
                    $pdf->Ln(25); // Después de la imagen

                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->SetXY(20, $pdf->GetY());
                    $pdf->Cell(80, 5, "Nombre y Firma Verificador Calidad", 0, 0, 'L');

                    $pdf->SetFont('Arial', '', 8);
                    $pdf->SetXY(20, $pdf->GetY() + 5);
                    $pdf->Cell(80, 5, utf8_decode($nomCalidad), 0, 0, 'L');


                    
                }


            }


        }
    }

}
function capitalizarOraciones($texto) {
    $texto = trim($texto);
    // Capitaliza la primera letra del texto
    $texto = mb_strtoupper(mb_substr($texto, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($texto, 1, null, 'UTF-8');

    // Capitaliza después de punto, signo de pregunta o exclamación
    $texto = preg_replace_callback('/([.!?]\s*)([a-z])/u', function ($match) {
        return $match[1] . mb_strtoupper($match[2], 'UTF-8');
    }, $texto);

    return $texto;
}