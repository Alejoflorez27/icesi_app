<?php

function infVisTeletrabajo($pdf, $id_solicitud, $id_servicio)
{
    //$pdf->AddPage();
    $candidato = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    //print_r($candidato['data'][0]['persona_visita']);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 8);
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
        
        $familia = CtrSolFamiliar::descripcionFamiliarTeletrabajo($id_solicitud, $id_servicio);
        //$pdf->AddPage();
        /*$pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('I. DIMENSIÓN FAMILIAR'), 0, 0, 'C', 1);
        $pdf->Ln(8);*/
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('INFORMACIÓN FAMILIAR (Personas que viven en casa con el funcionario)'), 0, 0, 'L', 1);
        $pdf->Ln(8);


        
        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial
        
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 6);
        
        $cellHeight = 5;  // Altura de la celda
        
        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial

        // Nombre
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Nombre(s) y apellidos"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);

        // Edad
        $x = $pdf->GetX();
        $pdf->MultiCell(10, 10, utf8_decode("Edad"), 1, 'C', 1);
        $pdf->SetXY($x + 10, $y);

        // Parentesco
        $pdf->MultiCell(30, 10, utf8_decode("Parentesco"), 1, 'C', 1);
        $pdf->SetXY($x + 40, $y); // Ajustar la posición X y mantener Y
        
        // Escolaridad
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Nivel educativo"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);

        // Ocupacion
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Ocupacion"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);
        

        // horario de permanencia en el hogar
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Horario de permanencia"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);
        

        // Depende economicamente
        $x = $pdf->GetX();
        $pdf->MultiCell(30, $cellHeight, utf8_decode("Depende\neconomicamente"), 1, 'C', 1);
        $pdf->SetXY($x + 20, $y);
        
        $pdf->Ln($cellHeight);
        
        
        
        $pdf->Ln(5);
        

        $pdf->SetWidths(array(30, 10, 30, 30, 30, 30, 30,15, 20));
        $pdf->SetAligns(array('L', 'C', 'L'));
        foreach ($familia['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($row['nombre']." ".$row['apellido']." CC - ".$row['identificacion']),
                            utf8_decode($row['edad']), 
                            utf8_decode($row['descripcion_parentesco']), 
                            utf8_decode($row['ocupacion']),
                            utf8_decode($row['descripcion_niv_escol']),
                            utf8_decode($row['horario']),
                            utf8_decode($row['descripcion_depende_candidato']),
                        ));
        }
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->MultiCell(190, 5, utf8_decode('Distribución de los roles y compromisos al interior de la familia  para que el funcionario pueda Teletrabajar: Verificar si las personas cuenta con las condiciones para estar en teletrabajo (distribución de tareas en el hogar, roles, dinamica familiar etc. ) '), 0, 'L', 1);
        //$pdf->MultiCell(30, 10, utf8_decode("Horario de permanencia"), 1, 'C', 1);
        $pdf->Ln(3);
/*
        $obsFamilia = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_familia');
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(190, 4, utf8_decode($obsFamilia['data']['observacion']), 0, 'J', 0);
        $pdf->Ln(5);
*/


        
        $distribucion_roles = CtrRolesTeletrabajo::descripcionFamiliarTeletrabajo($id_solicitud, $id_servicio);
        $pdf->SetWidths(array(90, 100));
        $pdf->SetAligns(array('L', 'L'));
        foreach ($distribucion_roles['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($row['des_pregunta']),
                            utf8_decode($row['respuesta']), 
                        ));
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('DESCRIPCIÓN DEL LUGAR DE RESIDENCIA'), 0, 0, 'L', 1);
        $pdf->Ln(8);

        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial
        
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 6);
        
        $cellHeight = 5;  // Altura de la celda
        
        $x = $pdf->GetX();  // Guardar la posición X inicial
        $y = $pdf->GetY();  // Guardar la posición Y inicial

        // Dirección de residencia
        $x = $pdf->GetX();
        $pdf->MultiCell(50, 10, utf8_decode("Dirección de residencia"), 1, 'C', 1);
        $pdf->SetXY($x + 50, $y);

        // Teléfono
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Teléfono"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);

        // Barrio
        $x = $pdf->GetX();
        $pdf->MultiCell(40, 10, utf8_decode("Barrio"), 1, 'C', 1);
        $pdf->SetXY($x + 40, $y); // Ajustar la posición X y mantener Y

        // Estrato
        $x = $pdf->GetX();
        $pdf->MultiCell(40, 10, utf8_decode("Estrato"), 1, 'C', 1);
        $pdf->SetXY($x + 40, $y); // Ajustar la posición X y mantener Y
        
        // Zona
        $x = $pdf->GetX();
        $pdf->MultiCell(30, 10, utf8_decode("Zona"), 1, 'C', 1);
        $pdf->SetXY($x + 30, $y);
        
        
        $pdf->Ln($cellHeight);
        
        
        
        $pdf->Ln(5);
        
        $vivienda = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);

        $pdf->SetWidths(array(50,30, 40, 40, 30));
        $pdf->SetAligns(array('L', 'L', 'L'));
        foreach ($vivienda['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(utf8_decode($row['direccion']),
                            utf8_decode($row['telefono']), 
                            utf8_decode($row['barrio']), 
                            utf8_decode($row['estrato']),
                            utf8_decode($row['zona']),

                        ));

            $pdf->Ln(5);


            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('Descripción del entorno (Marque "X", según corresponda)'), 0, 0, 'L', 0);
            $pdf->Ln(8);
            
            //Ambiente
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(20, 5, "Ambiente:", 1, 'L', 1);

            $tranquilo = '';
            $agitado = '';
            if ($row['ambiente'] == 'Tranquilo') {
                $tranquilo = 'X';
            } else if ($row['ambiente'] == 'Agitado') {
                $agitado = 'X';
            }

            //Tranquilo
            $y2 = $pdf->GetY();
            $pdf->SetXY(30, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Tranquilo'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(55, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);            
            $pdf->Cell(5, 5, utf8_decode($tranquilo), 1, 2, 'C', 0);

            //Agitado
            $y2 = $pdf->GetY();
            $pdf->SetXY(60, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Agitado'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(90, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 5, utf8_decode($agitado), 1, 2, 'C', 0);


            
            //Sector
            $pdf->Ln(0.2);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(20, 5, "Sector:", 1, 'L', 1);

            $residencial = '';
            $comercial = '';
            if ($row['sector'] == 'Residencial') {
                $residencial = 'X';
            } else if ($row['sector'] == 'Comercial') {
                $comercial = 'X';
            }

            //Residencial
            $y2 = $pdf->GetY();
            $pdf->SetXY(30, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Residencial'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(55, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 5, utf8_decode($residencial), 1, 2, 'C', 0);

            //Comercial
            $y2 = $pdf->GetY();
            $pdf->SetXY(60, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Comercial'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(90, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 5, utf8_decode($comercial), 1, 2, 'C', 0);




            //Lugar
            $pdf->Ln(0.2);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(20, 5, "Lugar:", 1, 'L', 1);

            $seguro = '';
            $inseguro = '';
            if ($row['lugar'] == 'Seguro') {
                $seguro = 'X';
            } else if ($row['lugar'] == 'Inseguro') {
                $inseguro = 'X';
            }

            //Seguro
            $y2 = $pdf->GetY();
            $pdf->SetXY(30, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Seguro'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(55, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 5, utf8_decode($seguro), 1, 2, 'C', 0);

            //Inseguro
            $y2 = $pdf->GetY();
            $pdf->SetXY(60, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode('Inseguro'), 1, 2, 'L', 0);
            $y2 = $pdf->GetY();
            $pdf->SetXY(90, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 5, utf8_decode($inseguro), 1, 2, 'C', 0);
            
            //Descripción de la seguridad del sector
            $vivDescripcion = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_descripcion_teletrabajo');
            //$y2 = $pdf->GetY();
            $pdf->SetX(10);
            $pdf->Ln(2);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(0, 4, utf8_decode('Descripción de la seguridad del sector y de la residencia:'."\n".$row['aclaracion_viv']), 1, 'J', 0);

            $pdf->Ln(10);

            //Descripcion interna
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('Descripción interna (Marque "X", según corresponda)'), 0, 0, 'L', 0);
            $pdf->Ln(8);

            //Tamaño aproximado
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(40, 5, utf8_decode("Tamaño aproximado:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(50, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['descripcion_tamano']), 1, 2, 'L', 0);

            //$pdf->Ln(0.2);
            //"Niveles de construcción
            /*$y2 = $pdf->GetY();
            $pdf->SetXY(100, $y2 - 5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(50, 5, utf8_decode("Niveles de construcción:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(150, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['descripcion_tamano']), 1, 2, 'L', 0);*/
            
            //Tipo de vivienda
            //$pdf->Ln(0.2);
            $y2 = $pdf->GetY();
            $pdf->SetXY(100, $y2 - 5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(50, 5, utf8_decode("Tipo de vivienda:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(150, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['descripcion_tipo_viv']), 1, 2, 'L', 0);

            $pdf->Ln(5);
            //Tipo de construcción:
            $y2 = $pdf->GetY();
            $pdf->SetXY(10, $y2 - 5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(40, 5, utf8_decode("Tipo de construcción:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(50, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['descripcion_estado']), 1, 2, 'L', 0);

            //Forma de propiedad
            $y2 = $pdf->GetY();
            $pdf->SetXY(100, $y2 - 5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(50, 5, utf8_decode("Forma de propiedad:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(150, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['descripcion_tenencia']), 1, 2, 'L', 0);

            $pdf->Ln(5);
            //Organización y limpieza:
            $y2 = $pdf->GetY();
            $pdf->SetXY(10, $y2 - 5);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(40, 5, utf8_decode("Organización y limpieza:"), 1, 'L', 1);
            $y2 = $pdf->GetY();
            $pdf->SetXY(50, $y2 - 5);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(50, 5, utf8_decode($row['limpieza']), 1, 2, 'L', 0);


        }
            //Servicios Publicos
            $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
            $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'], 'tipo_aspecto_servicios', $id_solicitud, $id_servicio);
            $descripcionServicios = '';
    
            foreach ($aspectFisico['data'] as $row) {
                $descripcionServicios .= $row['descripcion']. ', ' ;
            }

            //Forma de propiedad
            $pdf->Ln(10);
            $y2 = $pdf->GetY();
            $pdf->SetXY(10, $y2 - 5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(000, 000, 000);
            $pdf->multiCell(190, 5, utf8_decode("Servicios Publicos:"."\n".$descripcionServicios), 0, 'L', 0);

            $pdf->Ln(6);

            //Muebles y enseres
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('Muebles y enseres (Marque "X", según corresponda)'), 0, 0, 'L', 0);
            $pdf->Ln(8);

            $pdf->SetFont('Arial', '', 7);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('HABITACIONES:'), 0, 0, 'L', 0);
            $pdf->Ln(8);
            
            $cellHeight = 5;  // Altura de la celda
            
            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Hab. No.
            $pdf->MultiCell(95, 5, utf8_decode("Hab. No."), 1, 'C', 1);
            $pdf->SetXY($x + 95, $y); // Ajustar la posición X y mantener Y
            
            // Ocupante(s)
            $x = $pdf->GetX();
            $pdf->MultiCell(95, 5, utf8_decode("Ocupante(s)"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $vivDistribucion = CtrVivDistribuciones::findAllTeletrabajo($id_solicitud, $id_servicio);
            $pdf->SetWidths(array(95, 95));
            $pdf->SetAligns(array('C', 'C'));
            $countHabita = 0;
            $count = 1;
            foreach ($vivDistribucion['data'] as $row) {

                if ($row['descripcion_tipo_espacios']== 'HABITACIONES') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($count++), 
                                    utf8_decode($row['ocupante']), 
                                ));
                    $countHabita++;
                }

            }

            $pdf->Ln(4);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('Cantidad:'." ".$countHabita), 0, 0, 'L', 0);
            $pdf->Ln(8);



            $pdf->SetWidths(array(15, 10, 15, 10,140));
            $pdf->SetAligns(array('C', 'C', 'C', 'C','L'));
            foreach ($vivDistribucion['data'] as $row) {

                if ($row['descripcion_tipo_espacios'] == 'SALA') {

                // SALA
                $pdf->MultiCell(95, 5, utf8_decode("SALA:"), 0, 'L', 0);

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode('SI'),
                                    utf8_decode('X'),
                                    utf8_decode('NO'), 
                                    utf8_decode(''),
                                    utf8_decode('Descripción: '.$row['descripcion']), 
                                ));
                    
                }

                


            }
            $pdf->Ln(4);
            $pdf->SetWidths(array(15, 10, 15, 10,140));
            $pdf->SetAligns(array('C', 'C', 'C', 'C','L'));
            foreach ($vivDistribucion['data'] as $row) {

                if ($row['descripcion_tipo_espacios'] == 'COMEDOR') {

                // COMEDOR
                $pdf->MultiCell(95, 5, utf8_decode("COMEDOR:"), 0, 'L', 0);

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode('SI'),
                                    utf8_decode('X'),
                                    utf8_decode('NO'), 
                                    utf8_decode(''),
                                    utf8_decode('Descripción: '.$row['descripcion']), 
                                ));
                    
                }

                


            }

            $pdf->Ln(4);
            $pdf->SetWidths(array(15, 10, 15, 10, 20, 120));
            $pdf->SetAligns(array('C', 'C', 'C', 'C','L'));
            foreach ($vivDistribucion['data'] as $row) {

                if ($row['descripcion_tipo_espacios'] == 'BAÑOS') {

                // BAÑOS
                $pdf->MultiCell(95, 5, utf8_decode("BAÑOS:"), 0, 'L', 0);

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode('SI'),
                                    utf8_decode('X'),
                                    utf8_decode('NO'), 
                                    utf8_decode(''),
                                    utf8_decode('Cantidad: '.$row['numero_espacio']), 
                                    utf8_decode('Descripción: '.$row['descripcion']), 
                                ));
                    
                }
            }
            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('DESCRIPCIÓN DEL LUGAR DE TRABAJO'), 0, 0, 'L', 1);
            $pdf->Ln(5);
            //Descripción de la seguridad del sector
            $vivDescripcion = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_descripcion_teletrabajo');
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(190, 4, utf8_decode("\n".$vivDescripcion['data']['observacion']), 0, 'J', 0);

            $pdf->Ln(5);
            //factores de riesgo
            $pdf->SetFillColor(207, 207, 207);
            // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("FACTOR DE RIESGO"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);
            $pdf->SetFillColor(207, 207, 207);
            // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("FACTORES LIGADOS A LA TAREA"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);

            //ASPECTO IDENTIFICADO - CARGA DE TRABAJO
            $pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - CARGA DE TRABAJO"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'CARGA DE TRABAJO') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            //ASPECTO IDENTIFICADO AUTONOMIA
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - AUTONOMIA"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'AUTONOMIA') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            $pdf->SetFillColor(207, 207, 207);
            // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("FACTORES LIGADOS A LA ORGANIZACIÓN DE TIEMPO DE TRABAJO"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);

            //ASPECTO IDENTIFICADO - JORNADA DE TRABAJO Y DISTRIBUCION TEMPORAL
            $pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - JORNADA DE TRABAJO Y DISTRIBUCION TEMPORAL"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'JORNADA DE TRABAJO Y DISTRIBUCION TEMPORAL') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            //ASPECTO IDENTIFICADO DESCANSOS Y PAUSAS
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - DESCANSOS Y PAUSAS"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'DESCANSOS Y PAUSAS') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }






            
            $pdf->SetFillColor(207, 207, 207);
            // Renderizar las filas almacenadas para fuentes consultadas y hallazgos
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("FACTORES LIGADOS A LA ESTRUCTURA DE LA ORGANIZACIÓN"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);

            //ASPECTO IDENTIFICADO - ESTILO DE MANDO
            $pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - ESTILO DE MANDO"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'ESTILO DE MANDO') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            //ASPECTO IDENTIFICADO COMUNICACIÓN
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - COMUNICACIÓN"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'COMUNICACIÓN') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            //ASPECTO IDENTIFICADO RELACIONES CON OTRAS ÁREAS Y COMPAÑEROS
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - RELACIONES CON OTRAS ÁREAS Y COMPAÑEROS"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'RELACIONES CON OTRAS AREAS Y COMPAÑEROS') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            //ASPECTO IDENTIFICADO SISTEMA DE RECOMPENSAS O COMPENSACIONES
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - SISTEMA DE RECOMPENSAS O COMPENSACIONES"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'SISTEMA DE RECOMPENSAS O COMPENSACIONES') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }
            //ASPECTO IDENTIFICADO FUTURO INSEGURO EN EL EMPLEO
            //$pdf->Ln(5);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 5, utf8_decode("ASPECTO IDENTIFICADO - FUTURO INSEGURO EN EL EMPLEO"), 1, 0, 'C', 1);
            //$pdf->Cell(40, 5, utf8_decode("Descripción"), 1, 0, 'C', 1);
            $pdf->Ln(5);

            $x = $pdf->GetX();  // Guardar la posición X inicial
            $y = $pdf->GetY();  // Guardar la posición Y inicial

            
            // Descripción
            $pdf->SetFillColor(207, 207, 207);
            $pdf->MultiCell(70, 5, utf8_decode("Descripción"), 1, 'C', 1);
            $pdf->SetXY($x + 70, $y); // Ajustar la posición X y mantener Y
            
            // Calificación
            $x = $pdf->GetX();
            $pdf->MultiCell(30, 5, utf8_decode("Calificación"), 1, 'C', 1);
            $pdf->SetXY($x + 30, $y);

            // Observación
            $x = $pdf->GetX();
            $pdf->MultiCell(90, 5, utf8_decode("Observación"), 1, 'C', 1);
            $pdf->SetXY($x + 15, $y);
            


            $pdf->Ln(5);
            

            $riesgosTeletrabajo = CtrRiesgosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($riesgosTeletrabajo);
            $pdf->SetWidths(array(70, 30, 90));
            $pdf->SetAligns(array('L', 'C', 'L'));

            foreach ($riesgosTeletrabajo['data'] as $row) {

                if ($row['aspecto'] == 'FUTURO INSEGURO EN EL EMPLEO') {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array(utf8_decode($row['descripcion']), 
                                    utf8_decode($row['calificacion']),
                                    utf8_decode($row['observacion']), 
                                ));

                }

            }

            $pdf->Ln(8);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190, 5, utf8_decode('DISPOSITIVOS O HERRAMIENTAS DE TRABAJO'), 0, 0, 'L', 1);
            $pdf->Ln(10);

            $pdf->SetWidths(array(20, 20, 20, 60, 30, 40));
            $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));

            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Row2(array(utf8_decode("Computador"), 
                            utf8_decode("Personal"),
                            utf8_decode("Compartido"), 
                            utf8_decode("No. de personas que hacen uso del equipo"), 
                            utf8_decode("Cámara"),
                            utf8_decode("Tipo PC"),  
                        ));

            $dispositivoTeletrabajo = CtrDispositivosTeletrabajo::findAll($id_solicitud, $id_servicio);
            //print_r($dispositivoTeletrabajo['data']['computador']);
            $pdf->SetWidths(array(20, 20, 20, 60, 30, 40));
            $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'L'));

            foreach ($dispositivoTeletrabajo['data'] as $row1) {

                    $pdf->SetFillColor(207, 207, 207);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Row(array(utf8_decode($row1['computador']), 
                                    utf8_decode($row1['personal']),
                                    utf8_decode($row1['compartido']), 
                                    utf8_decode($row1['num_persona']), 
                                    utf8_decode($row1['camara']),
                                    utf8_decode($row1['marca']),  
                                ));
            }

        //Internet

        $pdf->SetWidths(array(60, 45, 45, 40));
        $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'L'));

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Row2(array(utf8_decode("Internet"), 
                        utf8_decode("Fijo"),
                        utf8_decode("Movil"),  
                        utf8_decode("# Megas"),  
                    ));
        

        $dispositivoTeletrabajo = CtrDispositivosTeletrabajo::findAll($id_solicitud, $id_servicio);
        //print_r($dispositivoTeletrabajo['data']['computador']);
        $pdf->SetWidths(array(60, 45, 45, 40));
        $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'L'));

        foreach ($dispositivoTeletrabajo['data'] as $row1) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Row(array(utf8_decode($row1['internet']), 
                                utf8_decode($row1['fijo']),
                                utf8_decode($row1['movil']),  
                                utf8_decode($row1['megas']),  
                            ));
        }


        //linea telefonica local

        $pdf->SetWidths(array(95, 95));
        $pdf->SetAligns(array('C', 'C'));

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Row2(array(utf8_decode("Linea telefonica local"), 
                        utf8_decode("Número"),  
                    ));      

        $dispositivoTeletrabajo = CtrDispositivosTeletrabajo::findAll($id_solicitud, $id_servicio);
        //print_r($dispositivoTeletrabajo['data']['computador']);
        $pdf->SetWidths(array(95, 95));
        $pdf->SetAligns(array('C', 'C'));

        foreach ($dispositivoTeletrabajo['data'] as $row1) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Row(array(utf8_decode($row1['linea_tele_local']), 
                                utf8_decode($row1['numero']),  
                            ));
        }

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('Sistema (Propiedades del Sistema)'), 0, 0, 'L', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('¿La empresa brinda los elementos de trabajo?: '.$dispositivoTeletrabajo['data'][0]['empresa_herramientas']), 0, 0, 'L', 0);
        $pdf->Ln(8);

        $pdf->SetWidths(array(60, 45, 45, 40));
        $pdf->SetAligns(array('C', 'C', 'C', 'C'));

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Row2(array(utf8_decode("Edición de Windows"), 
                        utf8_decode("Memoria Instalada (RAM)"),
                        utf8_decode("Procesador"),  
                        utf8_decode("Tipo de Sistema"),  
                    ));

        

        $dispositivoTeletrabajo = CtrDispositivosTeletrabajo::findAll($id_solicitud, $id_servicio);
        //print_r($dispositivoTeletrabajo['data']['computador']);
        $pdf->SetWidths(array(60, 45, 45, 40));
        $pdf->SetAligns(array('C', 'C', 'C', 'C'));

        foreach ($dispositivoTeletrabajo['data'] as $row1) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Row(array(utf8_decode($row1['windows']), 
                                utf8_decode($row1['ram']),
                                utf8_decode($row1['procesador']),  
                                utf8_decode($row1['sistema']),  
                            ));
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->MultiCell(190, 5, utf8_decode("Seguridad de la información (manejo de la información, archivos, medios fisicos y magneticos):"), 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(190, 5, utf8_decode($dispositivoTeletrabajo['data'][0]['seguridad']), 0, 'L', 0);
        
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('ASPECTOS DE SALUD'), 0, 0, 'L', 1);
        $pdf->Ln(10);

        $saludTeletrabajo = CtrSaludTeletrabajo::findAll($id_solicitud, $id_servicio);
        //print_r($dispositivoTeletrabajo['data']['computador']);
        $pdf->SetWidths(array(95, 95));
        $pdf->SetAligns(array('L', 'L'));

        foreach ($saludTeletrabajo['data'] as $row1) {

                $pdf->SetFillColor(207, 207, 207);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Row(array(utf8_decode($row1['aspecto']), 
                                utf8_decode($row1['observacion']), 
                            ));
        }

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->MultiCell(190, 5, utf8_decode('OBSERVACIONES DE LA VISITA, CONCEPTO GENERAL DE LAS CONDICIONES PSCOSOCIALES DEL  EVALUADO  ACTITUD FRENTE AL PROCESO'), 0, 'C', 1);
        $pdf->Ln(5);

        $conceptoTeletrabajo = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->MultiCell(190, 5, utf8_decode('Concepto: '.$conceptoTeletrabajo['data'][0]['des_concepto']."\n"
                                           .'Observación: '.$conceptoTeletrabajo['data'][0]['observacion']), 0, 'L', 0);
        

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
        
        //Registro Fotografico
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->MultiCell(190, 5, utf8_decode('REGISTRO FOTOGRAFICO'), 0, 'C', 1);
        $pdf->Ln(5);
        $fotos = CtrSolAdjuntos::descripcionAdjuntos($id_solicitud);
        $fotoConexionEquipos = '';
        $fotoPuestoTrabajo = '';
        $fotoUbicacionPuesto = '';
        $fotoFachada = '';
        $fotoPuertaIngreso = '';



        foreach ($fotos['data'] as $row) {

            if ($row['descripcion'] == 'CONEXIÓN DE EQUIPOS') {
                $fotoConexionEquipos = $row['directorio'] . '/' . $row['nombre_encr'];
            } else if ($row['descripcion'] == 'PUESTO DE TRABAJO') {
                $fotoPuestoTrabajo = $row['directorio'] . '/' . $row['nombre_encr'];
            } else if ($row['descripcion'] == 'UBICACIÓN DE PUESTO DE TRABAJO') {
                $fotoUbicacionPuesto = $row['directorio'] . '/' . $row['nombre_encr'];
            } else if ($row['descripcion'] == 'FUNCIONARIO EN PUESTO DE TRABAJO') {
                $fotoFuncionario = $row['directorio'] . '/' . $row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA FACHADA') {
                $fotoFachada = $row['directorio'] . '/' . $row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA PUERTA DE INGRESO') {
                $fotoPuertaIngreso = $row['directorio'] . '/' . $row['nombre_encr'];
            }
        }  //fin foreach

        // FOTO CONEXIÓN EQUIPOS
        $pdf->Ln(10);
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoConexionEquipos;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        //$getY = $pdf->GetY();
        $pdf->SetXY(23, $getY + 67);
        //  $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("CONEXIÓN EQUIPOS"), 0, 0, 'C', 0);

        // FOTO PUESTO DE TRABAJO
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        $filename = $fotoPuestoTrabajo;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }

        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("PUESTO DE TRABAJO"), 0, 0, 'C', 0);

        $pdf->Ln(5);
        $pdf->SetX(23);
        $getX = $pdf->GetX() + 1;
        // FOTO de la ubicacion del puesto
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoUbicacionPuesto;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        } //FIN

        $pdf->SetXY(23, $getY + 67);
        //  $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("UBICACIÓN DE PUESTO DE TRABAJO"), 0, 0, 'C', 0);

        // FOTO entrada del apto.
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        //ZONA SOCIAL
        $filename = $fotoFuncionario;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FUNCIONARIO EN PUESTO DE TRABAJO"), 0, 0, 'C', 0);


        $pdf->Ln(5);
        $pdf->SetX(23);
        $getX = $pdf->GetX() + 1;
        // FOTO DE FACHADA
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoFachada;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        } //FIN

        $pdf->SetXY(23, $getY + 67);
        //  $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DE LA FACHADA"), 0, 0, 'C', 0);

        // FOTO entrada del apto.
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        //ZONA SOCIAL
        $filename = $fotoPuertaIngreso;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DE LA PUERTA DE INGRESO"), 0, 0, 'C', 0);

    }
}
