<?php
function historiaClinicaPdf($pdf, $id_solicitud, $id_servicio)
{
    // Configuración básica del PDF
    $pdf->AddPage();
    
    // Obtener datos del paciente (debes adaptar estas consultas a tu base de datos)
    $paciente = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    
    // Datos del paciente (ejemplo - ajusta según tus tablas)
    $datos_paciente = array(
        'nombre' => isset($paciente['data'][0]['nombre']) ? $paciente['data'][0]['nombre'] : '',
        'documento' => isset($paciente['data'][0]['numero_documento']) ? $paciente['data'][0]['numero_documento'] : '',
        'direccion' => isset($paciente['data'][0]['direccion']) ? $paciente['data'][0]['direccion'] : '',
        'ciudad' => isset($paciente['data'][0]['ciudad']) ? $paciente['data'][0]['ciudad'] : '',
        'aseguradora' => isset($paciente['data'][0]['aseguradora']) ? $paciente['data'][0]['aseguradora'] : '',
        'fecha_nacimiento' => isset($paciente['data'][0]['fecha_nacimiento']) ? $paciente['data'][0]['fecha_nacimiento'] : '',
        'tipo_documento' => isset($paciente['data'][0]['tipo_documento']) ? $paciente['data'][0]['tipo_documento'] : ''
    );
    
    // Si necesitas más datos específicos, agrega más consultas aquí
    
    // Crear el formulario de historia clínica
    crearFormularioHistoriaClinica($pdf, $datos_paciente);
}

function crearFormularioHistoriaClinica($pdf, $datos)
{
    // Configurar fuente
    $pdf->SetFont('Arial', '', 10);
    
    // Cabecera de la empresa
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, 'EDSALUD SAS NIT 900432920-1', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'CALLE 20 M. 14 - 52 BARRIO GAITAN, CEL: 3226811175', 0, 1, 'C');
    $pdf->Cell(0, 5, 'edsaludsas@hotmail.com', 0, 1, 'C');
    
    // Línea separadora
    $pdf->Ln(2);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(2);
    
    // Código y título
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'CODIGO HC - F 01', 0, 1, 'R');
    
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(95, 8, 'HISTORIA CLINICA', 0, 0, 'L');
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(95, 8, 'FECHA: __________', 0, 1, 'R');
    
    // Línea gruesa
    $pdf->Ln(3);
    $pdf->SetLineWidth(1);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(5);
    
    // Sección 1: Datos del Paciente
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'DATOS DEL PACIENTE', 0, 1, 'L');
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 10);
    // Nombre
    $pdf->Cell(25, 6, 'Nombre:', 0, 0, 'L');
    $pdf->Cell(70, 6, ($datos['nombre'] != '' ? $datos['nombre'] : '___________________________'), 0, 0, 'L');
    
    // Tipo de Documento
    $pdf->Cell(45, 6, 'Tipo de Documento:', 0, 0, 'L');
    $pdf->Cell(45, 6, ($datos['tipo_documento'] != '' ? $datos['tipo_documento'] : '________________'), 0, 1, 'L');
    
    // Dirección
    $pdf->Cell(25, 6, 'Direccion:', 0, 0, 'L');
    $pdf->Cell(70, 6, ($datos['direccion'] != '' ? $datos['direccion'] : '___________________________'), 0, 0, 'L');
    
    // Ciudad
    $pdf->Cell(25, 6, 'Ciudad:', 0, 0, 'L');
    $pdf->Cell(45, 6, ($datos['ciudad'] != '' ? $datos['ciudad'] : '________________'), 0, 1, 'L');
    
    // Aseguradora
    $pdf->Cell(50, 6, 'Aseguradora del paciente:', 0, 0, 'L');
    $pdf->Cell(100, 6, ($datos['aseguradora'] != '' ? $datos['aseguradora'] : '___________________________'), 0, 1, 'L');
    $pdf->Ln(8);
    
    // Fecha de Nacimiento
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(60, 8, 'Fecha de Nacimiento', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    
    // Parsear fecha si existe
    $dia = $mes = $ano = '______';
    if ($datos['fecha_nacimiento'] != '') {
        $fecha = date_create($datos['fecha_nacimiento']);
        if ($fecha) {
            $dia = date_format($fecha, 'd');
            $mes = date_format($fecha, 'm');
            $ano = date_format($fecha, 'Y');
        }
    }
    
    $pdf->Cell(50, 8, 'Dia: ' . $dia, 0, 0, 'L');
    $pdf->Cell(50, 8, 'Mes: ' . $mes, 0, 0, 'L');
    $pdf->Cell(0, 8, 'Ano: ' . $ano, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Sección 2: Datos del PACIENTE (repetición como en el formulario)
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Datos del PACIENTE', 0, 1, 'L');
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 10);
    // Repetir los mismos datos
    $pdf->Cell(25, 6, 'Nombre:', 0, 0, 'L');
    $pdf->Cell(70, 6, ($datos['nombre'] != '' ? $datos['nombre'] : '___________________________'), 0, 0, 'L');
    
    $pdf->Cell(45, 6, 'Tipo de Documento:', 0, 0, 'L');
    $pdf->Cell(45, 6, ($datos['tipo_documento'] != '' ? $datos['tipo_documento'] : '________________'), 0, 1, 'L');
    
    $pdf->Cell(25, 6, 'Direccion:', 0, 0, 'L');
    $pdf->Cell(70, 6, ($datos['direccion'] != '' ? $datos['direccion'] : '___________________________'), 0, 0, 'L');
    
    $pdf->Cell(25, 6, 'Ciudad:', 0, 0, 'L');
    $pdf->Cell(45, 6, ($datos['ciudad'] != '' ? $datos['ciudad'] : '________________'), 0, 1, 'L');
    
    $pdf->Cell(50, 6, 'Aseguradora del paciente:', 0, 0, 'L');
    $pdf->Cell(100, 6, ($datos['aseguradora'] != '' ? $datos['aseguradora'] : '___________________________'), 0, 1, 'L');
    $pdf->Ln(8);
    
    // Fecha de Nacimiento (repetición)
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(60, 8, 'Fecha de Nacimiento', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 8, 'Dia: ' . $dia, 0, 0, 'L');
    $pdf->Cell(50, 8, 'Mes: ' . $mes, 0, 0, 'L');
    $pdf->Cell(0, 8, 'Ano: ' . $ano, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Sección 3: Causa que origina la atención
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 5, 'Causa que origina la atencion', 0, 1, 'L');
    $pdf->Ln(3);
    
    // Tabla de causas
    $pdf->SetFont('Arial', 'B', 9);
    $header = array('Conductor', 'Ocupante', 'Placa Vehiculo', 'Cinematica:');
    $widths = array(30, 30, 40, 90);
    
    // Crear tabla
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    for($i = 0; $i < count($header); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths[$i], 8, $header[$i], 1, 0, 'C', true);
        $x += $widths[$i];
    }
    $pdf->Ln(8);
    
    // Fila de datos
    $x = 10;
    $y = $pdf->GetY();
    $data = array('Peaton', 'Ciclista', '', '');
    for($i = 0; $i < count($data); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths[$i], 8, $data[$i], 1, 0, 'C');
        $x += $widths[$i];
    }
    $pdf->Ln(10);
    
    // Sección 4: Antecedentes personales
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Antecedentes personales', 0, 1, 'L');
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 10);
    $campos = array('Alergias', 'Medicamentos', 'Cx. Recientes', 'Antecedentes de Enfermedades', 'Origen clinico');
    
    foreach($campos as $campo) {
        $pdf->Cell(($campo == 'Antecedentes de Enfermedades' ? 70 : 35), 6, $campo . ':', 0, 0, 'L');
        $pdf->Cell(($campo == 'Antecedentes de Enfermedades' ? 80 : 100), 6, '___________________________', 0, 1, 'L');
        $pdf->Ln(($campo == 'Origen clinico' ? 8 : 2));
    }
    
// Sección 5: SIGNOS VITALES
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 8, 'SIGNOS VITALES:', 0, 1, 'L');
$pdf->Ln(3);

// Usando tu patrón de tablas
$widths_signos = array(20, 20, 20, 20, 20, 30, 30, 30);
$pdf->SetWidths($widths_signos);
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));

// Cabecera
$pdf->SetFillColor(174, 214, 241);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Row(array(
    utf8_decode('HORA'),
    utf8_decode('T.A.'),
    utf8_decode('F.C.'),
    utf8_decode('F.R.'),
    utf8_decode('S.02'),
    utf8_decode('GLUCOMETRÍA'),
    utf8_decode('TEMPERATURA'),
    utf8_decode('GLASCOW')
));

// Si tienes datos en BD, consulta aquí
// $signos_data = CtrHistoriaClinica::getSignosVitales($id_solicitud);

// Ejemplo con datos vacíos (3 filas)
for ($i = 0; $i < 3; $i++) {
    $pdf->SetFillColor(207, 207, 207);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Row(array('', '', '', '', '', '', '', ''));
}

$pdf->Ln(5);
    
    // Sección 6: Descripción de hallazgos
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Descripcion de hallazgos:', 0, 1, 'L');
    $pdf->Ln(3);
    
    // Cuadros para descripción
    $pdf->SetFont('Arial', '', 10);
    for($i = 0; $i < 2; $i++) {
        $pdf->MultiCell(0, 20, '', 1, 'L');
        $pdf->Ln(($i == 0 ? 5 : 0));
    }
    $pdf->Ln(8);
    
    // Sección 7: Clasificación final
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Clasificacion final:', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 8, 'Urgencia', 0, 0, 'L');
    $pdf->Cell(15, 8, '__________', 0, 0, 'L');
    $pdf->Cell(45, 8, 'TIPO DE TRASLADO:', 0, 0, 'L');
    $pdf->Cell(30, 8, '__________', 0, 0, 'L');
    $pdf->Cell(30, 8, 'CODIGO CUPS:', 0, 0, 'L');
    $pdf->Cell(0, 8, '__________', 0, 1, 'L');
    $pdf->Ln(8);
    
    // Sección 8: Procedimientos realizados
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Procedimientos realizados:', 0, 1, 'L');
    $pdf->Ln(3);
    
    // Primera fila de procedimientos
    $pdf->SetFont('Arial', '', 9);
    $proc1 = array('Monitoreo', 'Oxigenacion', 'Aspiracion', 'Intubacion', 'RCP', 'Hemostatica', 'Vendaje', 'Sutura');
    $widths_proc = array(25, 25, 25, 25, 20, 25, 20, 20);
    
    $x = 10;
    $y = $pdf->GetY();
    
    for($i = 0; $i < count($proc1); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths_proc[$i], 6, $proc1[$i], 0, 0, 'C');
        $x += $widths_proc[$i];
    }
    $pdf->Ln(6);
    
    // Líneas para checkboxes primera fila
    $x = 10;
    $y = $pdf->GetY();
    for($i = 0; $i < count($proc1); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths_proc[$i], 4, '___', 0, 0, 'C');
        $x += $widths_proc[$i];
    }
    $pdf->Ln(8);
    
    // Segunda fila de procedimientos
    $proc2 = array('Inmovilizacion', 'Asepsia', 'Collar Cervical', 'Liquido', 'Medicamento', 'Otros');
    $widths_proc2 = array(30, 25, 30, 20, 30, 20);
    
    $x = 10;
    $y = $pdf->GetY();
    
    for($i = 0; $i < count($proc2); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths_proc2[$i], 6, $proc2[$i], 0, 0, 'C');
        $x += $widths_proc2[$i];
    }
    $pdf->Ln(6);
    
    // Líneas para checkboxes segunda fila
    $x = 10;
    $y = $pdf->GetY();
    for($i = 0; $i < count($proc2); $i++) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($widths_proc2[$i], 4, '___', 0, 0, 'C');
        $x += $widths_proc2[$i];
    }
    $pdf->Ln(12);
    
    // Sección 9: Traslado a
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'Traslado a:', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 8, 'Casa', 0, 0, 'L');
    $pdf->Cell(10, 8, '___', 0, 0, 'C');
    $pdf->Cell(50, 8, 'Institucion de Salud', 0, 0, 'L');
    $pdf->Cell(10, 8, '___', 0, 0, 'C');
    $pdf->Cell(40, 8, 'HORA DEL SINIESTRO', 0, 0, 'L');
    $pdf->Cell(15, 8, '______', 0, 0, 'C');
    $pdf->Cell(30, 8, 'HORA INICIAL', 0, 0, 'L');
    $pdf->Cell(15, 8, '______', 0, 0, 'C');
    $pdf->Cell(0, 8, 'HORA FINAL', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->Cell(0, 8, '______', 0, 1, 'L');
    $pdf->Ln(5);
    
    // Nombre y/o Dirección
    $pdf->Cell(60, 8, 'NOMBRE Y/O DIRECCION:', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________________________________', 0, 1, 'L');
    $pdf->Ln(5);
    
    // NIT
    $pdf->Cell(15, 8, 'NIT:', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(8);
    
    // Sección 10: Estado del paciente
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, 'ESTADO DEL PACIENTE AL MOMENTO DE ENTREGA EN LA IPS:', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'CONSCIENTE REPS:', 0, 0, 'L');
    $pdf->Cell(10, 8, 'SI', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Cell(10, 8, 'NO', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Cell(30, 8, 'MUERTO', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Ln(12);
    
    // Sección 11: Autorización de traslado
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Dejo constancia que en mis facultades autorizo mi traslado en el sistema de Emergencia', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->Cell(50, 8, 'Paciente o Familiar', 0, 0, 'L');
    $pdf->Ln(8);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 8, 'Firma y C.C.', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->Cell(30, 8, 'Nombre:', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(10);
    
    // Sección 12: Personal médico
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 8, 'Conductor:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, '___________________________', 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 8, 'Paramedico:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(10);
    
    // Sección 13: Declaración de no negativa
    $pdf->SetFont('Arial', 'I', 9);
    $declaracion = '"No niego a recibir la atencion medica, traslado o intermedio negativo por el Sistema de Emergencia Medica, eximo de toda responsabilidad a la empresa de Transporte de Urgencias Medicas de las consecuencias que acarree el decide, asumiendo los riesgos que mi salud pueda generar"';
    $pdf->MultiCell(0, 5, $declaracion, 0, 'J');
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 8, 'Firma y C.C.', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(3);
    
    $pdf->Cell(30, 8, 'Nombre:', 0, 0, 'L');
    $pdf->Cell(0, 8, '___________________________', 0, 1, 'L');
    $pdf->Ln(10);
    
    // Sección 14: Repetición de CONSCIENTE REPS
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'CONSCIENTE REPS:', 0, 0, 'L');
    $pdf->Cell(10, 8, 'SI', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Cell(10, 8, 'NO', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Cell(30, 8, 'MUERTO', 0, 0, 'L');
    $pdf->Cell(5, 8, '___', 0, 0, 'C');
    $pdf->Ln(15);
    
    // Sección 15: Identificación del personal
    $pdf->SetFont('Arial', 'I', 9);
    $identificacion = 'Identifico con CC: _______________ a los profesionales de salud, conductores y personal paramedico asistencial de la empresa ED SALUD SAS de Girardot para realizar el procedimiento asistencial basico y todos los procedimientos durante la atencion pre hospitalaria. Soy conocedor del estado de salud del paciente y de las posibles complicaciones que se pueden presentar durante el traslado, lo cual el personal facultado de la institucion me informaron oportunamente y exonero de responsabilidad.';
    $pdf->MultiCell(0, 5, $identificacion, 0, 'J');
    $pdf->Ln(8);
    
    // Firmas finales
    $pdf->SetFont('Arial', '', 10);
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    $pdf->SetXY($x, $y);
    $pdf->Cell(60, 8, 'Firma', 0, 0, 'C');
    $pdf->Cell(60, 8, '', 0, 0, 'C');
    $pdf->Cell(60, 8, 'MOVIL', 0, 1, 'C');
    
    $pdf->SetXY($x, $y + 20);
    $pdf->Cell(60, 8, '___________________________', 0, 0, 'C');
    $pdf->Cell(60, 8, '', 0, 0, 'C');
    $pdf->Cell(60, 8, '___________________________', 0, 1, 'C');
}

// Cómo usar la función:
// $pdf = new FPDF();
// historiaClinicaPdf($pdf, $id_solicitud, $id_servicio);
// $pdf->Output();
?>