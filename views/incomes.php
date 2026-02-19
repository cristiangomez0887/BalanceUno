<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BalanceUno - Ingresos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/custom.css">
    <style>
        /* Ajuste general: modal más alto y scroll interno */
        .modal {
            max-height: 90% !important;
            overflow-y: auto !important;
        }

        /* En móviles: fullscreen para evitar scroll incómodo */
        @media only screen and (max-width: 480px) {
            .modal {
                width: 100% !important;
                height: 100% !important;
                top: 0 !important;
                margin: 0 !important;
                border-radius: 0 !important;
                max-height: 100% !important;
            }

            .modal .modal-content {
                overflow-y: auto !important;
            }
        }
    </style>
</head>

<body class="container">
    <!-- Barra superior -->
    <nav class="secondary-color">
        <div class="nav-wrapper nav-app">
            <!-- Botón atrás -->
            <a href="?action=dashboard" class="btn-back">
                <i class="material-icons">arrow_back</i>
            </a>

            <!-- Título con icono -->
            <div class="title-app">
                <i class="material-icons">trending_up</i>
                <h3>Ingresos</h3>
            </div>
        </div>
    </nav>
    <!-- Card con tabla de ingresos -->
    <div class="card">
        <div class="card-content">
            <div class="right-align">
                <a href="#modalCreateIncome" class="btn secondary-color modal-trigger action-btn">
                    <i class="material-icons left">add</i> Nuevo Ingreso
                </a>
                <a href="?action=exportIncomesXls" class="btn reports-color action-btn">
                    <i class="material-icons left">file_download</i> Exportar XLS
                </a>
            </div>
            <table id="incomesTable" class="striped display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th class="col-monto">Monto</th>
                        <th>Método</th>
                        <th>Código</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incomes as $income): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($income['date'])) ?></td>
                            <td><?= htmlspecialchars($income['description']) ?></td>
                            <td>$<?= number_format($income['amount'], 0, ",", ".") ?> COP</td>
                            <td><?= htmlspecialchars($income['payment_method']) ?></td>
                            <td><?= $income['payment_method'] === 'Efectivo' ? '-' : htmlspecialchars($income['code']) ?></td>
                            <td>
                                <a href="#modalEditIncome" class="btn-small blue modal-trigger"
                                    data-id="<?= $income['id'] ?>
                                    " data-date="<?= date('d/m/Y', strtotime($income['date'])) ?>"
                                    data-description="<?= htmlspecialchars($income['description']) ?>"
                                    data-amount="<?= htmlspecialchars($income['amount']) ?>"
                                    data-payment_method="<?= htmlspecialchars($income['payment_method']) ?>"
                                    data-code="<?= htmlspecialchars($income['code']) ?>">
                                    <i class="material-icons">edit</i>
                                </a>
                                <a href="#modalDeleteIncome<?= $income['id'] ?>" class="btn-small red modal-trigger">
                                    <i class="material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                        <div id="modalDeleteIncome<?= $income['id'] ?>" class="modal">
                            <div class="modal-content center-align">
                                <h5 class="red-text">
                                    <i class="material-icons left">delete</i> Eliminar Ingreso
                                </h5>
                                <p>¿Seguro que deseas eliminar el ingreso <strong><?= htmlspecialchars($income['description']) ?></strong> del <strong><?= date('d/m/Y', strtotime($income['date'])) ?></strong>?</p>
                                <form method="POST" action="?action=deleteIncome">
                                    <input type="hidden" name="id" value="<?= $income['id'] ?>">
                                    <button type="submit" class="btn red">Eliminar</button>
                                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Crear Ingreso -->
    <div id="modalCreateIncome" class="modal">
        <div class="modal-content">
            <h5 class="center-align secondary-color-text">
                <i class="material-icons left">add</i> Nuevo Ingreso
            </h5>
            <form method="POST" action="?action=createIncome">
                <div class="input-field">
                    <input type="text" class="datepicker" name="date" value="<?= date('d/m/Y') ?>" required>
                    <label>Fecha</label>
                </div>
                <div class="input-field">
                    <input type="text" name="description" required>
                    <label>Descripción</label>
                </div>
                <div class="input-field">
                    <input type="number" name="amount" step="0.01" required>
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
                <div class="input-field" style="z-index: 99 !important;">
                    <input type="text" name="code" style="z-index: 99 !important;">
                    <label>Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn secondary-color">Guardar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Editar Ingreso -->
    <div id="modalEditIncome" class="modal">
        <div class="modal-content">
            <h5 class="center-align secondary-color-text">
                <i class="material-icons left">edit</i> Editar Ingreso
            </h5>
            <form method="POST" action="?action=updateIncome">
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
                    <input type="number" name="amount" step="0.01" required>
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
                <div class="input-field" style="z-index: 99 !important;">
                    <input type="text" name="code" style="z-index: 99 !important;">
                    <label class="active">Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn secondary-color">Actualizar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="page-footer primary-color">
        <div class="container center-align">
            © 2026 BalanceUno — Hecho con ❤️
        </div>
    </footer>
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="../public/js/init.js"></script>
</body>

</html>