<?php
session_start();
require 'config/db.php';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if ($correo === '' || $clave === '') {
        $mensaje = '<div class="alert error">Todos los campos son obligatorios.</div>';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = '<div class="alert error">Ingrese un correo válido.</div>';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE correo = ? LIMIT 1');
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header('Location: dashboard.php');
            exit;
        } else {
            $mensaje = '<div class="alert error">Credenciales incorrectas.</div>';
        }
    }
}
include 'includes/header.php';
?>
<form method="POST" action="">
    <h2>Inicio de sesión</h2>
    <?= $mensaje ?>
    <label for="correo">Correo</label>
    <input type="email" id="correo" name="correo" required>

    <label for="clave">Contraseña</label>
    <input type="password" id="clave" name="clave" required>

    <button class="btn" type="submit">Entrar</button>
    <p class="small muted">Usuario de prueba: admin@siman.com | Contraseña: Admin123*</p>
</form>
<?php include 'includes/footer.php'; ?>
