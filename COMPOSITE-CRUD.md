# CRUD con claves primarias compuestas

El formulario de edición y eliminación del dashboard solicita todos los componentes de la clave primaria detectada por information_schema. El procesador exige el conjunto completo de valores, valida los nombres según el esquema y construye una condición WHERE con AND entre todos los campos; los valores se pasan por parámetros preparados.

Las tablas sin PK no permiten editar ni eliminar desde el dashboard. Los usuarios comunes siguen sin permisos de escritura hasta disponer de una política verificable de propiedad. Los campos de PK no se modifican desde el formulario. Los INSERT siguen admitidos para administradores, con valores de columnas reales.

No se han realizado pruebas funcionales con MySQL. Las operaciones de edición/eliminación sobre PK compuestas sólo deben usarse después de probarlas contra una copia de la base.
