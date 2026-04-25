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
                    <th class="center-align">Acciones</th>
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
                        <td class="center-align">
                            <a href="#modalEditLoan" class="btn-flat waves-effect modal-trigger" style="color: var(--info);"
                                data-id="<?= $loan['id'] ?>"
                                data-date="<?= date('d/m/Y', strtotime($loan['date'])) ?>"
                                data-loan="<?= htmlspecialchars($loan['loan']) ?>"
                                data-amount="<?= htmlspecialchars($loan['amount']) ?>"
                                data-payment_method="<?= htmlspecialchars($loan['payment_method']) ?>"
                                data-code="<?= htmlspecialchars($loan['code']) ?>">
                                <i class="material-icons">edit</i>
                            </a>
                            <a href="#modalDeleteLoan<?= $loan['id'] ?>" class="btn-flat waves-effect modal-trigger" style="color: var(--error);">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>
                    <!-- Modal Eliminar Préstamo -->
                    <div id="modalDeleteLoan<?= $loan['id'] ?>" class="modal">
                        <div class="modal-content center-align">
                            <div style="background: #fee2e2; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="material-icons error-color-text" style="font-size: 35px;">warning</i>
                            </div>
                            <h5 style="font-weight: 700;">¿Eliminar Préstamo?</h5>
                            <p class="grey-text">Estás a punto de borrar: <br><strong><?= htmlspecialchars($loan['loan']) ?></strong></p>
                            <p class="error-color-text" style="font-size: 0.9rem;">Nota: Solo se puede eliminar si no tiene pagos registrados.</p>
                            <form method="POST" action="?action=deleteLoan" style="margin-top: 30px;">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="id" value="<?= $loan['id'] ?>">
                                <button type="submit" class="btn error-color">Confirmar Eliminación</button>
                                <a href="#!" class="modal-close btn-flat grey-text">Cancelar</a>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Editar Préstamo -->
<div id="modalEditLoan" class="modal">
    <div class="modal-content">
        <h5 class="center-align loans-color-text">
            <i class="material-icons left">edit</i> Editar Préstamo
        </h5>
        <form method="POST" action="?action=updateLoan">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id">
            <input type="hidden" name="loan"> <!-- Mantener el código del préstamo -->
            <div class="input-field">
                <input type="text" class="datepicker" name="date" required>
                <label class="active">Fecha</label>
            </div>
            <div class="input-field">
                <input type="text" name="amount" required>
                <label class="active">Monto Inicial (COP)</label>
            </div>
            <input type="hidden" name="payment_method" id="loan_payment_method_hidden">
            <div class="input-field">
                <select id="modal_loan_payment_method" required>
                    <option value="" disabled>Elige método</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Nequi">Nequi</option>
                    <option value="Transferencia">Transferencia</option>
                </select>
                <label>Método de ingreso original</label>
            </div>
            <div class="input-field">
                <input type="text" name="code">
                <label class="active">Código (Nequi o Transferencia)</label>
            </div>
            <div class="center-align">
                <button type="submit" class="btn loans-color">Actualizar</button>
                <a href="#!" class="modal-close btn grey">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php
include __DIR__ . '/partials/footer.php';
include __DIR__ . '/partials/scripts.php';
?>