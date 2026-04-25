<?php 
$title = "Reportes";
$useDataTables = true;
$pageTitle = "Reportes";
$pageIcon = "bar_chart";
$navColor = "reports-color";

$extraStyles = '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

include __DIR__ . '/partials/header.php'; 
include __DIR__ . '/partials/navbar.php'; 
?>

    <section id="main">
        <!-- Card principal -->
        <div class="card">
            <div class="card-content">
                <!-- Formulario de fechas -->
                <form method="POST" action="?action=reports" class="row">
                    <div class="input-field col s12 m6">
                        <input type="text" id="startDate" name="startDate" value="<?= htmlspecialchars($filters['startDate'] ?? date('d/m/Y')) ?>">
                        <label for="startDate">Fecha inicio</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="text" id="endDate" name="endDate" value="<?= htmlspecialchars($filters['endDate'] ?? date('d/m/Y')) ?>">
                        <label for="endDate">Fecha fin</label>
                    </div>
                    <button class="btn reports-color waves-effect waves-light action-btn" type="submit">
                        <i class="material-icons left">search</i> Generar Reporte
                    </button>
                    <button class="btn green waves-effect waves-light action-btn" type="submit" formaction="?action=exportReportsXls">
                        <i class="material-icons left">file_download</i> Exportar XLS
                    </button>
                </form>

                <!-- Totales -->
                <div class="row totals-row">
                    <div class="col s12 m6">
                        <div class="card-panel secondary-color lighten-2 white-text center-align">
                            Ingresos: $<?= number_format($data['totals']['totalIncomes'] ?? 0, 0, ",", ".") ?> COP
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="card-panel error-color lighten-2 white-text center-align">
                            Gastos: $<?= number_format($data['totals']['totalExpenses'] ?? 0, 0, ",", ".") ?> COP
                        </div>
                    </div>
                </div>

                <!-- Distribución por método de pago -->
                <h5 class="teal-text"><i class="material-icons left">payment</i> Distribución por método de pago</h5>

                <div class="row">
                    <!-- Ingresos -->
                    <div class="col s12 m6">
                        <h6 class="secondary-color-text"><i class="material-icons left">arrow_upward</i> Ingresos</h6>
                        <ul class="collection">
                            <?php foreach ($data['paymentSummary'] as $summary): ?>
                                <?php if ($summary['tipo'] === 'Ingreso'): ?>
                                    <li class="collection-item">
                                        <strong><?= htmlspecialchars($summary['payment_method']) ?>:</strong>
                                        $<?= number_format($summary['total'], 0, ",", ".") ?> COP
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Gastos -->
                    <div class="col s12 m6">
                        <h6 class="error-color-text"><i class="material-icons left">arrow_downward</i> Gastos</h6>
                        <ul class="collection">
                            <?php foreach ($data['paymentSummary'] as $summary): ?>
                                <?php if ($summary['tipo'] === 'Gasto'): ?>
                                    <li class="collection-item">
                                        <strong><?= htmlspecialchars($summary['payment_method']) ?>:</strong>
                                        $<?= number_format($summary['total'], 0, ",", ".") ?> COP
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Gráfica -->
                <h5 class="reports-color-text"><i class="material-icons left">pie_chart</i> Distribución por método de pago</h5>
                <canvas id="reportChartPaymentMethod"></canvas>


                <!-- Gráfica -->
                <h5 class="reports-color-text"><i class="material-icons left">pie_chart</i> Distribución General</h5>
                <canvas id="reportChart"></canvas>

                <!-- Tabla -->
                <h5 class="accent-color-text"><i class="material-icons left">list</i> Detalle de movimientos</h5>
                <table id="reportsTable" class="striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Método</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['incomes'] as $i): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($i['date'])) ?></td>
                                <td>Ingreso</td>
                                <td><?= htmlspecialchars($i['description']) ?></td>
                                <td>$<?= number_format($i['amount'], 0, ",", ".") ?> COP</td>
                                <td><?= htmlspecialchars($i['payment_method']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($data['expenses'] as $e): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($e['date'])) ?></td>
                                <td>Gasto</td>
                                <td><?= htmlspecialchars($e['description']) ?></td>
                                <td>$<?= number_format($e['amount'], 0, ",", ".") ?> COP</td>
                                <td><?= htmlspecialchars($e['payment_method']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php 
include __DIR__ . '/partials/footer.php'; 
?>
<script>
    const totalsData = {
        incomes: <?= json_encode($data['totals']['totalIncomes'] ?? 0) ?>,
        expenses: <?= json_encode($data['totals']['totalExpenses'] ?? 0) ?>
    };
    const paymentSummary = <?= json_encode($data['paymentSummary']) ?>;
</script>
<?php
include __DIR__ . '/partials/scripts.php'; 
?>