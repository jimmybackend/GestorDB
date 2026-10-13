# Instalación de GestorDB

Esta edición usa un instalador web de un solo uso para conectar una base de datos MySQL **ya existente**. No importa el archivo SQL de ejemplo ni crea o modifica tablas.

## Requisitos
- PHP 8.0+ con extensión mysqli, sesiones PHP y un servidor HTTPS.
- Directorio padre de la aplicación con permiso de escritura para la cuenta PHP durante la instalación.
- Usuario MySQL existente de permisos mínimos; no usar root.
- Control de acceso al directorio `/install/` por IP o autenticación del servidor.

## Instalación
1. Despliega los archivos del proyecto en su propio directorio, p. ej. `/var/www/gestordb`.
2. Configura una variable `GESTORDB_SETUP_TOKEN` de al menos 24 caracteres aleatorios en PHP-FPM o en el entorno de PHP. **No** la guardes en el repositorio.
3. Abre con HTTPS la ruta `/install/`. Introduce token, host, puerto, usuario, contraseña y nombre de la base de datos.
4. El instalador prueba la conexión y escribe `gestordb-config.php` en el **directorio padre** de la aplicación (p. ej. `/var/www/gestordb-config.php`), permisos 0600. No sobrescribe configuración anterior.
5. Elimina `GESTORDB_SETUP_TOKEN` del entorno, bloquea públicamente `/install/` y retira el permiso de escritura del directorio padre.

Alternativamente, `db.php` lee las variables `GESTORDB_DB_HOST`, `GESTORDB_DB_USER`, `GESTORDB_DB_PASSWORD`, `GESTORDB_DB_NAME` y `GESTORDB_DB_PORT`. El instalador no es necesario en ese modo.

**Precaución:** el repositorio contiene un `dashboard.php` que referencia archivos `main00.php`, `main0.php`, `main01.php` y `main05.php`, no presentes en la raíz de este repositorio. El instalador configura la conexión, pero no inventa ni instala esas dependencias externas. El código heredado y su SQL dinámico no tienen una auditoría completa de seguridad. No exponer la aplicación al público sin protección y revisión.
