    <!-- Barra superior principal -->
    <nav class="primary-color">
        <div class="nav-wrapper nav-app">
            <div class="logo-app">
                <img src="../public/assets/logo.png" alt="BalanceUno" class="logo-img">
                <span class="app-name">Balance Uno</span>
            </div>
            <ul class="right hide-on-med-and-down">
                <li><span style="margin-right: 20px; font-weight: 500;"><i class="material-icons left">account_circle</i><?= $_SESSION['username'] ?? 'Usuario' ?></span></li>
                <li><a href="?action=logout" class="btn waves-effect waves-light secondary-color"><i class="material-icons left">exit_to_app</i>Cerrar Sesión</a></li>
            </ul>
            <!-- Botón logout solo icono para móviles -->
            <ul class="right hide-on-large-only">
                <li><a href="?action=logout" class="white-text"><i class="material-icons">exit_to_app</i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Sub-barra de navegación / Título de página -->
    <?php if (isset($pageTitle)): ?>
    <nav class="<?= $navColor ?? 'secondary-color' ?>">
        <div class="nav-wrapper nav-app">
            <a href="?action=dashboard" class="btn-back">
                <i class="material-icons">arrow_back</i>
            </a>
            <div class="title-app">
                <i class="material-icons"><?= $pageIcon ?? 'trending_up' ?></i>
                <h3><?= $pageTitle ?></h3>
            </div>
            <!-- Espaciador para mantener el título centrado -->
            <div style="width: 48px;" class="hide-on-small-only"></div>
        </div>
    </nav>
    <?php endif; ?>
