<?php
function piePaginaPdf($pdf, $id_solicitud, $id_servicio)
{

    // $pdf->AddPage();


    //ADJUNTO DE FOTOS
    //   $pdf->SetFont('Arial', 'B', 8);
    //   $pdf->Cell(190, 5, utf8_decode("REGISTRO FOTOGRÁFICO"), 0, 0, 'C', 0);


    $fotos = CtrSolAdjuntos::descripcionAdjuntos($id_solicitud);

$fotoAutorizacion = $fotoAutorizacionSinEncrptar = '';
$fotoCandidato = $fotoCandidatoSinEncrptar = '';
$fotoCertificado = $fotoCertificadoSinEncrptar = '';
$fotoEntradaApto = $fotoEntradaAptoSinEncrptar = '';
$fotoTorre = $fotoTorreSinEncrptar = '';
$fotoProfesional = $fotoProfesionalSinEncrptar = '';
$fotoAdicional = $fotoAdicionalSinEncrptar = '';
$fotoServiciosP = $fotoServiciosPSinEncrptar = '';
$fotoCedula = $fotoCedulaSinEncrptar = '';

foreach ($fotos['data'] as $row) {
    if ($row['descripcion'] == 'AUTORIZACIÓN') {
        $fotoAutorizacion = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoAutorizacionSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'FOTO DEL CANDIDATO Y SU FAMILIA') {
        $fotoCandidato = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoCandidatoSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'CERTIFICADOS ACADEMICOS') {
        $fotoCertificado = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoCertificadoSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'FOTO DE LA ENTRADA DEL APARTAMENTO') {
        $fotoEntradaApto = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoEntradaAptoSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'FOTO DE LA TORRE') {
        $fotoTorre = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoTorreSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'FOTO DEL CANDIDATO CON LA PROFESIONAL DE VISITAS') {
        $fotoProfesional = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoProfesionalSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'RECIBO DE SERVICIO PUBLICO') {
        $fotoServiciosP = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoServiciosPSinEncrptar = $row['nombre'];
    } else if ($row['descripcion'] == 'CEDULA DE CIUDADANIA') {
        $fotoCedula = $row['directorio'] . '/' . $row['nombre_encr'];
        $fotoCedulaSinEncrptar = $row['nombre'];
    }
}

    

/*    if ($id_servicio == 4) {
        // FOTO CANDIDATO
        $pdf->Ln(10);
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoCandidato;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        $pdf->SetXY(23, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DEL CANDIDATO Y SU FAMILIA"), 0, 0, 'C', 0);

        // FOTO CANDIDATO y profesional
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        $filename = $fotoProfesional;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }

        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DEL CANDIDATO CON EL PROFESIONAL DE VISITAS"), 0, 0, 'C', 0);

        $pdf->Ln(10);
        $pdf->SetX(23);
        $getX = $pdf->GetX() + 1;
        // FOTO de la torre
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoTorre;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        } //FIN

        $pdf->SetXY(23, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DE LA TORRE"), 0, 0, 'C', 0);


        // FOTO entrada del apto.
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        //ZONA SOCIAL
        $filename = $fotoEntradaApto;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DE LA ENTRADA DEL APARTAMENTO"), 0, 1, 'C', 0);

        $pdf->Ln(15);
    } // FIN ADJUNTOS VISITA MANTENIMIENTO
*/
    //Siguiente pagina //FOTO AUTORIZACION
    $solicitud  = CtrSolSolicitud::findById($id_solicitud);
    $id_combo = $solicitud['data']['id_combo'];

    $rutina = CtrSrvCombos::findAllByComboRutina($id_combo);

    //print_r($rutina);

    if ($fotoAutorizacion != NULL && ($rutina['data'][0]['tiene_rutina'] != "1")) {
        $pdf->AddPage();
        $pdf->SetX(25);
        $pdf->Ln(2);

        $getx = $pdf->GetX();
        $pdf->SetX(25);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(165, 5, utf8_decode('AUTORIZACIÓN'), 0, 2, 'C');
        $pdf->Cell(0, 2, "", 0, 2, 'C');

        $extension = strtolower(pathinfo($fotoAutorizacion, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            // Verifica que estés usando una clase que extienda Fpdi
            try {
                $pageCount = $pdf->setSourceFile($fotoAutorizacion);
                $tpl = $pdf->importPage(1);
                $getx = $pdf->GetX();
                $pdf->SetX(25);
                $pdf->SetFillColor(0, 0, 0);
                $pdf->Cell(165, 220, '', 1, 0, '', 1);
                $pdf->useTemplate($tpl, 26, 55, 163);
            } catch (Exception $e) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(0, 10, 'Error cargando autorizacion no hay archivo: ' . $e->getMessage(), 0, 1, 'C');
            }
        } else {
            validarImagen($fotoAutorizacion, $fotoAutorizacionSinEncrptar);
            // ✅ Si todo está bien, insertar en el PDF
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoAutorizacion, $getx + 16, $getY, 163, 218);
            $pdf->Ln(113);


/*
            // Imagen: JPG o PNG
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoAutorizacion, $getx + 16, $getY, 163, 218);
            $pdf->Ln(113);*/
        }
    }

    //foto cedula

    if ($fotoCedula != NULL) {
        $pdf->AddPage();
        $pdf->SetX(25);
        $pdf->Ln(2);

        $getx = $pdf->GetX();
        $pdf->SetX(25);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(165, 5, utf8_decode('CÉDULA DE CIUDADANÍA'), 0, 2, 'C');
        $pdf->Cell(0, 2, "", 0, 2, 'C');

        $extension = strtolower(pathinfo($fotoCedula, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            try {
                $pageCount = $pdf->setSourceFile($fotoCedula);
                $tpl = $pdf->importPage(1);
                $getx = $pdf->GetX();
                $pdf->SetX(25);
                $pdf->SetFillColor(0, 0, 0);
                $pdf->Cell(165, 220, '', 1, 0, '', 1);
                $pdf->useTemplate($tpl, 26, 55, 163);
            } catch (Exception $e) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(0, 10, 'Error cargando cedula no existe archivo: ' . $e->getMessage(), 0, 1, 'C');
            }
        } else {
            validarImagen($fotoCedula, $fotoCedulaSinEncrptar);
            // Imagen: JPG o PNG
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoCedula, $getx + 16, $getY, 163, 218);
            $pdf->Ln(113);
        }
    }

    //foto certificado
    
    if ($fotoCertificado != NULL) {
        $pdf->AddPage();
        $pdf->SetX(25);
        $pdf->Ln(2);

        $getx = $pdf->GetX();
        $pdf->SetX(25);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(165, 5, utf8_decode('CERTIFICADO ACADÉMICO'), 0, 2, 'C');
        $pdf->Cell(0, 2, "", 0, 2, 'C');

        $extension = strtolower(pathinfo($fotoCertificado, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            try {
                $pageCount = $pdf->setSourceFile($fotoCertificado);
                $tpl = $pdf->importPage(1);
                $pdf->SetX(25);
                $pdf->SetFillColor(0, 0, 0);
                $pdf->Cell(165, 220, '', 1, 0, '', 1);
                $pdf->useTemplate($tpl, 26, 55, 163);
            } catch (Exception $e) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(0, 10, 'Error cargando certificado no existe archivo: ' . $e->getMessage(), 0, 1, 'C');
            }
        } else {
            validarImagen($fotoCertificado, $fotoCertificadoSinEncrptar);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoCertificado, $getx + 16, $getY, 163, 218);
            $pdf->Ln(113);
        }
    }


if ($fotoServiciosP != NULL) {
    $pdf->AddPage();
    $pdf->SetX(25);
    $pdf->Ln(2);

    $getx = $pdf->GetX();
    $pdf->SetX(25);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(165, 5, utf8_decode('RECIBO DE SERVICIO PÚBLICO'), 0, 2, 'C');
    $pdf->Cell(0, 2, "", 0, 2, 'C');

    $extension = strtolower(pathinfo($fotoServiciosP, PATHINFO_EXTENSION));

    if ($extension === 'pdf') {
        try {
            $pageCount = $pdf->setSourceFile($fotoServiciosP);
            $tpl = $pdf->importPage(1);
            $pdf->SetX(25);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $pdf->useTemplate($tpl, 26, 55, 163);
        } catch (Exception $e) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(0, 10, 'Error cargando recibo de servicio publico: ' . $e->getMessage(), 0, 1, 'C');
        }
    } else {
        validarImagen($fotoServiciosP, $fotoServiciosPSinEncrptar);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Cell(165, 220, '', 1, 0, '', 1);
        $getY = $pdf->GetY() + 1;
        $pdf->Image($fotoServiciosP, $getx + 16, $getY, 163, 218);
        $pdf->Ln(113);
    }
}


foreach ($fotos['data'] as $row) {
    if ($row['descripcion'] == 'ARCHIVOS ADICIONALES') {
        $fotoAdicional = $row['directorio'] . '/' . $row['nombre_encr'];

        if ($fotoAdicional != NULL) {
            $pdf->AddPage();
            $pdf->SetX(25);
            $pdf->Ln(2);

            $getx = $pdf->GetX();
            $pdf->SetX(25);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(165, 5, utf8_decode('ARCHIVO ADICIONAL'), 0, 2, 'C');
            $pdf->Cell(0, 2, "", 0, 2, 'C');

            $extension = strtolower(pathinfo($fotoAdicional, PATHINFO_EXTENSION));

            if ($extension === 'pdf') {
                try {
                    $pageCount = $pdf->setSourceFile($fotoAdicional);
                    $tpl = $pdf->importPage(1);
                    $pdf->SetX(25);
                    $pdf->SetFillColor(0, 0, 0);
                    $pdf->Cell(165, 220, '', 1, 0, '', 1);
                    $pdf->useTemplate($tpl, 26, 55, 163);
                } catch (Exception $e) {
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->SetFillColor(000, 000, 000);
                    $pdf->Cell(0, 10, 'Error cargando archivo adicional: ' . $e->getMessage(), 0, 1, 'C');
                }
            } else {
                validarImagen($fotoAdicional, $fotoAdicionalSinEncrptar);
                $pdf->SetFillColor(0, 0, 0);
                $pdf->Cell(165, 215, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($fotoAdicional, $getx + 16, $getY, 163, 213);
            }
        }
    }
}

}

/**
 * Valida que una imagen exista, sea JPG o PNG,
 * y que la extensión coincida con el contenido real.
 */
function validarImagen($ruta, $nombreOriginal = '') {
    if (empty($ruta)) {
        return null; // No hay imagen cargada
    }

    if (!file_exists($ruta)) {
        throw new Exception("El archivo '{$nombreOriginal}' no existe en la ruta esperada.");
    }

    $tipoReal = @exif_imagetype($ruta);

    if ($tipoReal === false) {
        throw new Exception("El archivo '{$nombreOriginal}' no es una imagen válida.");
    }

    $mimeReal = image_type_to_mime_type($tipoReal);
    $extension = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));

    if ($tipoReal !== IMAGETYPE_JPEG && $tipoReal !== IMAGETYPE_PNG) {
        throw new Exception("El archivo '{$nombreOriginal}' no es válido. Se esperaba JPG o PNG, pero el contenido es: $mimeReal");
    }

    if ($tipoReal == IMAGETYPE_JPEG && $extension !== 'jpg' && $extension !== 'jpeg') {
        throw new Exception("El archivo '{$nombreOriginal}' tiene extensión .$extension pero en realidad es una imagen JPG.");
    }

    if ($tipoReal == IMAGETYPE_PNG && $extension !== 'png') {
        throw new Exception("El archivo '{$nombreOriginal}' tiene extensión .$extension pero en realidad es una imagen PNG.");
    }

    return true; // ✅ Todo correcto
}

