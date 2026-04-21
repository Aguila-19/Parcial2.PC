<?php include 'includes/header.php'; ?>
<section class="hero">
    <!-- LOGO ELIMINADO DE AQUÍ -->
    
    <h2>Sistema de Inventario y Catálogo Comercial</h2>
    <p>Aplicación web para <strong>Almacenes Siman</strong> orientada al registro y consulta de productos. Los visitantes pueden ver el catálogo y los usuarios autorizados pueden iniciar sesión para agregar datos al sistema.</p>
    <div class="actions">
        <a class="btn" href="productos.php">Ver catálogo</a>
        <a class="btn btn-secondary" href="login.php">Ingresar al sistema</a>
    </div>
</section>
<section class="grid">
    <article class="card">
        <h3>Función pública</h3>
        <p>Cualquier visitante puede ver los productos ordenados por categoría y precio.</p>
    </article>
    <article class="card">
        <h3>Función privada</h3>
        <p>Solo usuarios registrados pueden agregar productos y categorías nuevas.</p>
    </article>
    <article class="card">
        <h3>Validaciones</h3>
        <p>Se valida nombre, precio, stock, categoría, estado y formato de datos antes de guardar.</p>
    </article>
</section>
<?php include 'includes/footer.php'; ?>