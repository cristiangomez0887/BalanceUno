<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BalanceUno - Gastos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
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
    <nav class="red">
        <div class="nav-wrapper center-align">
            <h3 class="center-align white-text">
                <i class="material-icons left">trending_down</i> Gastos
            </h3>
        </div>
    </nav>
    <!-- Card con tabla de ingresos -->
    <div class="card">
        <div class="card-content">
            <div class="right-align">
                <a href="#modalCreateExpense" class="btn red modal-trigger">
                    <i class="material-icons left">add</i> Nuevo Gasto
                </a>
                <a href="?action=exportExpensesXls" class="btn green">
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
                                <a href="#modalDeleteExpense<?= $expense['id'] ?>" class="btn-small red modal-trigger">
                                    <i class="material-icons">delete</i>
                                </a>
                            </td>
                        </tr>
                        <div id="modalDeleteExpense<?= $expense['id'] ?>" class="modal">
                            <div class="modal-content center-align">
                                <h5 class="red-text">
                                    <i class="material-icons left">delete</i> Eliminar Gasto
                                </h5>
                                <p>¿Seguro que deseas eliminar el ingreso <strong><?= htmlspecialchars($expense['description']) ?></strong> del <strong><?= date('d/m/Y', strtotime($expense['date'])) ?></strong>?</p>
                                <form method="POST" action="?action=deleteExpense">
                                    <input type="hidden" name="id" value="<?= $expense['id'] ?>">
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

    <!-- Modal Crear Gasto -->
    <div id="modalCreateExpense" class="modal">
        <div class="modal-content">
            <h5 class="center-align red-text">
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
                    <input type="number" name="amount" step="0.01" required>
                    <label>Monto (COP)</label>
                </div>
                <div class="input-field">
                    <select name="payment_method" required>
                        <option value="" disabled selected>Método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Prestamo">Prestamo</option>
                    </select>
                    <label>Método de pago</label>
                </div>
                <div class="input-field">
                    <input type="text" name="code">
                    <label>Código (Nequi o Transferencia)</label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn red">Guardar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Gasto -->
    <div id="modalEditExpense" class="modal">
        <div class="modal-content">
            <h5 class="center-align red-text">
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


                <div class="input-field">
                    <input type="text" name="code">
                    <label class="active">Código (Nequi o Transferencia)</label>
                </div>

                <div class="center-align">
                    <button type="submit" class="btn red">Actualizar</button>
                    <a href="#!" class="modal-close btn grey">Cancelar</a>
                </div>
            </form>
        </div>
    </div>




    <!-- Footer -->
    <footer class="page-footer red">
        <div class="container center-align">
            © 2026 BalanceUno — Hecho con amor 💙
        </div>
    </footer>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            // Tooltips
            $('.tooltipped').tooltip();
            //inicializar selects
            $('select').formSelect();
            // Inicializar modales
            $('.modal').modal({
                onOpenStart: function(modal, trigger) {
                    //evitar que los datos carguen al mismo tiempo que los labels, lo que hace que se oculten
                    setTimeout(function() {
                        M.updateTextFields();
                    }, 100);

                    if (modal.id === 'modalEditExpense') {
                        // Obtener datos del botón
                        var id = $(trigger).data('id');
                        var date = $(trigger).data('date');
                        var description = $(trigger).data('description');
                        var amount = $(trigger).data('amount');
                        var payment_method = $(trigger).data('payment_method');
                        var code = $(trigger).data('code');

                        // Rellenar el formulario
                        $('#modalEditExpense input[name="id"]').val(id);
                        $('#modalEditExpense input[name="date"]').val(date);
                        $('#modalEditExpense input[name="description"]').val(description);
                        $('#modalEditExpense input[name="amount"]').val(amount);
                        // 👇 Truco: marcar el option correcto ANTES de refrescar
                        $('#modal_payment_method option').prop('selected', false); // limpiar
                        $('#modal_payment_method option[value="' + payment_method + '"]').prop('selected', true);

                        // Refrescar Materialize
                        $('#modal_payment_method').formSelect();

                        $('#modalEditExpense input[name="code"]').val(code);
                    }
                }
            });

            // Antes de enviar, copiar el valor del select al hidden
            $('#modalEditExpense .modal-content form').on('submit', function() {
                const val = $('#modal_payment_method').val();
                $('#payment_method_hidden').val(val);
                console.log("Enviando al backend:", val);
            });


            // Inicializar datepicker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoClose: true,
                container: 'body',
                color: 'red',
                i18n: {
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                    cancel: 'Cancelar',
                    clear: 'Limpiar',
                    done: 'Aceptar'
                }
            });

            // Inicializar DataTable
            $('#expensesTable').DataTable({
                responsive: true,
                pageLength: 10,
                dom: 'frtip', // sin selector de cantidad de registros
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0,
                        className: 'dt-body-center'
                    }, // Fecha
                    {
                        responsivePriority: 2,
                        targets: 2,
                        className: 'dt-body-right'
                    }, // Monto
                    {
                        responsivePriority: 3,
                        targets: -1,
                        orderable: false,
                        searchable: false,
                    } // Acciones
                ]
            });
        });
    </script>
</body>

</html>