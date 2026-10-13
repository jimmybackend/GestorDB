# Modos de acceso y aislamiento de datos

## Configuración del servidor PHP/FPM

- `GESTORDB_ACCESS_MODE=users` (predeterminado), `admin` o `mixed`
- `GESTORDB_ADMIN_ALLOWED_IPS=127.0.0.1,::1` (lista de IP **reales** de origen autorizadas para modo administrador; no usa cabeceras X-Forwarded-For)
- `GESTORDB_AUTH_TABLE=Users` (tabla de autenticación seleccionada explícitamente; requiere columnas `id`, `email` y `password`)

En `admin`, el acceso directo sin login sólo funciona desde IP permitida. Si no está permitida, el acceso se deniega. Mantener la aplicación detrás de VPN/firewall y TLS. El modo `mixed` todavía está limitado al inicio de sesión de usuario: no concede acceso administrativo directo.

Las credenciales de MySQL permanecen en configuración privada, como se describe en INSTALL.md. El modo de acceso **no** reemplaza esa conexión.

## Usuarios y propiedad de datos

Se admiten únicamente contraseñas PHP compatibles con `password_verify()` (hashes creados con `password_hash()`). **No** se convierten ni se comparan contraseñas antiguas en texto claro. El registro público está desactivado para no inventar columnas, privilegios ni roles en el esquema instalado.

En modo usuario, el menú muestra únicamente tablas con **una única clave foránea real** hacia `Users.id` (o la tabla indicada), y el SELECT filtra por esa columna con consulta preparada. Si una tabla no posee esa relación inequívoca, no se muestran sus registros. El CRUD de modificación por usuarios está bloqueado tanto en interfaz como en procesar.php. Las tablas con FK ambiguas o sólo relaciones indirectas quedan fuera hasta implementar políticas específicas.

La clase heredada GestorDB.php contiene sus propias clases CSS tipo Bootstrap (p. ej. `form-control`), pero el nuevo dashboard independiente usa `assets/gestordb.css`. No se ha migrado completamente el HTML heredado ni probado con una base MySQL real.

**Importante**: una conexión a MySQL no demuestra la identidad del visitante. La cuenta administradora sin contraseña local sólo es admisible bajo aislamiento por red confiable.
