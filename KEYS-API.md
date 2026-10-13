# Detección de llaves desde GestorDB

La clase `GestorDB` expone ahora:

- `obtenerLlaves($tabla)`: devuelve `primary` (todas las columnas de PK), `columns` (metadatos reales), y `relations` (restricciones FK y mapeos de columnas). No presupone `id`, `user_id_` o un nombre de llave concreto.
- `obtenerOpcionesRelacion($tabla, $restriccion, $limite)`: obtiene valores de las columnas realmente referenciadas por la clave foránea. Requiere una FK declarada en la BD.
 
La convención histórica de campos terminados en `_id_` se mantiene como pista opcional cuando puede vincularse inequívocamente a una tabla del esquema; se etiqueta como `inferred` y no se utiliza como autorización de acceso ni como relación FK confirmada. Las operaciones CRUD en `procesar.php` continúan validando nombres de tabla y columna contra el esquema real.

Esta integración no reescribe todavía todas las vistas y formularios heredados: algunos métodos anteriores siguen haciendo supuestos sobre el primer campo o nombres derivados. La inferencia de propiedad y los permisos de escritura multiusuario requieren comprobaciones adicionales. No se han probado estas nuevas consultas contra MySQL real.
