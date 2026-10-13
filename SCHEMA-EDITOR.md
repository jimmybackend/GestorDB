# Editor de estructura MySQL — primera parte

El dashboard ofrece un panel de estructura para administradores autorizados. Detecta las tablas reales de la conexión activa.

Operaciones implementadas:
- Crear una tabla nueva con una columna inicial (sin asumir estructura ni PK).
- Agregar columnas de tipos permitidos: VARCHAR, INT, BIGINT, TEXT, DATE, DATETIME, DECIMAL, BOOLEAN.
- Posicionar una columna nueva al principio, después de otra existente, o al final.
- Reordenar una columna existente **sólo si** su definición es simple (sin DEFAULT, AUTO_INCREMENT, generación de columnas u otros atributos complejos).
- Actualizar el dashboard mediante redirección tras ejecutar el DDL.

La entrada se valida; los nombres SQL se limitan a identificadores sencillos y no se acepta SQL arbitrario. La operación requiere identidad administrativa y token CSRF. No se incluyen DROP TABLE, DROP COLUMN ni operaciones destructivas automáticas.

**Precauciones**: Cambiar estructura es una operación real, no reversible automáticamente, que puede bloquear tablas o fallar según permisos y dependencias. Realizar respaldo previamente. No hay una prueba de integración con MySQL real ni respaldo transaccional de DDL. El acceso administrador sólo se permite desde el entorno de red configurado.

Pendiente en fases posteriores: pruebas funcionales de DDL en MySQL; manipulación de índices, FK y PK compuestas; reordenamiento seguro de columnas con atributos complejos; aprobaciones explícitas y edición multiusuario con reglas de propiedad.
