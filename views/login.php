<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BalanceUno</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background: #f5f5f5;
        }
        main {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .brand-logo {
            font-size: 2rem;
            font-weight: bold;
            color: #26a69a;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <main>
        <div class="login-box z-depth-2">
            <div class="center-align">
                <div class="brand-logo">BalanceUno</div>
                <h5 class="grey-text text-darken-2">Iniciar Sesión</h5>
            </div>

            <?php if (isset($error)): ?>
                <div class="card-panel red lighten-4 red-text text-darken-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="?action=doLogin" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input id="username" name="username" type="text" required>
                    <label for="username">Usuario</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">lock</i>
                    <input id="password" name="password" type="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <div class="center-align" style="margin-top: 30px;">
                    <button type="submit" class="btn-large waves-effect waves-light teal" style="width: 100%;">
                        Ingresar
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
