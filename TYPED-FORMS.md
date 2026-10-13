# Formularios generados por tipos de datos MySQL

`SchemaHierarchy` lee `DATA_TYPE`, `COLUMN_TYPE`, longitud, precisión, escala, valor predeterminado, nulabilidad y atributos de cada columna. `GestorFieldRenderer` los transforma en controles HTML con clases de estilo compatibles con Bootstrap.

- VARCHAR/CHAR: entrada de texto y `maxlength` basado en `CHARACTER_MAXIMUM_LENGTH`.
- TEXT y JSON: área de texto.
- ENUM: selector con los valores declarados.
- Enteros y números decimales: controles numéricos con el paso correspondiente.
- DATE/TIME/DATETIME/TIMESTAMP/YEAR: controles especializados.
- Columnas autoincrementales, generadas o de contenido binario complejo: se omiten del formulario genérico.

La clase `GestorDB` ahora expone `generarControlCampo($tabla, $campo, $insertar)` para reutilizar la misma lógica. El dashboard usa directamente el renderizador para los formularios de altas y edición.

**Límites actuales:** el formulario de edición no recupera previamente todos los valores del registro; deja los campos vacíos y el procesador omite los vacíos. Los tipos `SET`, geometría, blobs y archivos requieren controles o procesamiento especializados. Las llaves foráneas pueden requerir selectores más ricos; el tipo SQL por sí solo no identifica un correo, una contraseña ni una autorización. Validación de servidor y pruebas funcionales en MySQL siguen siendo necesarias. No se ejecutaron escrituras en producción.
