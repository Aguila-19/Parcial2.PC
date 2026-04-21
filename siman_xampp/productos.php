<?php
require 'config/db.php';
include 'includes/header.php';
$sql = "SELECT p.id, p.nombre, c.nombre AS categoria, p.precio, p.stock, p.estado, p.descripcion 
        FROM productos p 
        INNER JOIN categorias c ON p.categoria_id = c.id 
        ORDER BY c.nombre ASC, p.precio DESC";
$productos = $pdo->query($sql)->fetchAll();
?>
<div class="card">
    <h2>Catálogo de productos</h2>
    <p>Vista pública ordenada por categoría y precio.</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td><?= htmlspecialchars($p['stock']) ?></td>
                    <td><?= htmlspecialchars($p['estado']) ?></td>
                    <td><?= htmlspecialchars($p['descripcion'] ?: 'Sin descripción') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
