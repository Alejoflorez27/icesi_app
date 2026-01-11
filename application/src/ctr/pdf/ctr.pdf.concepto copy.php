<?php
function infConceptoFinal2($pdf, $id_solicitud, $id_servicio, $id_combo)
{

    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);

    if ($id_combo == 'null') {

        if (($id_servicio == 4) || ($id_servicio == 3)) {
            $pdf->Ln(10);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 5, utf8_decode('INFORME CONSOLIDADO DEL CANDIDATO'), 0, 2, 'C', 0);
            $pdf->Ln(3);

            $porcentaje = CtrDimRespuestas::PorcentajeDimension($id_solicitud, $id_servicio);

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
            $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada el candidato no evidencia riesgos.'), 1, 'J', 1);

            $y2 = $pdf->GetY();
            $pdf->SetXY(57, $y2 - 10);
            //  $pdf->SetXY(57,147);
            $pdf->SetFillColor(0, 166, 90);
            $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada el candidato evidencia un nivel bajo de riesgo'), 1, 'J', 1);

            $y2 = $pdf->GetY();
            $pdf->SetXY(105, $y2 - 10);
            //  $pdf->SetXY(105,147);
            $pdf->SetFillColor(243, 156, 16);
            $pdf->MultiCell(47, 5, utf8_decode('En la variable analizada el candidato evidencia un nivel medio de riesgo'), 1, 'J', 1);

            $y2 = $pdf->GetY();
            $pdf->SetXY(152, $y2 - 10);
            //$pdf->SetXY(152,147);
            $pdf->SetFillColor(221, 75, 57);
            $pdf->MultiCell(48, 5, utf8_decode('En la variable analizada el candidato evidencia un nivel alto de riesgo'), 1, 'J', 1);

            //$pdf->Ln(10);
            $y2 = $pdf->GetY();
            $pdf->SetXY(10, $y2);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetFillColor(0, 173, 215);
            $pdf->Cell(47, 5, utf8_decode('Menor a 1'), 1, 0, 'C', 1);

            //$pdf->SetXY(57,122);
            $pdf->SetFillColor(0, 149, 81);
            $pdf->Cell(48, 5, utf8_decode('1-45'), 1, 0, 'C', 1);

            //$pdf->SetXY(105,122);
            $pdf->SetFillColor(218, 149, 81);
            $pdf->Cell(47, 5, utf8_decode('46-75'), 1, 0, 'C', 1);

            //$pdf->SetXY(152,122);
            $pdf->SetFillColor(199, 67, 51);
            $pdf->Cell(48, 5, utf8_decode('76-100'), 1, 2, 'C', 1);

            $pdf->Ln(6);
            $i = 0;
            foreach ($porcentaje['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(93, 5, utf8_decode($row['nombre_dimension']), 1, 0, 'L', 1);

                /*  $pdf->Cell(12,5,$row['porcentaje'].'%',1,0,'C',0); */
                $pdf->Cell(2, 5, '', 0, 0, 'C', 0);

                if ($row['porcentaje'] <= 1) {
                    $pdf->SetFillColor(0, 192, 239);
                } elseif ($row['porcentaje'] > 1 && $row['porcentaje'] <= 45) {
                    $pdf->SetFillColor(0, 166, 90);
                } elseif ($row['porcentaje'] > 46 && $row['porcentaje'] <= 75) {
                    $pdf->SetFillColor(243, 156, 16);
                } elseif ($row['porcentaje'] > 75 && $row['porcentaje'] <= 100) {
                    $pdf->SetFillColor(221, 75, 57);
                }
                $size = 0;
                if ($row['porcentaje'] == 0) {
                    $size = 1;
                    $tamSize = 9;
                } else {
                    $size = $row['porcentaje'];

                    $tamSize = (85 * $size) / 100;
                }

                $pdf->SetFont('Arial', 'B', 8);

                $pdf->Cell($tamSize, 5, $row['porcentaje'] . '%', 1, 0, 'R', 1);
                $pdf->Cell(85 - $tamSize, 5, '', 0, 2, 'L', 0);

                $y2 = $pdf->GetY();
                $pdf->SetXY(10, $y2);
                $pdf->SetFont('Arial', '', 8);


                $pdf->Ln(2);
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
            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 8);

            $pdf->SetWidths(array(65, 125));
            $pdf->SetAligns(array('L', 'L'));

            $dimConceptoFam = CtrDimConceptoFinal::ConceptoFinalDim($id_solicitud, $id_servicio);
            $pdf->Ln(2);
            foreach ($dimConceptoFam['data'] as $row) {
                $pdf->Row(array(
                    utf8_decode(ucfirst(($row['nombre_dimension']))),
                    (utf8_decode(($row['observacion'])))
                ));
            }
        }

            $concepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);

            $pdf->Ln(8);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('CONCEPTO CONSOLIDADO DEL ESTUDIO'), 0, 0, 'C', 1);
            $pdf->Ln(7);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(50, 5, utf8_decode("Por lo tanto el candidato es:"), 0, 0, 'L', 0);
            $pdf->Cell(140, 5, utf8_decode($concepto['data'][0]['des_concepto']), 0, 1, 'L', 0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetWidths(array(50, 140));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->Row(array(
                utf8_decode('Observacion: '),
                (utf8_decode(ucfirst(strtolower($concepto['data'][0]['observacion']))))
            ));

        if ($id_servicio != 8) {
            // FIRMA DE CALIDAD
            $pdf->Ln(8);
            $firma = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_calidad']);
            $filename = $firma['directorio'] . $firma['nombre_encr'];

            //imprimir firma de calidad
            $y2 = $pdf->GetY();
            $pdf->SetXY(20, $y2);
            if ($filename) {
                $pdf->Image($filename, 20, $y2, 30, 25, substr(strrchr($filename, "."), 1));
            }

            // Cambiar para fijar firma en el mismo lugar siempre
            $pdf->Ln(25);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, "Nombre y Firma Verificador Calidad", 0, 0, 'L', 0);
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 5, utf8_decode($solicitud['data'][0]['usr_calidad']), 0, 0, 'L', 0);
        }
    } else {
        /* Porcetanjes para todos los servicios realizdos*/

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
        $pdf->MultiCell(47, 5, utf8_decode('No se evidencian hallazgos que generen riesgos para la organización y/o el desempeño del cargo.'), 1, 'J', 1);

        $y2 = $pdf->GetY();
        $pdf->SetXY(57, $y2 - 40);
        $pdf->SetFillColor(0, 166, 90);
        $pdf->MultiCell(48, 5, utf8_decode('Se evidencian hallazgos que generan un riesgo bajo, para la organización y/o el desempeño del cargo lo cual indica que pueden ser controlados y su impacto es mínimo.'), 1, 'J', 1);

        $y2 = $pdf->GetY();
        $pdf->SetXY(105, $y2 - 35);
        //  $pdf->SetXY(105,147);
        $pdf->SetFillColor(243, 156, 16);
        $pdf->MultiCell(47, 5, utf8_decode('Se encontraron hallazgos, los cuales, generan un riesgo intermedio para la organización y/o el desempeño del cargo, lo cual afecta el nivel de confiabilidad del evaluado.'), 1, 'J', 1);

        $y2 = $pdf->GetY();
        $pdf->SetXY(152, $y2 - 40);
        //$pdf->SetXY(152,147);
        $pdf->SetFillColor(221, 75, 57);
        $pdf->MultiCell(48, 5, utf8_decode('Se encontraron hallazgos, los cuales, generan un alto riesgo para la organización y/o el desempeño del cargo, lo cual indica un resultado no confiable.'), 1, 'J', 1);

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

        /* FOR para validar los servicios del combo*/
        $combo = CtrSrvCombos::findAllByCombo($id_combo);

        foreach ($combo['data'] as $row) {
            $servicio = $row['id_servicio'];
            $id_dimension = 0;
            switch ($servicio) {
                case 1:
                    $id_dimension = 11;
                case 3:
                    $id_dimension = 1;
                case 4:
                    $id_dimension = 2;
                case 5:
                    $id_dimension = 1;
                case 6:
                    $id_dimension = 5;
                case 7:
                    $id_dimension = 1;
                case 8:
                    $id_dimension = 1;
                case 9:
                    $id_dimension = 1;
                case 10:
                    $id_dimension = 1;
                case 11:
                    $id_dimension = 12;
                case 12:
                    $id_dimension = 1;
                case 13:
                    $id_dimension = 1;
            }
            
            $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $servicio, $id_dimension);

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
        }

        //
        //concepto_final

        // FIRMA DE CALIDAD

        $solCombo = CtrSolSolicitud::qry_infSolicitud($id_solicitud);
        if ($id_combo == 'null') {
            $idCalidad = $solicitud['data'][0]['id_usuario_calidad'];
            $nomCalidad = $solicitud['data'][0]['usr_calidad'];
        } else {
            $idCalidad = $solCombo['data'][0]['id_calidad'];
            $nomCalidad = $solCombo['data'][0]['evaluador_calidad'];
        }


        $pdf->Ln(8);
        $firma = CtrUsuario::consultar($idCalidad);
        $filename = $firma['directorio'] . $firma['nombre_encr'];

        //imprimir firma de calidad
        $y2 = $pdf->GetY();
        $pdf->SetXY(20, $y2);
        if ($filename) {
            $pdf->Image($filename, 20, $y2, 30, 25, substr(strrchr($filename, "."), 1));
        }

        // Cambiar para fijar firma en el mismo lugar siempre
        $pdf->Ln(25);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, "Nombre y Firma Verificador Calidad", 0, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(190, 5, utf8_decode($nomCalidad), 0, 0, 'L', 0);
    }
}
