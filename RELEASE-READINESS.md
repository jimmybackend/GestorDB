# Estado de publicación de GestorDB

La aplicación dispone de instalador web, configuraciones privadas MySQL, acceso de usuarios, administrador de red autorizada, jerarquía por PK/FK y operaciones CRUD administrativas. También contiene un editor DDL con limitaciones explícitas.

## Comprobaciones

La CI verifica sintaxis de componentes PHP y ejecuta pruebas de la política aislada de propiedad con relaciones únicas, ausentes y ambiguas. No hay prueba funcional integral con una base MySQL ejecutada por esta entrega.

## Restricciones vigentes

- El modo usuario puede consultar tablas con clave foránea directa hacia Users.id y filtro por identidad.
- El modo usuario **no puede insertar, actualizar ni borrar**: el endpoint procesar.php lo bloquea. Esto se mantiene deliberadamente hasta contar con pruebas de aislamiento que abarquen SQL de escritura y varias cuentas.
- Las cadenas indirectas de propiedad y las aprobaciones dobles no están autorizadas automáticamente.
- Las operaciones ALTER/CREATE de estructura necesitan respaldo y pruebas en copia antes de producción.
- El acceso administrativo sin login debe estar aislado en VPN, loopback o red privada de confianza, nunca Internet abierto.
- El esquema de inicio de sesión existente debe usar hashes compatibles con password_verify.

**No denominar estable de producción** hasta probar la instalación, autenticación, aislamiento entre usuarios, operaciones CRUD y editor DDL con MySQL real. La aprobación de sintaxis no certifica su funcionamiento integral.
