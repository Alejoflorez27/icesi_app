<?php

function infVisMantenimiento($pdf, $id_solicitud, $id_servicio)
{
    if (isset($id_solicitud) && $id_solicitud != "" && $id_solicitud != null) {
        $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);



        //Siguiente pagina
        //$pdf->AddPage();
        $pdf->Ln(5);


        $familia = CtrSolFamiliar::descripcionFamiliar($id_solicitud);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('I. DIMENSIÓN FAMILIAR'), 0, 0, 'C', 1);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. PERSONAS CON QUIENES VIVE ACTUALMENTE EL FUNCIONARIO'), 0, 0, 'L', 0);
        $pdf->Ln(6);
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
            $pdf->Cell(70, 5, utf8_decode($row['nombre']) . ' ' . utf8_decode($row['apellido']. ' - ID ' .utf8_decode($row['identificacion'])), 1, 0, 'L', 0);
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
            $pdf->Cell(0, 5, utf8_decode(ucfirst(strtolower($row['empresa']))), 1, 1, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 5, utf8_decode("Ocupación"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(0, 5, utf8_decode($row['ocupacion']), 1, 0, 'L', 0);
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(25, 5, utf8_decode("Escolaridad"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_niv_escol']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(33, 5, utf8_decode("Vive con el Funcionario"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(37, 5, utf8_decode($row['descripcion_viv_candidato']), 1, 0, 'L', 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(35, 5, utf8_decode("Depende del Funcionario"), 1, 0, 'L', 1);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(30, 5, utf8_decode($row['descripcion_depende_candidato']), 1, 0, 'L', 0);

            $pdf->Ln(5);
        }

        $obsFamilia = CtrObservaciones::observacionById($id_solicitud, $id_servicio, 'obs_familia');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('2. OBSERVACION GENERAL'), 0, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(3);
        $pdf->MultiCell(190, 5, $obsFamilia['data']['observacion'], 0, 'J', 0);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN FAMILIAR'), 0, 0, 'C', 0);
        $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 1, $id_servicio);

        /*$pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);*/
        $pdf->Ln(5);

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
/*
        $pdf->Ln(8);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('II. DIMENSIÓN SOCIAL Y HABITACIONAL'), 0, 0, 'C', 1);
*/
        //IMPRESION DE LAS FOTOS DE CARACTERISTICAS de VIVIENDA
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
                $imagenes_posibles[] = [$ruta, 'FOTO FUNCIONARIO Y SU FAMILIA'];
                break;
            case 'FOTO DEL CANDIDATO CON LA PROFESIONAL DE VISITAS':
                $imagenes_posibles[] = [$ruta, 'FOTO DEL FUNCIONARIO CON EL PROFESIONAL DE VISITAS'];
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

// Paso 1: Arreglo temporal con posibles imágenes
/*$imagenes_posibles = [
    [$fotoInteriorViv, 'FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)'],
    [$fotoFachada, 'FOTO FACHADA'],
    [$fotoNomenclatura, 'FOTO DE NOMENCLATURA'],
    [$fotoExteriorViv, 'FOTO EXTERIOR DE LA VIVIENDA'],

];*/

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

/*        // FOTO CANDIDATO
        $pdf->Ln(15);
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoInteriorViv;
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
        $pdf->Cell(80, 5, utf8_decode("FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)"), 0, 0, 'C', 0);

        // FOTO CANDIDATO y profesional
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        $filename = $fotoFachada;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }

        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO FACHADA"), 0, 0, 'C', 0);

        $pdf->Ln(10);
        $pdf->SetX(23);
        $getX = $pdf->GetX() + 1;
        // FOTO de la torre
        $pdf->SetX(23);
        $getY = $pdf->GetY() + 1;
        $getX = $pdf->GetX() + 1;
        $filename = $fotoNomenclatura;
        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        } //FIN

        $pdf->SetXY(23, $getY + 67);
        //  $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO DE NOMENCLATURA"), 0, 0, 'C', 0);

        // FOTO entrada del apto.
        $getY = $pdf->GetY();
        $pdf->SetXY(108, $getY - 68);
        $getX = $pdf->GetX() + 1;
        //ZONA SOCIAL
        $filename = $fotoExteriorViv;

        if ($filename != NULL) {
            $pdf->SetFillColor(000, 000, 000);
            $pdf->Cell(82, 67, '', 1, 0, '', 1);
            $getY = $pdf->GetY() + 1;
            $pdf->Image($filename, $getX, $getY, 80, 65);
        }
        $pdf->SetXY(108, $getY + 67);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(80, 5, utf8_decode("FOTO EXTERIOR DE LA VIVIENDA"), 0, 0, 'C', 0);

        $pdf->Ln(15);
*/
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. ASPECTOS HABITACIONALES DEL FUNCIONARIO Y SU FAMILIA'), 0, 0, 'L', 0);
        $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
        //print_r($carViv);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->Ln(8);
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
        $pdf->SetX(10);

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
        $disEspacios = CtrVivDistribuciones::findAll($id_solicitud, $id_servicio);

        $pdf->Ln(2);
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
        $pdf->Ln(5 + $varNewX);

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
        $pdf->Cell(12, 5, "Sector:", 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(40, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tipo_sector']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(13, 5, utf8_decode('Estrato:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(5, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['estracto']))), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(17, 5, utf8_decode('Ubicación:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_ubicacion_sector']))), 1, 1, 'L', 0);

        // $pdf->Ln(5);
        //$pdf->SetX(10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(58, 5, utf8_decode('Tiempo de desplazamiento al lugar del trabajo:'), 1, 0, 'L', 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tmp_ida_trabajo']))), 1, 2, 'L', 0);
        $pdf->SetX(10);

        $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(30,5,utf8_decode("Aclaraciones del estado de la vivienda :"),1,0,'L',1);
        $pdf->SetWidths(array(58, 132));
        $pdf->SetAligns(array('L'));
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Tiempo en la actual vivienda: '), (utf8_decode($sector['data'][0]['tmp_en_vivienda']))));
        //$pdf->Cell(52,5,utf8_decode('Tiempo en la actual vivienda: '),1,0,'L',1);
        //$pdf->SetFont('Arial','',8);
        //$pdf->MultiCell(0,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['tmp_en_vivienda']))),1,'L',0);
        // $varXD = $pdf->GetX();
        //$varYD = $pdf->GetY();

        //$pdf->SetXY(10,$varYA);
        //$pdf->SetFont('Arial','B',8);
        //$pdf->Cell(52,5,utf8_decode('Tiempo en la actual vivienda: '),0,0,'L',0);

        // $pdf->SetXY(10,$varYD);
        // $pdf->SetFont('Arial','',8);
        //  $varXA = $pdf->GetX();
        //  $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Puntos de Referencia:     '), (utf8_decode($sector['data'][0]['zonas_verdes']))));

        //   $varXD = $pdf->GetX();
        //   $varYD = $pdf->GetY();
        //   $pdf->SetXY(10,$varYA);
        //   $pdf->SetFont('Arial','B',8);
        //   $pdf->Row(52,5,utf8_decode("Disponibilidad de zonas verdes:    "),0,0,'L',0);
        //$pdf->SetFont('Arial','',8);
        //$pdf->MultiCell(0,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['zonas_verdes']))),1,'L',0);

        // $pdf->SetFont('Arial','',9);
        // $pdf->SetWidths(array(52,138));
        // $pdf->SetAligns(array('L'));
        //$contador=0;
        //  $pdf->SetXY(10,$varYD);
        //  $pdf->SetFont('Arial','',8);
        //  $varXA = $pdf->GetX();
        //  $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode("Principales vías de acceso:     "), (utf8_decode($sector['data'][0]['vias_principales']))));

        //  $varXD = $pdf->GetX();
        //  $varYD = $pdf->GetY();
        //  $pdf->SetXY(10,$varYA);
        //  $pdf->SetFont('Arial','B',8);
        //  $pdf->Cell(52,5,utf8_decode("Principales vías de acceso:    "),0,0,'L',0);
        // $pdf->SetFont('Arial','',8);
        // $pdf->Row(array(utf8_decode($sector['data'][0]['vias_principales'])));
        /*     $pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY(); */
        $pdf->Row(array(utf8_decode("Estado de calles y vías de acceso:   "), (utf8_decode($sector['data'][0]['estado_sector']))));

        /*    $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();
            $pdf->SetXY(10,$varYA);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(52,5,utf8_decode("Estado de calles y vías de acceso:  "),0,0,'L',0); */
        // $pdf->SetFont('Arial','',8);
        // $pdf->Row(array(utf8_decode($sector['data'][0]['estado_sector'])));

        /*   $pdf->SetXY(10,$varYD);
           $pdf->SetFont('Arial','',8);
           $varXA = $pdf->GetX();
           $varYA = $pdf->GetY(); */
        $pdf->Row(array(utf8_decode("Concepto del vecino:   "), (utf8_decode($sector['data'][0]['concepto_vecino']))));

        /*   $varXD = $pdf->GetX();
           $varYD = $pdf->GetY();
           $pdf->SetXY(10,$varYA);
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(52,5,utf8_decode("Concepto del vecino:   "),0,0,'L',0); */
        // $pdf->SetFont('Arial','',8);
        // $pdf->Row(array(utf8_decode($sector['data'][0]['concepto_vecino'])));
        //   $pdf->SetXY(10,$varYD);
        //   $pdf->SetFont('Arial','',8);
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode("Medios de transporte:"), 1, 1, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(0);

        $transporte = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_transporte', $id_solicitud, $id_servicio);
        // print_r($aspectFisico);
        $i = 0;
        foreach ($transporte['data'] as $row) {
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
        $pdf->Cell(0, 5, utf8_decode("Servicios en el entorno habitacional:"), 1, 1, 'L', 1);
        $pdf->SetX(10);
        $pdf->Ln(0);

        $sectorServicio = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'], 'tipo_aspecto_sector_servicio', $id_solicitud, $id_servicio);
        $i = 0;
        foreach ($sectorServicio['data'] as $row) {
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

        $pdf->Ln(6);
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
                utf8_decode(ucfirst(strtolower($row['motivo_cambio']))),
            ));
        }



        $pdf->SetFillColor(174, 214, 241);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIAL Y HABITACIONAL'), 0, 0, 'C', 0);
        $pdf->Ln(8);
/*
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
        $pdf->Ln(5);
*/
        $dimSocial = CtrDimRespuestas::descripcionDimension($id_solicitud, 2, $id_servicio);
        $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
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
        $pdf->Ln(4);
        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('III. DIMENSIÓN SOCIOECONÓMICA'), 0, 0, 'C', 1);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 5, utf8_decode('1. ANÁLISIS SOCIOECONÓMICO DEL FUNCIONARIO Y SU FAMILIA'), 0, 0, 'L', 0);

        $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
        //print_r($carViv);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('A. INGRESOS Y EGRESOS DEL FUNCIONARIO (ESPOSA O PAREJA DE CONVIVENCIA)'), 0, 0, 'L', 0);

        $pdf->Ln(6);
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(95, 5, utf8_decode("Ingresos Mensuales del funcionario (esposa o pareja de convivencia)"), 1, 0, 'C', '1');
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(95, 5, utf8_decode("Egresos Mensuales familiares del funcionario (esposa o pareja de convivencia)"), 1, 1, 'C', 1);

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
        $concepto = '';
        foreach ($egresos['data'] as $row) {
            if ($row['descripcion_tipo_concepto'] == 'Otros Cuales?') {
                $concepto = $row['otros'];
            }else {
                $concepto = $row['descripcion_tipo_concepto'];
            }
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode($concepto),
                utf8_decode('$ ' . number_format($row['valor_egreso'])),
                utf8_decode($row['descripcion_tipo_integrante'])
            ));

            $varYDR = $pdf->GetY();
            $pdf->SetXY($varXA + 95, $varYDR);

            //print_r($row['periocidad']);

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

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(190, 5, utf8_decode('B. PASIVO Y PATRIMONIO DEL FUNCIONARIO (ESPOSA O PAREJA DE CONVIVENCIA)'), 0, 1, 'L', 0);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 5, utf8_decode("Pasivos del funcionario (esposa o pareja de convivencia)"), 1, 1, 'C', '1');
        $pdf->Ln(1);
        $pdf->Cell(21, 5, utf8_decode("Concepto"), 1, 0, 'C', 1);
        $pdf->Cell(18, 5, utf8_decode("Otros"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Responsable"), 1, 0, 'C', 1);
        $pdf->Cell(23, 5, utf8_decode("Otro Responsable"), 1, 0, 'C', 1);
        $pdf->Cell(18, 5, utf8_decode("Valor pasivo"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Plazo pasivo"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Cuota Mensual"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Estado de la Obligación"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor de Mora"), 1, 1, 'C', 1);

        $pdf->SetWidths(array(21, 18, 20, 23, 18, 20, 20, 30, 20));
        $pdf->SetAligns(array('L', 'L', 'L', 'L', 'C', 'L', 'L', 'L', 'C'));


        $pasivos = CtrVivPasivos::findAllFuncionario($id_solicitud, $id_servicio);
        $totalPas = 0;
        $totalAct = 0;

        foreach ($pasivos['data'] as $row) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['descripcion_tipo_pasivo']))),
                utf8_decode(' '),
                utf8_decode($row['descripcion_tipo_responsable']),
                utf8_decode(' '),
                utf8_decode('$ ' . number_format($row['valor_pasivo'])),
                utf8_decode($row['descripcion_tipo_plazo']),
                utf8_decode('$ ' .$row['couta']),
                utf8_decode($row['descripcion_tipo_estado_obigacion']),
                utf8_decode('$ '.$row['valor_mora'])
            ));

            //$varYDR = $pdf->GetY();
            //$pdf->SetXY($varXA+95,$varYDR);  

            $totalPas = $totalPas + $row['valor_pasivo'];
        }


        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 5, utf8_decode("Activos del funcionario (esposa o pareja de convivencia)"), 1, 1, 'C', '1');
        $pdf->Ln(1);
        $pdf->Cell(30, 5, utf8_decode("Tipo de Activo"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Otro"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Propietario"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Otro Propietario"), 1, 0, 'C', 1);
        $pdf->Cell(30, 5, utf8_decode("Descripcion General"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor Activo"), 1, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode("Valor Catastral"), 1, 1, 'C', 1);


        $pdf->SetWidths(array(30, 30, 30, 30, 30, 20, 20));
        $pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'C', 'C'));


        $activos = CtrVivActivos::findAllFuncionario($id_solicitud, $id_servicio);

        foreach ($activos['data'] as $row) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Row(array(
                utf8_decode(ucfirst(strtolower($row['descripcion_tipo_activo']))),
                utf8_decode(' '),
                utf8_decode($row['descripcion_tipo_responsable']),
                utf8_decode(' '),
                utf8_decode($row['descripcion_general_viv']),
                utf8_decode('$ ' . number_format($row['valor_activo'])),
                utf8_decode('$ ')
            ));

            $totalAct = $totalAct + $row['valor_activo'];
        }

        $totalPat = $totalAct - $totalPas;

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(125, 206, 160);
        $pdf->Cell(39, 5, utf8_decode("Total pasivos funcionario"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalPas)), 1, 0, 'C', 0);
        //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
        $pdf->Cell(39, 5, utf8_decode("Total activos funcionario"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalAct)), 1, 0, 'C', 0);

        $pdf->Cell(37, 5, utf8_decode("Patrimonio funcionario"), 1, 0, 'C', 1);
        $pdf->Cell(25, 5, utf8_decode('$ ' . number_format($totalPat)), 1, 1, 'C', 0);

        $salario = CtrSolCandidato::findById_candidato_vistas($id_solicitud);
        //print_r($salario['data'][0]['salario_actual']);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(125, 206, 160);
        $salario_anterior = (float) $salario['data'][0]['salario_anterior'];
        $salario_actual = (float) $salario['data'][0]['salario_actual'];

        $pdf->Cell(55, 5, utf8_decode("Salario Anterior"), 1, 0, 'C', 1);
        $pdf->Cell(40, 5, utf8_decode('$ ' . number_format($salario_anterior, 0, ',', '.')), 1, 0, 'C', 0);

        $pdf->Cell(55, 5, utf8_decode("Salario Actual"), 1, 0, 'C', 1);
        $pdf->Cell(40, 5, utf8_decode('$ ' . number_format($salario_actual, 0, ',', '.')), 1, 0, 'C', 0);






        $pdf->Ln(9);
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
                utf8_decode($row['descripcion_tipo_financiero']),
                utf8_decode(ucfirst(strtolower($row['estado']))),
                utf8_decode(ucfirst(strtolower($row['descripcion_financiero'])))
            ));

            //$varYDR = $pdf->GetY();
            //$pdf->SetXY($varXA+95,$varYDR);  

            $totalAct = $totalAct + $row['valor_activo'];
        }

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->Cell(190, 5, utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIOECONÓMICA'), 0, 0, 'C', 0);
        $pdf->Ln(8);
/*
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);
        $pdf->Ln(5);
*/
        $dimEconomia = CtrDimRespuestas::descripcionDimension($id_solicitud, 3, $id_servicio);
         $pdf->SetWidths(array(60, 130));
        $pdf->SetAligns(array('L', 'L'));
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
        $pdf->Ln(8);

        $pdf->SetFillColor(207, 207, 207);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('IV. DIMENSIÓN SALUD DEL FUNCIONARIO Y SU FAMILIA'), 0, 0, 'C', 1);
        $pdf->Ln(6);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("VARIABLE ANALIZADA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("NIVEL DE RIESGO"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("INFORME POR VARIABLE"), 1, 0, 'C', 1);

        // $pdf->SetFont('Arial','B',8);
        // $pdf->Cell(40,5,utf8_decode("PREGUNTAS"),1,0,'C',1);

        $pdf->Ln(5);
/*
        $dimPregSalud = CtrDimRespuestas::descripcionDimension($id_solicitud, 4, $id_servicio);


        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        foreach ($dimPregSalud['data'] as $row) {
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetWidths(array(50, 35, 105));
            $pdf->SetAligns(array('L', 'C', 'L'));


            $id_pregunta = $row['id_pregunta'];
            $dimResp = CtrDimVarRespuestaSalud::consultaVariableSalud($id_solicitud, $id_pregunta);
            $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($dimResp['data']['descripcion_riesgo']), utf8_decode($dimResp['data']['respuesta'])));

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
        }
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
        //  $pdf->Ln(8);




        $pdf->Ln(5);

        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('V. DIMENSIÓN ACTITUD Y COMPROMISO DEL FUNCIONARIO CON EL PROCESO'), 0, 0, 'C', 1);
        $pdf->Ln(6);

        $pdf->SetFillColor(207, 207, 207);
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
        $pdf->Ln(4);

        // $pdf->Ln(5);


        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('VI. PROTOCOLO DE SEGURIDAD / ASPECTO CRÍTICOS DE RIESGO'), 0, 0, 'C', 1);
        $pdf->Ln(6);

        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(50, 5, utf8_decode("ASPECTO DE RIESGO "), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(35, 5, utf8_decode("RESPUESTA"), 1, 0, 'C', 1);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(105, 5, utf8_decode("OBSERVACIONES"), 1, 0, 'C', 1);
        $pdf->Ln(5);


        $dimProtocolo = CtrVivProtocoloSeguridad::findAll($id_solicitud, $id_servicio);
        $pdf->SetWidths(array(50, 35, 105));
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
            $descripcion = str_replace('Candidato', 'Evaluado', $row['descripcion_seguridad']);
            $pdf->Row(array(
                utf8_decode($descripcion_tipo_seguridad),
                utf8_decode($row['respuesta']), 
                utf8_decode($descripcion), 

            ));
        }
        $pdf->Ln(4);


        $pdf->SetFillColor(174, 214, 241);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, utf8_decode('VII. OBSERVACIONES GENERALES'), 0, 1, 'C', 1);
        $pdf->Ln(2);

        $dimConcepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
        //print_r($dimConcepto);
        //print_r($dimConcepto['data']['expectativas']);
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();
        $pdf->SetWidths(array(65, 125));
        $pdf->SetAligns(array('L', 'L'));

        //$pdf->SetXY(10,$varYD);
        $pdf->SetFont('Arial', '', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode('Sugerencias o recomendaciones frente a la empresa y el cargo: '), (utf8_decode($dimConcepto['data'][0]['expectativas']))));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();


        $pdf->SetXY(10, $varYD);
        $pdf->SetFont('Arial', '', 8);
        $varXA = $pdf->GetX();
        $varYA = $pdf->GetY();
        $pdf->Row(array(utf8_decode("Metas y proyectos: "), (utf8_decode($dimConcepto['data'][0]['metas']))));
        $varXD = $pdf->GetX();
        $varYD = $pdf->GetY();

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

    }
}
//insertarImagenOPDF(

function insertarImagenOPDFM($pdf, $filename, $titulo, $x, $y) {
    $pdf->SetXY($x, $y);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->Cell(82, 63, '', 1, 0, '', 1); // marco negro

    if ($filename != NULL && file_exists($filename)) {
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