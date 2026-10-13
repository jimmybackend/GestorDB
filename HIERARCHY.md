# Jerarquía dinámica PK/FK de GestorDB

La aplicación inicia en `index.php` y redirige a `dashboard.php`. `main05.php` se carga en cada visita y construye su menú consultando las tablas reales. `SchemaHierarchy.php` utiliza `information_schema`: columnas, PK y relaciones FOREIGN KEY declaradas en MySQL. Las tablas maestras sin padres se muestran en nivel 0 y sus descendientes en niveles 1, 2, 3... Las tablas con varios padres incluyen todas sus dependencias. Los ciclos se señalan, porque no tienen un orden estricto único.

**Importante**: el esquema no tiene un atributo universal "SK": una FK no equivale a una segunda aprobación humana. Una tabla puente puede tener dos claves foráneas, pero para exigir dos autorizaciones de negocio debe definirse un mecanismo explícito (quién aprueba, qué columnas/tabla registran aprobaciones y qué significa "autorizado"). No se inventan esas tablas ni se alteran las existentes.

`procesar.php` admite altas y cambios de campos existentes validados contra el esquema y consultas preparadas. Modifica/elimina solamente por clave primaria simple; en tablas con PK compuesta las acciones respectivas se deshabilitan. Los campos en blanco se omiten y no se usa `LIKE` para eliminar. La interfaz lista como máximo 100 registros por tabla por petición y no trae paginación avanzada.

Este proyecto no incluye sistema de autenticación de usuarios ni define credenciales de usuario final. **No expongas este CRUD administrativo a Internet sin un control de acceso de Nginx/Apache, VPN, proxy autenticado o equivalente.** El token del instalador no protege automáticamente el dashboard. `dashboard-legacy.php` preserva el dashboard previo con dependencias históricas. No se han efectuado pruebas funcionales con MySQL ni revisión integral de seguridad.
