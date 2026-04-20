<?php
include("../conexion_bd.php");

//Ventas por categoría (Uniendo pedidos, productos y categorías)
$sqlCat = "SELECT c.nombre, SUM(dp.cantidad) as total 
           FROM detalle_pedidos dp 
           JOIN productos p ON dp.id_producto = p.id 
           JOIN categoria c ON p.id_categoria = c.id 
           GROUP BY c.id";
$resCat = $conn->query($sqlCat);
$catLabels = []; $catData = [];
while($f = $resCat->fetch_assoc()){ 
    $catLabels[] = $f['nombre']; 
    $catData[] = $f['total']; 
}

//Stock por equipo
$sqlStock = "SELECT e.equipo, SUM(pt.stock) as total 
             FROM producto_tallas pt 
             JOIN productos p ON pt.id_producto = p.id 
             JOIN equipos e ON p.id_equipo = e.id 
             GROUP BY e.id";
$resStock = $conn->query($sqlStock);
$eqLabels = []; $eqData = [];
while($f = $resStock->fetch_assoc()){ 
    $eqLabels[] = $f['equipo']; 
    $eqData[] = $f['total'];
}

//Ventas por Liga (NUEVA)
$sqlLiga = "SELECT l.liga, SUM(dp.cantidad) as total FROM detalle_pedidos dp JOIN productos p ON dp.id_producto = p.id JOIN ligas l ON p.id_liga = l.id GROUP BY l.id";
$resLiga = $conn->query($sqlLiga);
$ligaLabels = []; $ligaData = [];
while($f = $resLiga->fetch_assoc()){ 
    $ligaLabels[] = $f['liga']; 
    $ligaData[] = $f['total']; 
}

//Top 3 Productos (NUEVA)
$sqlTop = "SELECT p.nombre, SUM(dp.cantidad) as total FROM detalle_pedidos dp JOIN productos p ON dp.id_producto = p.id GROUP BY p.id ORDER BY total DESC LIMIT 3";
$resTop = $conn->query($sqlTop);
$topLabels = []; $topData = [];
while($f = $resTop->fetch_assoc()){ 
    $topLabels[] = $f['nombre']; 
    $topData[] = $f['total']; 
}
?>
<h1 class="titulo">Analíticas Detalladas</h1>
<div class="total">
    <div class="info">
        <?php
        $hoy = date('Y-m-d');
        $consultaVentas = "SELECT total FROM pedidos WHERE fecha='$hoy'";
        $datosV = $conn->query($consultaVentas);
        $generado = 0;
        while($fila = $datosV->fetch_assoc()){
            $generado += $fila["total"];
        }
        ?>
        <span class="title">Total Hoy</span>
        <span class="value"><?=$generado?>€</span>
    </div>
    <div class="info">
        <?php
        $consultaVentas = "SELECT total FROM pedidos";
        $datosV = $conn->query($consultaVentas);
        $generado2 = 0;
        while($fila = $datosV->fetch_assoc()){
            $generado2 += $fila["total"];
        }
        ?>
        <span class="title">Total facturado</span>
        <span class="value"><?=$generado2?>€</span>
    </div>
</div>

<div class="grid-analiticas">
    <div class="card-grafico">
        <h3>Ventas por Categoría</h3>
        <div class="canvas-container"><canvas id="chartCat"></canvas></div>
    </div>
    <div class="card-grafico">
        <h3>Stock por Equipo</h3>
        <div class="canvas-container"><canvas id="chartStock"></canvas></div>
    </div>
    <div class="card-grafico">
        <h3>Ventas por Liga</h3>
        <div class="canvas-container"><canvas id="chartLiga"></canvas></div>
    </div>
    <div class="card-grafico">
        <h3>Productos más Vendidos</h3>
        <div class="canvas-container"><canvas id="chartTop"></canvas></div>
    </div>
</div>

<script>
    // Configuración común
    const commonOptions = { responsive: true, maintainAspectRatio: false };

    new Chart(document.getElementById('chartCat'), {
        type: 'doughnut',
        data: { labels: <?php echo json_encode($catLabels); ?>, datasets: [{ data: <?php echo json_encode($catData); ?>, backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0'] }] },
        options: commonOptions
    });

    new Chart(document.getElementById('chartStock'), {
        type: 'bar',
        data: { labels: <?php echo json_encode($eqLabels); ?>, datasets: [{ label: 'Stock', data: <?php echo json_encode($eqData); ?>, backgroundColor: '#6c5ce7' }] },
        options: commonOptions
    });

    new Chart(document.getElementById('chartLiga'), {
        type: 'pie',
        data: { labels: <?php echo json_encode($ligaLabels); ?>, datasets: [{ data: <?php echo json_encode($ligaData); ?>, backgroundColor: ['#fdcb6e', '#00b894', '#0984e3'] }] },
        options: commonOptions
    });

    new Chart(document.getElementById('chartTop'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($topLabels); ?>,
        datasets: [{
            label: 'Unidades vendidas',
            data: <?php echo json_encode($topData); ?>,
            backgroundColor: 'rgba(255, 159, 64, 0.6)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1 // Para que no salgan decimales en las unidades vendidas
                }
            }
        }
    }
});
</script>