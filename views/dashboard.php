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
</head>

<body class="container">

    <!-- Barra superior con logo -->
    <nav class="teal">
        <div class="nav-wrapper center-align">
            <a href="?action=dashboard" class="brand-logo">
                <img src="assets/logo.png" alt="BalanceUno" style="height:50px; vertical-align:middle;">
                BalanceUno
            </a>
        </div>
    </nav>

    <!-- Botones grandes estilo app -->
    <div class="section center-align">
        <a href="?action=incomes" class="btn-large waves-effect waves-light orange">
            <i class="material-icons left">trending_up</i> Ingresos
        </a>
    </div>

    <div class="section center-align">
        <a href="?action=expenses" class="btn-large waves-effect waves-light red">
            <i class="material-icons left">trending_down</i> Gastos
        </a>
    </div>

    <div class="section center-align">
        <a href="?action=movements" class="btn-large waves-effect waves-light grey darken-1">
            <i class="material-icons left">list</i> Movimientos
        </a>
    </div>

    <div class="section center-align">
        <a href="?action=reports" class="btn-large waves-effect waves-light blue">
            <i class="material-icons left">bar_chart</i> Reportes
        </a>
    </div>

    <!-- Footer -->
    <footer class="page-footer teal">
        <div class="container center-align">
            © 2026 BalanceUno — Hecho con amor 💙
        </div>
    </footer>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>