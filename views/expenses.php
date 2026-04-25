<?php 
$title = "Gastos";
$useDataTables = true;
$pageTitle = "Gastos";
$pageIcon = "trending_down";
$navColor = "error-color";

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
                <div class="right-align">
                    <a href="#modalCreateExpense" class="btn error-color modal-trigger action-btn">
                        <i class="material-icons left">add</i> Nuevo Gasto
                    </a>
                    <a href="#modalCreateLoanPayment" class="btn loans-color modal-trigger action-btn">
                        <i class="material-icons left">add</i> Pago a Préstamo
                    </a>
                    <a href="?action=exportExpensesXls" class="btn reports-color action-btn">
                        <i class="material-icons left">file_download</i> Exportar XLS
                    </a>
                </div>
                <table id="expensesTable" class="striped display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Código</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($expense['date'])) ?></td>
                                <td><?= htmlspecialchars($expense['description']) ?></td>
                                <td>$<?= number_format($expense['amount'], 0, ",", ".") ?> COP</td>
                                <td><?= htmlspecialchars($expense['payment_method']) ?></td>
                                <td><?= $expense['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($expense['code']) ?></td>
                                <td>
                                    <a href="#modalEditExpense" class="btn-small blue modal-trigger"
                                        data-id="<?= $expense['id'] ?>
                                    " data-date="<?= date('d/m/Y', strtotime($expense['date'])) ?>"
                                        data-description="<?= htmlspecialchars($expense['description']) ?>"
                                        data-amount="<?= htmlspecialchars($expense['amount']) ?>"
                                        data-payment_method="<?= htmlspecialchars($expense['payment_method']) ?>"
                                        data-code="<?= htmlspecialchars($expense['code']) ?>">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a href="#modalDeleteExpense<?= $expense['id'] ?>" class="btn-small error-color modal-trigger">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </td>
                            </tr>
                            <div id="modalDeleteExpense<?= $expense['id'] ?>" class="modal">
                                <div class="modal-content center-align">
                                    <h5 class="error-color-text">
                                        <i class="material-icons left">delete</i> Eliminar Gasto
                                    </h5>
                                    <p>¿Seguro que deseas eliminar el ingreso <strong><?= htmlspecialchars($expense['description']) ?></strong> del <strong><?= date('d/m/Y', strtotime($expense['date'])) ?></strong>?</p>
                                    <form method="POST" action="?action=deleteExpense">
                                        <input type="hidden" name="id" value="<?= $expense['id'] ?>">
                                        <button type="submit" class="btn error-color">Eliminar</button>
                                        <a href="#!" class="modal-close btn grey">Cancelar</a>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal Crear Gasto -->
    <div id="modalCreateExpense" class="modal">
        <div class="modal-content">
            <h5 class="center-align error-color-text">
                <i class="material-icons left">add</i> Nuevo Gasto
            </h5>
            <form method="POST" action="?action=createExpense">
                <div class="input-field">
                    <input type="text" class="datepicker" name="date" value="<?= date('d/m/Y') ?>" required>
                    <label>Fecha</label>
                </div>
                <div class="input-field">
                    <input type="text" name="description" required>
                    <label>Descripción</label>
                </div>
                <div class="input-field">
                    <input type="text" name="amount" required>
                    <label>Monto (COP)</label>
                </div>
                <div class="input-field">
                    <select name="payment_method" required>
                        <option value="" disabled selected>Método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                    <label>Método de pago</label>
                </div>
                <div class="input-field">
                    <input type="text" name="code">
                    <label>Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn error-color">Guardar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Pago Préstamo-->
    <div id="modalCreateLoanPayment" class="modal">
        <div class="modal-content">
            <h5 class="center-align loans-color-text">
                <i class="material-icons left">add</i> Pago a Préstamo
            </h5>
            <form method="POST" action="?action=createExpense">
                <div class="input-field">
                    <select name="loan_id" required>
                        <option value="" disabled selected>Seleccione un préstamo</option>
                        <?php foreach ($loans as $loan): ?>
                            <option value="<?= $loan['id'] ?>"><?= $loan['loan'] ?> - $<?= number_format($loan['pendiente'], 0, ",", ".") ?> COP</option>
                        <?php endforeach ?>
                    </select>
                    <label>Método de pago</label>
                </div>
                <div class="input-field">
                    <input type="text" class="datepicker" name="date" value="<?= date('d/m/Y') ?>" required>
                    <label>Fecha</label>
                </div>
                <div class="input-field">
                    <input type="text" name="amount" required>
                    <label>Monto (COP)</label>
                </div>
                <div class="input-field">
                    <select name="payment_method" required>
                        <option value="" disabled selected>Método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                    <label>Método de pago</label>
                </div>
                <div class="input-field">
                    <input type="text" name="code">
                    <label>Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn loans-color">Guardar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Editar Gasto -->
    <div id="modalEditExpense" class="modal">
        <div class="modal-content">
            <h5 class="center-align error-color-text">
                <i class="material-icons left">edit</i> Editar Gasto
            </h5>
            <form method="POST" action="?action=updateExpense">
                <input type="hidden" name="id">
                <div class="input-field">
                    <input type="text" class="datepicker" name="date" required>
                    <label class="active">Fecha</label>
                </div>
                <div class="input-field">
                    <input type="text" name="description" required>
                    <label class="active">Descripción</label>
                </div>
                <div class="input-field">
                    <input type="text" name="amount" required>
                    <label class="active">Monto (COP)</label>
                </div>
                <!-- Hidden que sí se envía -->
                <input type="hidden" name="payment_method" id="payment_method_hidden">
                <div class="input-field">
                    <select id="modal_payment_method" required>
                        <option value="" disabled>Elige método</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                    <label>Método de pago</label>
                </div>
                <div class="input-field">
                    <input type="text" name="code">
                    <label class="active">Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn error-color">Actualizar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

<?php 
include __DIR__ . '/partials/footer.php'; 
include __DIR__ . '/partials/scripts.php'; 
?>