# Trabajo de Fin de Grado

Sistema inteligente orientado a servicios para la optimización de escaneo de documentos manuscritos.

Se ejecuta bajo un sistema operatio Linux con Python instalado y un servidor apache en funcionamiento. Es necesario darle permisos de lectura y escritura a las carpetas /app/temp y /app/archivos y permisos de ejcución al archivo /app/notesrhink/noteshrink.py para el usuario www-data del servidor.

Para instalar módulos dependientes de Python se incluye un script en /app/noteshrink/resolver_dependencias.

La base de datos para su funcionamiento es de tipo MySQL y el script para realizar la importación se encuentra en la carpeta bbdd.

La API de la documentación está en la carpeta phpDoc.
