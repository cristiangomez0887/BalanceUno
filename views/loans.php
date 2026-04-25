<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BalanceUno - Prestamos</title>
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
         <nav class="primary-color">
        <div class="nav-wrapper nav-app">
            <div class="logo-app">
                <img src="../public/assets/logo.png" alt="BalanceUno" class="logo-img">
                <span class="app-name">Balance Uno</span>
            </div>
        </div>
    </nav>
    <nav class="loans-color">
        <div class="nav-wrapper nav-app">
            <!-- Botón atrás -->
            <a href="?action=dashboard" class="btn-back">
                <i class="material-icons">arrow_back</i>
            </a>
            <!-- Título con icono -->
            <div class="title-app">
                <i class="material-icons">sync</i>
                <h3>Prestamos</h3>
            </div>
        </div>
    </nav>
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