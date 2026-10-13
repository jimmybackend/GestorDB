# Parte 5: reglas de propiedad de registros

Se incorporó `OwnershipPolicy.php` para determinar si la relación de propiedad es inequívoca: exactamente una clave foránea declarada hacia `Users.id` (o la tabla de autenticación configurada). Esta política evita deducir permisos por similitud de nombres de campos.

**Este módulo todavía no se conecta al procesador de escrituras**: por tanto, los usuarios siguen sin poder insertar, actualizar o eliminar registros. El bloqueo actual de escrituras se mantiene deliberadamente; nunca debe otorgarse acceso antes de verificar la propiedad en el mismo SQL que realiza el UPDATE/DELETE, y de forzar el propietario en INSERT.

No se han habilitado permisos de escritura indirectos, ni realizado pruebas de aislamiento entre usuarios con MySQL real. La clase proporciona sólo la política de metadatos.
