<?php

//controlador que dibuja el Informe de Visita de mantenimiento
class CtrInfVisMan extends PDF
{
    public static function imprimir($id_solicitud, $id_servicio)
    {
        if (isset($id_solicitud) && $id_solicitud != "" && $id_solicitud != null) {
            $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
            $candidato = CtrSolCandidato::findById_candidato_vistas($id_solicitud);

            //print_r($solicitud);
           $imageLogo = 'upload/image/sitio/prohumanoslogo.jpg';
            $nomInforme = 'INFORME DE VISITA DE MANTENIMIENTO ';

    //        PDF::Header($imageLogo, $nomInforme, $id_solicitud, $id_servicio);          
            $pdf = new PDF();
            $pdf->AddPage();

              

    /*    $pdf->SetFillColor(255,255,255);
	    $pdf->Image('upload/image/sitio/prohumanoslogo.jpg', 10, 10, 30, 30, '', 1);
        $pdf->Ln(18);
        $pdf->SetFont('Arial', 'B', 12);
        //$pdf->SetFillColor(207,207,207);
        $pdf->Cell(190, 10, utf8_decode('INFORME DE VISITA DE MANTENIMIENTO '), 0, 0, 'C', 0);
        $pdf->Ln(13);
        $pdf->SetFont('Arial','B',14);

        $id_solicitud = $_GET['id_solicitud'];
        $id_servicio = $_GET['id_servicio'];
        $solicitud = CtrSolSolicitud::qry_solicitud($id_solicitud, $id_servicio);
        $empresa = CtrTrcEmpresa::findById( $solicitud['data'][0]['id_empresa']);
        
        $logo_empresa = $empresa['data']['directorio'].$empresa['data']['nombre_encr'];

        if($logo_empresa){
            $pdf->Image($logo_empresa, 165, 10, 35, 25, substr(strrchr($logo_empresa, "."), 1));
        }

        $pdf->Ln(5); */





            $pdf->SetFont('Arial','B',8);
            //$pdf->Cell(5);
            $pdf->SetX(10);
            $pdf->SetFillColor(207,207,207);
            $pdf->SetTextColor(000,000,000);
            
            $pdf->Ln(1);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Fecha de Recibo de la Orden:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($solicitud['data'][0]['fch_solicitud']),1,0,'L',0);
            //$pdf->SetXY(140,96);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Fecha de la visita :'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(55,5,utf8_decode($solicitud['data'][0]['fch_asistio']),1,2,'L',0);
            $pdf->SetX(10);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode('Fecha de finalización:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($solicitud['data'][0]['fch_fin_solicitud']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Ciudad vacante:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(55,5,utf8_decode($solicitud['data'][0]['ciudad_vacante']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode('Empresa Solicitante:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($solicitud['data'][0]['razon_social']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Usuario Solicitante:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(55,5,utf8_decode($solicitud['data'][0]['nom_usuario']),1,2,'L',0);
            
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode('Nombre del profesional:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(140,5,utf8_decode($solicitud['data'][0]['proveedor']),1,0,'L',0);
            
            $pdf->Ln(10);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',9);
            //$pdf->SetTextColor(255,255,255);
            $pdf->Cell(190,5,utf8_decode('DATOS GENERALES DEL CANDIDATO'),0,0,'C',0);
            $pdf->Ln(8);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Nombre del evaluado:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['nombre']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Apellido del funcionario:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['apellido']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Tipo de documento:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['des_tipo_doc']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Documento de identidad:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['numero_doc']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Fecha nacimiento:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['fch_nacimiento']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Edad:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['edad']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Pais, Dpto y Ciudad Nacimiento:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(
                50,
                5,
                utf8_decode(
                    ucwords(
                        strtolower(
                            $candidato['data'][0]['nom_pais_nac'] . ' - ' .
                            $candidato['data'][0]['nom_dpto_nac'] . ' - ' .
                            $candidato['data'][0]['nombre_ciudad_nac']
                        )
                    )
                ),
                1,
                0,
                'L',
                0
            );
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Teléfono:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['telefono']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("Dirección:"),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['direccion']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Barrio:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['barrio']),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,"Estado Civil:",1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['des_estado_civil']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Salario Actual:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode('$ '.number_format($candidato['data'][0]['salario_actual'])),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("Estrato:"),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['estracto']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Pais, Dpto y Ciudad actual:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(
                45,
                5,
                utf8_decode(
                    mb_convert_case(
                        $candidato['data'][0]['nombre_pais_actual'] . ' - ' .
                        $candidato['data'][0]['nom_dpto_actual'] . ' - ' .
                        $candidato['data'][0]['nombre_ciu_actual'],
                        MB_CASE_TITLE,
                        "UTF-8"
                    )
                ),
                1,
                2,
                'L',
                0
            );

            $pdf->SetX(10);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("Nivel de Escolaridad:"),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(50,5,utf8_decode($candidato['data'][0]['des_nivel_escolar']),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,utf8_decode('Cargo que desempeña:'),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(45,5,utf8_decode($candidato['data'][0]['cargo_desempeno']),1,2,'L',0);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("Correo:"),1,0,'L',1);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(140,5,utf8_decode($candidato['data'][0]['email']),1,2,'L',0);

            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(000,000,000);
            $pdf->multiCell(50,5,"Nombre y parentesco de quien atiende la visita:",1,'L',1);
            $y2 = $pdf->GetY();
	        $pdf->SetXY(60,$y2-10);
            //$pdf->SetXY(60,119); // Cambiar segun se acomode la hoja
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(0,10,utf8_decode($candidato['data'][0]['persona_visita'] . ' / '. $candidato['data'][0]['parantesco_visita']),1,2,'L',0);

            $pdf->Ln(10);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('INFORME CONSOLIDADO NIVEL DE CONFIABILIDAD DEL CANDIDATO'),0,2,'C',0);
            $pdf->Ln(3);
            
            $porcentaje = CtrDimRespuestas::PorcentajeDimension($id_solicitud, $id_servicio);
            
            $y2 = $pdf->GetY();
	        $pdf->SetXY(10,$y2);
            $pdf->SetFillColor(0,192,239);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(47,5,utf8_decode("RIESGO INEXISTENTE"),1,0,'C',1);
            
            $pdf->SetFillColor(0,166,90);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(48,5,utf8_decode("RIESGO BAJO"),1,0,'C',1);

            $pdf->SetFillColor(243,156,16);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(47,5,utf8_decode("RIESGO INTERMEDIO"),1,0,'C',1);

            $pdf->SetFillColor(221,75,57);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(48,5,utf8_decode("RIESGO ALTO"),1,0,'C',1);

            
            $pdf->Ln(5);
            $pdf->SetFont('Arial','',7);
            $pdf->SetFillColor(0,192,239);
            $pdf->MultiCell(47,5,utf8_decode('En la variable analizada el candidato no evidencia riesgos.'),1,'J',1);
            
            $y2 = $pdf->GetY();
	        $pdf->SetXY(57,$y2-10);
          //  $pdf->SetXY(57,147);
            $pdf->SetFillColor(0,166,90);
            $pdf->MultiCell(48,5,utf8_decode('En la variable analizada el candidato evidencia un nivel bajo de riesgo'),1,'J',1);

            $y2 = $pdf->GetY();
	        $pdf->SetXY(105,$y2-10);
          //  $pdf->SetXY(105,147);
            $pdf->SetFillColor(243,156,16);
            $pdf->MultiCell(47,5,utf8_decode('En la variable analizada el candidato evidencia un nivel medio de riesgo'),1,'J',1);

            $y2 = $pdf->GetY();
	        $pdf->SetXY(152,$y2-10);
            //$pdf->SetXY(152,147);
            $pdf->SetFillColor(221,75,57);
            $pdf->MultiCell(48,5,utf8_decode('En la variable analizada el candidato evidencia un nivel alto de riesgo'),1,'J',1);

            //$pdf->Ln(10);
            $y2 = $pdf->GetY();
	        $pdf->SetXY(10,$y2);
            $pdf->SetFont('Arial','B',7);
            $pdf->SetFillColor(0, 173, 215);
            $pdf->Cell(47,5,utf8_decode('Menor a 1'),1,0,'C',1);
                        
            //$pdf->SetXY(57,122);
            $pdf->SetFillColor(0, 149, 81);
            $pdf->Cell(48,5,utf8_decode('1-45'),1,0,'C',1);

            //$pdf->SetXY(105,122);
            $pdf->SetFillColor(218, 149, 81);
            $pdf->Cell(47,5,utf8_decode('46-75'),1,0,'C',1);

            //$pdf->SetXY(152,122);
            $pdf->SetFillColor(199, 67, 51);
            $pdf->Cell(48,5,utf8_decode('76-100'),1,2,'C',1);
            

            $conceptoVariables = CtrDimConceptoFinal::DimConceptoAll($id_solicitud, $id_servicio) ;

            //print_r($conceptoVariables['data'][0]['observacion']);
            $pdf->Ln(6);
            $i = 0;
            foreach ($porcentaje['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','B',7);
                $pdf->Cell(93,5,utf8_decode($row['nombre_dimension']),1,0,'L',1);

              /*  $pdf->Cell(12,5,$row['porcentaje'].'%',1,0,'C',0); */
              $pdf->Cell(2,5,'',0,0,'C',0);

                if ($row['porcentaje']<= 1){
                    $pdf->SetFillColor(0,192,239);
                } elseif ($row['porcentaje']> 1 && $row['porcentaje'] <= 45){
                    $pdf->SetFillColor(0,166,90);
                } elseif ($row['porcentaje']> 46 && $row['porcentaje'] <= 75){
                    $pdf->SetFillColor(243,156,16);
                }  elseif ($row['porcentaje']> 75 && $row['porcentaje'] <= 100){
                    $pdf->SetFillColor(221,75,57);
                }
                $size = 0;
                if  ($row['porcentaje']== 0){
                    $size = 1;
                    $tamSize = 9;
                } else {
                    $size = $row['porcentaje'];

                    $tamSize = (85*$size)/100;

                }
                
                $pdf->SetFont('Arial','B',8);
               /*
                $pdf->Cell($tamSize,5,$row['porcentaje'].'%',1,0,'R',1);
                $pdf->Cell(85-$tamSize,5,'',1,2,'L',0); */

                $pdf->Cell($tamSize,5,$row['porcentaje'].'%',1,0,'R',1);
                $pdf->Cell(85-$tamSize,5,'',0,2,'L',0); 

                $y2 = $pdf->GetY();
                $pdf->SetXY(10,$y2);
                $pdf->SetFont('Arial','',8);
              //  $pdf->Cell(22,5,utf8_decode('OBSERVACION'),1,0,'L',0);
              //  $pdf->MultiCell(0,5,$conceptoVariables['data'][$i]['observacion'],0,'J',0);
                
                
                $pdf->Ln(2);
                $i= $i+1;    
            }
   
            $concepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio) ;
            
            

            $pdf->Ln(8);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190,5,utf8_decode('CONCEPTO FINAL'),0,0,'C',1);
            $pdf->Ln(7);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(50,5,utf8_decode("Por lo tanto el candidato es:"),0,0,'L',0);
            $pdf->Cell(140,5,utf8_decode($concepto['data']['des_concepto']),0,1,'L',0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','',8);
          //  $pdf->MultiCell(190,5,utf8_decode($concepto['data']['observacion']),0,'J',0);
          $pdf->SetWidths(array(65,125));
          $pdf->SetAligns(array('L','L'));

           $dimConceptoFam = CtrDimConceptoFinal::DimConceptoById($id_solicitud, $id_servicio,1);
           $pdf->Ln(2);
           $pdf->Row(array(utf8_decode('Matriz familiar: '),
           (utf8_decode(ucfirst(strtolower($dimConceptoFam['data']['observacion']))))));

           $dimConceptoFam = CtrDimConceptoFinal::DimConceptoById($id_solicitud, $id_servicio,2);
           $pdf->Row(array(utf8_decode('Matriz social y habitacional: '),
           (utf8_decode(ucfirst(strtolower($dimConceptoFam['data']['observacion']))))));

           $dimConceptoFam = CtrDimConceptoFinal::DimConceptoById($id_solicitud, $id_servicio,3);
           $pdf->Row(array(utf8_decode('Matriz financiera y economica: '),
           (utf8_decode(ucfirst(strtolower($dimConceptoFam['data']['observacion']))))));

           $dimConceptoFam = CtrDimConceptoFinal::DimConceptoById($id_solicitud, $id_servicio,4);
           $pdf->Row(array(utf8_decode('Matriz salud: '),
           (utf8_decode(ucfirst(strtolower($dimConceptoFam['data']['observacion']))))));
            
           $dimConceptoFam = CtrDimConceptoFinal::DimConceptoById($id_solicitud, $id_servicio,5);
           $pdf->Row(array(utf8_decode('Matriz actitud y compromiso: '),
           (utf8_decode(ucfirst(strtolower($dimConceptoFam['data']['observacion']))))));
            
           $pdf->Ln(8); 
           $firma = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_calidad']);
            $filename = $firma['directorio'].$firma['nombre_encr'];

            //imprimir firma de calidad
            $y2 = $pdf->GetY();
            $pdf->SetXY(20,$y2);
             if($filename){
                 $pdf->Image($filename, 20,$y2, 30, 25, substr(strrchr($filename, "."), 1));
             }

            // Cambiar para fijar firma en el mismo lugar siempre
            //$pdf->Cell(50,5,'',0,1,'L',0);
            $pdf->Ln(25);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,"Nombre y Firma Verificador Calidad",0,0,'L',0);
            $pdf->Ln(5);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(190,5,utf8_decode($solicitud['data'][0]['usr_calidad']),0,0,'L',0);

            //Siguiente pagina
           $pdf->AddPage();
            $pdf->Ln(2);


/*         //   print_r($firma['directorio'].$firma['nombre_encr']);
         //   $pdf->Image('/upload/arch_adjuntos/prohumanos/USERS/043f812f596924c5eadfffb3cd33abe4.jpg', 60, 260, 30, 30,'jpg');
            //$logo_empresa = $firma['directorio'].$firma['nombre_encr'];
          //  print_r($firma['directorio'].$firma['nombre_encr']);
         // print_r($logo_empresa);

       

//print_r($firma);
/*            $location = "upload/image/sitio/";
            $firmaData = $firma['firma'];
            // Crear un nombre de archivo único para la imagen de la firma
            $filename = $location . uniqid() . '.jpg';
            // Guardar los datos de la firma como un archivo de imagen PNG
            file_put_contents($filename, $firmaData);
            // Mostrar la firma en el PDF
            $pdf->Image($filename, 60, 260, 30, 30, 'JPG');
            // Eliminar el archivo de imagen temporal
            unlink($filename);  
            
            // Siguiente pagina
            $pdf->AddPage();
            //$pdf->Ln(8);
*/            
            $familia = CtrSolFamiliar::descripcionFamiliar($id_solicitud, $id_servicio);
           
            $pdf->SetFont('Arial','B',10);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->Cell(190,5,utf8_decode('I. DIMENSIÓN FAMILIAR'),0,0,'C',1);
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('1. PERSONAS CON QUIENES VIVE ACTUALMENTE EL FUNCIONARIO'),0,0,'L',0);
            $pdf->Ln(8);
            foreach ($familia['data'] as $row) {

               //ßprint_r($row);
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Parentesco"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['descripcion_parentesco']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Nombre"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(70,5,utf8_decode($row['nombre']).' '.utf8_decode($row['apellido']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(15,5,utf8_decode("Edad"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['edad']),1,0,'L',0);
                $pdf->Ln(5);
                
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Número contacto"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['telefono']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Residencia"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(50,5,utf8_decode($row['nombre_pais']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Ciudad"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(45,5,utf8_decode(ucfirst(strtolower($row['descripcion_ciudad']))),1,0,'L',0);
                $pdf->Ln(5);


                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Estado civil"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['descripcion_estado_civil']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Empresa"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(50, 5, utf8_decode(ucfirst(strtolower($row['empresa']))), 1, 0, 'L', 0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Ocupación"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(45,5,utf8_decode($row['ocupacion']),1,0,'L',0);
                $pdf->Ln(5);

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Escolaridad"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['descripcion_niv_escol']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(33,5,utf8_decode("Vive con el Candidato"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(37,5,utf8_decode($row['descripcion_viv_candidato']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(35,5,utf8_decode("Depende del Candidato"),1,0,'L',1);
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(30,5,utf8_decode($row['descripcion_depende_candidato']),1,0,'L',0);

                $pdf->Ln(8);
            }

            $obsFamilia = CtrObservaciones::observacionById($id_solicitud,$id_servicio,'obs_familia');
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('2. OBSERVACION GENERAL'),0,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Ln(6);
            $pdf->MultiCell(190,5,$obsFamilia['data']['observacion'],0,'J',0);
            $pdf->Ln(5);



            /*
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('2. DESARROLLO ACADÉMICO Y PROFESIONAL DEL CANDIDATO'),0,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Ln(6);
            $pdf->Cell(190,5,utf8_decode('A. FORMACIÓN ACADÉMICA'),0,0,'L',0);
            $pdf->Ln(5);
            
            $forAcedemica = CtrSolFormacion::findAllVisitas($id_solicitud, $id_servicio);
            
            foreach ($forAcedemica['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Tipo"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(30,5,utf8_decode($row['descripcion_niv_escol']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(33,5,utf8_decode("Institución"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(102,5,utf8_decode($row['nombre_institucion']),1,0,'L',0);
                $pdf->Ln(5);
                
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,utf8_decode("Fecha Grado"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(30,5,utf8_decode($row['fch_grado']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(33,5,utf8_decode("Programa Academico"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(52,5,utf8_decode($row['programa_academico']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(20,5,utf8_decode("Acta / Folio"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(30,5,utf8_decode($row['acta_folio']),1,0,'L',0);

                $pdf->Ln(8);
            }

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,utf8_decode('B. EXPERIENCIA LABORAL'),0,0,'L',0);
            $pdf->Ln(5);
            $forAcedemica = CtrSolLaboral::descripcionLaboral_visitas($id_solicitud, $id_servicio);
         // print_r ($forAcedemica);
            
            foreach ($forAcedemica['data'] as $row) {
                $pdf->SetFillColor(207,207,207);

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(32,5,utf8_decode("Empresa"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(70,5,utf8_decode($row['nombre_empresa']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(22,5,utf8_decode("Teléfono"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(20,5,utf8_decode($row['telefono_empresa']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(22,5,utf8_decode("Tipo Contrato"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(24,5,utf8_decode($row['tipo_contrato']),1,0,'L',0);
                $pdf->Ln(5);
                
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(32,5,utf8_decode("Cargo desempañado"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(70,5,utf8_decode($row['cargo_finalizo']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(22,5,utf8_decode("Fecha ingreso"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(20,5,utf8_decode($row['fch_ingreso']),1,0,'L',0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(22,5,utf8_decode("Fecha retiro"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(24,5,utf8_decode($row['fch_retiro']),1,0,'L',0);
                $pdf->Ln(5);

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(32,5,utf8_decode("Jefe inmediato"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(70,5,utf8_decode($row['jefe_inmediato']),1,0,'L',0); 
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(42,5,utf8_decode("Numero jefe inmediato"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(46,5,utf8_decode($row['numero_jefe']),1,0,'L',0);
                $pdf->Ln(5);
                
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(32,5,utf8_decode("Cargo jefe inmediato"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(70,5,utf8_decode($row['cargo_jefe']),1,0,'L',0); 
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(22,5,utf8_decode("Tipo de retiro"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(66,5,utf8_decode($row['tipo_retiro']),1,0,'L',0);
                $pdf->Ln(5);

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(32,5,utf8_decode("Motivo retiro"),1,0,'L',1);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(158,5,utf8_decode($row['motivo_retiro']),1,0,'L',0);

                $pdf->Ln(8);

            }
*/
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('CALIFICACIÓN DIMENSIÓN FAMILIAR'),0,0,'C',0);
            $pdf->Ln(8);
            $dimFamiliar = CtrDimRespuestas::descripcionDimension($id_solicitud, 6, $id_servicio);
                           
            
            //print_r($dimFamiliar);
            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("VARIABLE ANALIZADA"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("NIVEL DE RIESGO"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("INFORME POR VARIABLE"),1,0,'C',1);
            $pdf->Ln(5);

            $pdf->SetWidths(array(50, 40, 100));
            $pdf->SetAligns(array('L','C','L'));
            foreach ($dimFamiliar['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
            }
            $pdf->Ln(8);

            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('II. DIMENSIÓN SOCIAL Y HABITACIONAL'),0,0,'C',1);

             //IMPRESION DE LAS FOTOS DE CARACTERISTICAS de VIVIENDA
          $fotos = CtrSolAdjuntos::descripcionAdjuntoVisitaIngreso($id_solicitud, $id_servicio);
          $fotoInteriorViv = '';
          $fotoAutorizacion = '';  
          $fotoCandidato = '';
          $fotoCertificado ='';
          $fotoNomenclatura='';
          $fotoExteriorViv='';
          $fotoEntradaApto='';
          $fotoTorre='';
          $fotoFachada='';
          $fotoProfesional='';


          foreach ($fotos['data'] as $row) {
            
            if($row['descripcion'] == 'FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)'){
                $fotoInteriorViv = $row['directorio'].'/'.$row['nombre_encr'];   
            }else if ($row['descripcion'] == 'AUTORIZACIÓN'){
                $fotoAutorizacion = $row['directorio'].'/'.$row['nombre_encr'];
            }else if  ($row['descripcion'] == 'FOTO DEL CANDIDATO Y SU FAMILIA'){
                $fotoCandidato = $row['directorio'].'/'.$row['nombre_encr'];
            }else if ($row['descripcion'] == 'CERTIFICADOS ACADEMICOS'){
                $fotoCertificado = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE NOMENCLATURA'){
                $fotoNomenclatura = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO EXTERIOR DE LA VIVIENDA'){
                $fotoExteriorViv = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA ENTRADA DEL APARTAMENTO'){
                $fotoEntradaApto = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA TORRE'){
                $fotoTorre = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO FACHADA'){    
                $fotoFachada = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DEL CANDIDATO CON LA PROFESIONAL DE VISITAS'){    
                $fotoProfesional = $row['directorio'].'/'.$row['nombre_encr'];
            }            

          }  //fin foreach 
        

    /*    print_r($fotoInteriorViv.$fotoAutorizacion.
            $fotoCandidato.
            $fotoCertificado.
            $fotoNomenclatura.
            $fotoExteriorViv.
            $fotoEntradaApto.
            $fotoTorre.
            $fotoFachada
        );
*/
        
         // FOTO CANDIDATO
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
            $pdf->SetXY(23,$getY+67);
          //  $pdf->Ln(1);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)"),0,0,'C',0);
           
            // FOTO CANDIDATO y profesional
            $getY = $pdf->GetY();
            $pdf->SetXY(108,$getY-68);
            $getX = $pdf->GetX()+1;
            $filename = $fotoFachada;

            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            }

            $pdf->SetXY(108,$getY+67);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO FACHADA"),0,0,'C',0);    

            $pdf->Ln(10);
            $pdf->SetX(23);
            $getX = $pdf->GetX()+1;
             // FOTO de la torre
            $pdf->SetX(23);
            $getY = $pdf->GetY()+1;
            $getX = $pdf->GetX()+1;
            $filename = $fotoNomenclatura;
            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            } //FIN

            $pdf->SetXY(23,$getY+67);
          //  $pdf->Ln(1);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO DE NOMENCLATURA"),0,0,'C',0);

            // FOTO entrada del apto.
            $getY = $pdf->GetY();
            $pdf->SetXY(108,$getY-68);
            $getX = $pdf->GetX()+1;
            //ZONA SOCIAL
            $filename = $fotoExteriorViv;

            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            }
            $pdf->SetXY(108,$getY+67);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO EXTERIOR DE LA VIVIENDA"),0,0,'C',0);    

            $pdf->Ln(15);

            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('1. ASPECTOS HABITACIONALES DEL CANDIDATO Y SU FAMILIA'),0,0,'L',0);
            $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
            //print_r($carViv);

            $pdf->SetFillColor(207, 207, 207);
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(30,5,"Tipo:",1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(65,5,ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tipo_viv']))),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(30,5,utf8_decode('Tenencia:'),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(65,5,ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tenencia']))),1,2,'L',0);
            $pdf->SetX(10);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(30,5,utf8_decode("Tamaño:"),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(65,5,ucfirst(strtolower(utf8_decode($carViv['data'][0]['descripcion_tamano']))),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(30,5,utf8_decode('Estado:'),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(65,5,utf8_decode($carViv['data'][0]['descripcion_estado']),1,2,'L',0);
            $pdf->SetX(10);

            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();

            $pdf->SetXY(10,$varYD);
           // $pdf->SetX(10);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,utf8_decode("Aspectos Fisicos:"),1,0,'L',1);

            $pdf->SetX(10);
            $pdf->Ln(5);

            $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'],'tipo_aspecto_fisico',$id_solicitud, $id_servicio);
            //print_r($aspectFisico);
            $i=0;
            foreach ($aspectFisico['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }
        
            $pdf->SetX(10);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,utf8_decode("Organización y limpieza:"),1,0,'L',1);
            $pdf->SetX(10);
            $pdf->Ln(5);

            $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'],'tipo_aspecto_limpieza',$id_solicitud, $id_servicio);
           // print_r($aspectFisico);
            $i=0;
            foreach ($aspectFisico['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }

            $pdf->SetX(10);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(0,5,utf8_decode("Servicios Publicos:"),1,0,'L',1);
            $pdf->SetX(10);
            $pdf->Ln(5);
            
            $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'],'tipo_aspecto_servicios',$id_solicitud, $id_servicio);
           // print_r($aspectFisico);
            $i=0;
            foreach ($aspectFisico['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }
            
            $pdf->Ln(3);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(0,5,utf8_decode("Servicios Adicionales:"),1,0,'L',1);
            $pdf->SetX(10);
            $pdf->Ln(5);
            
            $aspectFisico = CtrVivCaracteristicas::findAllByCombo($carViv['data'][0]['id_caracteristica'],'tipo_aspecto_adicionales',$id_solicitud, $id_servicio);
           // print_r($aspectFisico);
            $i=0;
            foreach ($aspectFisico['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }


            $pdf->Ln(5);

            $pdf->SetFont('Arial','',8);
           // $pdf->Cell(30,5,utf8_decode("Aclaraciones del estado de la vivienda :"),1,0,'L',1);
            $pdf->SetWidths(array(56,134));
            $pdf->SetAligns(array('L'));
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode(" "),utf8_decode($carViv['data'][0]['aclaracion_viv'])));

            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();
            $pdf->SetXY(10,$varYA);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(56,5,utf8_decode("Aclaraciones del estado de la vivienda :"),0,0,'L',0);

            $pdf->SetXY(15, $varYD+5);

            $disEspacios = CtrVivDistribuciones::findAll($id_solicitud, $id_servicio);

            $pdf->Ln(3);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(0,5,utf8_decode("Distribución de la vivienda:"),1,0,'L',1);
            $pdf->SetX(10);
            $pdf->Ln(6);
            
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(70,5,utf8_decode("Tipo de espacios"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(22,5,utf8_decode("Nro. de espacios"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(16,5,utf8_decode("Estado"),1,0,'C',1);

            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(22,5,utf8_decode("Dotación"),1,0,'C',1);
            $pdf->Ln(5);

            $varX = $pdf->GetX();
            $varY = $pdf->GetY();

            $idMob = array();
            $i = 1;

            $pdf->SetWidths(array(70, 22, 16,22));
            $pdf->SetAligns(array('L','C','C','C'));
            foreach ($disEspacios['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(ucfirst(strtolower(utf8_decode($row['descripcion_tipo_espacios']))), 
                                utf8_decode(ucfirst(strtolower($row['numero_espacio']))), 
                                utf8_decode(ucfirst(strtolower($row['descripcion_estado_espacios']))),
                                utf8_decode(ucfirst(strtolower($row['descripcion_dotacion_mob'])))));
                
                
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

           $pdf->SetFont('Arial','B',7);
           $pdf->Cell(48,5,utf8_decode("Tipo de mobiliario"),1,0,'C',1);
           $pdf->Cell(16,5,utf8_decode("Cantidad"),1,0,'C',1);
           $pdf->Cell(16,5,utf8_decode("Estado"),1,0,'C',1);
           $pdf->Cell(17,5,utf8_decode("Tenencia"),1,0,'C',1);

           $pdf->SetFont('Arial','B',7);
           $pdf->Cell(48,5,utf8_decode("Electrodoméstico"),1,0,'C',1);
           $pdf->Cell(16,5,utf8_decode("Cantidad"),1,0,'C',1);
           $pdf->Cell(16,5,utf8_decode("Estado"),1,0,'C',1);
           $pdf->Cell(17,5,utf8_decode("Tenencia"),1,1,'C',1);

           
           $esp = 0;

           $array_num = count($idMob);
           $esp = $esp+5;
           $pdf->SetWidths(array(48, 16, 16, 17));
           $pdf->SetAligns(array('L','C','C','C'));
           
           $varXA = $pdf->GetX();
           $varYA = $pdf->GetY(); 
            //print_r($array_num);
           for ($t = 0; $t < $array_num; $t++){
           // foreach ($idMob as $row) {
            //for($t=1; $t <= $idMob.length; $t++){
                $mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio, $idMob[$t]);
                //print_r($idMob[$t]);
                foreach ($mobiliario['data'] as $row) {
    
                    $pdf->SetFillColor(207,207,207);
                    $pdf->SetFont('Arial','',8);
                    $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['tipo_elemento']))), 
                                    utf8_decode(ucfirst(strtolower($row['cantidad']))), 
                                    utf8_decode(ucfirst(strtolower($row['des_estado_mobiliario']))),
                                    utf8_decode(ucfirst(strtolower($row['des_tipo_tenencia_dotacion'])))));
                
                    $esp = $esp+5;
                    //$varY = $pdf->GetY();
                }
               // $pdf->Ln(5);
            }
            //$mobiliario = CtrVivMobiliarios::findAll($id_solicitud, $id_servicio);
           // print_r($mobiliario);
           $varXD = $pdf->GetX();
           $varYD = $pdf->GetY();

           //$pdf->Ln(3);
           $pdf->SetXY($varXA+97,$varYA);
           $electro = CtrVivElectrodomesticos::findAll($id_solicitud, $id_servicio);
           
          // $pdf->SetWidths(array(70, 22, 16,22));
          // $pdf->SetAligns(array('L','C','C','C'));
            foreach ($electro['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['descripcion_tipo_elemento']))), 
                                utf8_decode(ucfirst(strtolower($row['cantidad']))), 
                                utf8_decode(ucfirst(strtolower($row['descripcion_estado_electrodomestico']))),
                                utf8_decode(ucfirst(strtolower($row['descripcion_tenencia_electrodomestico'])))));
                
                
                //array para el id de la distribucion
                $idMob[] =  $row['id_distribucion'];  
                //$i = $i+1;  
                $varYDR = $pdf->GetY();
                $pdf->SetXY($varXA+97,$varYDR);             
            }

            if($varYDR < $varYD){
                $varNewX = $varYD - $varYDR;
            }

           // $pdf->SetXY(10,$varYDR);
            $pdf->Ln(8+$varNewX);

            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('2. ASPECTOS SOCIALES Y DEL ENTORNO HABITACIONAL'),0,0,'L',0);
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('A. CARACTERÍSTICAS DEL SECTOR'),0,0,'L',0);

            $sector = CtrVivSector::findAll($id_solicitud, $id_servicio);
            //print_r($sector);
           
            $pdf->SetX(10);
            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(12,5,"Sector:",1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(40,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tipo_sector']))),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(13,5,utf8_decode('Estrato:'),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(5,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['estracto']))),1,0,'L',0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(17,5,utf8_decode('Ubicación:'),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(17,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_ubicacion_sector']))),1,0,'L',0);

           // $pdf->Ln(5);
            //$pdf->SetX(10);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(58,5,utf8_decode('Tiempo de desplazamiento al lugar del trabajo:'),1,0,'L',0);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(0,5,ucfirst(strtolower(utf8_decode($sector['data'][0]['descripcion_tmp_ida_trabajo']))),1,2,'L',0);
            $pdf->SetX(10);

            $pdf->SetFont('Arial','',8);
           // $pdf->Cell(30,5,utf8_decode("Aclaraciones del estado de la vivienda :"),1,0,'L',1);
            $pdf->SetWidths(array(52,138));
            $pdf->SetAligns(array('L'));
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode('Tiempo en la actual vivienda: '),(utf8_decode($sector['data'][0]['tmp_en_vivienda']))));
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
            $pdf->Row(array(utf8_decode('Puntos de Referencia:     '),(utf8_decode($sector['data'][0]['zonas_verdes']))));

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
            $pdf->Row(array(utf8_decode("Principales vías de acceso:     "),(utf8_decode($sector['data'][0]['vias_principales']))));
            
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
            $pdf->Row(array(utf8_decode("Estado de calles y vías de acceso:   "),(utf8_decode($sector['data'][0]['estado_sector']))));
           
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
           $pdf->Row(array(utf8_decode("Concepto del vecino:   "),(utf8_decode($sector['data'][0]['concepto_vecino']))));
           
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
           
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(0,5,utf8_decode("Medios de transporte:"),1,1,'L',1);
           $pdf->SetX(10);
           $pdf->Ln(0); 

           $transporte = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'],'tipo_aspecto_transporte',$id_solicitud, $id_servicio);
           // print_r($aspectFisico);
            $i=0;
            foreach ($transporte['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }
            
            $pdf->Ln(3);
            $pdf->SetX(10); 
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(0,5,utf8_decode("Servicios en el entorno habitacional:"),1,1,'L',1);
            $pdf->SetX(10);
            $pdf->Ln(0); 
            
            $sectorServicio = CtrVivSector::findAllByCombo($sector['data'][0]['id_sector'],'tipo_aspecto_sector_servicio',$id_solicitud, $id_servicio);
            $i=0;
            foreach ($sectorServicio['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(95,5,utf8_decode('* '.$row['descripcion']),1,0,'L',0);
                //(array(utf8_decode($row['descripcion']), utf8_decode($row['descripcion'])));
                $i = $i+1;
                if(($i % 2) == 0){
                    $pdf->Ln(5); 
                }
            }
            if(($i % 2) != 0){$pdf->Ln(5); }

            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('B. SITIOS DE VIVIENDA ANTERIORES Y TIEMPO DE ESTADÍA EN ELLOS'),0,1,'L',0);

            $pdf->Ln(2);
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(80,5,utf8_decode("Ubicación"),1,0,'C',1);
         
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(40,5,utf8_decode("Tiempo Estadía"),1,0,'C',1);

           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(70,5,utf8_decode("Motivo de Cambio"),1,0,'C',1);
           $pdf->Ln(5);

           $viviendas = CtrVivAnteriores::findAllVisitas($id_solicitud, $id_servicio);
           
           $pdf->SetWidths(array(80,40,70));
           $pdf->SetAligns(array('L','L','L'));
            foreach ($viviendas['data'] as $row) {
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['ubicacion']))), 
                                utf8_decode(ucfirst(strtolower($row['descripcion_tiempo_reside']))), 
                                utf8_decode(ucfirst(strtolower($row['motivo_cambio']))),
                               ));
                    
            }



            $pdf->SetFillColor(174, 214, 241);
            $pdf->Ln(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIAL Y HABITACIONAL'),0,0,'C',0);
            $pdf->Ln(8);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("VARIABLE ANALIZADA"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("NIVEL DE RIESGO"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("INFORME POR VARIABLE"),1,0,'C',1);
            $pdf->Ln(5);

            $dimSocial = CtrDimRespuestas::descripcionDimension($id_solicitud, 7, $id_servicio);
            $pdf->SetWidths(array(50, 40, 100));
            $pdf->SetAligns(array('L','C','L'));
            foreach ($dimSocial['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
            }
            $pdf->Ln(10);

            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('III. DIMENSIÓN SOCIOECONÓMICA'),0,0,'C',1);
            $pdf->Ln(8);
            
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(190,5,utf8_decode('1. ANÁLISIS SOCIOECONÓMICO DEL CANDIDATO Y SU FAMILIA'),0,0,'L',0);

            $carViv = CtrVivCaracteristicas::findAll($id_solicitud, $id_servicio);
            //print_r($carViv);
            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,utf8_decode('A. INGRESOS Y EGRESOS DEL FUNCIONARIO Y LA FAMILIA CON LA QUE CONVIVE'),0,0,'L',0);
            
            $pdf->Ln(6);
            $pdf->SetFillColor(207, 207, 207);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(95,5,utf8_decode("Ingresos Mensuales del funcionario y familia con la que convive"),1,0,'C','1');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(95,5,utf8_decode("Egresos Mensuales familiares del funcionario y familia con la que convive"),1,1,'C',1);
            
            $ingresos = CtrVivIngresos::findAll($id_solicitud, $id_servicio);
            $egresos = CtrVivEgresos::findAll($id_solicitud, $id_servicio);
           
            $pdf->Cell(40,5,utf8_decode("Integrante de la Familia"),1,0,'C',1);
            $pdf->Cell(25,5,utf8_decode("valor de Ingreso"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Donde Proviene"),1,0,'C',1);
            //$pdf->Ln(5);
            $pdf->Cell(40,5,utf8_decode("Concepto"),1,0,'C',1);
            $pdf->Cell(25,5,utf8_decode("Valor Egreso"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Responsable"),1,1,'C',1);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            
            $pdf->SetWidths(array(40, 25, 30));
            $pdf->SetAligns(array('L','C','L'));
            $totalIng = 0;
            $totalEg = 0;
            foreach ($ingresos['data'] as $row) {
                $pdf->SetFont('Arial','',7);
                $pdf->Row(array(utf8_decode($row['descripcion_tipo_integrante']), 
                                utf8_decode('$ '.number_format($row['valor_ingreso'])), 
                                utf8_decode($row['ingreso_proveniente'])));

                $totalIng = $totalIng + $row['valor_ingreso'];              
            }
            
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();
            $varYDR = 0;
            $pdf->SetXY($varXA+95,$varYA);
            foreach ($egresos['data'] as $row) {
                $pdf->SetFont('Arial','',7);
                $pdf->Row(array(utf8_decode($row['descripcion_tipo_concepto']), 
                                utf8_decode('$ '.number_format($row['valor_egreso'])), 
                                utf8_decode($row['descripcion_tipo_integrante'])));

                $varYDR = $pdf->GetY();
                $pdf->SetXY($varXA+95,$varYDR);  
                
                $totalEg = $totalEg + $row['valor_egreso']; 
            }
            $varYN = 0;
           // print_r($varYDR);
            if($varYD < $varYDR){
              //  $varYN = $varYDR - $varYD;
                $pdf->SetXY(10, $varYDR+4); 
            }else
             if($varYDR < $varYD){
                //$varYN = $varYD - $varYDR;
                $pdf->SetXY(10, $varYD+4); 
            }

            $pdf->Ln(1);
           // $pdf->SetX(10, $varYN); 
            $pdf->SetFont('Arial','B',8);
            $pdf->SetFillColor( 125, 206, 160);
            $pdf->Cell(40,5,utf8_decode("Total valor ingresos"),1,0,'C',1);
            $pdf->Cell(55,5,utf8_decode('$ '.number_format($totalIng)),1,0,'C',0);
            //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
            $pdf->Cell(40,5,utf8_decode("Total valor egresos"),1,0,'C',1);
            $pdf->Cell(55,5,utf8_decode('$ '.number_format($totalEg)),1,0,'C',0);
            //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
           
            $pdf->Ln(12);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(190,5,utf8_decode('B. PASIVO Y PATRIMONIO DEL CANDIDATO Y LA FAMILIA CON LA QUE CONVIVE'),0,1,'L',0);
            
            $pdf->SetFillColor(207,207,207);
            $pdf->Ln(1);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(0,5,utf8_decode("Pasivos del candidato y familia con la que convive"),1,1,'C','1');
            $pdf->Ln(1);
            $pdf->Cell(21,5,utf8_decode("Concepto"),1,0,'C',1);
            $pdf->Cell(18,5,utf8_decode("Otros"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Responsable"),1,0,'C',1);
            $pdf->Cell(23,5,utf8_decode("Otro Responsable"),1,0,'C',1);
            $pdf->Cell(18,5,utf8_decode("Valor pasivo"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Plazo pasivo"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Cuota Mensual"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Estado de la Obligación"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Valor de Mora"),1,1,'C',1);
            
            $pdf->SetWidths(array(21, 18, 20, 23,18, 20, 20, 30, 20));
            $pdf->SetAligns(array('L','L','L','L','C','L','L','L','C'));
           

            $pasivos = CtrVivPasivos::findAllCandidato($id_solicitud, $id_servicio);
            $totalPas = 0;
            $totalAct = 0;

            foreach ($pasivos['data'] as $row) {
                $pdf->SetFont('Arial','',7);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['descripcion_tipo_pasivo']))), 
                                utf8_decode(' '),
                                utf8_decode($row['descripcion_tipo_responsable']), 
                                utf8_decode(' '), 
                                utf8_decode('$ '.number_format($row['valor_pasivo'])), 
                                utf8_decode($row['descripcion_tipo_plazo']), 
                                utf8_decode(' '), 
                                utf8_decode(' '),  
                                utf8_decode('$ ')));

                //$varYDR = $pdf->GetY();
                //$pdf->SetXY($varXA+95,$varYDR);  
                
                $totalPas = $totalPas + $row['valor_pasivo']; 
            }


            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(0,5,utf8_decode("Activos del candidato y familia con la que convive"),1,1,'C','1');
            $pdf->Ln(1);
            $pdf->Cell(30,5,utf8_decode("Tipo de Activo"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Otro"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Propietario"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Otro Propietario"),1,0,'C',1);
            $pdf->Cell(30,5,utf8_decode("Descripcion General"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Valor Activo"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Valor Catastral"),1,1,'C',1);
           
            
            $pdf->SetWidths(array(30, 30, 30, 30, 30, 20, 20));
            $pdf->SetAligns(array('L','L','L','L','L','C','C'));
           

            $activos = CtrVivActivos::findAllCandidato($id_solicitud, $id_servicio);

            foreach ($activos['data'] as $row) {
                $pdf->SetFont('Arial','',7);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['descripcion_tipo_activo']))), 
                                utf8_decode(' '),
                                utf8_decode($row['descripcion_tipo_responsable']), 
                                utf8_decode(' '), 
                                utf8_decode($row['descripcion_general_viv']), 
                                utf8_decode('$ '.number_format($row['valor_activo'])), 
                                utf8_decode('$ ') 
                                ));
                
                $totalAct = $totalAct + $row['valor_activo']; 
            }

            $totalPat = $totalAct - $totalPas;

            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',8);
            $pdf->SetFillColor( 125, 206, 160);
            $pdf->Cell(39,5,utf8_decode("Total pasivos candidato"),1,0,'C',1);
            $pdf->Cell(25,5,utf8_decode('$ '.number_format($totalPas)),1,0,'C',0);
            //$pdf->Cell(30,5,utf8_decode(""),0,0,'C',0);
            $pdf->Cell(39,5,utf8_decode("Total activos candidato"),1,0,'C',1);
            $pdf->Cell(25,5,utf8_decode('$ '.number_format($totalAct)),1,0,'C',0);

            $pdf->Cell(37,5,utf8_decode("Patrimonio candidato"),1,0,'C',1);
            $pdf->Cell(25,5,utf8_decode('$ '.number_format($totalPat)),1,1,'C',0);




            $pdf->Ln(9);
            $pdf->SetFont('Arial','B',8);
            $pdf->SetFillColor(207,207,207);
            $pdf->Cell(190,5,utf8_decode('C. ANÁLISIS DE REPORTES EN CENTRALES DE RIESGO FINANCIERO'),0,1,'L',0);
            $pdf->Ln(1);
            $pdf->Cell(80,5,utf8_decode("Aspecto Consultado"),1,0,'C',1);
            $pdf->Cell(20,5,utf8_decode("Estado "),1,0,'C',1);
            $pdf->Cell(90,5,utf8_decode("Observaciones "),1,1,'C',1);
            
           
            $pdf->SetWidths(array(80, 20, 90));
            $pdf->SetAligns(array('L','C','L'));

            $centrales = CtrVivRiesgosFinanciero::findAll($id_solicitud, $id_servicio);

            foreach ($centrales['data'] as $row) {
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['descripcion_tipo_financiero']))), 
                                utf8_decode(ucfirst(strtolower($row['estado']))),
                                utf8_decode(ucfirst(strtolower($row['descripcion_financiero'])))
                                ));

                //$varYDR = $pdf->GetY();
                //$pdf->SetXY($varXA+95,$varYDR);  
                
                $totalAct = $totalAct + $row['valor_activo']; 
            }

            $pdf->Ln(8);
            $pdf->SetFont('Arial','B',9);
            
            $pdf->SetFillColor(  174, 214, 241 );
            $pdf->Cell(190,5,utf8_decode('CALIFICACIÓN DIMENSIÓN SOCIOECONÓMICA'),0,0,'C',0);
            $pdf->Ln(8); 

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("VARIABLE ANALIZADA"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("NIVEL DE RIESGO"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("INFORME POR VARIABLE"),1,0,'C',1);
            $pdf->Ln(5);

            $dimEconomia = CtrDimRespuestas::descripcionDimension($id_solicitud, 8, $id_servicio);
            $pdf->SetWidths(array(50, 40, 100));
            $pdf->SetAligns(array('L','C','L'));
            
            foreach ($dimEconomia['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
            }
            $pdf->Ln(8);

            $pdf->SetFillColor(207,207,207);
            
            $pdf->Ln(10);

            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('IV. DIMENSIÓN SALUD DEL CANDIDATO Y SU FAMILIA'),0,0,'C',1);
            $pdf->Ln(8);

            $pdf->SetFillColor(207,207,207);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("VARIABLE ANALIZADA"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("NIVEL DE RIESGO"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("INFORME POR VARIABLE"),1,0,'C',1);
            
           // $pdf->SetFont('Arial','B',8);
           // $pdf->Cell(40,5,utf8_decode("PREGUNTAS"),1,0,'C',1);

            $pdf->Ln(5);

            $dimPregSalud= CtrDimRespuestas::findAllVariables($id_solicitud,3);
           

            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            foreach ($dimPregSalud['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->SetWidths(array(50, 40, 100));
                $pdf->SetAligns(array('L','C','L'));
    
                
                $id_pregunta = $row['id_pregunta'];
                $dimResp = CtrDimVarRespuestaSalud::consultaVariableSalud($id_solicitud, $id_pregunta);
                $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($dimResp['data']['descripcion_riesgo']), utf8_decode($dimResp['data']['respuesta'])));
                                
               // $varXA = $pdf->GetX();
                $varYD = $pdf->GetY();

                $pdf->SetXY(10,$varYD);
                $dimRespCheck = CtrDimVarRespuestaSalud::consultaExiste($id_solicitud, $id_pregunta);
                $pdf->SetWidths(array(190));
                $pdf->SetAligns(array('L'));
               // $pdf->Row(array(utf8_decode('Preguntas por variable de salud: ')));
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(190,5,utf8_decode("Preguntas por variable de salud: "),1,1,'L',1);

                foreach ($dimRespCheck['data'] as $row) {
                    if($row['activo'] == '1'){
                        $pdf->SetFont('Arial','',8);
                        $preg = $row['nombre_pregunta'];
                        $pdf->Row(array(utf8_decode($preg)));

                        $varXR = $pdf->GetX();
                        $varYR = $pdf->GetY();
                        $pdf->SetXY($varXR,$varYR);
                    }    
                } 

                $pdf->Ln(3);
                
            }    

          //  $pdf->Ln(8);




            $pdf->Ln(10);

            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('V. DIMENSIÓN ACTITUD Y COMPROMISO DEL FUNCIONARIO CON EL PROCESO'),0,0,'C',1);
            $pdf->Ln(8);

            $pdf->SetFillColor(207,207,207);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("VARIABLE ANALIZADA"),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("NIVEL DE RIESGO"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("INFORME POR VARIABLE"),1,0,'C',1);
            $pdf->Ln(5); 
 
            $dimActitud = CtrDimRespuestas::descripcionDimension($id_solicitud, 10, $id_servicio);
            $pdf->SetWidths(array(50, 40, 100));
            $pdf->SetAligns(array('L','C','L'));
            
            foreach ($dimActitud['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode($row['nombre_pregunta']), utf8_decode($row['descripcion_niv_riesgo']), utf8_decode($row['respuesta'])));
            }
            $pdf->Ln(9);

           // $pdf->Ln(5);


            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('VI. PROTOCOLO DE SEGURIDAD / ASPECTO CRÍTICOS DE RIESGO'),0,0,'C',1);
            $pdf->Ln(8);

            $pdf->SetFillColor(207,207,207);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,utf8_decode("ASPECTO DE RIESGO "),1,0,'C',1);
            
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,utf8_decode("RESPUESTA"),1,0,'C',1);
          
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(100,5,utf8_decode("OBSERVACIONES"),1,0,'C',1);
            $pdf->Ln(5);

            
            $dimProtocolo = CtrVivProtocoloSeguridad::findAll($id_solicitud, $id_servicio);
            $pdf->SetWidths(array(50, 40, 100));
            $pdf->SetAligns(array('L','C','L'));
            
            foreach ($dimProtocolo['data'] as $row) {
                $pdf->SetFillColor(207,207,207);
                $pdf->SetFont('Arial','',8);
                $pdf->Row(array(utf8_decode(ucfirst(strtolower($row['descripcion_tipo_seguridad']))), 
                                utf8_decode($row['respuesta']), utf8_decode($row['descripcion_seguridad'])));
            }
            $pdf->Ln(9);
            

            $pdf->SetFillColor(174, 214, 241);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,5,utf8_decode('VII. OBSERVACIONES GENERALES'),0,1,'C',1);
            $pdf->Ln(5);

            $dimConcepto = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();
            $pdf->SetWidths(array(65,125));
            $pdf->SetAligns(array('L','L'));

            //$pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode('Expectativas familiares frente al cargo y la empresa: '),(utf8_decode($dimConcepto['data']['expectativas']))));
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();


            $pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode("Metas y proyectos: "),(utf8_decode($dimConcepto['data']['metas']))));
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();


       /*     $pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode('Como llega la hoja de vida a la empresa:  '),(utf8_decode($dimConcepto['data']['medio_hv']))));
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();


            $pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
            $varXA = $pdf->GetX();
            $varYA = $pdf->GetY();
            $pdf->Row(array(utf8_decode('Tiene usted conocimiento de las condiciones laborales de la entidad y está de acuerdo con ellas? '),
                            (utf8_decode(ucfirst(strtolower($dimConcepto['data']['condicion_laboral']))))));
            $varXD = $pdf->GetX();
            $varYD = $pdf->GetY();

            $pdf->Ln(2);
            $pdf->SetXY(10,$varYD);
            $pdf->SetFont('Arial','',8);
*/
           
            
           
           $pdf->Ln(6);
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(190,5,"Nombre del profesional a cargo: ",0,0,'L',0);
           $pdf->Ln(5);
           $pdf->SetFont('Arial','',8);
           $pdf->Cell(190,5,utf8_decode(strtoupper($solicitud['data'][0]['proveedor'])),0,0,'L',0);
           


           //Firma Calidad
           $firma = CtrUsuario::consultar($solicitud['data'][0]['id_usuario_calidad']);
           $filename = $firma['directorio'].$firma['nombre_encr'];
           $pdf->Ln(25);
           
           //imprimir firma de calidad
           $y2 = $pdf->GetY();
           
           $pdf->SetXY(20,$y2);
            if($filename){
                $pdf->Image($filename, 20,$y2, 30, 25, substr(strrchr($filename, "."), 1));
            }

           // Cambiar para fijar firma en el mismo lugar siempre
           //$pdf->Cell(50,5,'',0,1,'L',0);
           $pdf->Ln(25);
           $pdf->SetFont('Arial','B',8);
           $pdf->Cell(190,5,"Nombre y Firma Verificador Calidad",0,0,'L',0);
           $pdf->Ln(5);
           $pdf->SetFont('Arial','',8);
           $pdf->Cell(190,5,utf8_decode(strtoupper($solicitud['data'][0]['usr_calidad'])),0,0,'L',0);

           //Siguiente pagina
          $pdf->AddPage();
          $pdf->Ln(2);

          
          //ADJUNTO DE FOTOS
          $pdf->SetFont('Arial','B',8);
          $pdf->Cell(190,5,utf8_decode("REGISTRO FOTOGRÁFICO"),0,0,'C',0);

          
          $fotos = CtrSolAdjuntos::descripcionAdjuntoVisitaIngreso($id_solicitud, $id_servicio);
          $fotoInteriorViv = '';
          $fotoAutorizacion = '';  
          $fotoCandidato = '';
          $fotoCertificado ='';
          $fotoNomenclatura='';
          $fotoExteriorViv='';
          $fotoEntradaApto='';
          $fotoTorre='';
          $fotoFachada='';
          $fotoProfesional='';


          foreach ($fotos['data'] as $row) {
            
            if($row['descripcion'] == 'FOTO INTERIOR DE LA VIVIENDA (ZONA SOCIAL)'){
                $fotoInteriorViv = $row['directorio'].$row['nombre_encr'];   
            }
            else if ($row['descripcion'] == 'AUTORIZACIÓN'){
                $fotoAutorizacion = $row['directorio'].'/'.$row['nombre_encr'];
            }else if  ($row['descripcion'] == 'FOTO DEL CANDIDATO Y SU FAMILIA'){
                $fotoCandidato = $row['directorio'].'/'.$row['nombre_encr'];
            }else if ($row['descripcion'] == 'CERTIFICADOS ACADEMICOS'){
                $fotoCertificado = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE NOMENCLATURA'){
                $fotoNomenclatura = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO EXTERIOR DE LA VIVIENDA'){
                $fotoExteriorViv = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA ENTRADA DEL APARTAMENTO'){
                $fotoEntradaApto = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DE LA TORRE'){
                $fotoTorre = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO FACHADA'){    
                $fotoFachada = $row['directorio'].'/'.$row['nombre_encr'];
            } else if ($row['descripcion'] == 'FOTO DEL CANDIDATO CON LA PROFESIONAL DE VISITAS'){    
                $fotoProfesional = $row['directorio'].'/'.$row['nombre_encr'];
            }            

          }  //fin foreach 
        

    /*    print_r($fotoInteriorViv.$fotoAutorizacion.
            $fotoCandidato.
            $fotoCertificado.
            $fotoNomenclatura.
            $fotoExteriorViv.
            $fotoEntradaApto.
            $fotoTorre.
            $fotoFachada
        );
*/
        
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
            $pdf->SetXY(23,$getY+67);
          //  $pdf->Ln(1);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO DEL CANDIDATO Y SU FAMILIA"),0,0,'C',0);
           
           
            // FOTO CANDIDATO y profesional
            $getY = $pdf->GetY();
            $pdf->SetXY(108,$getY-68);
            $getX = $pdf->GetX()+1;
            $filename = $fotoProfesional;

            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            }

            $pdf->SetXY(108,$getY+67);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO DEL CANDIDATO CON EL PROFESIONAL DE VISITAS"),0,0,'C',0);  



            $pdf->Ln(10);
            $pdf->SetX(23);
            $getX = $pdf->GetX()+1;
             // FOTO de la torre
            $pdf->SetX(23);
            $getY = $pdf->GetY()+1;
            $getX = $pdf->GetX()+1;
            $filename = $fotoTorre;
            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            } //FIN
            
              $pdf->SetXY(23,$getY+67);
            //  $pdf->Ln(1);
              $pdf->SetFont('Arial','B',7);
              $pdf->Cell(80,5,utf8_decode("FOTO DE LA TORRE"),0,0,'C',0);


            // FOTO entrada del apto.
            $getY = $pdf->GetY();
            $pdf->SetXY(108,$getY-68);
            $getX = $pdf->GetX()+1;
            //ZONA SOCIAL
            $filename = $fotoEntradaApto;
            if ($filename != NULL) {
                $pdf->SetFillColor(000, 000, 000);
                $pdf->Cell(82, 67, '', 1, 0, '', 1);
                $getY = $pdf->GetY() + 1;
                $pdf->Image($filename, $getX, $getY, 80, 65);
            }
            $pdf->SetXY(108,$getY+67);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(80,5,utf8_decode("FOTO DE LA ENTRADA DEL APARTAMENTO"),0,1,'C',0);  

            $pdf->Ln(15);
        
        
        
         //Siguiente pagina //FOTO AUTORIZACION
          $pdf->AddPage();
          $pdf->Ln(2);
          
          $pdf->SetX(25);
			$getx = $pdf->GetX();
			if ($fotoAutorizacion != NULL) {
				//$pdf->SetX(45);
				//$pdf->Ln(7);
				$pdf->SetX(25);
				$pdf->Cell(165, 5,utf8_decode('AUTORIZACIÓN'), 0, 2, 'C', 0);
				$pdf->Cell(0, 2, "", 0, 2, 'C', 0);
				$pdf->SetFillColor(000, 000, 000);
				$pdf->Cell(165, 220, '', 1, 0, '', 1);
				$getY = $pdf->GetY() + 1;
				$pdf->Image($fotoAutorizacion, $getx + 1, $getY, 163, 218);
				$pdf->Ln(113);
			}

          //foto certificación
          $pdf->AddPage();
          $pdf->Ln(2);
          
          $pdf->SetX(25);
			$getx = $pdf->GetX();
			if ($fotoCertificado != NULL) {
				//$pdf->SetX(45);
				//$pdf->Ln(7);
				$pdf->SetX(25);
				$pdf->Cell(165, 5,utf8_decode('CERTIFICADO ACADEMICO'), 0, 2, 'C', 0);
				$pdf->Cell(0, 2, "", 0, 2, 'C', 0);
				$pdf->SetFillColor(000, 000, 000);
				$pdf->Cell(165, 220, '', 1, 0, '', 1);
				$getY = $pdf->GetY() + 1;
				$pdf->Image($fotoCertificado, $getx + 1, $getY, 163, 218);
				$pdf->Ln(113);
			}   



            $pdf->Output();
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }
}