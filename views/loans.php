<?php 
$title = "Prestamos";
$useDataTables = true;
$pageTitle = "Prestamos";
$pageIcon = "sync";
$navColor = "loans-color";

$extraStyles = '
<style>
    .modal { max-height: 90% !important; overflow-y: auto !important; }
    @media only screen and (max-width: 480px) {
        .modal { width: 100% !important; height: 100% !important; top: 0 !important; margin: 0 !important; border-radius: 0 !important; max-height: 100% !important; }
        .modal .modal-content { overflow-y: auto !important; }
    }
</style>';

include __DIR__ . '/partials/header.php'; 
include __DIR__ . '/partials/navbar.php'; 
?>

    <section id="main">
        <!-- Card con tabla de ingresos -->
        <div class="card">
            <div class="card-content">
                <table id="loansTable" class="striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Préstamo</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                            <th>Fecha</th>
                            <th>Método</th>
                            <th>Código</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loans as $loan): ?>
                            <tr>
                                <td><?= $loan['loan'] ?></td>
                                <td>$<?= number_format($loan['amount'], 0, ",", ".") ?> COP</td>
                                <td>$<?= number_format($loan['saldo'], 0, ",", ".") ?> COP</td>
                                <td><?= date('d/m/Y', strtotime($loan['date'])) ?></td>
                                <td><?= htmlspecialchars($loan['payment_method']) ?></td>
                                <td><?= $loan['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($loan['code']) ?></td>
                                <td><?= $loan['status'] === 'Pendiente' ? '🔴' : '✅' ?></td>
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