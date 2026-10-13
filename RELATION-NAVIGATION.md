# Parte 4: navegación de maestros y detalles

El dashboard descubre las relaciones definidas mediante FOREIGN KEY y presenta enlaces desde cada registro maestro a las tablas que lo referencian. El recorrido puede continuar de detalle a subdetalle por todos los niveles del esquema, incluso cuando la tabla intermedia tiene clave primaria compuesta. Cada enlace transporta los valores de la PK del maestro, el nombre de la tabla hija y la restricción que vincula ambas.

El servidor vuelve a consultar el registro maestro usando la PK completa y parámetros preparados; sólo después obtiene los valores referenciados para construir el filtro de la tabla hija. Admite relaciones foráneas de varias columnas, múltiples tablas hijas y varias FK entre el mismo par de tablas.

**Acceso**: la navegación entre tablas está restringida al modo administrador; no se aplica a usuarios comunes porque para ellos sería necesario demostrar la propiedad de cada fila a través de toda la cadena de relaciones. El aislamiento básico del usuario permanece tal como estaba, sin conceder privilegios adicionales.

**Alcance**: navegación de lectura y filtrado de registros por relaciones declaradas. Esta parte no crea aprobaciones humanas automáticas, no infiere relaciones sin FK, ni sustituye el formulario de entrada por selectores dinámicos para todas las relaciones. El límite de resultados sigue siendo 100 registros por tabla. Se requiere integración funcional con una base MySQL para asegurar comportamiento real; el lint de PHP verifica sólo sintaxis.
