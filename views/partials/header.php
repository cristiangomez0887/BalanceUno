<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BalanceUno - <?= $title ?? 'Control Financiero' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php if (isset($useDataTables) && $useDataTables): ?>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <?php endif; ?>
    <link rel="stylesheet" href="../public/css/custom.css">
    <?php if (isset($extraStyles)) echo $extraStyles; ?>
</head>
<body class="container">
