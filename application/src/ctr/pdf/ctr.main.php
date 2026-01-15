<?php
require('ctr.pdf.encabezado.php'); // Encabezado de las solicitudes
require('ctr.pdf.piepagina.php'); // Pie de pagina con adjuntos
require('ctr.pdf.autorizacion.php'); // Pie de pagina con adjuntos
require('ctr.pdf.basico.php'); // Datos basicos de los informes
require('ctr.pdf.concepto.php'); // Conceptos finales de los servicios
require('ctr.pdf.dimension.php'); // Resultados de las dimensiones x servicio (validar)
require('ctr.pdf.vacademica.php'); // Verificación academica
require('ctr.pdf.vmantenimiento.php'); // Informe de Visita de mantenimineto
require('ctr.pdf.antecedentes.php'); // Informe de Antecedentes Base CIFIN
require('ctr.pdf.vingreso.php'); // Informe de Antecedentes Base CIFIN
require('ctr.pdf.polipre.php'); // Informe de POLIGRAFIA PREempleo
require('ctr.pdf.cifin.php'); // Informe de POLIGRAFIA PREempleo
require('ctr.pdf.auto_bash.php'); // Informe de Bash

require('ctr.pdf.historia_clinica.php'); // Informe de historia clinica


/*
1	ANTECEDENTES BASES
3	VISITA INGRESO
4	VISITA  MANTENIMIENTO
5	VISITA  TELETRABAJO
6	LABORAL
7	ACADÉMICA
8	PRE-EMPLEO
9	RUTINA
10	ESPECIFICO
11	CENTRALES DE RIESGO
12	VISITA ASOCIADO DE NEGOCIO
*/


class CtrInformeMain extends PDF
{
    public static function informe($idsolicitud, $idservicio, $idcombo)
    {
        $pdf = new PDF();
        //print_r($idcombo);
        // Llama a las funciones pasando la instancia de la clase PDF como argumento
        // Encabezado
        encabezadoPdf($pdf, $idsolicitud, $idservicio, $idcombo);
        // Datos Basicos
        imprimir($pdf, $idsolicitud, $idservicio);

        //Crear funcion para concepto final de todos los informes
        infConceptoFinal($pdf, $idsolicitud, $idservicio, $idcombo);
        
        //Crear funcion para concepto final de todos los informes
       //infDimension($pdf, $idsolicitud, $idservicio);

        // imprimir por combo
        if (isset($idcombo)) {

            $combo = CtrSrvCombos::findAllByComboOrden($idcombo);

            $comboAcdLab = CtrSrvCombos::findAllByComboAcademicoLaboral($idcombo);
            //print_r($comboAcdLab['data'][0]['servicio_seleccionado']);
            $pintaActituComromiso = $comboAcdLab['data'][0]['servicio_seleccionado'];
            
            
            //print_r($combo);
            foreach ($combo['data'] as $row) {
                $servicio = CtrSrvServicio::findByIdServicio($row['id_servicio']);

                //Antecedentes
                if ($row['id_servicio'] == 1) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode( $servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(6);
                    infAntecedentes($pdf, $idsolicitud,  $row['id_servicio']);
                }
                //Laboral
                if ($row['id_servicio'] == 6) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode( $servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(6);
                    infVerLaboral($pdf, $idsolicitud,  $row['id_servicio'], $pintaActituComromiso);
                }
                //academica
                if ($row['id_servicio'] == 7) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infVerAcademica($pdf, $idsolicitud,  $row['id_servicio'], $pintaActituComromiso);
                }
                //visita de Mantenimiento
                if ($row['id_servicio'] == 4) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infVisMantenimiento($pdf, $idsolicitud, $row['id_servicio']);
                }
                //visita de ingreso
                if ($row['id_servicio'] == 3) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infVisIngreso($pdf, $idsolicitud, $row['id_servicio']);
                }

                //visita de teletrabajo
                if ($row['id_servicio'] == 5) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infVisTeletrabajo($pdf, $idsolicitud, $row['id_servicio']);
                }

                //visita de asociado de negocio
                if ($row['id_servicio'] == 12) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infVisAsociadoNegocio($pdf, $idsolicitud, $row['id_servicio']);
                }
                
                //centrales de riesgo
                if ($row['id_servicio'] == 11) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infCifin($pdf, $idsolicitud, $row['id_servicio']);
                }
                //pre-empleo
                if ($row['id_servicio'] == 8) {
                    //$pdf->AddPage();
                    //print_r($idcombo);
                    if ($idcombo == 10) {
                        infPoligrafiaPre($pdf, $idsolicitud, $row['id_servicio']);
                    } else {
                        $pdf->Ln(15);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                        $pdf->Ln(2);
                        infPoligrafiaPre($pdf, $idsolicitud, $row['id_servicio']);
                    }
                    
                }
                //pol-rutina
                if ($row['id_servicio'] == 9) {
                    //$pdf->AddPage();
                    if ($idcombo == 11) {
                        infPoligrafiaRutina($pdf, $idsolicitud, $row['id_servicio']);
                    } else {
                        $pdf->Ln(20);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                        $pdf->Ln(4);
                        infPoligrafiaRutina($pdf, $idsolicitud, $row['id_servicio']);
                    }
                    
                }
                //pol-especifico
                if ($row['id_servicio'] == 10) {
                    //$pdf->AddPage();
                    if ($idcombo == 12) {
                        infPoligrafiaEspecifico($pdf, $idsolicitud, $row['id_servicio']);
                    } else {
                        $pdf->Ln(20);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                        $pdf->Ln(4);
                        infPoligrafiaEspecifico($pdf, $idsolicitud, $row['id_servicio']);
                    }
                    
                }

                //historia clinica
                if ($row['id_servicio'] == 29) {
                    //$pdf->AddPage();
                    $pdf->Ln(5);
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->Cell(190, 5, utf8_decode($servicio['data']['nom_servicio']), 0, 0, 'C', 0);
                    $pdf->Ln(4);
                    infCifin($pdf, $idsolicitud, $row['id_servicio']);
                }
            }
        }
        // imprimir por servicio
        if (isset($idservicio)) {
            if ($idservicio == 1) {
                infAntecedentes($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 6) {
                infVerLaboral($pdf, $idsolicitud,  $idservicio, 'LABORAL');
            }

            if ($idservicio == 7) {
                infVerAcademica($pdf, $idsolicitud,  $idservicio, 'ACADÉMICA');
            }

            if ($idservicio == 4) {
                infVisMantenimiento($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 3) {
                infVisIngreso($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 5) {
                infVisTeletrabajo($pdf, $idsolicitud,  $idservicio);
            }
            if ($idservicio == 12) {
                infVisAsociadoNegocio($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 8) {
                infPoligrafiaPre($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 9) {
                infPoligrafiaRutina($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 10) {
                infPoligrafiaEspecifico($pdf, $idsolicitud,  $idservicio);
            }
            
            if ($idservicio == 11) {
                infCifin($pdf, $idsolicitud,  $idservicio);
            }

            if ($idservicio == 29) {
                historiaClinicaPdf($pdf, $idsolicitud,  $idservicio);
                consentimientoInformadoPdf($pdf, $idsolicitud,  $idservicio);
                certificadoAtencionTransitoPdf($pdf, $idsolicitud,  $idservicio);
                encuestaSatisfaccionPdf($pdf, $idsolicitud,  $idservicio);
                
            }
        }
        // pie de pagina de adjuntos
        piePaginaPdf($pdf, $idsolicitud, $idservicio);

        // pie de pagina de adjuntos
        $validacion = CtrSrvCombos::valAutoPdfCandidato($idcombo);
        
        if ($validacion['data'][0]['resultado'] == "muestra_auto") {

                $fotos = CtrSolAdjuntos::descripcionAdjuntos($idsolicitud);

                $fotoAutorizacion = 0;

                foreach ($fotos['data'] as $row) {

                    if ($row['descripcion'] == 'AUTORIZACIÓN') {
                        $fotoAutorizacion++;
                        //print_r($fotoAutorizacion);
                    } 
                }
                if ($fotoAutorizacion<1) {
                    autorizacionPdf($pdf, $idsolicitud, $idservicio);
                }
                
        }

        $pdf->Output();
    }

    public static function informe_bash($id_empresa, $id_auto)
    {
        $pdf = new PDF();
        $usuarioSesion = $_SESSION[constant('APP_NAME')]['user'];
        generarSolicitudAccesoPDF($usuarioSesion, $id_empresa, $id_auto);
        $pdf->Output();
    }
}
