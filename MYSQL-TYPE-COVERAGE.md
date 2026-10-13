# Cobertura de tipos MySQL en formularios

El generador usa los metadatos reales (`DATA_TYPE`, `COLUMN_TYPE`, nulabilidad, longitud, valores por defecto y precisión) y no deduce el tipo por el nombre del campo.

| Familia de MySQL | Componente |
|---|---|
| TINYINT, SMALLINT, MEDIUMINT, INT, BIGINT, DECIMAL, FLOAT, DOUBLE | Campo numérico; BIGINT/DECIMAL como texto numérico para evitar pérdida de precisión del navegador |
| CHAR, VARCHAR | Campo de texto con longitud máxima |
| TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT | Área de texto |
| ENUM | Selector de opciones |
| SET | Casillas de selección múltiple; el servidor valida y serializa los valores |
| DATE, DATETIME, TIMESTAMP, TIME, YEAR | Fecha, fecha-hora, duración/hora y año según el tipo |
| JSON | Área de texto con validación de JSON del lado servidor |
| BIT | Entrada de bits con validación y conversión SQL parametrizada |
| BINARY, VARBINARY, TINYBLOB, BLOB, MEDIUMBLOB, LONGBLOB | Área para Base64; el servidor decodifica a bytes antes del INSERT/UPDATE |
| POINT, LINESTRING, POLYGON, MULTIPOINT, MULTILINESTRING, MULTIPOLYGON, GEOMETRY, GEOMETRYCOLLECTION | Editor WKT; se transforma con `ST_GeomFromText(?)` |
| VECTOR (MySQL 9+) | Área de texto para lista JSON numérica, convertida mediante `STRING_TO_VECTOR(?)` |
| Columnas autoincrementales o generadas | No se editan directamente |

No todos los tipos tienen un widget HTML nativo. Para datos binarios o espaciales se usa una representación textual especializada y conversión explícita en PHP/MySQL. Las columnas desconocidas se muestran como sólo lectura.

**Limitaciones:** la compatibilidad puede variar según versión MySQL, SRID, restricciones de columnas y extensiones. No se proporcionan subidas de archivos reales ni vista previa geométrica. Los campos no enviados y los vacíos continúan sin reemplazar por defecto valores existentes. Se requieren pruebas funcionales con MySQL real para garantizar INSERT/UPDATE de cada familia y conservar los límites de seguridad multiusuario.
