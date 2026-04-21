<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Comercial Siman</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="logo-titulo">
    <img src="img/logo.jpeg" alt="Logo Siman" class="logo-navbar">
    <h1>Almacenes Siman</h1>
</div>
    <div class="container nav">
        
        <nav>
            <a href="index.php">Inicio</a>
            <a href="productos.php">Catálogo</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="dashboard.php">Panel</a>
                <a href="logout.php">Salir</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
