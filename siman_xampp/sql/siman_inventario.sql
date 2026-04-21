CREATE DATABASE IF NOT EXISTS siman_inventario CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE siman_inventario;

DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL,
    correo VARCHAR(80) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'admin'
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    area VARCHAR(50) NOT NULL,
    activo ENUM('Sí','No') NOT NULL DEFAULT 'Sí',
    observacion VARCHAR(120) NULL
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    categoria_id INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    estado ENUM('Disponible','Agotado') NOT NULL,
    destacado ENUM('Sí','No') NOT NULL DEFAULT 'No',
    descripcion VARCHAR(150) NULL,
    CONSTRAINT fk_productos_categorias FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO usuarios (nombre, correo, clave, rol) VALUES
('Administrador Siman', 'admin@siman.com', '$2y$12$aCVsOjHhIY.G6X.WOBzYNOTSPeZ3Cv0T6U7eyrUgNjwaQHp61aFW2', 'admin');
-- Contraseña: Admin123*

INSERT INTO categorias (nombre, area, activo, observacion) VALUES
('Electrodomésticos', 'Hogar', 'Sí', 'Productos de cocina y limpieza'),
('Tecnología', 'Electrónica', 'Sí', 'Área de dispositivos y accesorios'),
('Moda', 'Ropa', 'Sí', NULL),
('Muebles', 'Hogar', 'Sí', 'Línea para sala y dormitorio'),
('Deportes', 'Bienestar', 'Sí', NULL);

INSERT INTO productos (nombre, categoria_id, precio, stock, estado, destacado, descripcion) VALUES
('Licuadora Oster 10 velocidades', 1, 69.99, 12, 'Disponible', 'Sí', 'Ideal para uso doméstico'),
('Smart TV Samsung 43 pulgadas', 2, 399.00, 6, 'Disponible', 'Sí', 'Pantalla Full HD'),
('Camisa formal para caballero', 3, 24.50, 20, 'Disponible', 'No', NULL),
('Sofá de tres plazas', 4, 550.00, 2, 'Disponible', 'No', 'Color gris oscuro'),
('Bicicleta estática', 5, 210.00, 0, 'Agotado', 'Sí', 'Equipo para ejercicio en casa');
