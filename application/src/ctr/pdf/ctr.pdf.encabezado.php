<?php
function encabezadoPdf($pdf, $id_solicitud, $id_servicio, $id_combo)
{
    //print_r($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    $servicio = CtrSrvServicio::findByIdServicio($id_servicio);
    $solCombo = CtrSolSolicitud::qry_infSolicitud($id_solicitud);
    $solCombo2 = CtrSolSolicitud::findById($id_solicitud);


    //$pdf = new PDF();
    $pdf->AddPage();

    if ($id_combo == 'null') {
        $pdf->Cell(190, 5, utf8_decode('Informe ' . $servicio['data']['nom_prod'] . ' ' . $servicio['data']['nom_servicio']), 0, 0, 'C', 0);
        $pdf->Ln(8);

        $pdf->SetX(10);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetTextColor(000, 000, 000);
    
        $pdf->SetFont('Arial', 'B', 10);
        if (($id_servicio == 4) || ($id_servicio == 3)) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, "Fecha de Recibo de la Orden:", 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($solicitud['data'][0]['fch_solicitud']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(35, 5, utf8_decode('Fecha de la visita :'), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(55, 5, utf8_decode($solicitud['data'][0]['fecha_programacion']), 1, 2, 'L', 0);
        } else {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, "Fecha de Recibo de la Orden:", 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(140, 5, utf8_decode($solicitud['data'][0]['fch_solicitud']), 1, 2, 'L', 0);
        }

        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Fecha de finalización:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, utf8_decode($solicitud['data'][0]['fecha_termina_proveedor']), 1, 0, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode('Ciudad vacante:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(55, 5, utf8_decode($solicitud['data'][0]['ciudad_vacante']), 1, 2, 'L', 0);
        $pdf->SetX(10);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Empresa Solicitante:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($solicitud['data'][0]['razon_social']), 1, 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Usuario Solicitante:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($solicitud['data'][0]['nom_usuario']), 1, 2, 'L', 0);

        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Nombre del profesional:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(140, 5, utf8_decode($solicitud['data'][0]['proveedor']), 1, 0, 'L', 0);

        $pdf->Ln(10);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
    } else {
        $combo = CtrSrvCombos::findById($id_combo);
        $pdf->Cell(190, 5, utf8_decode('Informe ' . $combo['data']['nom_combo']), 0, 0, 'C', 0);
        $pdf->Ln(8);

        $pdf->SetX(10);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetTextColor(000, 000, 000);
    
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, "Fecha de Recibido:", 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(45, 5, utf8_decode($solCombo['data'][0]['fch_solicitud']), 1, 0, 'L', 0);

        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Fecha de finalización:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(45, 5, utf8_decode($solCombo['data'][0]['fch_fin_solicitud']), 1, 2, 'L', 0);
        
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Nombre de la empresa:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(140, 5, utf8_decode($solCombo['data'][0]['razon_social']), 1, 2, 'L', 0);

        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Nombre funcionario solicitante:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(140, 5, utf8_decode($solCombo['data'][0]['nom_cliente']), 1, 2, 'L', 0);

        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Cargo:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        //print_r($solCombo['data'][0]['cargo']);
        $pdf->Cell(0, 5, utf8_decode($solCombo['data'][0]['cargo']), 1, 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode('Ciudad de realización del proceso:'), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($solCombo['data'][0]['ciudad_vacante']), 1, 2, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 9);
    }
}
