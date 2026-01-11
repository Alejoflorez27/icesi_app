<?php 
$resumen = Result::getData(CtrSolSolicitud::dashboardResume());

// Obtener datos mensuales reales
$datosMensualesResult = CtrSolSolicitud::getMonthlyTrendData();
$datosMensuales = Result::getData($datosMensualesResult);

// Preparar arrays para los gráficos
$meses = [];
$nuevasSolicitudes = [];
$completadas = [];
$enGestion = [];

// Mapeo de meses en español
$mesesEsp = [
    'January' => 'Ene', 'February' => 'Feb', 'March' => 'Mar', 
    'April' => 'Abr', 'May' => 'May', 'June' => 'Jun',
    'July' => 'Jul', 'August' => 'Ago', 'September' => 'Sep',
    'October' => 'Oct', 'November' => 'Nov', 'December' => 'Dic'
];

// Obtener el mes actual en español
$mesActualNumero = (int)date('n'); // 1-12
$mesesNombres = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$mesActualNombre = $mesesNombres[$mesActualNumero - 1];
$mesActualAbrev = substr($mesActualNombre, 0, 3); // Primera letra

// Variables para el mes actual
$mesActualTotal = 0;
$mesActualCompletadas = 0;
$mesActualEnGestion = 0;

if ($datosMensuales && is_array($datosMensuales)) {
    foreach ($datosMensuales as $mes) {
        $nombreMesIngles = $mes['nombre_mes'];
        $nombreMesAbrev = isset($mesesEsp[$nombreMesIngles]) ? $mesesEsp[$nombreMesIngles] : substr($nombreMesIngles, 0, 3);
        
        $meses[] = $nombreMesAbrev;
        $nuevasSolicitudes[] = (int)$mes['total_solicitudes'];
        $completadas[] = (int)$mes['finalizadas'];
        $enGestion[] = (int)$mes['en_gestion'];
        
        // Guardar datos del mes actual
        if ($nombreMesAbrev === $mesActualAbrev) {
            $mesActualTotal = (int)$mes['total_solicitudes'];
            $mesActualCompletadas = (int)$mes['finalizadas'];
            $mesActualEnGestion = (int)$mes['en_gestion'];
        }
    }
    
    // Invertir arrays para mostrar de más antiguo a más reciente
    $meses = array_reverse($meses);
    $nuevasSolicitudes = array_reverse($nuevasSolicitudes);
    $completadas = array_reverse($completadas);
    $enGestion = array_reverse($enGestion);
    
    // Si no encontramos datos del mes actual, usar el último mes disponible
    if ($mesActualTotal === 0 && !empty($meses)) {
        $ultimoMesIndex = count($meses) - 1;
        $mesActualAbrev = $meses[$ultimoMesIndex];
        $mesActualNombre = $mesesNombres[array_search($mesActualAbrev, ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'])];
        $mesActualTotal = $nuevasSolicitudes[$ultimoMesIndex];
        $mesActualCompletadas = $completadas[$ultimoMesIndex];
        $mesActualEnGestion = $enGestion[$ultimoMesIndex];
    }
} else {
    // Datos de ejemplo si no hay datos reales
    $mesActualAbrev = date('M', strtotime('first day of this month'));
    $mesActualNombre = $mesActualNombre;
    $mesActualTotal = 0;
    $mesActualCompletadas = 0;
    $mesActualEnGestion = 0;
    
    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
    $nuevasSolicitudes = [0, 0, 0, 0, 0, 0];
    $completadas = [0, 0, 0, 0, 0, 0];
    $enGestion = [0, 0, 0, 0, 0, 0];
}

// Calcular tasa de completitud del mes actual
$mesActualTasa = $mesActualTotal > 0 ? round(($mesActualCompletadas / $mesActualTotal) * 100, 1) : 0;
?>

<style>
    /* Estilos responsive para el dashboard */
    .dashboard-container {
        display: grid;
        grid-template-columns: 320px 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }
    
    .stats-sidebar {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-left: 5px solid #2ecc71;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.15);
    }
    
    .chart-main, .trend-chart {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .chart-main {
        border-top: 4px solid #3498db;
    }
    
    .trend-chart {
        border-top: 4px solid #2ecc71;
        display: flex;
        flex-direction: column;
    }
    
    /* Media Queries para responsive */
    @media (max-width: 1200px) {
        .dashboard-container {
            grid-template-columns: 1fr 1fr;
        }
        
        .stats-sidebar {
            grid-column: span 2;
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        .stat-card {
            flex: 1;
            min-width: 250px;
        }
    }
    
    @media (max-width: 992px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
        
        .stats-sidebar {
            grid-column: span 1;
            flex-direction: column;
        }
        
        .stat-card {
            width: 100%;
        }
        
        .chart-controls {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .chart-controls button {
            margin-bottom: 5px;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            gap: 15px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-number {
            font-size: 28px !important;
        }
        
        .chart-main, .trend-chart {
            padding: 15px;
        }
        
        .chart-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
        
        .chart-header h3 {
            margin-bottom: 10px;
        }
        
        .chart-container {
            height: 250px !important;
        }
        
        #mesActualInfo {
            padding: 10px;
        }
        
        .legend-container {
            flex-direction: column;
            gap: 8px;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-container {
            gap: 10px;
        }
        
        .stat-card {
            padding: 12px;
        }
        
        .stat-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
        }
        
        .stat-number {
            font-size: 24px !important;
        }
        
        .stat-label {
            font-size: 12px !important;
        }
        
        .chart-main, .trend-chart {
            padding: 12px;
        }
        
        .chart-header h3 {
            font-size: 16px !important;
        }
        
        .chart-controls button {
            padding: 5px 10px;
            font-size: 11px;
        }
        
        .chart-container {
            height: 220px !important;
        }
        
        #mesActualInfo {
            font-size: 12px;
        }
        
        .mes-actual-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 8px !important;
        }
        
        .mes-actual-value {
            font-size: 16px !important;
        }
        
        .mes-actual-label {
            font-size: 10px !important;
        }
    }
    
    @media (max-width: 400px) {
        .stat-card {
            flex-direction: column !important;
            text-align: center;
            gap: 10px !important;
        }
        
        .stat-icon {
            margin: 0 auto 10px !important;
        }
        
        .chart-controls {
            flex-direction: column;
            width: 100%;
        }
        
        .chart-controls button {
            width: 100%;
            justify-content: center;
        }
        
        .mes-actual-grid {
            grid-template-columns: 1fr !important;
            gap: 5px !important;
        }
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <!-- Encabezado -->
                    <center><h1>Dashboard <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1></center>
                    <br><br>
                    
                    <div class="dashboard-container">
                        <?php $validar = $_SESSION[constant('APP_NAME')]['user']['perfil']; ?>
                        
                        <!-- Panel izquierdo: Estadísticas apiladas -->
                        <div class="stats-sidebar">
                            <?php if ($validar == '1' || $validar == '10' || $validar == '11' || $validar == '12' || $validar == '13' || $validar == '14' || $validar == '15' || $validar == '16'): ?>
                            <div class="stat-card sin-iniciar" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 15px rgba(46, 204, 113, 0.15)'" 
                                 onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'"
                                 onclick="filterRequests('ingresado')">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stat-icon" style="
                                        width: 50px;
                                        height: 50px;
                                        background: linear-gradient(135deg, #2ecc71, #27ae60);
                                        border-radius: 10px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 20px;
                                    ">
                                        <i class="fa fa-hourglass-start"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="stat-number" style="
                                            font-size: 32px;
                                            font-weight: 800;
                                            color: #2c3e50;
                                            line-height: 1;
                                            margin-bottom: 5px;
                                        ">
                                            <?= number_format($resumen['ingresado'], 0, ',', '.') ?>
                                        </div>
                                        <div class="stat-label" style="
                                            font-size: 14px;
                                            color: #666;
                                            margin-bottom: 8px;
                                        ">
                                            Sin Iniciar
                                        </div>
                                        <a href="#" class="link-resumen-dashboard" estado="ingresado" style="
                                            color: #3498db;
                                            text-decoration: none;
                                            font-size: 13px;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 5px;
                                        ">
                                            Ver detalles <i class="fa fa-arrow-right" style="font-size: 12px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($validar == '1' || $validar == '7' || $validar == '8' || $validar == '9' || $validar == '10' || $validar == '11' || $validar == '12' || $validar == '13' || $validar == '14' || $validar == '15' || $validar == '16'): ?>
                            <div class="stat-card en-gestion" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 15px rgba(243, 156, 18, 0.15)'" 
                                 onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'"
                                 onclick="filterRequests('gestion')">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stat-icon" style="
                                        width: 50px;
                                        height: 50px;
                                        background: linear-gradient(135deg, #f39c12, #e67e22);
                                        border-radius: 10px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 20px;
                                    ">
                                        <i class="fa fa-tasks"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="stat-number" style="
                                            font-size: 32px;
                                            font-weight: 800;
                                            color: #2c3e50;
                                            line-height: 1;
                                            margin-bottom: 5px;
                                        ">
                                            <?= number_format($resumen['gestion'], 0, ',', '.') ?>
                                        </div>
                                        <div class="stat-label" style="
                                            font-size: 14px;
                                            color: #666;
                                            margin-bottom: 8px;
                                        ">
                                            En Gestión
                                        </div>
                                        <a href="#" class="link-resumen-dashboard" estado="gestion" style="
                                            color: #3498db;
                                            text-decoration: none;
                                            font-size: 13px;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 5px;
                                        ">
                                            Ver detalles <i class="fa fa-arrow-right" style="font-size: 12px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($validar == '1' || $validar == '7' || $validar == '8' || $validar == '9' || $validar == '10' || $validar == '11' || $validar == '12' || $validar == '13' || $validar == '14' || $validar == '15' || $validar == '16'): ?>
                            <div class="stat-card finalizada" onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 15px rgba(231, 76, 60, 0.15)'" 
                                 onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'"
                                 onclick="filterRequests('finalizada')">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stat-icon" style="
                                        width: 50px;
                                        height: 50px;
                                        background: linear-gradient(135deg, #e74c3c, #c0392b);
                                        border-radius: 10px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 20px;
                                    ">
                                        <i class="fa fa-flag-checkered"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="stat-number" style="
                                            font-size: 32px;
                                            font-weight: 800;
                                            color: #2c3e50;
                                            line-height: 1;
                                            margin-bottom: 5px;
                                        ">
                                            <?= number_format($resumen['finalizada'], 0, ',', '.') ?>
                                        </div>
                                        <div class="stat-label" style="
                                            font-size: 14px;
                                            color: #666;
                                            margin-bottom: 8px;
                                        ">
                                            Finalizadas
                                        </div>
                                        <a href="#" class="link-resumen-dashboard" estado="finalizada" style="
                                            color: #3498db;
                                            text-decoration: none;
                                            font-size: 13px;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 5px;
                                        ">
                                            Ver detalles <i class="fa fa-arrow-right" style="font-size: 12px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Panel centro: Gráfico principal -->
                        <?php if ($validar == '1' || $validar == '10' || $validar == '11' || $validar == '12' || $validar == '13' || $validar == '14' || $validar == '15' || $validar == '16'): ?>
                        <div class="chart-main">
                            <div class="chart-header" style="
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-bottom: 20px;
                                padding-bottom: 15px;
                                border-bottom: 2px solid #f0f0f0;
                            ">
                                <h3 style="
                                    margin: 0;
                                    color: #2c3e50;
                                    font-size: 18px;
                                    font-weight: 600;
                                ">
                                    <i class="fa fa-chart-pie" style="color: #3498db; margin-right: 10px;"></i>
                                    Distribución de Solicitudes
                                </h3>
                                <div class="chart-controls" style="display: flex; gap: 8px;">
                                    <button onclick="changeChartType('pie')" style="
                                        padding: 6px 12px;
                                        background: #3498db;
                                        color: white;
                                        border: 1px solid #3498db;
                                        border-radius: 4px;
                                        cursor: pointer;
                                        font-size: 12px;
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    ">
                                        <i class="fa fa-chart-pie"></i> Pastel
                                    </button>
                                    <button onclick="changeChartType('bar')" style="
                                        padding: 6px 12px;
                                        background: white;
                                        color: #666;
                                        border: 1px solid #ddd;
                                        border-radius: 4px;
                                        cursor: pointer;
                                        font-size: 12px;
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    ">
                                        <i class="fa fa-chart-bar"></i> Barras
                                    </button>
                                    <button onclick="changeChartType('doughnut')" style="
                                        padding: 6px 12px;
                                        background: white;
                                        color: #666;
                                        border: 1px solid #ddd;
                                        border-radius: 4px;
                                        cursor: pointer;
                                        font-size: 12px;
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                    ">
                                        <i class="fa fa-chart-pie"></i> Dona
                                    </button>
                                </div>
                            </div>
                            
                            <div class="chart-container" style="height: 300px; position: relative;">
                                <canvas id="mainChart"></canvas>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Panel derecha: Gráfico de tendencia mensual con datos reales -->
                        <?php if ($validar == '1' || $validar == '10' || $validar == '11' || $validar == '12' || $validar == '13' || $validar == '14' || $validar == '15' || $validar == '16'): ?>
                        <div class="trend-chart">
                            <div style="margin-bottom: 20px;">
                                <h4 style="
                                    margin: 0 0 10px 0;
                                    color: #2c3e50;
                                    font-size: 16px;
                                    font-weight: 600;
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                ">
                                    <i class="fa fa-chart-line" style="color: #2ecc71;"></i>
                                    Tendencia Mensual
                                </h4>
                                <div class="legend-container" style="
                                    display: flex;
                                    gap: 15px;
                                    font-size: 12px;
                                    color: #666;
                                    flex-wrap: wrap;
                                ">
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <div style="width: 12px; height: 12px; background: rgba(52, 152, 219, 0.8); border-radius: 2px;"></div>
                                        <span>Nuevas</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <div style="width: 12px; height: 12px; background: rgba(243, 156, 18, 0.8); border-radius: 2px;"></div>
                                        <span>En Gestión</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <div style="width: 12px; height: 12px; background: rgba(46, 204, 113, 0.8); border-radius: 2px;"></div>
                                        <span>Completadas</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="flex: 1; position: relative;">
                                <canvas id="trendChart"></canvas>
                            </div>
                            
                            <!-- Panel informativo del MES ACTUAL -->
                            <div id="mesActualInfo">
                                <div style="margin-bottom: 10px;">
                                    <strong style="color: #2c3e50; display: block; margin-bottom: 5px;">
                                        <i class="fa fa-calendar-alt" style="color: #3498db; margin-right: 5px;"></i>
                                        Resumen <?= $mesActualNombre ?> (Mes Actual)
                                    </strong>
                                </div>
                                <div class="mes-actual-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                                    <div style="text-align: center;">
                                        <div class="mes-actual-value" style="font-size: 18px; font-weight: 700; color: #3498db;">
                                            <?= $mesActualTotal ?>
                                        </div>
                                        <div class="mes-actual-label" style="font-size: 11px; color: #666;">
                                            Total Solicitudes
                                        </div>
                                    </div>
                                    <div style="text-align: center;">
                                        <div class="mes-actual-value" style="font-size: 18px; font-weight: 700; color: #f39c12;">
                                            <?= $mesActualEnGestion ?>
                                        </div>
                                        <div class="mes-actual-label" style="font-size: 11px; color: #666;">
                                            En Gestión
                                        </div>
                                    </div>
                                    <div style="text-align: center;">
                                        <div class="mes-actual-value" style="font-size: 18px; font-weight: 700; color: #2ecc71;">
                                            <?= $mesActualCompletadas ?>
                                        </div>
                                        <div class="mes-actual-label" style="font-size: 11px; color: #666;">
                                            Completadas
                                        </div>
                                    </div>
                                </div>
                                <?php if ($mesActualTotal > 0): ?>
                                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee; text-align: center;">
                                    <div style="font-size: 12px; color: #666;">
                                        Tasa de completitud: <strong><?= $mesActualTasa ?>%</strong>
                                    </div>
                                    <div style="font-size: 11px; color: #999; margin-top: 3px;">
                                        <?= $mesActualCompletadas ?> de <?= $mesActualTotal ?> solicitudes
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div style="margin-top: 10px; font-size: 11px; color: #666; text-align: center;">
                                    <i class="fa fa-mouse-pointer" style="margin-right: 5px;"></i>
                                    Pasa el mouse sobre el gráfico para ver detalles por mes
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Inicializar gráficos cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
        
        // Configurar enlaces
        document.querySelectorAll('.link-resumen-dashboard').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const estado = this.getAttribute('estado');
                filterRequests(estado);
            });
        });
    });
    
    // Variables para los gráficos
    let mainChart = null;
    let trendChart = null;
    let currentChartType = 'pie';
    
    // Datos del dashboard
    const dashboardData = {
        ingresado: <?= $resumen['ingresado'] ?>,
        gestion: <?= $resumen['gestion'] ?>,
        finalizada: <?= $resumen['finalizada'] ?>,
        labels: ['Sin Iniciar', 'En Gestión', 'Finalizadas'],
        colors: {
            sinIniciar: 'rgba(46, 204, 113, 0.8)',
            enGestion: 'rgba(243, 156, 18, 0.8)',
            finalizada: 'rgba(231, 76, 60, 0.8)'
        },
        // Datos mensuales desde PHP
        monthlyData: {
            labels: <?= json_encode($meses) ?>,
            totales: <?= json_encode($nuevasSolicitudes) ?>,
            completadas: <?= json_encode($completadas) ?>,
            enGestion: <?= json_encode($enGestion) ?>
        },
        mesActual: {
            nombre: '<?= $mesActualNombre ?>',
            total: <?= $mesActualTotal ?>,
            completadas: <?= $mesActualCompletadas ?>,
            enGestion: <?= $mesActualEnGestion ?>,
            tasa: <?= $mesActualTasa ?>
        }
    };
    
    function initializeCharts() {
        // Destruir gráficos existentes si los hay
        if (mainChart) mainChart.destroy();
        if (trendChart) trendChart.destroy();
        
        // Gráfico principal
        const mainCtx = document.getElementById('mainChart');
        if (mainCtx) {
            mainChart = new Chart(mainCtx.getContext('2d'), createChartConfig(currentChartType));
        }
        
        // Gráfico de tendencia con datos reales
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            trendChart = new Chart(trendCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: dashboardData.monthlyData.labels,
                    datasets: [
                        {
                            label: 'Nuevas Solicitudes',
                            data: dashboardData.monthlyData.totales,
                            borderColor: 'rgba(52, 152, 219, 1)',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(52, 152, 219, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'En Gestión',
                            data: dashboardData.monthlyData.enGestion,
                            borderColor: 'rgba(243, 156, 18, 1)',
                            backgroundColor: 'rgba(243, 156, 18, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(243, 156, 18, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Completadas',
                            data: dashboardData.monthlyData.completadas,
                            borderColor: 'rgba(46, 204, 113, 1)',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(46, 204, 113, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3498db',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.parsed.y || 0;
                                    return `${label}: ${value} solicitudes`;
                                },
                                title: function(context) {
                                    return `Mes: ${context[0].label}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Solicitudes',
                                color: '#666',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                stepSize: 1,
                                color: '#666'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                color: '#666',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#666'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    },
                    elements: {
                        line: {
                            tension: 0.4
                        }
                    }
                }
            });
        }
    }
    
    function createChartConfig(type) {
        const configs = {
            pie: {
                type: 'pie',
                data: {
                    labels: dashboardData.labels,
                    datasets: [{
                        data: [dashboardData.ingresado, dashboardData.gestion, dashboardData.finalizada],
                        backgroundColor: [
                            dashboardData.colors.sinIniciar,
                            dashboardData.colors.enGestion,
                            dashboardData.colors.finalizada
                        ],
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#3498db',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            },
            bar: {
                type: 'bar',
                data: {
                    labels: dashboardData.labels,
                    datasets: [{
                        label: 'Cantidad',
                        data: [dashboardData.ingresado, dashboardData.gestion, dashboardData.finalizada],
                        backgroundColor: [
                            dashboardData.colors.sinIniciar,
                            dashboardData.colors.enGestion,
                            dashboardData.colors.finalizada
                        ],
                        borderColor: [
                            'rgba(46, 204, 113, 1)',
                            'rgba(243, 156, 18, 1)',
                            'rgba(231, 76, 60, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            },
            doughnut: {
                type: 'doughnut',
                data: {
                    labels: dashboardData.labels,
                    datasets: [{
                        data: [dashboardData.ingresado, dashboardData.gestion, dashboardData.finalizada],
                        backgroundColor: [
                            dashboardData.colors.sinIniciar,
                            dashboardData.colors.enGestion,
                            dashboardData.colors.finalizada
                        ],
                        borderWidth: 2,
                        cutout: '60%',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            }
        };
        
        return configs[type] || configs.pie;
    }
    
    function changeChartType(type) {
        currentChartType = type;
        
        // Actualizar estilos de botones
        const buttons = document.querySelectorAll('.chart-controls button');
        buttons.forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = '#666';
            btn.style.borderColor = '#ddd';
        });
        
        // Activar el botón seleccionado
        const activeBtn = document.querySelector(`.chart-controls button[onclick*="${type}"]`);
        if (activeBtn) {
            activeBtn.style.background = '#3498db';
            activeBtn.style.color = 'white';
            activeBtn.style.borderColor = '#3498db';
        }
        
        // Actualizar gráfico
        if (mainChart) {
            mainChart.destroy();
            const mainCtx = document.getElementById('mainChart');
            mainChart = new Chart(mainCtx.getContext('2d'), createChartConfig(type));
        }
    }
    
    function filterRequests(status) {
        const statusMap = {
            'ingresado': 'Sin Iniciar',
            'gestion': 'En Gestión',
            'finalizada': 'Finalizadas'
        };
        
        // Mostrar notificación
        const notification = document.createElement('div');
        notification.innerHTML = `
            <div style="
                position: fixed;
                top: 70px;
                right: 20px;
                background: #2c3e50;
                color: white;
                padding: 12px 20px;
                border-radius: 6px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
                font-size: 14px;
            ">
                <i class="fa fa-filter" style="margin-right: 8px;"></i>
                Filtrando por: ${statusMap[status] || status}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
        
        // window.location.href = `solicitudes.php?estado=${status}`;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= constant('APP_URL') ?>app/js/ini/dashboard.js?v=<?= time() ?>"></script>