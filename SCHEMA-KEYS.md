# Editor de claves e índices — Parte 2

En el dashboard de una tabla, únicamente el administrador autorizado puede crear:

- Clave primaria simple para una columna ya NOT NULL, si la tabla no tiene PK.
- Índice normal de una columna existente.
- Clave foránea de una columna existente a una columna de otra tabla (o de la misma), con ON DELETE RESTRICT / ON UPDATE RESTRICT.

El editor sólo acepta nombres SQL sencillos y valida previamente la existencia de las columnas. Se exige sesión administrativa, CSRF y confirmación explícita de respaldo. Los conflictos de tipos, integridad referencial, unicidad y sintaxis definitiva los rechaza MySQL.

**No** permite borrar ni modificar claves ya existentes; tampoco crea automáticamente índices o columnas auxiliares. En esta parte no se admiten claves compuestas, claves únicas, operaciones destructivas ni mapeo de relaciones mediante convenciones inferidas. No se ejecutaron pruebas con servidor MySQL: sintaxis PHP no demuestra que el DDL se aplique a toda versión/esquema. Antes de activar en producción, respaldar y verificar con una copia de la base.
