# Parcial2.PC

## estudiantes
 David Alfonso Alvarenga bonilla.
 Fredys Alejandro Hernandez Robles.


# Sistema Comercial Siman - PHP + MySQL + XAMPP
## Descripción del proyecto
Este proyecto consiste en una app web para *Almacenes Siman*, empresa comercial real, orientada al registro y consulta de productos. La aplicación permite que cualquier visitante visualice el catálogo de productos, pero únicamente un usuario registrado puede iniciar sesión para agregar nuevos productos al sistema.

## Requisitos cumplidos
- Empresa real del país con enfoque comercial.
- Dos tablas principales con cuatro o más campos: categorias y productos.
- Campo nulo: observacion en categorias y descripcion en productos.
- Login para restringir el ingreso de datos.
- Vista pública de datos ordenados.
- Validaciones en formularios.
- Al menos cinco registros en las tablas.
- Uso de select, radio y checkbox.
- Estilos CSS personalizados.

## Cómo ejecutar en XAMPP
1. Copiar la carpeta del proyecto dentro de htdocs con el nombre siman_xampp.
2. Abrir XAMPP y encender *Apache* y *MySQL*.
3. Entrar a *phpMyAdmin*.
4. Crear una base de datos importando el archivo sql/siman_inventario.sql.
5. Abrir en el navegador: http://localhost/siman_xampp/
6. Para entrar al sistema usar:
   - Correo: admin@siman.com
   - Contraseña: Admin123*
   - la contraseña mantiene el * al final

## Respuestas solicitadas

### ¿Cómo manejan la conexión a la BD y qué pasa si algunos de los datos son incorrectos? Justifiquen la manera de validación de la conexión.
La conexión se maneja con *PDO* en el archivo config/db.php. Se usa un bloque try...catch para detectar errores de conexión y mostrar un mensaje claro si la base de datos no responde o si el nombre de la base, el usuario o la contraseña son incorrectos. Esta forma es adecuada porque evita que la aplicación continúe funcionando con una conexión inválida. Además, PDO permite usar consultas preparadas, lo cual reduce riesgos de seguridad y mejora el manejo de errores.

Cuando algunos datos son incorrectos, el sistema no los guarda. Primero se validan en PHP antes de hacer el INSERT. Por ejemplo, se comprueba que el nombre tenga al menos 3 caracteres, que el precio sea numérico y mayor que 0, que el stock sea entero, que la categoría exista y que el estado tenga un valor permitido. Si algo falla, se muestra un mensaje de error al usuario.

### ¿Cuál es la diferencia entre $_GET y $_POST en PHP? ¿Cuándo es más apropiado usar cada uno? Da un ejemplo real de tu proyecto.
$_GET envía los datos por la URL, por eso se usa más cuando solo se desea consultar o filtrar información. $_POST envía los datos de forma no visible en la URL y es más apropiado cuando se van a mandar datos sensibles o cuando se insertarán registros.

En este proyecto, $_POST se usa en el *login* y en el formulario para *agregar productos*, porque ahí se envían credenciales y datos que terminan guardándose en la base de datos. Un ejemplo de $_GET en este proyecto podría ser filtrar productos por categoría desde la URL, por ejemplo: productos.php?categoria=2.

### Tu app va a usarse en una empresa de la zona oriental. ¿Qué riesgos de seguridad identificas en una app web con BD que maneja datos de los usuarios? ¿Cómo los mitigarían?
Uno de los principales riesgos es la *inyección SQL, donde un usuario intenta alterar consultas para acceder o modificar datos. Esto se mitiga usando **consultas preparadas con PDO*.

Otro riesgo es el *acceso no autorizado, especialmente si cualquier persona pudiera entrar al panel administrativo. Para reducirlo, se implementó **inicio de sesión con contraseña cifrada con password_hash* y control de sesión para restringir el acceso.

También existe riesgo de *XSS*, es decir, que un usuario intente insertar código malicioso en formularios. Esto se mitiga mostrando los datos con htmlspecialchars().

Además, hay riesgo de *errores por entradas inválidas*, como precios negativos o textos demasiado largos. Para eso se usan validaciones de tipo, longitud y obligatoriedad antes de guardar.

Finalmente, en un entorno real también sería importante aplicar *roles de usuario, cierre de sesión por tiempo de inactividad, HTTPS y respaldos periódicos*.

## Diccionario de datos

### Tabla: usuarios
| Columna | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción                        |
|---------|--------------|----------------------|-----------|------------------------------------|
| id      | INT          | 11                   | No        | Identificador único del usuario    |
| nombre  | VARCHAR      | 60                   | No        | Nombre del usuario administrador   |
| correo  | VARCHAR      | 80                   | No        | Correo usado para iniciar sesión   |
| clave   | VARCHAR      | 255                  | No        | Contraseña cifrada del usuario     |
| rol     | VARCHAR      | 20                   | No        | Tipo de usuario dentro del sistema |
### Tabla: categorias
| Columna     | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción                          |
|-------------|--------------|----------------------|-----------|--------------------------------------|
| id          | INT          | 11                   | No        | Identificador de la categoría        |
| nombre      | VARCHAR      | 50                   | No        | Nombre de la categoría               |
| area        | VARCHAR      | 50                   | No        | Área comercial a la que pertenece    |
| activo      | ENUM         | 2 valores            | No        | Indica si la categoría está activa   |
| observacion | VARCHAR      | 120                  | Sí        | Comentario adicional de la categoría |
### Tabla: productos
| Columna      | Tipo de dato | Límite de caracteres | ¿Es nulo? | Descripción                      |
|--------------|--------------|----------------------|-----------|----------------------------------|
| id           | INT          | 11                   | No        | Identificador del producto       |
| nombre       | VARCHAR      | 80                   | No        | Nombre del producto              |
| categoria_id | INT          | 11                   | No        | Relación con la tabla categorías |
| precio       | DECIMAL      | 10,2                 | No        | Precio de venta del producto     |
| stock        | INT          | 11                   | No        | Cantidad disponible              |
| estado       | ENUM         | 2 valores            | No        | Estado del producto              |
| destacado    | ENUM         | 2 valores            | No        | Indica si es producto destacado  |
| descripcion  | VARCHAR      | 150                  | Sí        | Detalle opcional del producto    |

