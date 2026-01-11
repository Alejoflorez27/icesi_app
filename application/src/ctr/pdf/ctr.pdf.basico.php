<?php
function imprimir($pdf, $id_solicitud, $id_servicio)
{
    $candidato = CtrSolCandidato::findById_candidato_vistas($id_solicitud);

    $obj_solSolicitud = new SolSolicitud($id_solicitud);
    $id_combo = $obj_solSolicitud->getIdCombo('id_combo');
    //print_r($id_combo);

    $pdf->SetX(10);
    $pdf->SetFillColor(207,207,207);
    $pdf->SetTextColor(000,000,000);
    if ($id_servicio == 12 || $id_combo == 3) {
        $pdf->Cell(190, 5, utf8_decode('DATOS GENERALES DE LA EMPRESA'), 0, 0, 'C', 0);
        $pdf->Ln(8);
    } else {
        $mantenimiento = CtrSrvCombos::findAllByComboMantenimiento($id_combo);
        if ($id_servicio == 4 || $mantenimiento['data'][0]['tiene_mantenimiento'] == "1") {
            $pdf->Cell(190, 5, utf8_decode('DATOS GENERALES DEL FUNCIONARIO'), 0, 0, 'C', 0);
        } else {
            $pdf->Cell(190, 5, utf8_decode('DATOS GENERALES DEL CANDIDATO'), 0, 0, 'C', 0);
        }
        
        //$pdf->Cell(190, 5, utf8_decode('DATOS GENERALES DEL CANDIDATO'), 0, 0, 'C', 0);
        $pdf->Ln(8);
    }

    if ($id_servicio == 12 || $id_combo == 3) { //Para visitas de asociado de negogio

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, "Fecha de Visita:", 1, 0, 'L', 1);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['fecha_visita']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Razón Social:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['razon_social']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("NIT:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 5, utf8_decode($candidato['data'][0]['nit']), 1, 0, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, utf8_decode("Dirección:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 5, utf8_decode($candidato['data'][0]['direccion']), 1, 0, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, utf8_decode("Teléfono:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(30, 5, utf8_decode($candidato['data'][0]['telefono']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Ciudad:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 5, utf8_decode($candidato['data'][0]['nombre_ciu_actual']), 1, 0, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, utf8_decode("Correo:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['email']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("Nombre del Representante Legal:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 5, utf8_decode($candidato['data'][0]['nombre_representante']." ".$candidato['data'][0]['apellido_representante']), 1, 0, 'L', 0);
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(45, 5, utf8_decode("Documento de Identificación:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(35, 5, utf8_decode($candidato['data'][0]['tipo_id']." - ".$candidato['data'][0]['numero_doc']), 1, 1, 'L', 0);


        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("Nombre de quien atendió la visita:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(60, 5, utf8_decode($candidato['data'][0]['nombre']." ".$candidato['data'][0]['apellido']), 1, 0, 'L', 0);
        
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 5, utf8_decode("Cargo:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['cargo_desempeno']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(85, 5, utf8_decode("Código de Actividad Económica:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['act_economica']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(85, 5, utf8_decode("Capital Suscrito en la Cámara de Comercio:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['capital_suscrito']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(85, 5, utf8_decode("País (es) donde realiza sus operaciones de comercio exterior:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['paises_exterior']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(100, 5, utf8_decode("Fecha de constitución de la empresa y fecha de inicio de operaciones:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['fch_constituida']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(85, 5, utf8_decode("Hace cuanto tiempo opera en las instalaciones visitadas:"), 1, 0, 'L', 1);
        
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['tmp_operacion']), 1, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(85, 5, utf8_decode("Volúmen de las operaciones mensuales:"), 1, 0, 'L', 1);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['vol_operaciones']), 1, 1, 'L', 0);

        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Row(array(utf8_decode("Tiene mas instalaciones propias o de terceros, en las cuales se desarrollen actividades inherentes a su actividad económica.\n* Si la respuesta es SI, enuncielos con dirección y persona de contacto. Amplie la información."),
                        utf8_decode($candidato['data'][0]['instalaciones']),

                    ));

        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Row(array(utf8_decode("Horario de Operación y Área Administrativa "),
                        utf8_decode($candidato['data'][0]['horario_operacion']),

                    ));

} else{
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, "Nombre y apellido del evaluado:", 1, 0, 'L', 1);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['nombre'] . ' ' . $candidato['data'][0]['apellido']), 1, 1, 'L', 0);

        //Direccion
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("Dirección:"), 1, 0, 'L', 1);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['direccion']), 1, 1, 'L', 0);

        //Cargo
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("Cargo:"), 1, 0, 'L', 1);

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, utf8_decode($candidato['data'][0]['cargo_desempeno']), 1, 1, 'L', 0);

    $campos = array(
        //"Nombre y apellido del evaluado" => $candidato['data'][0]['nombre'] . ' ' . $candidato['data'][0]['apellido'],
        //"Tipo de documento:" => ($candidato['data'][0]['des_tipo_doc']),
        "Documento de identidad:" => ($candidato['data'][0]['numero_doc']." - ".$candidato['data'][0]['des_tipo_doc']),
        "Pais, Dpto y Ciudad Nacimiento:" => ucwords(
            strtolower(
                $candidato['data'][0]['nom_pais_nac'] . ' - ' .
                $candidato['data'][0]['nom_dpto_nac'] . ' - ' .
                $candidato['data'][0]['nombre_ciudad_nac']
            )
        ),
        "Fecha de nacimiento - Edad" => date("d/m/Y", strtotime($candidato['data'][0]['fch_nacimiento'])) . " - " . $candidato['data'][0]['edad'] . " años",
        //"Pais, Dpto y Ciudad actual:" => ($candidato['data'][0]['nombre_pais_actual'] . '-' .  ($candidato['data'][0]['nom_dpto_actual']) . '-' .  ($candidato['data'][0]['nombre_ciu_actual'])),
        "Pais, Dpto y Ciudad actual:" => ucwords(
            strtolower(
                $candidato['data'][0]['nombre_pais_actual'] . ' - ' .
                $candidato['data'][0]['nom_dpto_actual'] . ' - ' .
                $candidato['data'][0]['nombre_ciu_actual']
            )
        ),
        "Localidad" => $candidato['data'][0]['localidad'],
        "Libreta militar:" =>  $candidato['data'][0]['libreta'],
        "Estado Civil:" => $candidato['data'][0]['des_estado_civil'],
        "Jefe de Area" => utf8_decode($candidato['data'][0]['jefe_area']),
        "Area" => utf8_decode($candidato['data'][0]['area']),
        "Teléfono" => $candidato['data'][0]['telefono'],
        "Correo:" => $candidato['data'][0]['email'],
        "Correo 2:" => $candidato['data'][0]['email1'],
        //"Dirección" => (($candidato['data'][0]['direccion'])),
        "Barrio" => ($candidato['data'][0]['barrio']),
        "Estrato" => $candidato['data'][0]['estracto'],
        //"Cargo que desempeña:" => $candidato['data'][0]['cargo_desempeno'],
        "Salario a Devengar:" => $candidato['data'][0]['salario_dev'],
        "Salario Actual:" => $candidato['data'][0]['salario_actual'],
        "Estado:" => $candidato['data'][0]['estado'],
        "Nivel de Escolaridad:" => $candidato['data'][0]['des_nivel_escolar'],
        //"Nombre de quien atiende la visita:" => $candidato['data'][0]['persona_visita'],
        //"Parentesco de quien atiende la visita:" => $candidato['data'][0]['parantesco_visita'],
        "Referencia personal:" => $candidato['data'][0]['referencia_personal'],
        "Salario Anterior:" => $candidato['data'][0]['salario_anterior'],
        "ARL:" => $candidato['data'][0]['arl'],
        "Razon social:" => $candidato['data'][0]['razon_social'],
        "NIT:" => $candidato['data'][0]['nit'],
        "Numero resolucion:" => $candidato['data'][0]['num_resolucion'],
        "Certificación:" => $candidato['data'][0]['certificacion'],
        "Alias:" => $candidato['data'][0]['alias'],
        //"¿Hace cuanto opera la empresa?" => $candidato['data'][0]['tmp_operacion'],
        //"Horario de operación" => $candidato['data'][0]['horario_operacion'],
        // Agrega los demás campos aquí
    );
    
    // Filtrar los campos que tienen valores no vacíos
    $campos_no_vacios = array_filter($campos);
    
    // Contar el número total de campos no vacíos
    $total_campos = count($campos_no_vacios);
    
    // Calcular la mitad del número total de campos no vacíos
    $mitad_campos = ceil($total_campos / 2);
    
    // Dividir el array de campos en dos partes
    $columna1 = array_slice($campos_no_vacios, 0, $mitad_campos, true);
    $columna2 = array_slice($campos_no_vacios, $mitad_campos, null, true);
    
    // Configura el ancho de cada columna
    $ancho_columna1 = 50;
    $ancho_columna2 = 45;
    
    // Establece la posición inicial de las columnas
    $x1 = 10;
    $x2 = 110;
    
    // Inicializa la posición Y para las dos columnas
    $posicion_y1 = $pdf->GetY();
    $posicion_y2 = $pdf->GetY();
    
    // Recorre la primera columna
    foreach ($columna1 as $nombre_campo => $valor) {
        if (!empty($valor)) {
            // Pinta el nombre del campo
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetXY($x1, $posicion_y1);
            $pdf->Cell($ancho_columna1, 5, utf8_decode($nombre_campo), 1, 0, 'L', 1);
            
            // Pinta el valor del campo
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell($ancho_columna1, 5, utf8_decode($valor), 1, 1, 'L');
            
            // Actualiza la posición Y para la próxima celda
            $posicion_y1 += 5;
        }
    }
    
    // Recorre la segunda columna
    foreach ($columna2 as $nombre_campo => $valor) {
        if (!empty($valor)) {
            // Pinta el nombre del campo
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY($x2, $posicion_y2);
            $pdf->Cell($ancho_columna2-5, 5, utf8_decode($nombre_campo), 1, 0, 'L', 1);
            
            // Pinta el valor del campo
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell($ancho_columna2+5, 5, utf8_decode($valor), 1, 1, 'L');
            
            // Actualiza la posición Y para la próxima celda
            $posicion_y2 += 5;
        }
    }
    
        $tmp_operacion = $candidato['data'][0]['tmp_operacion'];
        $servicio_suministrado = $candidato['data'][0]['servicio_suministrado'];
        $horario_operacion = $candidato['data'][0]['horario_operacion'];
    
        //Asociado de negocio
        if ($tmp_operacion != '') {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, utf8_decode("Tiempo de operación:"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->Cell(140, 5, utf8_decode($tmp_operacion), 1, 1, 'L', 0);
            $pdf->MultiCell(140, 5, utf8_decode($tmp_operacion), 1, 'L', 0);
        }
        if ($servicio_suministrado != '') {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, utf8_decode("Servicio suministrado:"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->Cell(140, 5, utf8_decode($servicio_suministrado), 1, 1, 'L', 0);
            $pdf->MultiCell(140, 5, utf8_decode($servicio_suministrado), 1, 'L', 0);
        }
    
        if ($horario_operacion != '') {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(50, 5, utf8_decode("Horario de operación:"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->Cell(140, 5, utf8_decode($horario_operacion), 1, 1, 'L', 0);
            $pdf->MultiCell(140, 5, utf8_decode($horario_operacion), 1, 'L', 0);
        }
}

    
/*
$pdf->Ln(18);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, "Nombre del funcionario:", 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['nombre']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Apellido del funcionario:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['apellido']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, "Tipo de documento:", 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['des_tipo_doc']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Documento de identidad:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['numero_doc']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, "Fecha nacimiento:", 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['fch_nacimiento']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Edad:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['edad']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, "Pais, Dpto y Ciudad Nacimiento:", 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['nom_pais_nac'] . '-' . $candidato['data'][0]['nom_dpto_nac'] . '-' . $candidato['data'][0]['nombre_ciudad_nac']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Teléfono:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['telefono']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Dirección:"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['direccion']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Barrio:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['barrio']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, "Estado Civil:", 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['des_estado_civil']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Salario Actual:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode('$ ' . number_format($candidato['data'][0]['salario_actual'])), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Estrato:"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['estracto']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Pais, Dpto y Ciudad actual:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['nombre_pais_actual'] . '-' . $candidato['data'][0]['nom_dpto_actual'] . '-' . $candidato['data'][0]['nombre_ciu_actual']), 1, 2, 'L', 0);
    $pdf->SetX(10);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Nivel de Escolaridad:"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(50, 5, utf8_decode($candidato['data'][0]['des_nivel_escolar']), 1, 0, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(45, 5, utf8_decode('Cargo que desempeña:'), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 5, utf8_decode($candidato['data'][0]['cargo_desempeno']), 1, 2, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(50, 5, utf8_decode("Correo:"), 1, 0, 'L', 1);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(140, 5, utf8_decode($candidato['data'][0]['email']), 1, 2, 'L', 0);

    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetTextColor(000, 000, 000);
    $pdf->multiCell(50, 5, "Nombre y parentesco de quien atiende la visita:", 1, 'L', 1);
    $y2 = $pdf->GetY();
    $pdf->SetXY(60, $y2 - 10);
    //$pdf->SetXY(60,119); // Cambiar segun se acomode la hoja
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(0, 10, utf8_decode($candidato['data'][0]['persona_visita'] . ' / ' . $candidato['data'][0]['parantesco_visita']), 1, 2, 'L', 0);
    */
}
