<?php
function consentimientoInformadoPdf($pdf, $id_solicitud, $id_servicio)
{
    // Configuración básica del PDF
    $pdf->AddPage();
    
    // Obtener datos del paciente (ajusta según tu base de datos)
    $paciente = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    
    // Datos del paciente
    $datos_paciente = array(
        'nombre' => isset($paciente['data'][0]['nombre']) ? $paciente['data'][0]['nombre'] : '',
        'apellido' => isset($paciente['data'][0]['apellido']) ? $paciente['data'][0]['apellido'] : '',
        'tipo_documento' => isset($paciente['data'][0]['tipo_documento']) ? $paciente['data'][0]['tipo_documento'] : '',
        'numero_documento' => isset($paciente['data'][0]['numero_documento']) ? $paciente['data'][0]['numero_documento'] : '',
        'ciudad_exp' => isset($paciente['data'][0]['ciudad_exp']) ? $paciente['data'][0]['ciudad_exp'] : '',
        'familiar_responsable' => isset($paciente['data'][0]['familiar_responsable']) ? $paciente['data'][0]['familiar_responsable'] : '',
        'tipo_doc_responsable' => isset($paciente['data'][0]['tipo_doc_responsable']) ? $paciente['data'][0]['tipo_doc_responsable'] : '',
        'num_doc_responsable' => isset($paciente['data'][0]['num_doc_responsable']) ? $paciente['data'][0]['num_doc_responsable'] : ''
    );
    
    // Crear el formulario
    crearFormularioConsentimiento($pdf, $datos_paciente);
}

function crearFormularioConsentimiento($pdf, $datos)
{
    // Configurar márgenes
    $pdf->SetMargins(15, 15, 15);
    
    // Título principal
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('CONSENTIMIENTO INFORMADO PARA EL TRANSPORTE ASISTENCIAL'), 0, 1, 'C');
    $pdf->Ln(5);
    
    // Subtítulo: Básico / Medicalizado
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, utf8_decode('BÁSICO: ___   MEDICALIZADO: ___'), 0, 1, 'L');
    $pdf->Ln(8);
    
    // Primer párrafo
    $pdf->SetFont('Arial', '', 11);
    $texto1 = utf8_decode('Yo ') . 
             ($datos['nombre'] != '' ? utf8_decode($datos['nombre'] . ' ' . $datos['apellido']) : '________________________') .
             utf8_decode(' identificado(a) con el tipo de documento de identidad: ') .
             ($datos['tipo_documento'] != '' ? utf8_decode($datos['tipo_documento']) : '__________') .
             utf8_decode(' y el número: ') .
             ($datos['numero_documento'] != '' ? utf8_decode($datos['numero_documento']) : '________________') .
             utf8_decode(' de ') .
             ($datos['ciudad_exp'] != '' ? utf8_decode($datos['ciudad_exp']) : '________________') .
             utf8_decode(', manifiesto que he recibido información acerca de la necesidad de realizar mi traslado en ambulancia terrestre básica ___ medicalizada ___.');
    
    $pdf->MultiCell(0, 6, $texto1, 0, 'J');
    $pdf->Ln(6);
    
    // Segundo párrafo
    $pdf->MultiCell(0, 6, utf8_decode('Se me ha explicado que la ambulancia dispone de un médico ___, auxiliar de enfermería ___ y un conductor ___, así como también de los equipos, insumos y dispositivos médicos necesarios para la realización de las actividades y procedimientos que se puedan requerir durante el traslado acordes con mi estado de salud.'), 0, 'J');
    $pdf->Ln(6);
    
    // Tercer párrafo
    $pdf->MultiCell(0, 6, utf8_decode('Se me ha informado que el traslado se hará en el menor tiempo posible, con el fin de reducir los riesgos en mi estado de salud por la demora en el mismo, y así poder garantizar una atención médica oportuna en la institución de salud más cercana, o a la cual debo trasladarme.'), 0, 'J');
    $pdf->Ln(6);
    
    // Cuarto párrafo
    $pdf->MultiCell(0, 6, utf8_decode('También se me ha explicado, que existen riesgos de difícil previsión que no pueden ser advertidos, y pueden surgir complicaciones que conlleven a detener la ambulancia hasta que estas se solucionen mediante técnicas y/o tratamientos que sean necesarios, que existen unos riesgos debidos al propio transporte (vibraciones, aceleración - desaceleración, accidente, avería, etc.) los cuales podrían determinar modificaciones en el estado de salud.'), 0, 'J');
    $pdf->Ln(6);
    
    // Quinto párrafo
    $pdf->MultiCell(0, 6, utf8_decode('Se me explicaron las alternativas posibles, tuve la oportunidad de aclarar las dudas realizando las preguntas necesarias, las cuales se respondieron en forma satisfactoria, y en consecuencia ACEPTO Y DOY ____ NO ACEPTO NI DOY ___ mi consentimiento y autorización a la tripulación correspondiente para llevar a cabo el traslado y efectuar los procedimientos terapéuticos que se consideren indicados.'), 0, 'J');
    $pdf->Ln(12);
    
    // ============================
    // TABLA DE DATOS Y FIRMAS
    // ============================
    $pdf->SetFont('Arial', 'B', 10);
    
    // Definir anchos de columnas
    $pdf->SetWidths(array(95, 95));
    $pdf->SetAligns(array('C', 'C'));
    
    // Fila 1: Títulos
    $pdf->SetFillColor(174, 214, 241); // Azul claro para cabecera
    $pdf->Row(array(
        utf8_decode('NOMBRE COMPLETO DEL PACIENTE'),
        utf8_decode('NOMBRE COMPLETO DEL RESPONSABLE DEL PACIENTE')
    ));
    
    // Fila 2: Datos del paciente y responsable
    $pdf->SetFillColor(207, 207, 207); // Gris claro para datos
    $pdf->SetFont('Arial', '', 10);
    $pdf->Row(array(
        utf8_decode($datos['nombre'] != '' ? $datos['nombre'] . ' ' . $datos['apellido'] : '________________________'),
        utf8_decode($datos['familiar_responsable'] != '' ? $datos['familiar_responsable'] : '________________________')
    ));
    
    // Fila 3: Títulos documento
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Row(array(
        utf8_decode('TIPO Y No DEL DOCUMENTO DEL PACIENTE'),
        utf8_decode('TIPO Y No DEL DOCUMENTO DEL RESPONSABLE')
    ));
    
    // Fila 4: Datos documento
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Row(array(
        utf8_decode(($datos['tipo_documento'] != '' ? $datos['tipo_documento'] : '____') . ' ' . 
                   ($datos['numero_documento'] != '' ? $datos['numero_documento'] : '____________')),
        utf8_decode(($datos['tipo_doc_responsable'] != '' ? $datos['tipo_doc_responsable'] : '____') . ' ' . 
                   ($datos['num_doc_responsable'] != '' ? $datos['num_doc_responsable'] : '____________'))
    ));
    
    // Fila 5: Títulos firma
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Row(array(
        utf8_decode('FIRMA DEL PACIENTE'),
        utf8_decode('FIRMA DEL RESPONSABLE DEL PACIENTE')
    ));
    
    // Fila 6: Espacios para firma (más altos)
    $pdf->SetWidths(array(95, 95));
    $pdf->SetAligns(array('C', 'C'));
    $pdf->SetFillColor(240, 240, 240); // Gris muy claro para espacios de firma
    
    // Fila para firma paciente
    $nb = 0;
    $h = 25; // Altura mayor para espacio de firma
    //$this->CheckPageBreak($h);
    
    for ($i = 0; $i < 2; $i++) {
        $w = 95;
        $a = 'C';
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        
        // Dibujar rectángulo para espacio de firma
        $pdf->Rect($x, $y, $w, $h);
        
        // Espacio para firma
        $pdf->SetXY($x, $y + ($h/2) - 3);
        $pdf->Cell($w, 6, '', 0, 0, $a, true);
        
        // Poner posición a la derecha de la celda
        $pdf->SetXY($x + $w, $y);
    }
    
    // Ir a la siguiente línea
    $pdf->Ln($h);
    
    // Fila 7: Títulos personal médico
    $pdf->SetWidths(array(95, 95));
    $pdf->SetAligns(array('C', 'C'));
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Row(array(
        utf8_decode('NOMBRE COMPLETO DEL AUXILIAR DE ENFERMERÍA'),
        utf8_decode('FIRMA DEL AUXILIAR DE ENFERMERÍA')
    ));
    
    // Fila 8: Datos auxiliar de enfermería
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Row(array(
        utf8_decode('________________________'),
        utf8_decode('________________________')
    ));
    
    // Fila 9: Títulos médico
    $pdf->SetFillColor(174, 214, 241);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Row(array(
        utf8_decode('NOMBRE COMPLETO DEL MÉDICO'),
        utf8_decode('FIRMA DEL MÉDICO')
    ));
    
    // Fila 10: Datos médico
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Row(array(
        utf8_decode('________________________'),
        utf8_decode('________________________')
    ));
    
    // Espacio al final
    $pdf->Ln(10);
}


?>