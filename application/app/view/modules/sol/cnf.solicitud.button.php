<?php

$perfil = CtrUsuario::getUsuarioAppProperty('perfil');
$rule_btn = btn_rules();

#solicitud
$show_btn_crear = false;
$show_btn_finalizar = false;
$show_btn_cancelar_solicitud = false;
$show_btn_cancelar_admin = false;
$show_btn_editar = false;
$show_btn_reenviar = false;
$show_btn_archivo_solicitud = false;
$show_btn_servicios_adicionales = false;
$show_btn_preliminar = false;
$show_btn_agregar_servicio = false;
$show_btn_pdf_combo = false;
$show_btn_obs_calidad = false;
$show_btn_centro_costo = false;

#servicio
$show_btn_eliminar = false;
$show_btn_asignar = false;
$show_btn_programar = false;
$show_btn_asistio = false;
$show_btn_notificacion = false;
$show_btn_observacion = false;
$show_btn_archivo = false;
$show_btn_formato = false;
$show_btn_pdf = false;
$show_btn_user_info = false;
$show_btn_finalizar = false;
$show_btn_cancelar = false;
$show_btn_notificacion = false;
$show_btn_calificar = false;
$show_btn_valor_adicional = false;
$show_btn_cancelar_asignacion = false;
$show_btn_continuar_proceso = false;


foreach ($rule_btn as $btn => $rule) {
    ${"show_btn_$btn"} =
        (in_array($solicitud['id_estado_solicitud'], $rule['states']) || empty($rule['states']))  &&
        in_array(intval($perfil), $rule['roles']);
}

function btn_rules()
{
    # --+-------------+
    # id|descripcion  |
    # --+-------------+
    //     1|Administrador      
    //     7|Cliente Administrador
    //     8|Cliente Sin Informe
    //     9|Cliente Con Informe
    //    10|Visitador          
    //    11|Poligrafista       
    //    12|Coordinador        
    //    13|Calidad            
    //    14|Candidato          
    //    15|Analista de Riesgo 
    //    16|Asesor
    # --+-------------+

    return array(
        # Solicitud
        'crear' => array(
            'roles' => [1, 2, 3, 4, 12],
            'states' => []
        ),
        'finalizar' => array(
            'roles' => [1, 12, 13],
            'states' => ['ingresado', 'gestion']
        ),
        'cancelar_solicitud' => array(
            'roles' => [1, 12, 13],
            'states' => ['ingresado','gestion']
        ),
        'editar' => array(
            'roles' => [1, 12],
            'states' => ['ingresado', 'gestion']
        ),
        'reenviar' => array(
            'roles' => [1, 12, 10, 11, 13, 15, 16],
            'states' => ['ingresado', 'gestion']
        ),
        'archivo_solicitud' => array(
            'roles' => [1, 10, 11, 12, 13, 15],
            'states' => ['ingresado', 'gestion'],
        ),

        'agregar_servicio' => array(
            'roles' => [1, 12],
            'states' => ['ingresado', 'gestion']
        ),

        // Boton de PDF
        'pdf_combo' => array(
            'roles' => [1, 10, 11, 12, 13, 15, 7, 9],
            'states' => ['ingresado', 'gestion', 'preliminar', 'finalizada']
        ),

        'preliminar' => array(
            'roles' => [1, 12, 13],
            'states' => ['ingresado', 'gestion']
        ),

        'obs_calidad' => array(
            'roles' => [13,1, 12],
            'states' => ['preliminar', 'gestion', 'finalizada']
        ),

        'centro_costo' => array(
            'roles' => [1, 10, 11, 12, 13, 15, 7, 9],
            'states' => ['ingresado', 'gestion', 'preliminar', 'finalizada']
        ),

        # Servicio  
        'asignar' => array(
            'roles' => [1, 12],
            'states' => ['ingresado', 'gestion']
        ),
        'programar' => array(
            'roles' => [1, 10, 11, 12],
            'states' => ['ingresado', 'gestion', 'finalizada']
        ),
        'asistio' => array(
            'roles' => [1, 10, 11, 12],
            'states' => ['ingresado', 'gestion']
        ),
        'observacion' => array(
            'roles' => [1, 7, 8, 9, 10, 11, 12, 13, 15],
            'states' => ['ingresado', 'gestion']
        ),
        'archivo' => array(
            'roles' => [1, 10, 11, 12, 13, 15],
            'states' => ['ingresado', 'gestion']
        ),
        //show_btn_formato
        'formato' => array(
            'roles' => [1, 10, 11, 12, 13, 15],
            'states' => ['ingresado', 'gestion']
        ),
        'pdf' => array(
            'roles' => [1, 10, 11, 12, 13, 15],
            'states' => ['ingresado', 'gestion']
        ),
        'finalizar' => array(
            'roles' => [1, 12, 13],
            'states' => [/*'ingresado', */'gestion']
        ),
        'cancelar' => array(
            'roles' => [1, 12, 13],
            'states' => ['ingresado', 'gestion']
        ),
        'cancelar_asignacion' => array(
            'roles' => [1,12],
            'states' => ['ingresado', 'gestion']
        ),        
        'notificacion' => array(
            'roles' => [1,10, 12, 15, 7, 8, 9],
            'states' => ['ingresado', 'gestion']
        ),

        'calificar' => array(
            'roles' => [1, 12, 13],
            'states' => ['gestion']
        ),
        'valor_adicional' => array(
            'roles' => [1, 12],
            'states' => ['ingresado', 'gestion', 'preliminar']
        ),
        //show_btn_continuar_proceso
            'continuar_proceso' => array(
            'roles' => [1, 12],
            'states' => ['gestion', 'preliminar', 'finalizada']
        ),
    );
}
