<?php
$title = "Dashboard";
include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/navbar.php';
?>

<section id="main" class="container">
    <!-- Resumen de Totales en la parte superior -->
    <div class="row totals-row">
        <div class="col s12 m4">
            <div class="card-panel accent-color white-text">
                <p>Balance Neto</p>
                <h5>$<?= number_format($data['balance'], 0, ",", ".") ?></h5>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card-panel secondary-color white-text">
                <p>Ingresos</p>
                <h5>$<?= number_format($data['incomes'], 0, ",", ".") ?></h5>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card-panel error-color white-text">
                <p>Gastos</p>
                <h5>$<?= number_format($data['expenses'], 0, ",", ".") ?></h5>
            </div>
        </div>
    </div>

    <!-- Menú de Acciones en Grid -->
    <div class="dashboard-box">
        <h5 class="center-align" style="margin-bottom: 30px; font-weight: 600; color: var(--text-muted);">Accesos Rápidos</h5>
        <div class="row">
            <div class="col s12 m6 l4">
                <a href="?action=incomes" class="card-panel waves-effect waves-block white center-align action-card" style="display: block; color: var(--text-main);">
                    <i class="material-icons secondary-color-text" style="font-size: 3rem;">trending_up</i>
                    <h6 style="font-weight: 600;">Ingresos</h6>
                    <p class="grey-text" style="font-size: 0.8rem;">Registrar entradas de dinero</p>
                </a>
            </div>
            <div class="col s12 m6 l4">
                <a href="?action=expenses" class="card-panel waves-effect waves-block white center-align action-card" style="display: block; color: var(--text-main);">
                    <i class="material-icons error-color-text" style="font-size: 3rem;">trending_down</i>
                    <h6 style="font-weight: 600;">Gastos</h6>
                    <p class="grey-text" style="font-size: 0.8rem;">Controlar salidas y pagos</p>
                </a>
            </div>
            <div class="col s12 m6 l4">
                <a href="?action=loans" class="card-panel waves-effect waves-block white center-align action-card" style="display: block; color: var(--text-main);">
                    <i class="material-icons loans-color-text" style="font-size: 3rem;">sync</i>
                    <h6 style="font-weight: 600;">Préstamos</h6>
                    <p class="grey-text" style="font-size: 0.8rem;">Gestionar deudas y cuotas</p>
                </a>
            </div>
            <div class="col s12 m6 l4">
                <a href="?action=balance" class="card-panel waves-effect waves-block white center-align action-card" style="display: block; color: var(--text-main);">
                    <i class="material-icons accent-color-text" style="font-size: 3rem;">assessment</i>
                    <h6 style="font-weight: 600;">Balance</h6>
                    <p class="grey-text" style="font-size: 0.8rem;">Estado actual de cuentas</p>
                </a>
            </div>
            <div class="col s12 m6 l4">
                <a href="?action=reports" class="card-panel waves-effect waves-block white center-align action-card" style="display: block; color: var(--text-main);">
                    <i class="material-icons reports-color-text" style="font-size: 3rem;">bar_chart</i>
                    <h6 style="font-weight: 600;">Reportes</h6>
                    <p class="grey-text" style="font-size: 0.8rem;">Análisis detallado mensual</p>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
include __DIR__ . '/partials/footer.php';
include __DIR__ . '/partials/scripts.php';
?>