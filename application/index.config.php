<?php

define(
    'CONF',
    array(
        # configuraciones de base de datos
        'DB' => array(
            #tipo de base de datos: DB_DRIVER
            'DRIVER' => $_ENV['DB_DRIVER'],
            #host de la base de datos: DB_HOST
            'HOST' => $_ENV['DB_HOST'],
            #puerto de la base de datos: DB_PORT
            'PORT' => $_ENV['DB_PORT'],
            #nombre de la base de datos : DB_NAME
            'NAME' => $_ENV['DB_NAME'],
            #usuario de la base de datos : DB_USER
            'USER' => $_ENV['DB_USER'],
            #password de la base de datos : DB_PASSWORD
            'PASSWORD' => $_ENV['DB_PASSWORD'],
            #juego de caracteres de la base de datos : DB_CHARSET
            'CHARSET' => $_ENV['DB_CHARSET']
        ),
        'APP' => array(
            'COMPANY' => 'Softditech',
            #version de la aplicacion : APP_VERSION
            'VERSION' => '1.0',
            #salt para encriptar las contraseñas : APP_KEY
            'KEY' => $_ENV['APP_KEY'],
            #ruta de la aplicacion : APP_URL
            'URL' => $_ENV['APP_URL'],
            #nombre de la aplicacion : APP_NAME
            'NAME' => $_ENV['APP_NAME'],
            #nombre del token : APP_TOKEN_NAME
            'TOKEN_NAME' => 'secret_token',
            #skin de la aplicacion adminlte : APP_SKIN_DEFAULT
            'SKIN_DEFAULT' => 'skin-blue',
            #timezone de la aplicacion : APP_TIMEZONE
            'TIMEZONE' => $_ENV['APP_TIMEZONE'],
            #tiempo maximo de sesion en milisegundos : APP_TIMEOUT
            'TIMEOUT' => $_ENV['APP_TIMEOUT'],
            #modo seguro de la aplicacion / validacion de token : APP_SAFE
            'SAFE' => $_ENV['APP_SAFE'],
            #modo debug de la aplicacion : APP_DEBUG
            'DEBUG' => $_ENV['APP_DEBUG'],
            #rutas de la aplicaicon : APP_ROUTES
            'ROUTES' => array(
                #ruta de los modelos : APP_ROUTES_MODELS
                'MODELS' => 'src/mdl/',
                #ruta de los controladores : APP_ROUTES_CONTROLLERS
                'CONTROLLERS' => 'src/ctr/',
                #ruta de las librerias : APP_ROUTES_VENDORS
                'VENDORS' => 'vendor/',
                #ruta para cargar archivos de la aplicacion : APP_ROUTES_UPLOADS
                'UPLOADS' => 'upload/',
                #ruta de las vistas : APP_ROUTES_VIEWS
                'VIEWS' => 'app/',
                #ruta de los modulos de vistas de la aplicacion : APP_ROUTES_MODULES
                'MODULES' => 'modules/',
                #ruta de cada modulo de vistas de la aplicacion : APP_ROUTES_MODULE_XXX
                'MODULE' => array(
                    'configuracion' => 'cnf/',
                    'usuario' => 'usr/',
                    'perfil' => 'usr/',
                    'usuarioEmpresa' => 'usr_cli/',
                    'inicio' => 'ini/',
                    'dashboard' => 'ini/',
                    'auto_bash' => 'ini/',
                    'autoBash' => 'auto_bash/',
                    'producto' => 'prd/',
                    'empresa' => 'cli/',
                    'empresaser' => 'cli/',
                    'servicio' => 'srv/',
                    'cuenta' => 'cta/',
                    'combo' => 'cmb/',
                    'calidad' => 'cld/',
                    'pendiente_asignacion' => 'pas/',
                    'seguimiento_srv' => 'segsrv/',
                    'prefactura' => 'ftc/',
                    'prefacturap' => 'ftcprv/',
                    'comboCliente' => 'cmbcli/',
                    'serviciosFin' => 'srvfin/',
                    'solicitud' => 'sol/',
                    'sla' => 'sol/',
                    'festivos' => 'sol/',

                    //Hoja de vida
                    'candidato' => 'candidato/',
                    'autorizacion' => 'candidato/',
                    'formacion' => 'candidato/',
                    'familia' => 'candidato/',
                    'laboral' => 'candidato/',
                    'adjuntos' => 'candidato/',

                    //Visita de Ingreso
                    'candidato_visita_ingreso' => 'visita_ingreso/',
                    'familia_visita_ingreso' => 'visita_ingreso/',
                    'dimensionFamilia_visita_ingreso' => 'visita_ingreso/',
                    'formacion_visita_ingreso' => 'visita_ingreso/',
                    'laboral_visita_ingreso' => 'visita_ingreso/',
                    'caracteristicaVivienda_visita_ingreso' => 'visita_ingreso/',

                    'newdistribucionVivienda_visita_ingreso' => 'visita_ingreso/',
                    'newelectrodomesticos_visita_ingreso' => 'visita_ingreso/',

                    'distribucionVivienda_visita_ingreso' => 'visita_ingreso/',//prueba nueva
                    'mobiliarioVivienda_visita_ingreso' => 'visita_ingreso/',
                    'electrodomesticosVivienda_visita_ingreso' => 'visita_ingreso/',
                    'sectorVivienda_visita_ingreso' => 'visita_ingreso/',
                    'viviendaAnteriores_visita_ingreso' => 'visita_ingreso/',
                    'dimensionSocial_visita_ingreso' => 'visita_ingreso/',
                    'ingresos_visita_ingreso' => 'visita_ingreso/',
                    'egresos_visita_ingreso' => 'visita_ingreso/',
                    'pasivos_visita_ingreso' => 'visita_ingreso/',
                    'activos_visita_ingreso' => 'visita_ingreso/',
                    'financiero_visita_ingreso' => 'visita_ingreso/',
                    'dimensionFinanciero_visita_ingreso' => 'visita_ingreso/',
                    'dimensionSalud_visita_ingreso' => 'visita_ingreso/',
                    'dimensionCompromiso_visita_ingreso' => 'visita_ingreso/',
                    'protocoloSeguridad_visita_ingreso' => 'visita_ingreso/',
                    'conceptoProfesional_visita_ingreso' => 'visita_ingreso/',
                    'adjuntos_visita_ingreso' => 'visita_ingreso/',

                    //Visita de Ingreso
                    'candidato_admisiones' => 'pacientes/',


                    
                ),
                #imagenes de la aplicacion #APP_ROUTES_IMAGE_XXX
                'IMAGE' => array(
                    'DIR' => 'upload/image/sitio/',
                    'ICON' => 'logoedsalud.png',
                    'ISOLOGO' => 'logoedsalud.png',
                    'LOGO' => 'logoedsalud.png',
                    'INICIO' => 'logoedsalud.png'
                )
            )
        ),
        #proveedores o servicios de la aplicacion
        'PROVIDER' => array(
            #proveedor de correo
            'MAIL' => array(
                'HOST' => $_ENV['PROVIDER_MAIL_HOST'],
                'PORT' => $_ENV['PROVIDER_MAIL_PORT'],
                'USER' => $_ENV['PROVIDER_MAIL_USER'],
                'PASSWORD' => $_ENV['PROVIDER_MAIL_PASSWORD'],
                'FROM' => $_ENV['PROVIDER_MAIL_FROM'],
                'SMTP_AUTH' => $_ENV['PROVIDER_MAIL_SMTP_AUTH'],
                'SMTP_SECURE' => $_ENV['PROVIDER_MAIL_SMTP_SECURE'],
            ),
            #proveedor de sms
            'SMS' => array(
                'CLIENT' => $_ENV['PROVIDER_SMS_CLIENT'],
                'PASSWORD' => $_ENV['PROVIDER_SMS_PASSWORD'],
            )
        )
    )
);
