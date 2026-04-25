<?php 
$title = "Dashboard";
include __DIR__ . '/partials/header.php'; 
include __DIR__ . '/partials/navbar.php'; 
?>

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
            <a href="?action=loans" class="btn-large waves-effect waves-light loans-color">
                <i class="material-icons left">sync</i> Prestamos
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

        <!-- Totales -->
        <!-- Cuadro decorado -->
        <div class="dashboard-box">

            <div class="row totals-row">
                <div class="col s12 m4">
                    <div class="card-panel card-mini secondary-color lighten-2 white-text center-align">
                        Ingresos Totales: $<?= number_format($data['incomes'], 0, ",", ".") ?> COP
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="card-panel card-mini error-color lighten-2 white-text center-align">
                        Gastos Totales: $<?= number_format($data['expenses'], 0, ",", ".") ?> COP
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="card-panel card-mini accent-color lighten-2 white-text center-align">
                        Balance Neto: $<?= number_format($data['balance'], 0, ",", ".") ?> COP
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 
include __DIR__ . '/partials/footer.php'; 
include __DIR__ . '/partials/scripts.php'; 
?>