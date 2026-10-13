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


## Selección de acceso en el instalador

El instalador permite guardar el modo de acceso `users`, `admin` o `mixed`; la tabla de autenticación (`Users` por defecto) y la lista de IP de administración. En `users` o `mixed` se comprueba que la tabla elegida contenga `id`, `email` y `password`. El inicio de sesión sólo admite contraseñas PHP compatibles con `password_verify()`; la simple presencia de columnas no demuestra que las contraseñas existentes tengan hashes válidos.

Las variables `GESTORDB_ACCESS_MODE`, `GESTORDB_AUTH_TABLE` y `GESTORDB_ADMIN_ALLOWED_IPS` tienen precedencia sobre las opciones guardadas. La dirección IP se coteja con `REMOTE_ADDR`, no con cabeceras proporcionadas por visitantes. El acceso administrativo sin contraseña de aplicación **sólo debe usarse mediante una red de administración aislada y autenticada (por ejemplo VPN)**. No implica autorización para abrir el dashboard a Internet.

Los cambios de configuración después de la primera instalación exigen editar la configuración privada fuera del servidor web o las variables de entorno: el instalador de un solo uso no sobrescribe configuraciones existentes. Las credenciales MySQL se guardan fuera de la raíz del repositorio.

La interfaz actual es independiente de los `main00.php`, `main0.php` y otros archivos antiguos: esa nota de versiones anteriores ya no describe el dashboard nuevo, aunque el respaldo `dashboard-legacy.php` aún los referencia.
