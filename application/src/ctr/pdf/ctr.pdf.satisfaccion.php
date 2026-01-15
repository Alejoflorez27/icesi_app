<?php
function encuestaSatisfaccionPdf($pdf, $id_solicitud, $id_servicio)
{
    // Configuración básica del PDF
    $pdf->AddPage();
    
    // Obtener datos del paciente
    $paciente = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    
    // Datos para la encuesta
    $datos_encuesta = array(
        'nombre_paciente' => isset($paciente['data'][0]['nombre']) ? $paciente['data'][0]['nombre'] . ' ' . $paciente['data'][0]['apellido'] : '',
        'tipo_documento' => isset($paciente['data'][0]['tipo_documento']) ? $paciente['data'][0]['tipo_documento'] : '',
        'numero_documento' => isset($paciente['data'][0]['numero_documento']) ? $paciente['data'][0]['numero_documento'] : '',
        'telefono_paciente' => isset($paciente['data'][0]['telefono']) ? $paciente['data'][0]['telefono'] : '',
        'fecha_aplicacion' => date('d/m/Y'),
        'tipo_transporte' => 'BÁSICO',
        'aseguradora' => isset($solicitud['aseguradora']) ? $solicitud['aseguradora'] : 'NO APLICA',
        'auxiliar_nombre' => 'NOMBRE DEL AUXILIAR'
    );
    
    // Crear el formulario de encuesta
    crearFormularioEncuestaSatisfaccion($pdf, $datos_encuesta);
}

function crearFormularioEncuestaSatisfaccion($pdf, $datos)
{
    // Configurar márgenes (15mm cada lado = 30mm, ancho útil: 210-30 = 180mm)
    $pdf->SetMargins(10, 10, 10);
    $ancho_util = 190; // Ancho máximo dentro de márgenes
    
    // Título principal (más pequeño)
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, utf8_decode('ENCUESTA DE SATISFACCIÓN'), 0, 1, 'C');
    
    // Subtítulo
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, utf8_decode('TRANSPORTE ASISTENCIAL BÁSICO ___MEDICALIZADO___'), 0, 1, 'C');
    
    $pdf->Ln(5);
    
    // Texto introductorio (más pequeño)
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(0, 4.5, utf8_decode('Para nosotros es de gran importancia el mejoramiento de los servicios; por ello, le invitamos a evaluar la forma en la que fue atendido. Su opinión será tenida en cuenta.'), 0, 'J');
    
    $pdf->Ln(6);
    
    // Fecha de aplicación
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode('Fecha de aplicación de la Encuesta:'), 0, 1, 'L');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(40, 6, utf8_decode($datos['fecha_aplicacion']), 'B', 0, 'L');
    
    $pdf->Ln(10);
    
    // TABLA 1 - Preguntas SI/NO (ajustada a 190mm)
    // Anchos calculados para 190mm total
    $col1_ancho = 100; // Pregunta
    $col2_ancho = 12;  // SI
    $col3_ancho = 12;  // NO
    $col4_ancho = 66;  // Motivo
    
    // Encabezado tabla 1 (fuente más pequeña)
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(220, 220, 220);
    
    // Fila encabezado
    $pdf->Cell($col1_ancho, 8, utf8_decode('Marque con una X, la casilla que esté'), 1, 0, 'C', true);
    $pdf->Cell($col2_ancho, 8, utf8_decode('SI'), 1, 0, 'C', true);
    $pdf->Cell($col3_ancho, 8, utf8_decode('NO'), 1, 0, 'C', true);
    $pdf->Cell($col4_ancho, 8, utf8_decode('Si la respuesta es NO explique'), 1, 1, 'C', true);
    
    // Segunda fila encabezado
    $pdf->Cell($col1_ancho, 8, utf8_decode('acorde a su respuesta'), 1, 0, 'C', true);
    $pdf->Cell($col2_ancho, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col3_ancho, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col4_ancho, 8, utf8_decode('el motivo'), 1, 1, 'C', true);
    
    // Pregunta 1
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell($col1_ancho, 4, utf8_decode('1. ¿Recibió un trato respetuoso y amable por parte del personal que lo atendió?'), 1, 'L', true);
    $pdf->SetXY(10 + $col1_ancho, $pdf->GetY() - 12); // Ajustar posición
    $pdf->Cell($col2_ancho, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col3_ancho, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col4_ancho, 12, '', 1, 1, 'C', true);
    
    // Pregunta 2
    $pdf->MultiCell($col1_ancho, 4, utf8_decode('2. ¿Le dieron oportunidad de resolver las dudas?'), 1, 'L', true);
    $pdf->SetXY(10 + $col1_ancho, $pdf->GetY() - 8);
    $pdf->Cell($col2_ancho, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col3_ancho, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col4_ancho, 8, '', 1, 1, 'C', true);
    
    // Pregunta 3
    $pdf->MultiCell($col1_ancho, 4, utf8_decode('3. ¿Tuvo alguna dificultad administrativa para la prestación del servicio? Si su respuesta es Si por favor explique el motivo.'), 1, 'L', true);
    $pdf->SetXY(10 + $col1_ancho, $pdf->GetY() - 16);
    $pdf->Cell($col2_ancho, 16, '', 1, 0, 'C', true);
    $pdf->Cell($col3_ancho, 16, '', 1, 0, 'C', true);
    $pdf->Cell($col4_ancho, 16, '', 1, 1, 'C', true);
    
    $pdf->Ln(8);
    
    // TABLA 2 - Pregunta 4 (ajustada a 190mm)
    $col_pregunta = 70;
    $col_opciones = 24; // (190-70)/5 = 24
    
    // Encabezado tabla 2
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(220, 220, 220);
    
    // Fila encabezado pregunta 4
    $pdf->Cell($col_pregunta, 8, utf8_decode('Marque con una X, la casilla que esté'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Definitivamente'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Probablemente'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Probablemente'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Definitivamente'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('No'), 1, 1, 'C', true);
    
    // Segunda fila encabezado
    $pdf->Cell($col_pregunta, 8, utf8_decode('acorde a su respuesta'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('No'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('No'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Si'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('Si'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 8, utf8_decode('informa'), 1, 1, 'C', true);
    
    // Pregunta 4
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell($col_pregunta, 4, utf8_decode('4. ¿Recomendaría a sus familiares y amigos nuestros servicios?'), 1, 'L', true);
    $pdf->SetXY(10 + $col_pregunta, $pdf->GetY() - 12);
    $pdf->Cell($col_opciones, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones, 12, '', 1, 1, 'C', true);
    
    $pdf->Ln(8);
    
    // TABLA 3 - Pregunta 5 (ajustada a 190mm)
    $col_pregunta5 = 80;
    $col_opciones5 = 22; // (190-80)/5 = 22
    
    // Encabezado tabla 3
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(220, 220, 220);
    
    // Fila encabezado pregunta 5
    $pdf->Cell($col_pregunta5, 8, utf8_decode('5. ¿Cómo calificaría su experiencia global'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Muy'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Buena'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Regular'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Mala'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Muy'), 1, 1, 'C', true);
    
    // Segunda fila encabezado
    $pdf->Cell($col_pregunta5, 8, utf8_decode('respecto a los servicios que ha recibido?'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Buena'), 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 8, utf8_decode('Mala'), 1, 1, 'C', true);
    
    // Pregunta 5 (datos)
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell($col_pregunta5, 12, '', 1, 0, 'L', true);
    $pdf->Cell($col_opciones5, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 12, '', 1, 0, 'C', true);
    $pdf->Cell($col_opciones5, 12, '', 1, 1, 'C', true);
    
    $pdf->Ln(10);
    
    // Comentarios adicionales
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode('Desea agregar algún comentario adicional:'), 0, 1, 'L');
    
    // Cuadro para comentarios
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(0, 5, '', 1, 'L');
    $pdf->SetY($pdf->GetY() + 15); // Espacio para comentarios
    
    $pdf->Ln(8);
    
    // Título datos del usuario
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, utf8_decode('DATOS DEL USUARIO ENCUESTADO'), 0, 1, 'C');
    
    $pdf->Ln(4);
    
    // Tabla de datos del usuario (ajustada a 190mm)
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(240, 240, 240);
    
    // Fila 1: Nombres
    $pdf->Cell(45, 8, utf8_decode('NOMBRES Y APELLIDOS:'), 1, 0, 'L', true);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(145, 8, utf8_decode($datos['nombre_paciente']), 1, 1, 'L', true);
    
    // Fila 2: Cédula, Teléfono y Aseguradora
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(40, 8, utf8_decode('NÚMERO DE CÉDULA:'), 1, 0, 'L', true);
    $pdf->Cell(40, 8, utf8_decode('TELÉFONO:'), 1, 0, 'L', true);
    $pdf->Cell(110, 8, utf8_decode('ASEGURADORA:'), 1, 1, 'L', true);
    
    // Datos
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(40, 8, utf8_decode($datos['numero_documento']), 1, 0, 'L', true);
    $pdf->Cell(40, 8, utf8_decode($datos['telefono_paciente']), 1, 0, 'L', true);
    $pdf->Cell(110, 8, utf8_decode($datos['aseguradora']), 1, 1, 'L', true);
    
    // Fila 3: Firma del paciente
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(45, 12, utf8_decode('FIRMA DEL PACIENTE:'), 1, 0, 'L', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(145, 12, '', 1, 1, 'C', true);
    
    $pdf->Ln(8);
    
    // Firma del auxiliar
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(95, 8, utf8_decode('NOMBRE DEL AUXILIAR QUE APLICÓ LA ENCUESTA:'), 1, 0, 'L', true);
    $pdf->Cell(95, 8, utf8_decode('FIRMA:'), 1, 1, 'L', true);
    
    // Datos auxiliar
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(95, 10, utf8_decode($datos['auxiliar_nombre']), 1, 0, 'L', true);
    $pdf->Cell(95, 10, '', 1, 1, 'C', true);
    
    $pdf->Ln(10);
    
    // Código del formulario
    $pdf->SetFont('Arial', 'I', 7);
    $pdf->Cell(0, 5, utf8_decode('MS-GTA-FO-03/V1-2021-febrero'), 0, 1, 'R');
}

// Función alternativa usando SetWidths si tienes esa funcionalidad
function crearTablaEncuesta($pdf, $anchos, $datos, $alineaciones, $alturas = null)
{
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    for($i = 0; $i < count($datos); $i++) {
        $w = $anchos[$i];
        $a = isset($alineaciones[$i]) ? $alineaciones[$i] : 'L';
        $h = isset($alturas[$i]) ? $alturas[$i] : 8;
        
        // Verificar si cabe en la página
        if($x + $w > 200) { // 210 - margen derecho
            $pdf->Ln();
            $x = 10;
            $y = $pdf->GetY();
        }
        
        $pdf->SetXY($x, $y);
        $pdf->Cell($w, $h, utf8_decode($datos[$i]), 1, 0, $a);
        $x += $w;
    }
    
    $pdf->Ln();
    $pdf->SetX(10);
}