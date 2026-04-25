<?php
$title = "Prestamos";
$useDataTables = true;
$pageTitle = "Prestamos";
$pageIcon = "sync";
$navColor = "loans-color";


include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/navbar.php';
?>

<section id="main" class="container">
    <!-- Dashboard-box para la tabla -->
    <div class="dashboard-box">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col s12 m6">
                <h5 style="font-weight: 700; color: var(--primary);">Gestión de Préstamos</h5>
                <p class="grey-text">Seguimiento de deudas y saldos pendientes</p>
            </div>
        </div>

        <table id="loansTable" class="highlight display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Préstamo</th>
                    <th class="right-align">Monto</th>
                    <th class="right-align">Saldo</th>
                    <th>Fecha</th>
                    <th>Método</th>
                    <th>Código</th>
                    <th class="center-align">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                    <tr>
                        <td style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($loan['loan']) ?></td>
                        <td class="right-align accent-color-text" style="font-weight: 500;">
                            $<?= number_format($loan['amount'], 0, ",", ".") ?>
                        </td>
                        <td class="right-align error-color-text" style="font-weight: 700;">
                            $<?= number_format($loan['saldo'], 0, ",", ".") ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($loan['date'])) ?></td>
                        <td>
                            <span class="badge grey lighten-3 black-text" style="float: none; border-radius: 4px;">
                                <?= htmlspecialchars($loan['payment_method']) ?>
                            </span>
                        </td>
                        <td class="grey-text"><?= $loan['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($loan['code']) ?></td>
                        <td class="center-align">
                            <?php if ($loan['status'] === 'Pendiente'): ?>
                                <span class="badge red lighten-4 red-text text-darken-4" style="float: none; border-radius: 20px; padding: 0 12px; font-weight: 600;">Pendiente</span>
                            <?php else: ?>
                                <span class="badge green lighten-4 green-text text-darken-4" style="float: none; border-radius: 20px; padding: 0 12px; font-weight: 600;">Pagado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
include __DIR__ . '/partials/footer.php';
include __DIR__ . '/partials/scripts.php';
?>