
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cargue Masivo de Solicitudes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                    <li class="breadcrumb-item">Solicitudes</li>
                    <li class="breadcrumb-item active">Cargue Masivo</li>
                </ol>
            </div>
        </div>
    </div>    
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="div-box-clientes">
                <div class="box">
                
                    <div class="box-header">
                        <style>
                            .btnAddCargueMasivo {
                                font-size: 2.5rem; /* Ajusta el tamaño del texto y del ícono */
                                padding: 20px 60px; /* Ajusta el relleno del botón */
                                border-radius: 1rem; /* Ajusta el radio de borde */
                                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Añade una sombra más pronunciada */
                                transition: background-color 0.3s, transform 0.3s; /* Añade transiciones suaves */
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            }

                            .btnAddCargueMasivo .fa {
                                font-size: 4rem; /* Ajusta el tamaño del ícono */
                                margin-right: 25px; /* Espacio entre el ícono y el texto */
                            }

                            .btnAddCargueMasivo:hover {
                                background-color: #004494; /* Cambia el color de fondo en el hover */
                                transform: scale(1.2); /* Agranda el botón ligeramente en el hover */
                            }
                        </style>
                        <center>
                            <button class="btn btn-lg btn-primary btnAddCargueMasivo" data-toggle="modal">
                            <i class="fa fa-upload"></i><b>&nbsp;Cargue Masivo</b>
                            </button>
                        </center>

                    </div>

                    <div class="box-body">
                        <table id="tbl-solicitudMasiva" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:10px">id solicitud</th>
                                    <th>Nombre</th>
                                    <th>Número Identificación</th>
                                    <th>Cargo</th>
                                    <th>Correo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="div-box-clientes">
                <div class="box">
                
                    <div class="box-header">

                        <h1> Solicitudes - Error</h1>

                    </div>

                    <div class="box-body">
                        <table id="tbl-solicitudError" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                            <thead>
                                <tr>
                                    <th>Fila</th>
                                    <th>Mensaje Solicitud</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</section>

<?php include 'vw.solicitud.masivo.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/sol/solicitud.cargue.masivo.js?v=<?= time() ?>"></script>