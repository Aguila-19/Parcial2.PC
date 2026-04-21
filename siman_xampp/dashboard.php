<?php
require 'includes/auth.php';
requireLogin();
require 'config/db.php';

$mensaje = '';
$errores = [];
$categorias = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $categoria_id = $_POST['categoria_id'] ?? '';
    $precio = trim($_POST['precio'] ?? '');
    $stock = trim($_POST['stock'] ?? '');
    $estado = $_POST['estado'] ?? '';
    $destacado = isset($_POST['destacado']) ? 'Sí' : 'No';
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($nombre === '' || mb_strlen($nombre) < 3) {
        $errores[] = 'El nombre debe tener al menos 3 caracteres.';
    }
    if (!ctype_digit($categoria_id)) {
        $errores[] = 'Debe seleccionar una categoría válida.';
    }
    if ($precio === '' || !is_numeric($precio) || $precio <= 0) {
        $errores[] = 'El precio debe ser numérico y mayor que cero.';
    }
    if ($stock === '' || !ctype_digit($stock)) {
        $errores[] = 'El stock debe ser un número entero.';
    }
    if (!in_array($estado, ['Disponible', 'Agotado'], true)) {
        $errores[] = 'Seleccione un estado válido.';
    }
    if ($descripcion !== '' && mb_strlen($descripcion) > 150) {
        $errores[] = 'La descripción no puede exceder 150 caracteres.';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare('INSERT INTO productos (nombre, categoria_id, precio, stock, estado, destacado, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $categoria_id, $precio, $stock, $estado, $destacado, $descripcion !== '' ? $descripcion : null]);
        $mensaje = '<div class="alert success">Producto guardado correctamente.</div>';
    } else {
        $mensaje = '<div class="alert error"><ul><li>' . implode('</li><li>', $errores) . '</li></ul></div>';
    }
}

$productos = $pdo->query("SELECT p.id, p.nombre, c.nombre AS categoria, p.precio, p.stock, p.estado, p.destacado, p.descripcion FROM productos p INNER JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC")->fetchAll();
include 'includes/header.php';
?>
<div class="card">
    
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></h2>

    <p>Desde este panel puedes registrar productos nuevos.</p>
</div>
<form method="POST" action="">
    <h2>Agregar producto</h2>
    <?= $mensaje ?>

    <label for="nombre">Nombre del producto</label>
    <input type="text" id="nombre" name="nombre" maxlength="80" required>

    <label for="categoria_id">Categoría</label>
    <select id="categoria_id" name="categoria_id" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="precio">Precio</label>
    <input type="number" step="0.01" min="0.01" id="precio" name="precio" required>

    <label for="stock">Stock</label>
    <input type="number" min="0" id="stock" name="stock" required>

    <label>Estado</label>
    <div class="radio-group">
        <label><input type="radio" name="estado" value="Disponible" required> Disponible</label>
        <label><input type="radio" name="estado" value="Agotado"> Agotado</label>
    </div>

    <label class="check-group"><input type="checkbox" name="destacado"> Marcar como producto destacado</label>

    <label for="descripcion">Descripción (opcional)</label>
    <textarea id="descripcion" name="descripcion" maxlength="150"></textarea>

    <button class="btn" type="submit">Guardar producto</button>
</form>

<div class="card">
    <h2>Productos registrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Destacado</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= htmlspecialchars($p['estado']) ?></td>
                    <td><?= htmlspecialchars($p['destacado']) ?></td>
                    <td><?= htmlspecialchars($p['descripcion'] ?: 'Sin descripción') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
