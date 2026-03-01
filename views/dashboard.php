<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BalanceUno - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/custom.css">
</head>

<body class="container">
    <!-- Barra superior con logo -->
    <nav class="primary-color">
        <div class="nav-wrapper nav-app">
            <div class="logo-app">
                <img src="../public/assets/logo.png" alt="BalanceUno" class="logo-img">
                <span class="app-name">Balance Uno</span>
            </div>
        </div>
    </nav>
    <!-- Botones grandes estilo app -->
    <section id="main">
        <div class="section center-align">
            <a href="?action=incomes" class="btn-large waves-effect waves-light secondary-color">
                <i class="material-icons left">trending_up</i> Ingresos
            </a>
        </div>
        <div class="section center-align">
            <a href="?action=expenses" class="btn-large waves-effect waves-light error-color">
                <i class="material-icons left">trending_down</i> Gastos
            </a>
        </div>
        <div class="section center-align">
            <a href="?action=balance" class="btn-large waves-effect waves-light accent-color">
                <i class="material-icons left">assessment</i> Balance
            </a>
        </div>
        <div class="section center-align">
            <a href="?action=reports" class="btn-large waves-effect waves-light reports-color">
                <i class="material-icons left">bar_chart</i> Reportes
            </a>
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
</body>

</html>