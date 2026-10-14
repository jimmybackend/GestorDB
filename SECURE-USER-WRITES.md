# Escrituras multiusuario con propietario verificado

Se habilita el CRUD de usuario solamente para tablas con una **única relación FK declarada**, simple, a la columna `id` de la tabla utilizada para autenticar al usuario. No se exige que la columna local tenga el nombre `user_id_`: el esquema indica su nombre real.

Para crear un registro, el controlador ignora cualquier valor de propietario remitido desde el formulario y fuerza el ID autenticado en la sesión. Para actualizar y eliminar, la sentencia parametrizada incorpora simultáneamente **todos los componentes de la clave primaria y la columna de propietario** en la misma condición WHERE. En esas operaciones no se permiten cambios de columnas PK ni del propietario. El usuario no tiene acceso de escritura a la tabla de autenticación. Las tablas sin PK no permiten UPDATE/DELETE.

El dashboard sólo muestra al usuario las tablas cuyo propietario es inequívoco según la política estricta; no expone controles para modificar el propietario. Las operaciones del administrador conservan sus capacidades anteriores.

Las relaciones múltiples o indirectas, las relaciones inferidas por nombres, los datos compartidos y las tablas sin una FK válida quedan **denegados**, no autorizados automáticamente. Este comportamiento es deliberado: una relación con ID no garantiza que el usuario tenga permiso para todas las filas.

Pruebas agregadas en `tests/owned-writes.php` comprueban inyección obligatoria del propietario, restricción de tabla de autenticación y composición segura del filtro por PK compuesta. Se requiere prueba de integración con un servidor MySQL real, además de las pruebas de CI, antes de desplegar públicamente.
