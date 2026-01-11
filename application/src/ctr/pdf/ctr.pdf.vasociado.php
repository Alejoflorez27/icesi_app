<?php

function infVisAsociadoNegocio($pdf, $id_solicitud, $id_servicio)
{
    //$pdf->AddPage();
    $candidato = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    //print_r($candidato['data'][0]['persona_visita']);
    $pdf->Ln(5);

    if (isset($id_solicitud) && $id_solicitud != "" && $id_solicitud != null) {
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('I. Certificaciones'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(40, 30, 10, 40, 70));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('Sistema de Gestión'),
                            utf8_decode('Estado'),
                            utf8_decode('SI'),
                            utf8_decode('Código de la Certificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(40, 30, 10, 40, 70));
        $pdf->SetAligns(array('L', 'C', 'C'));
        $certificaciones = CtrCertificacionesVsa::findAll($id_solicitud, $id_servicio);
        if ($certificaciones['data'] != null) {
            foreach ($certificaciones['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Row(array(utf8_decode($row['sistema_gestion']),
                                utf8_decode($row['estado']),
                                utf8_decode($row['afirmativo']),
                                utf8_decode($row['numero']),
                                utf8_decode($row['observacion']),
                            ));
            }
        } else {
            //foreach ($certificaciones['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Row(array(utf8_decode("N/A"),
                                utf8_decode("N/A"),
                                utf8_decode("N/A"),
                                utf8_decode("N/A"),
                                utf8_decode("N/A"),
                            ));
            //}
        }
        
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($row['sistema_gestion']),
                            utf8_decode($row['estado']),
                            utf8_decode($row['afirmativo']),
                            utf8_decode($row['numero']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);


        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('II. Concepto Legal'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrInfoGeneralVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);


        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('III. Concepto Seguridad Física y Control de Acceso'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrRequisitoMinimoVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('IV. Concepto Asociados de Negocio'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrRequisitoMinimoVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('V. Concepto Seguridad de Personal. Capacitación'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrEntrenamientoVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);


        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('VI. Concepto Seguridad Informática'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrSeguridadInformaticaVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('VII. Concepto Operativo'), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'C', 'C'));
        //foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row2(array(utf8_decode('#'),
                            utf8_decode('Requisito'),
                            utf8_decode('Calificación'),
                            utf8_decode('Observación'),
                        ));
        //}

        $pdf->SetWidths(array(10, 75, 30, 75));
        $pdf->SetAligns(array('C', 'L', 'C'));
        $certificaciones = CtrOperativoVsa::findAll($id_solicitud, $id_servicio);
        $count = 1;
        foreach ($certificaciones['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($count++),
                            utf8_decode($row['requisito']),
                            utf8_decode($row['calificacion']),
                            utf8_decode($row['observacion']),
                        ));
        }
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('VIII. Concepto Final'), 1, 0, 'C', 1);
        $pdf->Ln(5);
        $conceptoVSA = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(130, 5, utf8_decode("¿Cómo califica los aspectos y controles de seguridad evidenciados?:"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 5, utf8_decode($conceptoVSA['data'][0]['des_p_uno']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(130, 5, utf8_decode("¿El asociado autoriza la toma de registro fotográfico? Enuncie las restricciones si las hay:"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 5, utf8_decode($conceptoVSA['data'][0]['requisito']), 1, 0, 'L', 0);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode("¿Se evidencia buena atención al cliente?: "), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $otro_dos = "";
        if ($conceptoVSA['data'][0]['pregunta_dos'] == 'A') {
            $otro_dos = "Si";
        } else if ($conceptoVSA['data'][0]['pregunta_dos'] == 'B'){
            $otro_dos = "No";
        } else if ($conceptoVSA['data'][0]['pregunta_dos'] == 'C'){
            $otro_dos = "¿Por que? ".$conceptoVSA['data'][0]['otro_dos'];
        }
        $pdf->Ln(5);
        $pdf->MultiCell(0, 5, utf8_decode($otro_dos), 1, 'J', 0);

        /*$pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode("Evidencio que las personas con las que trata comercialmente no son personas inexistentes: "), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $otro_tres = "";
        if ($conceptoVSA['data'][0]['pregunta_tres'] == 'A') {
            $otro_tres = "Si";
        } else if ($conceptoVSA['data'][0]['pregunta_tres'] == 'B'){
            $otro_tres = "No";
        } else if ($conceptoVSA['data'][0]['pregunta_tres'] == 'C'){
            $otro_tres = "¿Por que? ".$conceptoVSA['data'][0]['otro_tres'];
        }
        
        $pdf->Ln(5);
        
        $pdf->MultiCell(0, 5, utf8_decode($otro_tres), 1, 'J', 0);*/

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(130, 5, utf8_decode("¿El asociado cumple con requisitos mínimos de seguridad?"), 1, 0, 'L', 1);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 5, utf8_decode($conceptoVSA['data'][0]['asociado_confiable']), 1, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->MultiCell(0, 5, utf8_decode("CONCEPTO FINAL :\n".$conceptoVSA['data'][0]['observacion']), 1, 'J', 0);

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
            $pdf->Cell(80, 5, "Nombre y Firma del Vistador", 0, 0, 'L');

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(20, $pdf->GetY() + 5);
            $pdf->Cell(80, 5, utf8_decode($nomProveedor), 0, 0, 'L');

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(20, $pdf->GetY() + 5);
            $pdf->Cell(80, 5, utf8_decode($registroProveedor), 0, 0, 'L');
        }
   //Fotos de Poligrafia pre
   $fotos = CtrSolAdjuntos::descripcionAdjuntos($id_solicitud);
   //print_r($fotos);

   $fotoRegistro = '';
   $fotoPublicidad = '';
   $fotoAutorizacion = '';



    foreach ($fotos['data'] as $row) {

        if ($row['descripcion'] == 'Registro fotográfico a instalaciones (Previa autorización del cliente)') {
            $fotoRegistro = $row['directorio'] . '/' . $row['nombre_encr'];
        }else if ($row['descripcion'] == 'Material Publicitario del Cliente Proveedor visitado') {
            $fotoPublicidad = $row['directorio'] . '/' . $row['nombre_encr'];
        }else if ($row['descripcion'] == 'AUTORIZACIÓN') {
            $fotoAutorizacion = $row['directorio'] . '/' . $row['nombre_encr'];
        }
    }

    $fotos = CtrSolAdjuntos::descripcionAdjuntos($id_solicitud);

    // Arrays para almacenar las fotos correspondientes a cada descripción
    $fotoRegistro = [];
    $fotoPublicidad = [];
    
    foreach ($fotos['data'] as $row) {
        if ($row['descripcion'] == 'Registro fotográfico a instalaciones (Previa autorización del cliente)') {
            $fotoRegistro[] = $row['directorio'] . '/' . $row['nombre_encr'];
        } else if ($row['descripcion'] == 'Material Publicitario del Cliente Proveedor visitado') {
            $fotoPublicidad[] = $row['directorio'] . '/' . $row['nombre_encr'];
        }
    }
    
    if ($id_servicio == 12) {
            //Autorización 
            $pdf->SetX(25);
            $pdf->AddPage();
            $pdf->Ln(2);
            
            $pdf->SetX(25);
            $getx = $pdf->GetX();
            $pdf->Cell(165, 5, utf8_decode('Autorización'), 0, 2, 'C', 0);
            $pdf->Cell(0, 2, "", 0, 2, 'C', 0);
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(165, 220, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($fotoAutorizacion, $getx + 1, $getY, 163, 218);
            $pdf->Ln(113);
            $pdf->AddPage();
        // Imprimir todas las fotos de "Registro fotográfico"
        if (!empty($fotoRegistro)) {
            $pdf->SetX(25);
            $pdf->Cell(165, 5, utf8_decode('Registro fotográfico a instalaciones (Previa autorización del cliente)'), 0, 2, 'C', 0);
            
            $contador = 0; // Contador para controlar la cantidad de imágenes por fila
            foreach ($fotoRegistro as $foto) {
                // Configuración inicial de posición para cada fila
                if ($contador % 3 == 0) {
                    $pdf->Ln(5); // Espacio entre filas
                    $pdf->SetX(25); // Margen inicial en X
                }
                
                // Coordenadas y dimensiones de cada celda de imagen
                $getx = $pdf->GetX();
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(52, 72, '', 1, 0, '', 1); // Crear el borde de la celda
                $getY = $pdf->GetY() + 1;
                $pdf->Image($foto, $getx + 1, $getY, 50, 70); // Insertar imagen dentro de la celda
                
                // Ajustar X para la siguiente imagen en la misma fila
                $pdf->SetX($getx + 55);
                $contador++;

                // Si es la tercera imagen, hacer un salto de línea
                if ($contador % 3 == 0) {
                    $pdf->Ln(75); // Altura de la celda + espacio entre filas
                }
            }
        }

        // Imprimir todas las fotos de "Material Publicitario"
        if (!empty($fotoPublicidad)) {
            $pdf->AddPage();
            $pdf->SetX(25);
            $pdf->Cell(165, 5, utf8_decode('Material Publicitario del Cliente Proveedor visitado'), 0, 2, 'C', 0);

            $contador = 0; // Reiniciar el contador para la segunda sección
            foreach ($fotoPublicidad as $foto) {
                if ($contador % 3 == 0) {
                    $pdf->Ln(5);
                    $pdf->SetX(25);
                }
                
                $getx = $pdf->GetX();
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(52, 72, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($foto, $getx + 1, $getY, 50, 70);

                $pdf->SetX($getx + 55);
                $contador++;

                if ($contador % 3 == 0) {
                    $pdf->Ln(75);
                }
            }
        }


    }
    
    }
}
