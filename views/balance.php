<?php 
$title = "Balance";
$useDataTables = true;
$pageTitle = "Balance";
$pageIcon = "assessment";
$navColor = "accent-color";

include __DIR__ . '/partials/header.php'; 
include __DIR__ . '/partials/navbar.php'; 
?>

    <section id="main">
        <!-- Card principal -->
        <div class="card">
            <div class="card-content">
                <!-- Formulario de fechas -->
                <form method="POST" action="?action=balance" class="row">
                    <div class="input-field col s12 m6">
                        <input type="text" id="startDate" name="startDate" value="<?= htmlspecialchars($filters['startDate'] ?? date('d/m/Y')) ?>">
                        <label for="startDate">Fecha inicio</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="text" id="endDate" name="endDate" value="<?= htmlspecialchars($filters['endDate'] ?? date('d/m/Y')) ?>">
                        <label for="endDate">Fecha fin</label>
                    </div>
                    <button class="btn accent-color waves-effect waves-light action-btn" type="submit">
                        <i class="material-icons left">search</i> Generar Balance
                    </button>

                    <button class="btn green waves-effect waves-light action-btn" type="submit" formaction="?action=exportBalanceXls">
                        <i class="material-icons left">file_download</i> Exportar XLS
                    </button>

                </form>

                <!-- Totales -->
                <div class="row totals-row">
                    <div class="col s12 m4">
                        <div class="card-panel secondary-color lighten-2 white-text center-align">
                            Ingresos: $<?= number_format($data['totalIncomes'], 0, ",", ".") ?> COP
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card-panel error-color lighten-2 white-text center-align">
                            Gastos: $<?= number_format($data['totalExpenses'], 0, ",", ".") ?> COP
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="card-panel accent-color lighten-2 white-text center-align">
                            Balance Neto: $<?= number_format($data['netBalance'], 0, ",", ".") ?> COP
                        </div>
                    </div>
                </div>

                <!-- Distribución por método de pago -->
                <h5 class="teal-text"><i class="material-icons left">payment</i> Distribución por método de pago</h5>
                <div class="row">
                    <div class="col s12 m6">
                        <h6 class="secondary-color-text"><i class="material-icons left">arrow_upward</i> Ingresos</h6>
                        <ul class="collection">
                            <?php foreach ($data['paymentSummary']['Ingresos'] as $method => $value): ?>
                                <li class="collection-item">
                                    <strong><?= htmlspecialchars($method) ?>:</strong>
                                    $<?= number_format($value, 0, ",", ".") ?> COP
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col s12 m6">
                        <h6 class="error-color-text"><i class="material-icons left">arrow_downward</i> Gastos</h6>
                        <ul class="collection">
                            <?php foreach ($data['paymentSummary']['Gastos'] as $method => $value): ?>
                                <li class="collection-item">
                                    <strong><?= htmlspecialchars($method) ?>:</strong>
                                    $<?= number_format($value, 0, ",", ".") ?> COP
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Top 5 Ingresos -->
                <h5 class="secondary-color-text"><i class="material-icons left">trending_up</i> Top 5 Ingresos</h5>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['topIncomes'] as $income): ?>
                            <tr>
                                <td><?= htmlspecialchars($income['description']) ?></td>
                                <td>$<?= number_format($income['amount'], 0, ",", ".") ?> COP</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Top 5 Gastos -->
                <h5 class="error-color-text"><i class="material-icons left">trending_down</i> Top 5 Gastos</h5>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['topExpenses'] as $expense): ?>
                            <tr>
                                <td><?= htmlspecialchars($expense['description']) ?></td>
                                <td>$<?= number_format($expense['amount'], 0, ",", ".") ?> COP</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Tabla completa -->
                <h5 class="accent-color-text"><i class="material-icons left">list</i> Detalle de movimientos</h5>
                <table id="balanceTable" class="striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Código</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ingresos -->
                        <?php foreach ($data['incomes'] as $income): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($income['date'])) ?></td>
                                <td>Ingreso</td>
                                <td><?= htmlspecialchars($income['description']) ?></td>
                                <td>$<?= number_format($income['amount'], 0, ",", ".") ?> COP</td>
                                <td><?= htmlspecialchars($income['payment_method']) ?></td>
                                <td><?= $income['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($income['code']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Gastos -->
                        <?php foreach ($data['expenses'] as $expense): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($expense['date'])) ?></td>
                                <td>Gasto</td>
                                <td><?= htmlspecialchars($expense['description']) ?></td>
                                <td>$<?= number_format($expense['amount'], 0, ",", ".") ?> COP</td>
                                <td><?= htmlspecialchars($expense['payment_method']) ?></td>
                                <td><?= $expense['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($expense['code']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php 
include __DIR__ . '/partials/footer.php'; 
include __DIR__ . '/partials/scripts.php'; 
?>