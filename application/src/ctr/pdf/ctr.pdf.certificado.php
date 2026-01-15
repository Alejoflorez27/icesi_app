<?php
function certificadoAtencionTransitoPdf($pdf, $id_solicitud, $id_servicio)
{
    // Configuración básica del PDF
    $pdf->AddPage();
    
    // Obtener datos del paciente (ajusta según tu base de datos)
    $paciente = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
    $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
    
    // Aquí deberías obtener los datos específicos del accidente y atención médica
    // Estos son datos de ejemplo que deberás adaptar a tu base de datos
    
    $datos_certificado = array(
        'nombre_paciente' => isset($paciente['data'][0]['nombre']) ? $paciente['data'][0]['nombre'] . ' ' . $paciente['data'][0]['apellido'] : '',
        'tipo_documento' => isset($paciente['data'][0]['tipo_documento']) ? $paciente['data'][0]['tipo_documento'] : '',
        'numero_documento' => isset($paciente['data'][0]['numero_documento']) ? $paciente['data'][0]['numero_documento'] : '',
        'departamento_paciente' => isset($paciente['data'][0]['departamento']) ? $paciente['data'][0]['departamento'] : '',
        'telefono_paciente' => isset($paciente['data'][0]['telefono']) ? $paciente['data'][0]['telefono'] : '',
        // Datos de la institución (ajusta según tu sistema)
        'nombre_institucion' => 'NOMBRE DE LA INSTITUCIÓN',
        'direccion_institucion' => 'DIRECCIÓN DE LA INSTITUCIÓN',
        'ciudad_institucion' => 'CIUDAD',
        'departamento_institucion' => 'DEPARTAMENTO',
        'telefono_institucion' => 'TELÉFONO',
        // Datos del accidente (deberás obtener estos datos de tu sistema)
        'declarado_por' => 'NOMBRE DEL DECLARANTE',
        'documento_declarante' => 'NÚMERO DOCUMENTO',
        'expedido_en' => 'CIUDAD DE EXPEDICIÓN',
        'fecha_accidente' => 'FECHA ACCIDENTE',
        'hora_accidente' => 'HORA ACCIDENTE',
        'fecha_ingreso' => 'FECHA INGRESO',
        'hora_ingreso' => 'HORA INGRESO',
        // Signos vitales
        'ta' => '120/80',
        'fc' => '80',
        'fr' => '16',
        't' => '36.5',
        'estado_conciencia' => 'Alerta', // Alerta, Obnubilado, Estuporoso, Coma
        'glasgow' => '15',
        'datos_positivos' => 'DESCRIPCIÓN DE DATOS POSITIVOS',
        'impresion_diagnostica' => 'IMPRESIÓN DIAGNÓSTICA INICIAL',
        'diagnostico_definitivo' => 'DIAGNÓSTICO DEFINITIVO',
        'nombre_medico' => 'NOMBRE COMPLETO DEL MÉDICO',
        'registro_medico' => 'NÚMERO DE REGISTRO MÉDICO'
    );
    
    // Crear el formulario
    crearFormularioCertificadoTransito($pdf, $datos_certificado);
}

function crearFormularioCertificadoTransito($pdf, $datos)
{
    // Configurar márgenes
    $pdf->SetMargins(15, 15, 15);
    
    // Encabezado - República de Colombia
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('REPÚBLICA DE COLOMBIA'), 0, 1, 'C');
    
    // Ministerio de Salud
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 8, utf8_decode('MINISTERIO DE SALUD'), 0, 1, 'C');
    
    // Título principal del certificado
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, utf8_decode('CERTIFICADO DE ATENCIÓN MÉDICA PARA VÍCTIMAS DE ACCIDENTES DE'), 0, 1, 'C');
    $pdf->Cell(0, 8, utf8_decode('TRÁNSITO EXPEDIDO POR LA INSTITUCIÓN PRESTADORA DE SERVICIOS'), 0, 1, 'C');
    $pdf->Cell(0, 8, utf8_decode('DE SALUD'), 0, 1, 'C');
    
    $pdf->Ln(10);
    
    // Texto introductorio
    $pdf->SetFont('Arial', '', 9);
    $texto_intro = utf8_decode('El suscrito médico del servicio de urgencias de la institución prestadora de servicios de Salud ');
    
    // Nombre de la institución (resaltado)
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['nombre_institucion']), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    
    $pdf->Cell(0, 6, utf8_decode('con domicilio en'), 0, 1, 'C');
    
    // Dirección de la institución (resaltada)
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['direccion_institucion']), 0, 1, 'C');
    
    // Ciudad, Departamento y Teléfono en una línea
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['ciudad_institucion'] . ', ' . $datos['departamento_institucion'] . ' Teléfono: ' . $datos['telefono_institucion']), 0, 1, 'C');
    
    $pdf->Ln(5);
    
    // Texto principal del certificado
    $pdf->SetFont('Arial', '', 9);
    $texto_certifica = utf8_decode('Certifica que atendió en el servicio de urgencias al señor(a)');
    $pdf->MultiCell(0, 6, $texto_certifica, 0, 'C');
    $pdf->Ln(2);
    
    // Datos del paciente
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['nombre_paciente']), 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, utf8_decode('Identificado con ' . $datos['tipo_documento'] . ' No ' . $datos['numero_documento']), 0, 1, 'C');
    
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['departamento_paciente']), 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, utf8_decode('Teléfono: ' . $datos['telefono_paciente']), 0, 1, 'C');
    
    $pdf->Ln(5);
    
    // Información del accidente
    $texto_accidente = utf8_decode('Quien según declaración de ');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode($datos['declarado_por']), 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, utf8_decode('(No ' . $datos['documento_declarante'] . ')'), 0, 1, 'C');
    
    $pdf->Cell(0, 6, utf8_decode('Expedida en ' . $datos['expedido_en']), 0, 1, 'C');
    
    $pdf->Cell(0, 6, utf8_decode('Fue víctima de accidente de tránsito, ocurrido el ' . $datos['fecha_accidente'] . ' a las ' . $datos['hora_accidente'] . ' Hrs,'), 0, 1, 'C');
    
    $pdf->Cell(0, 6, utf8_decode('ingresado al servicio de urgencias de esta institución el ' . $datos['fecha_ingreso'] . ' a las ' . $datos['hora_ingreso'] . ' Hrs,'), 0, 1, 'C');
    
    $pdf->Cell(0, 6, utf8_decode('con los siguientes hallazgos:'), 0, 1, 'C');
    
    $pdf->Ln(5);
    
    // Signos vitales
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode('Signos Vitales:'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, utf8_decode('TA: ' . $datos['ta'] . ' mmHg   FC: ' . $datos['fc'] . ' XMin   FR: ' . $datos['fr'] . ' XMin   T: ' . $datos['t'] . ' °C'), 0, 1, 'L');
    
    $pdf->Ln(3);
    
    // Estado de conciencia
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 6, utf8_decode('Estado de conciencia:'), 0, 1, 'L');
    
    $pdf->SetFont('Arial', '', 9);
    $estado_conciencia = $datos['estado_conciencia'];
    $pdf->Cell(0, 6, utf8_decode('☐ Alerta   ☐ Obnubilado   ☐ Estuporoso   ☐ Coma'), 0, 1, 'L');
    
    // Marcar la opción correspondiente
    $pdf->SetFont('ZapfDingbats', '', 11);
    switch(strtolower($estado_conciencia)) {
        case 'alerta':
            $pdf->SetXY(45, $pdf->GetY() - 6);
            $pdf->Cell(5, 6, '4', 0, 0, 'L');
            break;
        case 'obnubilado':
            $pdf->SetXY(70, $pdf->GetY() - 6);
            $pdf->Cell(5, 6, '4', 0, 0, 'L');
            break;
        case 'estuporoso':
            $pdf->SetXY(105, $pdf->GetY() - 6);
            $pdf->Cell(5, 6, '4', 0, 0, 'L');
            break;
        case 'coma':
            $pdf->SetXY(135, $pdf->GetY() - 6);
            $pdf->Cell(5, 6, '4', 0, 0, 'L');
            break;
    }
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode('Glasgow: ' . $datos['glasgow']), 0, 1, 'L');
    
    $pdf->Ln(3);
    
    // Datos positivos
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, utf8_decode('DATOS POSITIVOS'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, utf8_decode($datos['datos_positivos']), 0, 'L');
    
    $pdf->Ln(3);
    
    // Impresión diagnóstica
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, utf8_decode('Impresión diagnóstica:'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, utf8_decode($datos['impresion_diagnostica']), 0, 'L');
    
    $pdf->Ln(3);
    
    // Diagnóstico definitivo
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, utf8_decode('Diagnóstico definitivo:'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, utf8_decode($datos['diagnostico_definitivo']), 0, 'L');
    
    $pdf->Ln(15);
    
    // Firma y datos del médico
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode('Nombres y apellidos del Médico:'), 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, utf8_decode($datos['nombre_medico']), 0, 1, 'L');
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, utf8_decode('Registro médico N°: ' . $datos['registro_medico']), 0, 1, 'L');
    
    $pdf->Ln(15);
    
    // Espacio para firma y sello
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 6, utf8_decode('Firma y sello'), 0, 1, 'C');
    
    // Línea para firma
    $pdf->SetLineWidth(0.5);
    $pdf->Line(($pdf->GetPageWidth()/2) - 50, $pdf->GetY(), ($pdf->GetPageWidth()/2) + 50, $pdf->GetY());
    
    $pdf->Ln(5);
}