<?php

function infVisIngreso($pdf, $id_solicitud, $id_servicio)
{
    $pdf->Ln(4);
    $candidato = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    //print_r($candidato['data'][0]['persona_visita']);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetTextColor(000, 000, 000);
    $pdf->multiCell(70, 5, "Fecha de la visita:", 1, 'L', 1);
    $y2 = $pdf->GetY();
    $pdf->SetXY(80, $y2 - 5);
    //$pdf->SetXY(60,119); // Cambiar segun se acomode la hoja
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(120, 5, utf8_decode($solicitud['data'][0]['fecha_programacion']), 1, 2, 'L', 0);
    $pdf->Ln(0.2);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(000, 000, 000);
    $pdf->multiCell(70, 5, "Nombre y parentesco de quien atiende la visita:", 1, 'L', 1);
    $y2 = $pdf->GetY();
    $pdf->SetXY(80, $y2 - 5);
    //$pdf->SetXY(60,119); // Cambiar segun se acomode la hoja
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(120, 5, utf8_decode($candidato['data'][0]['persona_visita'] . ' / ' . $candidato['data'][0]['parantesco_visita']), 1, 2, 'L', 0);
    $pdf->Ln(4);

    if (isset($id_solicitud) && $id_solicitud != "" && $id_solicitud != null) {
        

        $familia = CtrSolFamiliar::descripcionFamiliar($id_solicitud);
        //$pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('I. DIMENSIÓN FAMILIAR'), 0, 0, 'C', 1);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. PERSONA CON QUIEN VIVE ACTUALMENTE Y FAMILIA DE ORIGEN DEL EVALUADO'), 0, 0, 'L', 0);
        $pdf->Ln(8);


        
        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial
        
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 6);
        
        $cellHeight = 5;  // Altura de la celda
        
        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial
        
        // Parentesco
        $pdf->MultiCell(16, 10, utf8_decode("Parentesco"), 1, 'C', 1);
        $pdf->SetXY($x + 16, $y); // Ajustar la posición X y mantener Y
        
        // Nombre
        $x = $pdf->GetX();
        $pdf->MultiCell(19, 10, utf8_decode("Nombre"), 1, 'C', 1);
        $pdf->SetXY($x + 19, $y);
        
        // Edad
        $x = $pdf->GetX();
        $pdf->MultiCell(8, 10, utf8_decode("Edad"), 1, 'C', 1);
        $pdf->SetXY($x + 8, $y);
        
        // Número contacto
        $x = $pdf->GetX();
        $pdf->MultiCell(20, $cellHeight, utf8_decode("Número\ncontacto"), 1, 'C', 1);
        $pdf->SetXY($x + 20, $y);
        
        // Residencia
        $x = $pdf->GetX();
        $pdf->MultiCell(15, 10, utf8_decode("Residencia"), 1, 'C', 1);
        $pdf->SetXY($x + 15, $y);
        
        // Ciudad
        $x = $pdf->GetX();
        $pdf->MultiCell(15, 10, utf8_decode("Ciudad"), 1, 'C', 1);
        $pdf->SetXY($x + 15, $y);
        
        // Estado Civil
        $x = $pdf->GetX();
        $pdf->MultiCell(15, $cellHeight, utf8_decode("Estado\n Civil"), 1, 'C', 1);
        $pdf->SetXY($x + 15, $y);
/*        
        // Empresa
        $x = $pdf->GetX();
        $pdf->MultiCell(15, 10, utf8_decode("Empresa"), 1, 'C', 1);
        $pdf->SetXY($x + 15, $y);
*/        
        // Ocupacion
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Ocupacion"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);
        
        // Escolaridad
        $x = $pdf->GetX();
        $pdf->MultiCell(15, 10, utf8_decode("Escolaridad"), 1, 'C', 1);
        $pdf->SetXY($x + 15, $y);
        
        // Vive con el evaluado
        $x = $pdf->GetX();
        $pdf->MultiCell(16, $cellHeight, utf8_decode("Vive con\nel evaluado"), 1, 'C', 1);
        $pdf->SetXY($x + 16, $y);

        // Depende economicamente
        $x = $pdf->GetX();
        $pdf->MultiCell(20, $cellHeight, utf8_decode("Depende\neconomicamente"), 1, 'C', 1);
        $pdf->SetXY($x + 20, $y);
        
        $pdf->Ln($cellHeight);
        
        
        $pdf->Ln(5);
        

        $pdf->SetWidths(array(16, 19, 8, 20, 15, 15, 15, 30,15, 16, 20));
        $pdf->SetAligns(array('L', 'C', 'L'));
        foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($row['descripcion_parentesco']), 
                            utf8_decode($row['nombre'].' '.$row['apellido'].' - ID '.$row['identificacion']), 
                            utf8_decode($row['edad']), 
                            utf8_decode($row['telefono']),
                            utf8_decode($row['nombre_pais']),
                            utf8_decode(ucfirst(strtolower($row['descripcion_ciudad']))),
                            utf8_decode($row['descripcion_estado_civil']),
                            //utf8_decode($row['empresa']),
                            utf8_decode($row['ocupacion']),
                            utf8_decode($row['descripcion_niv_escol']),
                            utf8_decode($row['descripcion_viv_candidato']),
                            utf8_decode($row['descripcion_depende_candidato']),
                        ));
        }
        $pdf->Ln(5);


/*

        foreach ($familia['data'] as $row) {

            //ßprint_r($row);
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Parentesco"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_parentesco']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Nombre"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(70, 5, utf8_decode($row['nombre']) . ' ' . utf8_decode($row['apellido']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, utf8_decode("Edad"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['edad']), 1, 0, 'L', 0);
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Número contacto"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['telefono']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Residencia"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['nombre_pais']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Ciudad"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(45, 5, utf8_decode(ucfirst(strtolower($row['descripcion_ciudad']))), 1, 0, 'L', 0);
            $pdf->Ln(5);


            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Estado civil"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_estado_civil']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Empresa"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode(ucfirst(strtolower($row['empresa']))), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Ocupación"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(45, 5, utf8_decode($row['ocupacion']), 1, 0, 'L', 0);
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Escolaridad"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_niv_escol']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(33, 5, utf8_decode("Vive con el Candidato"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(37, 5, utf8_decode($row['descripcion_viv_candidato']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(35, 5, utf8_decode("Depende del Candidato"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_depende_candidato']), 1, 0, 'L', 0);

            $pdf->Ln(8);
        }
*/
        $obsFamilia = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_familia');
        //$pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('OBSERVACIÓN GENERAL'), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(4);
        $pdf->MultiCell(190, 4, utf8_decode($obsFamilia['data']['observacion']), 0, 'J', 0);
        $pdf->Ln(5);

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
            $academico = CtrSolFormacion::findAllVisitas($id_solicitud);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 5, utf8_decode('2. DESARROLLO ACADÉMICO Y PROFESIONAL DEL CANDIDATO'), 0, 0, 'L', 0);
            $pdf->Ln(6);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 5, utf8_decode('A. FORMACIÓN ACADÉMICA'), 0, 0, 'L', 0);
            $pdf->Ln(6);

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(40, 5, utf8_decode("Nivel escolaridad"), 1, 0, 'C', 1);

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(50, 5, utf8_decode("Nombre Institución"), 1, 0, 'C', 1);

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(40, 5, utf8_decode("Programa Academico"), 1, 0, 'C', 1);

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(28, 5, utf8_decode("Fecha de graduación"), 1, 0, 'C', 1);

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 5, utf8_decode("Acta y Folio"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $pdf->SetWidths(array(40, 50, 40, 28, 30));
            $pdf->SetAligns(array('L', 'C', 'C', 'C'));
            foreach ($academico['data'] as $row) {
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Row(array(
                    ucfirst(strtolower(utf8_decode($row['descripcion_niv_escol']))),
                    utf8_decode($row['nombre_institucion']),
                    utf8_decode($row['programa_academico']),
                    utf8_decode(ucfirst(strtolower($row['fch_grado']))),
                    utf8_decode(ucfirst(strtolower($row['acta_folio'])))
                ));
            }
        }


        if ($countlaboral < 1) {
            //Laboral
            $laboral = CtrSolLaboral::descripcionLaboral_visitas($id_solicitud, $id_servicio);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 5, utf8_decode('B. INFORMACIÓN LABORAL'), 0, 0, 'L', 0);
            $pdf->Ln(8);
            foreach ($laboral['data'] as $row) {

                //ßprint_r($row);
                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Empresa"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(0, 5, utf8_decode($row['nombre_empresa']), 1, 0, 'L', 0);
                $pdf->SetFont('Arial', 'B', 8);
                /*
                $pdf->Cell(45, 5, utf8_decode("Teléfono empresa"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['telefono_empresa']), 1, 0, 'L', 0);
                */
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Último Cargo"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['cargo_finalizo']), 1, 0, 'L', 0);

                //$pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Fecha de Ingreso"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['fch_ingreso']), 1, 0, 'L', 0);
                $pdf->Ln(5);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Fecha de Retiro"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['fch_retiro']), 1, 0, 'L', 0);
/*
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(25, 5, utf8_decode("Tipo de Contrato"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(39, 5, utf8_decode($row['tipo_contrato']), 1, 0, 'L', 0);
*/


/*                
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Jefe Inmediato"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['jefe_inmediato']), 1, 0, 'L', 0);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Cargo Jefe"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['cargo_jefe']), 1, 0, 'L', 0);
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Número Jefe"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['numero_jefe']), 1, 0, 'L', 0);
*/
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(45, 5, utf8_decode("Tipo de Retiro"), 1, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 7);
                $pdf->Cell(50, 5, utf8_decode($row['tipo_retiro']), 1, 1, 'L', 0);

                if ($row['motivo_retiro'] != null || $row['motivo_retiro'] != "") {
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(45, 4, utf8_decode("Motivo de Retiro"), 1, 0, 'L', 1);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->multiCell(0, 4, utf8_decode($row['motivo_retiro']), 1, 'L', 0);
                }

                $pdf->Ln(5);
            }
        }

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN FAMILIAR'), 0, 0, 'C', 0);

        $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 1, $id_servicio);

        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 1);
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
    
        //$pdf->Ln(5);
        //print_r($dimFamiliar);
        /*$pdf->SetFillColor(174, 214, 241);
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
        }*/

        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        foreach ($dimFamiliar['data'] as $row) {
            $pdf->SetWidths(array(60, 130));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->RowBold(array(utf8_decode("VARIABLE ANALIZADA"),utf8_decode($row['nombre_pregunta'])));
            $pdf->RowBold(array(utf8_decode("NIVEL DE RIESGO"),utf8_decode($row['descripcion_niv_riesgo'])));
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array(utf8_decode($row['respuesta'])));
            
        }

$imagenes_posibles = [];

$fotos = CtrSolAdjuntos::descripcionAdjuntosValida($id_solicitud);

foreach ($fotos['data'] as $row) {
    $descripcion = $row['descripcion'];
    $ruta = $row['directorio'] . '/' . $row['nombre_encr'];

    if (!empty($ruta) && file_exists($ruta)) {
        switch ($descripcion) {
            case 'FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)':
                $imagenes_posibles[] = [$ruta, 'FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)'];
                break;
            case 'FOTO FACHADA':
                $imagenes_posibles[] = [$ruta, 'FOTO FACHADA'];
                break;
            case 'FOTO DE NOMENCLATURA':
                $imagenes_posibles[] = [$ruta, 'FOTO DE NOMENCLATURA'];
                break;
            case 'FOTO EXTERIOR DE LA VIVIENDA':
                $imagenes_posibles[] = [$ruta, 'FOTO EXTERIOR DE LA VIVIENDA'];
                break;
            case 'FOTO DEL CANDIDATO Y SU FAMILIA':
                $imagenes_posibles[] = [$ruta, 'FOTO CANDIDATO Y SU FAMILIA'];
                break;
            case 'FOTO DEL CANDIDATO CON LA PROFESIONAL DE VISITAS':
                $imagenes_posibles[] = [$ruta, 'FOTO DEL CANDIDATO CON EL PROFESIONAL DE VISITAS'];
                break;
            case 'FOTO DE LA ENTRADA DEL APARTAMENTO':
                $imagenes_posibles[] = [$ruta, 'FOTO DE LA ENTRADA DEL APARTAMENTO'];
                break;
            case 'FOTO DE LA TORRE':
                $imagenes_posibles[] = [$ruta, 'FOTO DE LA TORRE'];
                break;
        }
    }
}

    $pdf->AddPage();

    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, utf8_decode('II. DIMENSIÓN SOCIAL Y HABITACIONAL'), 0, 0, 'C', 1);


// Paso 2: Filtrar solo los archivos existentes
$imagenes = [];

foreach ($imagenes_posibles as $item) {
    $file = $item[0];
    $titulo = $item[1];

    if (!empty($file) && file_exists($file)) {
        $imagenes[] = ['file' => $file, 'titulo' => $titulo];
    }
}


$imagenesPorFila = 2;
$espacioY = 75;
$y = 50;

for ($i = 0; $i < count($imagenes); $i++) {

    // Si es la séptima imagen, agregar nueva página y reiniciar coordenadas
    if ($i == 6) {
        $pdf->AddPage();
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('II. DIMENSIÓN SOCIAL Y HABITACIONAL (CONTINUACIÓN)'), 0, 0, 'C', 1);
        $pdf->Ln(10);
        $y = 50; // Reiniciar Y para la nueva página
    }

    $x = ($i % 2 == 0) ? 23 : 108;

    // Nueva fila cada 2 imágenes (excepto cuando se agregó una nueva página)
    if ($i != 0 && $i % 2 == 0 && $i != 6) {
        $y += $espacioY;
    }

    insertarImagenOPDF($pdf, $imagenes[$i]['file'], $imagenes[$i]['titulo'], $x, $y);
}



        //$pdf->AddPage();
        $pdf->Ln(12);

        //$pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. ASPECTOS HABITACIONALES'), 0, 0, 'L', 0);
        $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
        //print_r($carViv);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->Ln(6);
          $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, "Tipo:", 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 5, ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tipo_viv']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode('Tenencia:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 5, ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tenencia']))), 1, 2, 'L', 0);
        $pdf->SetX(10);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Tamaño:"), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 5, ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tamano']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode('Estado:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(65, 5, utf8_decode($carViv['data'][0]['descripcion_estado']), 1, 2, 'L', 0);
        $pdf->SetX(8);
    
    
/*
        //Como esta actualmente aspecto habitacional
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        $pdf->SetXY(10, $varYD);
        // $pdf->SetX(10);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(95, 5, utf8_decode("Caracteristicas de la vivienda"), 1, 0, 'C', 1);
        $pdf->Cell(95, 5, utf8_decode("Distribución"), 1, 1, 'C', 1);

        $pdf->SetWidths(array(35, 60));
        $pdf->SetAligns(array('C','C'));
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Row(array(utf8_decode("TIPO DE CARACTERÍSTICA"), utf8_decode("DESCRIPCIÓN DE LA CARACTERÍSTICA")));
        

        

        $pdf->SetFont('Arial', '', 6);
        $pdf->SetAligns(array('L','L'));
        $pdf->Row(array(utf8_decode("Tipo"), utf8_decode($carViv['data'][0]['descripcion_tipo_viv'])));
        $pdf->Row(array(utf8_decode("Tenencia"), utf8_decode($carViv['data'][0]['descripcion_tenencia'])));
        $pdf->Row(array(utf8_decode("Tamaño"), utf8_decode($carViv['data'][0]['descripcion_tamano'])));
        $pdf->Row(array(utf8_decode("Estado"), utf8_decode($carViv['data'][0]['descripcion_estado'])));

        //Aspectos Fisicos
        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_fisico', $id_solicitud, $id_servicio);
        $descripcionFisica = '';

        foreach ($aspectFisico['data'] as $row) {
            $descripcionFisica .= $row['descripcion']. ', ' ;
        }

        $pdf->Row(array(utf8_decode("Aspecto Fisico"), utf8_decode($descripcionFisica)));

        //Organización y limpieza
        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_limpieza', $id_solicitud, $id_servicio);
        $descripcionlimpieza = '';

        foreach ($aspectFisico['data'] as $row) {
            $descripcionlimpieza .= $row['descripcion']. ', ' ;
        }

        $pdf->Row(array(utf8_decode("Organización y limpieza:"), utf8_decode($descripcionlimpieza)));

        //Servicios Publicos
        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_servicios', $id_solicitud, $id_servicio);
        $descripcionServicios = '';

        foreach ($aspectFisico['data'] as $row) {
            $descripcionServicios .= $row['descripcion']. ', ' ;
        }

        $pdf->Row(array(utf8_decode("Servicios Publicos:"), utf8_decode($descripcionServicios)));

        //Servicios Adicionales
        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_adicionales', $id_solicitud, $id_servicio);
        $descripcionServiciosAdicionales = '';

        foreach ($aspectFisico['data'] as $row) {
            $descripcionServiciosAdicionales .= $row['descripcion']. ', ' ;
        }

        $pdf->Row(array(utf8_decode("Servicios Adicionales:"), utf8_decode($descripcionServiciosAdicionales)));

        $pdf->Row(array(utf8_decode("Aclaraciones del estado de la vivienda :"), utf8_decode($carViv['data'][0]['aclaracion_viv'])));

        $pdf->SetWidths(array(26, 23, 23, 23));
        $pdf->SetAligns(array('C','C','C','C'));
        //$varXA = $pdf->GetX();
        //$varYA = $pdf->GetY();
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        $pdf->SetXY($varXA + 95, $varYA);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Row(array(utf8_decode("TIPO DE ESPACIO"), utf8_decode("N° DE ESPACIOS"), utf8_decode("ESTADO"), utf8_decode("DOTACIÓN")));

        $disEspacios = CtrVivDistribuciones::findAll($id_solicitud, $id_servicio);
        $idMob = array();
        $i = 1;
        
        $pdf->SetWidths(array(26, 23, 23, 23));
        $pdf->SetAligns(array('L', 'C', 'C', 'C'));
        $pdf->SetXY($varXA + 95, $varYA+5);

        foreach ($disEspacios['data'] as $row) {
            //$pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            //arreglo de tildes en mayusculas
            $descripcion_tipo_espacios = $row['descripcion_tipo_espacios'];
            $descripcion_tipo_espacios = mb_strtolower($descripcion_tipo_espacios, 'UTF-8');
            $descripcion_tipo_espacios = mb_strtoupper(mb_substr($descripcion_tipo_espacios, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($descripcion_tipo_espacios, 1, null, 'UTF-8');
            $pdf->Row(array(
                utf8_decode($descripcion_tipo_espacios),
                utf8_decode(ucfirst(strtolower($row['numero_espacio']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_estado_espacios']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_dotacion_mob'])))
            ));


            //array para el id de la distribucion
            $idMob[] =  $row['id_distribucion'];
            //$i = $i+1;      
            $varYDR = $pdf->GetY();
            $pdf->SetXY($varXA + 95, $varYDR);       

        }
        if ($varYDR < $varYD) {
            $varNewX = $varYD - $varYDR;
        }

        // $pdf->SetXY(10,$varYDR);
        $pdf->Ln(4 + $varNewX);
        //como esta actualmente aspecto habitacional
*/

        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        $pdf->SetXY(10, $varYD);
        // $pdf->SetX(10);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode("Aspectos Fisicos:"), 1, 0, 'L', 1);

        $pdf->SetX(10);
        $pdf->Ln(5);

        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_fisico', $id_solicitud, $id_servicio);
        //print_r($aspectFisico);
        $i = 0;
        foreach ($aspectFisico['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }

        $pdf->SetX(10);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode("Organización y limpieza:"), 1, 0, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(5);

        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_limpieza', $id_solicitud, $id_servicio);
        // print_r($aspectFisico);
        $i = 0;
        foreach ($aspectFisico['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }

        $pdf->SetX(10);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Servicios Publicos:"), 1, 0, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(5);

        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_servicios', $id_solicitud, $id_servicio);
        // print_r($aspectFisico);
        $i = 0;
        foreach ($aspectFisico['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }

        $pdf->Ln(3);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Servicios Adicionales:"), 1, 0, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(5);

        $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_adicionales', $id_solicitud, $id_servicio);
        // print_r($aspectFisico);
        $i = 0;
        foreach ($aspectFisico['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }


        //$pdf->Ln(5);

        $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(30,5,utf8_decode("Aclaraciones del estado de la vivienda :"),1,0,'L',1);
        $pdf->SetWidths(array(56, 134));
        $pdf->SetAligns(array('L'));
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode(" "), utf8_decode($carViv['data'][0]['aclaracion_viv'])));

        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();
        $pdf->SetXY(10, $varYA);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(56, 5, utf8_decode("Aclaraciones del estado de la vivienda :"), 0, 0, 'L', 0);

        $pdf->SetXY(15, $varYD + 5);

        // en esta parte va a estar la nueva parte de la tabla

        //Fin de la tabla

        $disEspacios = CtrVivDistribuciones::findAll($id_solicitud, $id_servicio);

        //$pdf->Ln(3);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Distribución de la vivienda:"), 1, 0, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(6);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(70, 5, utf8_decode("Tipo de espacios"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(40, 5, utf8_decode("Nro. de espacios"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(40, 5, utf8_decode("Estado"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(40, 5, utf8_decode("Dotación"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $varX = $pdf->GetX();
        $varY = $pdf->GetY();

        $idMob = array();
        $i = 1;

        $pdf->SetWidths(array(70, 40, 40, 40));
        $pdf->SetAligns(array('L', 'C', 'C', 'C'));
        foreach ($disEspacios['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            //arreglo de tildes en mayusculas
            $descripcion_tipo_espacios = $row['descripcion_tipo_espacios'];
            $descripcion_tipo_espacios = mb_strtolower($descripcion_tipo_espacios, 'UTF-8');
            $descripcion_tipo_espacios = mb_strtoupper(mb_substr($descripcion_tipo_espacios, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($descripcion_tipo_espacios, 1, null, 'UTF-8');
            $pdf->Row(array(
                utf8_decode($descripcion_tipo_espacios),
                utf8_decode(ucfirst(strtolower($row['numero_espacio']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_estado_espacios']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_dotacion_mob'])))
            ));


            //array para el id de la distribucion
            $idMob[] =  $row['id_distribucion'];
            //$i = $i+1;             

        }
        // print_r($idMob);
        // $t = 1;
        $pdf->Ln(5);
        //$varX = $pdf->GetX();
        //$varY = $pdf->GetY();
        $pdf->SetX(10);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 5, utf8_decode("Tipo de mobiliario"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Cantidad"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
        $pdf->Cell(17, 5, utf8_decode("Tenencia"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 5, utf8_decode("Electrodoméstico"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Cantidad"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
        $pdf->Cell(17, 5, utf8_decode("Tenencia"), 1, 1, 'C', 1);


        $esp = 0;

        $array_num = count($idMob);
        $esp = $esp + 5;
        $pdf->SetWidths(array(48, 16, 16, 17));
        $pdf->SetAligns(array('L', 'C', 'C', 'C'));

        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        //print_r($array_num);
        for ($t = 0; $t < $array_num; $t++) {
            // foreach ($idMob as $row) {
            //for($t=1; $t <= $idMob.length; $t++){
            $mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio, $idMob[$t]);
            //print_r($idMob[$t]);
            foreach ($mobiliario['data'] as $row) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                //arreglo de tildes en mayusculas
                $tipo_elemento = $row['tipo_elemento'];
                $tipo_elemento = mb_strtolower($tipo_elemento, 'UTF-8');
                $tipo_elemento = mb_strtoupper(mb_substr($tipo_elemento, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($tipo_elemento, 1, null, 'UTF-8');
                $pdf->Row(array(
                    utf8_decode($tipo_elemento),
                    utf8_decode(ucfirst(strtolower($row['cantidad']))),
                    utf8_decode(ucfirst(strtolower($row['des_estado_mobiliario']))),
                    utf8_decode(ucfirst(strtolower($row['des_tipo_tenencia_dotacion'])))
                ));

                $esp = $esp + 5;
                //$varY = $pdf->GetY();
            }
            // $pdf->Ln(5);
        }
        //$mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio);
        // print_r($mobiliario);
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        //$pdf->Ln(3);
        $pdf->SetXY($varXA + 97, $varYA);
        $electro = CtrVivElectrodomesticos::findAll($id_solicitud, $id_servicio);

        // $pdf->SetWidths(array(70, 22, 16,22));
        // $pdf->SetAligns(array('L','C','C','C'));
        foreach ($electro['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['descripcion_tipo_elemento']))),
                utf8_decode(ucfirst(strtolower($row['cantidad']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_estado_electrodomestico']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_tenencia_electrodomestico'])))
            ));


            //array para el id de la distribucion
            $idMob[] =  $row['id_distribucion'];
            //$i = $i+1;  
            $varYDR = $pdf->GetY();
            $pdf->SetXY($varXA + 97, $varYDR);
        }

        if ($varYDR < $varYD) {
            $varNewX = $varYD - $varYDR;
        }

        // $pdf->SetXY(10,$varYDR);
        $pdf->Ln(8 + $varNewX);
/*//inicio actual tipo de mobiliario
        $pdf->Ln(10);
        //$varX = $pdf->GetX();
        //$varY = $pdf->GetY();
        $pdf->SetX(10);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 5, utf8_decode("Tipo de mobiliario"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Cantidad"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
        $pdf->Cell(17, 5, utf8_decode("Tenencia"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(48, 5, utf8_decode("Electrodoméstico"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Cantidad"), 1, 0, 'C', 1);
        $pdf->Cell(16, 5, utf8_decode("Estado"), 1, 0, 'C', 1);
        $pdf->Cell(17, 5, utf8_decode("Tenencia"), 1, 1, 'C', 1);


        $esp = 0;

        $array_num = count($idMob);
        $esp = $esp + 5;
        $pdf->SetWidths(array(48, 16, 16, 17));
        $pdf->SetAligns(array('L', 'C', 'C', 'C'));

        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        //print_r($array_num);
        for ($t = 0; $t < $array_num; $t++) {
            // foreach ($idMob as $row) {
            //for($t=1; $t <= $idMob.length; $t++){
            $mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio, $idMob[$t]);
            //print_r($idMob[$t]);
            foreach ($mobiliario['data'] as $row) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 7);
                //arreglo de tildes en mayusculas
                $tipo_elemento = $row['tipo_elemento'];
                $tipo_elemento = mb_strtolower($tipo_elemento, 'UTF-8');
                $tipo_elemento = mb_strtoupper(mb_substr($tipo_elemento, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($tipo_elemento, 1, null, 'UTF-8');
                $pdf->Row(array(
                    utf8_decode($tipo_elemento),
                    utf8_decode(ucfirst(strtolower($row['cantidad']))),
                    utf8_decode(ucfirst(strtolower($row['des_estado_mobiliario']))),
                    utf8_decode(ucfirst(strtolower($row['des_tipo_tenencia_dotacion'])))
                ));

                $esp = $esp + 5;
                //$varY = $pdf->GetY();
            }
            // $pdf->Ln(5);
        }
        //$mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio);
        // print_r($mobiliario);
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        //$pdf->Ln(3);
        $pdf->SetXY($varXA + 97, $varYA);
        $electro = CtrVivElectrodomesticos::findAll($id_solicitud, $id_servicio);

        // $pdf->SetWidths(array(70, 22, 16,22));
        // $pdf->SetAligns(array('L','C','C','C'));
        foreach ($electro['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['descripcion_tipo_elemento']))),
                utf8_decode(ucfirst(strtolower($row['cantidad']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_estado_electrodomestico']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_tenencia_electrodomestico'])))
            ));


            //array para el id de la distribucion
            $idMob[] =  $row['id_distribucion'];
            //$i = $i+1;  
            $varYDR = $pdf->GetY();
            $pdf->SetXY($varXA + 97, $varYDR);
        }

        if ($varYDR < $varYD) {
            $varNewX = $varYD - $varYDR;
        }
//termina tipo de mobiliario*/
        // $pdf->SetXY(10,$varYDR);
        //$pdf->Ln(4 + $varNewX);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('2. ASPECTOS SOCIALES Y DEL ENTORNO HABITACIONAL'), 0, 0, 'L', 0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('A. CARACTERÍSTICAS DEL SECTOR'), 0, 0, 'L', 0);

        $sector = CtrVivSector::findAll($id_solicitud, $id_servicio);
        //print_r($sector);

        $pdf->SetX(10);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, "Sector:", 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tipo_sector']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(31, 5, utf8_decode('Estrato:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(31, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['estracto']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(31, 5, utf8_decode('Ubicación:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(32, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_ubicacion_sector']))), 1, 0, 'L', 0);

        $pdf->Ln(5);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(58, 5, utf8_decode('Tiempo de desplazamiento al lugar del trabajo:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tmp_ida_trabajo']))), 1, 2, 'L', 0);
        $pdf->SetX(10);

        $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(30,5,utf8_decode("Aclaraciones del estado de la vivienda :"),1,0,'L',1);
        $pdf->SetWidths(array(52, 138));
        $pdf->SetAligns(array('L'));
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Tiempo en la actual vivienda: '), (utf8_decode($sector['data'][0]['tmp_en_vivienda']))));
        $pdf->Row(array(utf8_decode('Puntos de Referencia:     '), (utf8_decode($sector['data'][0]['zonas_verdes']))));
        $pdf->Row(array(utf8_decode("Principales vías de acceso:     "), (utf8_decode($sector['data'][0]['vias_principales']))));
        $pdf->Row(array(utf8_decode("Seguridad del Sector:   "), (utf8_decode($sector['data'][0]['estado_sector']))));
        //$pdf->Ln(5);

        //Medios de Transporte
        $transporte = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_transporte', $id_solicitud, $id_servicio);
        $medioTransporte = '';

        foreach ($transporte['data'] as $row) {
            $medioTransporte .= $row['descripcion']. ', ' ;
        }
        //Puntos de referencia en el entorno habitacional
        $entorno = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_sector_servicio', $id_solicitud, $id_servicio);
        $entornoHabitacional = '';

        foreach ($entorno['data'] as $row) {
            $entornoHabitacional .= $row['descripcion']. ', ' ;
        }

        $concatenado = $medioTransporte . $entornoHabitacional;
        $pdf->Row(array(utf8_decode("aspectos sociales y del entrono habitacional:"), utf8_decode($concatenado)));
/*
        //Puntos de referencia en el entorno habitacional
        $entorno = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_sector_servicio', $id_solicitud, $id_servicio);
        $entornoHabitacional = '';

        foreach ($entorno['data'] as $row) {
            $entornoHabitacional .= $row['descripcion']. ', ' ;
        }

        $pdf->Row(array(utf8_decode("Puntos de referencia en el entorno habitacional:"), utf8_decode($entornoHabitacional)));
*/
        $pdf->Row(array(utf8_decode("Concepto del vecino:   "), (utf8_decode($sector['data'][0]['concepto_vecino']))));
        $pdf->Ln(4);

        /*$pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Medios de transporte:"), 1, 1, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(0);

        $transporte = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_transporte', $id_solicitud, $id_servicio);
        $i = 0;
        foreach ($transporte['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }

        $pdf->Ln(3);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Servicios en el entorno habitacional:"), 1, 1, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(0);

        $sectorServicio = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_sector_servicio', $id_solicitud, $id_servicio);
        $i = 0;
        foreach ($sectorServicio['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(95, 5, utf8_decode('* ' . $row['descripcion']), 1, 0, 'L', 0);
            $i = $i + 1;
            if (($i % 2) == 0) {
                $pdf->Ln(5);
            }
        }
        if (($i % 2) != 0) {
            $pdf->Ln(5);
        }
*/
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('B. SITIOS DE VIVIENDA ANTERIORES Y TIEMPO DE ESTADÍA EN ELLOS'), 0, 1, 'L', 0);

        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(80, 5, utf8_decode("Ubicación"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, utf8_decode("Tiempo Estadía"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 5, utf8_decode("Motivo de Cambio"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $viviendas = CtrVivAnteriores::findAllVisitas($id_solicitud, $id_servicio);

        $pdf->SetWidths(array(80, 40, 70));
        $pdf->SetAligns(array('L', 'L', 'L'));
        foreach ($viviendas['data'] as $row) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['ubicacion']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_tiempo_reside']))),
                utf8_decode($row['motivo_cambio']),
            ));
        }




        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIAL Y HABITACIONAL'), 0, 0, 'C', 0);
        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 2);
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
/*        
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $dimSocial = CtrDimRespuestas::descripcionDimension($id_solicitud, 2, $id_servicio);
        $pdf->SetWidths(array(50, 35, 105));
        $pdf->SetAligns(array('L', 'C', 'L'));
        foreach ($dimSocial['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
        }
*/
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $dimSocial = CtrDimRespuestas::descripcionDimension($id_solicitud, 2, $id_servicio);
        foreach ($dimSocial['data'] as $row) {
            $pdf->SetWidths(array(60, 130));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->RowBold(array(utf8_decode("VARIABLE ANALIZADA"),utf8_decode($row['nombre_pregunta'])));
            $pdf->RowBold(array(utf8_decode("NIVEL DE RIESGO"),utf8_decode($row['descripcion_niv_riesgo'])));
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array(utf8_decode($row['respuesta'])));
            
        }
        $pdf->AddPage();

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('III. DIMENSIÓN SOCIOECONÓMICA'), 0, 0, 'C', 1);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. ANÁLISIS SOCIOECONÓMICO DEL CANDIDATO Y SU FAMILIA'), 0, 0, 'L', 0);

        $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
        //print_r($carViv);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('A. INGRESOS Y EGRESOS DEL FUNCIONARIO Y LA FAMILIA CON LA QUE CONVIVE'), 0, 0, 'L', 0);

        $pdf->Ln(6);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(95, 5, utf8_decode("Ingresos Mensuales del funcionario y familia con la que convive"), 1, 0, 'C', '1');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(95, 5, utf8_decode("Egresos Mensuales familiares del funcionario y familia con la que convive"), 1, 1, 'C', 1);

        $ingresos = CtrVivIngresos::findAll($id_solicitud, $id_servicio);
        $egresos = CtrVivEgresos::findAll($id_solicitud, $id_servicio);

        $pdf->Cell(40, 5, utf8_decode("Integrante de la Familia"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode("valor de Ingreso"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Donde Proviene"), 1, 0, 'C', 1);
        //$pdf->Ln(5);
        $pdf->Cell(40, 5, utf8_decode("Concepto"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode("Valor Egreso"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Responsable"), 1, 1, 'C', 1);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();

        $pdf->SetWidths(array(40, 25, 30));
        $pdf->SetAligns(array('L', 'C', 'L'));
        $totalIng = 0;
        $totalEg = 0;
        foreach ($ingresos['data'] as $row) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode($row['descripcion_tipo_integrante']),
                utf8_decode('$ ' . number_format($row['valor_ingreso'])),
                utf8_decode($row['ingreso_proveniente'])
            ));

            $totalIng = $totalIng + $row['valor_ingreso'];
        }

        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();
        $varYDR = 0;
        $pdf->SetXY($varXA + 95, $varYA);
        $concepto='';
        foreach ($egresos['data'] as $row) {
            $pdf->SetFont('Arial', '', 7);
            if ($row['descripcion_tipo_concepto'] == 'Otros Cuales?') {
                $concepto = $row['otros'];
            }else {
                $concepto = $row['descripcion_tipo_concepto'];
            }
            $pdf->Row(array(
                utf8_decode($concepto),
                utf8_decode('$ ' . number_format($row['valor_egreso'])),
                utf8_decode($row['descripcion_tipo_integrante'])
            ));

            $varYDR = $pdf->GetY();
            $pdf->SetXY($varXA + 95, $varYDR);

            if ($row['periocidad'] == 'A') {
                $totalEg = $totalEg + $row['valor_egreso'];
            }
        }
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

        $pdf->Ln(12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('B. PASIVO Y PATRIMONIO DEL CANDIDATO Y LA FAMILIA CON LA QUE CONVIVE'), 0, 1, 'L', 0);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 5, utf8_decode("Pasivos del candidato y familia con la que convive"), 1, 1, 'C', '1');
        $pdf->Ln(1);
        $pdf->Cell(50, 5, utf8_decode("Concepto"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Responsable"), 1, 0, 'C', 1);
        $pdf->Cell(18, 5, utf8_decode("Valor pasivo"), 1, 0, 'C', 1);
        $pdf->Cell(32, 5, utf8_decode("Plazo pasivo"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Cuota Mensual"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Estado de la Obligación"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor de Mora"), 1, 1, 'C', 1);

        

        $pdf->SetWidths(array(50, 20, 18, 32, 20, 30, 20, 18, 23));
        $pdf->SetAligns(array('L', 'L', 'L', 'L', 'C', 'L', 'L', 'L', 'C'));


        $pasivos = CtrVivPasivos::findAllCandidato($id_solicitud, $id_servicio);
        $totalPas = 0;
        $totalAct = 0;
        $otroConcepto = '';
        $otroResponsable = '';

        foreach ($pasivos['data'] as $row) {
            //Otro concepto
            if ($row['concepto_pasivo'] == 'J') {
                $otroConcepto = $row['otros'];
            } else {
                $otroConcepto = $row['descripcion_tipo_pasivo'];
            }
            //print_r($row['tipo_familiar']);
            //Otro responsable
            if ($row['tipo_familiar'] == 'OTR') {
                $otroResponsable = $row['otro_propietario'];
            } else {
                $otroResponsable = $row['descripcion_tipo_responsable'];
            }
            
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($otroConcepto))),
                utf8_decode($otroResponsable),
                utf8_decode('$ ' . number_format($row['valor_pasivo'])),
                utf8_decode($row['descripcion_tipo_plazo']),
                utf8_decode($row['couta']),
                utf8_decode($row['descripcion_tipo_estado_obigacion']),
                utf8_decode('$ ' . $row['valor_mora'])
            ));

            $totalPas = $totalPas + $row['valor_pasivo'];
        }


        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 5, utf8_decode("Activos del candidato y familia con la que convive"), 1, 1, 'C', '1');
        $pdf->Ln(1);
        $pdf->Cell(50, 5, utf8_decode("Tipo de Activo"), 1, 0, 'C', 1);
        $pdf->Cell(40, 5, utf8_decode("Propietario"), 1, 0, 'C', 1);
        $pdf->Cell(60, 5, utf8_decode("Descripcion General"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor Comercial"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor Catastral"), 1, 1, 'C', 1);


        $pdf->SetWidths(array(50, 40, 60, 20, 20));
        $pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'C', 'C'));


        $activos = CtrVivActivos::findAllCandidato($id_solicitud, $id_servicio);
        $otroConceptoA = '';
        $otroResponsableA = '';

        foreach ($activos['data'] as $row) {
            //Otro concepto
            if ($row['concepto_activo'] == 'J') {
                $otroConceptoA = $row['otros'];
            } else {
                $otroConceptoA = $row['descripcion_tipo_activo'];
            }
            //print_r($row['otros']);
            //Otro responsable
            if ($row['tipo_familiar'] == 'OTR') {
                $otroResponsableA = $row['otro_propietario'];
            } else {
                $otroResponsableA = $row['descripcion_tipo_responsable'];
            }
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($otroConceptoA))),
                utf8_decode($otroResponsableA),
                utf8_decode($row['descripcion_general_viv']),
                utf8_decode('$ ' . number_format($row['valor_activo'])),
                utf8_decode('$ ' . number_format($row['valor_activo_catastral']))
            ));

            $totalAct = $totalAct + $row['valor_activo'];
        }

        $totalPat = $totalAct - $totalPas;

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(125, 206, 160);
        $pdf->Cell(39, 5, utf8_decode("Total pasivos candidato"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalPas)), 1, 0, 'C', 0);
        //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
        $pdf->Cell(39, 5, utf8_decode("Total activos candidato"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalAct)), 1, 0, 'C', 0);

        $pdf->Cell(37, 5, utf8_decode("Patrimonio candidato"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalPat)), 1, 1, 'C', 0);




        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->Cell(190, 5, utf8_decode('C. ANÁLISIS DE REPORTES EN CENTRALES DE RIESGO FINANCIERO'), 0, 1, 'L', 0);
        $pdf->Ln(1);
        $pdf->Cell(80, 5, utf8_decode("Aspecto Consultado"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Estado "), 1, 0, 'C', 1);
        $pdf->Cell(90, 5, utf8_decode("Observaciones "), 1, 1, 'C', 1);


        $pdf->SetWidths(array(80, 20, 90));
        $pdf->SetAligns(array('L', 'C', 'L'));

        $centrales = CtrVivRiesgosFinanciero::findAll($id_solicitud, $id_servicio);

        foreach ($centrales['data'] as $row) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(
                utf8_decode(($row['descripcion_tipo_financiero'])),
                utf8_decode(ucfirst(strtolower($row['estado']))),
                utf8_decode(($row['descripcion_financiero']))
            ));

            //$varYDR = $pdf->GetY();
            //$pdf->SetXY($varXA+95,$varYDR);  

            $totalAct = $totalAct + $row['valor_activo'];
        }

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIOECONÓMICA'), 0, 0, 'C', 0);
        $pdf->Ln(8);
        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 3);
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
/*
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $dimEconomia = CtrDimRespuestas::descripcionDimension($id_solicitud, 3, $id_servicio);
        $pdf->SetWidths(array(50, 35, 105));
        $pdf->SetAligns(array('L', 'C', 'L'));

        foreach ($dimEconomia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
        }
        //$pdf->Ln(4);
*/
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $dimEconomia = CtrDimRespuestas::descripcionDimension($id_solicitud, 3, $id_servicio);
        foreach ($dimEconomia['data'] as $row) {
            $pdf->SetWidths(array(60, 130));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->RowBold(array(utf8_decode("VARIABLE ANALIZADA"),utf8_decode($row['nombre_pregunta'])));
            $pdf->RowBold(array(utf8_decode("NIVEL DE RIESGO"),utf8_decode($row['descripcion_niv_riesgo'])));
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array(utf8_decode($row['respuesta'])));
            
        }

        $pdf->SetFillColor(207, 207, 207);

        $pdf->Ln(5);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('IV. DIMENSIÓN SALUD DEL CANDIDATO Y SU FAMILIA'), 0, 0, 'C', 1);
        $pdf->Ln(8);

        $porcentaje = CtrDimRespuestas::ValidacionDimension($id_solicitud, $id_servicio, 4);
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
        /*
        $pdf->SetFillColor(174, 214, 241);

        //$pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);

        // $pdf->SetFont('Arial','B',8);
        // $pdf->Cell(40,5,utf8_decode("PREGUNTAS"),1,0,'C',1);

        $pdf->Ln(5);
*/
        $dimPregSalud = CtrDimRespuestas::findAllVariables($id_servicio, 4);
        //  print_r($dimPregSalud);

        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();

        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $dimPregSalud = CtrDimRespuestas::findAllVariables($id_servicio, 4);
        foreach ($dimPregSalud['data'] as $row) {

            $pdf->SetWidths(array(60, 130));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);

            $pdf->RowBold(array(utf8_decode("VARIABLE ANALIZADA"),utf8_decode($row['nombre_pregunta'])));
            $id_pregunta = $row['id_pregunta'];
            //print_r($id_pregunta);
            $dimResp = CtrDimVarRespuestaSalud::consultaVariableSalud($id_solicitud, $id_pregunta);
            //print_r($dimResp);
            $pdf->RowBold(array(utf8_decode("NIVEL DE RIESGO"),utf8_decode($dimResp['data']['descripcion_riesgo'])));
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array(utf8_decode($dimResp['data']['respuesta'])));
            
        }
        
        /*foreach ($dimPregSalud['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetWidths(array(50, 35, 105));
            $pdf->SetAligns(array('L', 'C', 'L'));

            $id_pregunta = $row['id_pregunta'];
            $dimResp = CtrDimVarRespuestaSalud::consultaVariableSalud($id_solicitud, $id_pregunta);
            $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($dimResp['data']['descripcion_riesgo']), utf8_decode($dimResp['data']['respuesta'])));
*/
            /*
            // $varXA = $pdf->GetX();
            $varYD = $pdf->GetY();

            $pdf->SetXY(10, $varYD);
            $dimRespCheck = CtrDimVarRespuestaSalud::consultaExiste($id_solicitud, $id_pregunta);
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            // $pdf->Row(array(utf8_decode('Preguntas por variable de salud: ')));
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("Preguntas por variable de salud: "), 1, 1, 'L', 1);

            foreach ($dimRespCheck['data'] as $row) {
                if ($row['activo'] == '1') {
                    $pdf->SetFont('Arial', '', 8);
                    $preg = $row['nombre_pregunta'];
                    $pdf->Row(array(utf8_decode($preg)));

                    $varXR = $pdf->GetX();
                    $varYR = $pdf->GetY();
                    $pdf->SetXY($varXR, $varYR);
                }
            }

            $pdf->Ln(3);
            */
        //}

        //  $pdf->Ln(8);

        $pdf->Ln(5);

        // $pdf->Ln(5);


        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('VI. PROTOCOLO DE SEGURIDAD / ASPECTO CRÍTICOS DE RIESGO'), 0, 0, 'C', 1);
        $pdf->Ln(8);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("ASPECTO DE RIESGO "), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("RESPUESTA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(110, 5, utf8_decode("OBSERVACIONES"), 1, 0, 'C', 1);
        $pdf->Ln(5);


        $dimProtocolo = CtrVivProtocoloSeguridad::findAll($id_solicitud, $id_servicio);
        $pdf->SetWidths(array(50, 30, 110));
        $pdf->SetAligns(array('L', 'C', 'L'));

        foreach ($dimProtocolo['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $descripcion_tipo_seguridad = $row['descripcion_tipo_seguridad'];
            $descripcion_tipo_seguridad = mb_strtolower($descripcion_tipo_seguridad, 'UTF-8');
            
            // Buscar la primera letra en la cadena
            preg_match('/\p{L}/u', $descripcion_tipo_seguridad, $matches, PREG_OFFSET_CAPTURE);
            
            if ($matches) {
                $pos = $matches[0][1]; // Posición de la primera letra encontrada
                $descripcion_tipo_seguridad = mb_substr($descripcion_tipo_seguridad, 0, $pos, 'UTF-8') . 
                                              mb_strtoupper(mb_substr($descripcion_tipo_seguridad, $pos, 1, 'UTF-8'), 'UTF-8') . 
                                              mb_substr($descripcion_tipo_seguridad, $pos + 1, null, 'UTF-8');
            }
            $pdf->Row(array(
                utf8_decode($descripcion_tipo_seguridad),
                utf8_decode($row['respuesta']), utf8_decode($row['descripcion_seguridad'])
            ));
        }


        $pdf->Ln(5);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('V. DIMENSIÓN ACTITUD Y COMPROMISO DEL FUNCIONARIO CON EL PROCESO'), 0, 0, 'C', 1);
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
        /*//$pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
        $pdf->Ln(5);

        $dimActitud = CtrDimRespuestas::descripcionDimension($id_solicitud, 5, $id_servicio);
        $pdf->SetWidths(array(50, 35, 105));
        $pdf->SetAligns(array('L', 'C', 'L'));

        foreach ($dimActitud['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
        }
*/
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $dimActitud = CtrDimRespuestas::descripcionDimension($id_solicitud, 5, $id_servicio);
        foreach ($dimActitud['data'] as $row) {
            $pdf->SetWidths(array(60, 130));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->RowBold(array(utf8_decode("VARIABLE ANALIZADA"),utf8_decode($row['nombre_pregunta'])));
            $pdf->RowBold(array(utf8_decode("NIVEL DE RIESGO"),utf8_decode($row['descripcion_niv_riesgo'])));
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array(utf8_decode($row['respuesta'])));
            
        }

        $pdf->Ln(5);


        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('VII. OBSERVACIONES GENERALES'), 0, 1, 'C', 1);
        $pdf->Ln(5);

        $dimConcepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
        
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();
        $pdf->SetWidths(array(190));
        $pdf->SetAligns(array('L', 'L'));

        //$pdf->SetXY(10,$varYD);
        $pdf->SetFont('Arial', 'B', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Expectativas familiares frente al cargo y la empresa: ')));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array((utf8_decode($dimConcepto['data'][0]['expectativas']))));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();


        $pdf->SetXY(10, $varYD);
        $pdf->SetFont('Arial', 'B', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode("Metas y proyectos: ")));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array((utf8_decode($dimConcepto['data'][0]['metas']))));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();


        $pdf->SetXY(10, $varYD);
        $pdf->SetFont('Arial', 'B', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Como llega la hoja de vida a la empresa:  ')));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array((utf8_decode($dimConcepto['data'][0]['medio_hv']))));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();


        $pdf->SetXY(10, $varYD);
        $pdf->SetFont('Arial', 'B', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(
            utf8_decode('¿Tiene usted conocimiento de las condiciones laborales de la entidad y está de acuerdo con ellas? ')
        ));
        $pdf->SetFont('Arial', '', 8);
        $pdf->Row(array(
            (utf8_decode(ucfirst(strtolower($dimConcepto['data'][0]['condicion_laboral']))))
        ));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

        $pdf->Ln(2);
        $pdf->SetXY(10, $varYD);
        $pdf->SetFont('Arial', '', 8);


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

        $imagenes_posibles = [];

        $fotos = CtrSolAdjuntos::descripcionAdjuntosValidaTel($id_solicitud);

        //print_r($fotos['data']);


        foreach ($fotos['data'] as $row) {
            $descripcion = $row['descripcion'];
            $ruta = $row['directorio'] . '/' . $row['nombre_encr'];

            if (!empty($ruta) && file_exists($ruta)) {
                switch ($descripcion) {
                    case 'Foto del Puesto de Trabajo':
                        $imagenes_posibles[] = [$ruta, 'Foto del Puesto de Trabajo'];
                        break;
                    case 'Foto del Evaluado (a) en el Puesto de Trabajo':
                        $imagenes_posibles[] = [$ruta, 'Foto del Evaluado (a) en el Puesto de Trabajo'];
                        break;
                    case 'Foto de la Panorámica del Puesto de Trabajo':
                        $imagenes_posibles[] = [$ruta, 'Foto de la Panorámica del Puesto de Trabajo'];
                        break;
                    case 'Foto de las Conexiones':
                        $imagenes_posibles[] = [$ruta, 'Foto de las Conexiones'];
                        break;
                }
            }
        }

        if ($fotos['data'] != NULL) {
            $pdf->AddPage();
            
            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 5, utf8_decode('FOTOS DE TELETRABAJO'), 0, 0, 'C', 1);
        }




        // Paso 2: Filtrar solo los archivos existentes
        $imagenes = [];

        foreach ($imagenes_posibles as $item) {
            $file = $item[0];
            $titulo = $item[1];

            if (!empty($file) && file_exists($file)) {
                $imagenes[] = ['file' => $file, 'titulo' => $titulo];
            }
        }


        $imagenesPorFila = 2;
        $espacioY = 75;
        $y = 50;

        for ($i = 0; $i < count($imagenes); $i++) {

            // Si es la séptima imagen, agregar nueva página y reiniciar coordenadas
            if ($i == 6) {
                $pdf->AddPage();
                $pdf->SetFillColor(174, 214, 241);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(190, 5, utf8_decode('FOTOS DE TELETRABAJO (CONTINUACIÓN)'), 0, 0, 'C', 1);
                $pdf->Ln(10);
                $y = 50; // Reiniciar Y para la nueva página
            }

            $x = ($i % 2 == 0) ? 23 : 108;

            // Nueva fila cada 2 imágenes (excepto cuando se agregó una nueva página)
            if ($i != 0 && $i % 2 == 0 && $i != 6) {
                $y += $espacioY;
            }

            insertarImagenOPDF($pdf, $imagenes[$i]['file'], $imagenes[$i]['titulo'], $x, $y);
        }
    }
}



function insertarImagenOPDF($pdf, $filename, $titulo, $x, $y) {
    if (!empty($filename) && file_exists($filename)) {
        // Dibuja el marco
        $pdf->SetXY($x, $y);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->Cell(82, 63, '', 1, 0, '', 1); // marco negro

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        try {
            if ($extension === 'pdf') {
                $pdf->setSourceFile($filename);
                $tpl = $pdf->importPage(1);
                $pdf->useTemplate($tpl, $x + 1, $y - 1, 80, 65); // PDF
            } else {
                $pdf->Image($filename, $x + 1, $y + 1, 80, 61); // Imagen
            }
        } catch (Exception $e) {
            $pdf->SetXY($x, $y + 20);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(82, 5, 'Error: ' . $e->getMessage(), 0, 0, 'C');
        }

        // Título
        $pdf->SetXY($x, $y + 63);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(82, 5, utf8_decode($titulo), 0, 0, 'C');
    }
}




