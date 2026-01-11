<?php
function infDimension($pdf, $id_solicitud, $id_servicio)
{
    $pdf->AddPage();
    /*
1	ANTECEDENTES BASES
3	VISITA INGRESO
4	VISITA  MANTENIMIENTO
5	VISITA  TELETRABAJO
6	LABORAL
7	ACADÉMICA
8	PRE-EMPLEO
9	RUTINA
10	ESPECIFICO
11	CENTRALES DE RIESGO
12	VISITA ASOCIADO DE NEGOCIO
*/
    $id_dimension = 0;
    switch ($id_servicio) {
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

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(190, 5, utf8_decode('EVALUACIÓN DE LAS VARIABLES DE DIMENSIÓN'), 0, 2, 'C', 0);
    $pdf->Ln(3);

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


    $pdf->Ln(6);
    $i = 0;
    $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, $id_dimension);

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
    $pdf->Cell(40, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(100, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
    $pdf->Ln(5);

    $pdf->SetWidths(array(50, 40, 100));
    $pdf->SetAligns(array('L', 'C', 'L'));
    foreach ($dimFamiliar['data'] as $row) {
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
    }
}
