    <!-- Barra superior con logo -->
    <nav class="primary-color">
        <div class="nav-wrapper nav-app">
            <div class="logo-app">
                <img src="../public/assets/logo.png" alt="BalanceUno" class="logo-img">
                <span class="app-name">Balance Uno</span>
            </div>
        </div>
    </nav>
    <?php if (isset($pageTitle)): ?>
    <nav class="<?= $navColor ?? 'secondary-color' ?>">
        <div class="nav-wrapper nav-app">
            <!-- Botón atrás -->
            <a href="?action=dashboard" class="btn-back">
                <i class="material-icons">arrow_back</i>
            </a>
            <!-- Título con icono -->
            <div class="title-app">
                <i class="material-icons"><?= $pageIcon ?? 'trending_up' ?></i>
                <h3><?= $pageTitle ?></h3>
            </div>
        </div>
    </nav>
    <?php endif; ?>
