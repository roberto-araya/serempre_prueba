Este módulo Drupal 8 cumple con los siguientes requirimientos de la prueba de postulación al
cargo de desarrollador en Serempre. 

Realizar un módulo custom, siguiendo los estándares de codificación de Drupal.
https://www.drupal.org/docs/develop/standards

Características del módulo.

1. Crear una tabla "myusers" que contenga el nombre, id(dejar este como llave
autonumerica).
2. Crear los menús requeridos para realizar las operaciones de Registro, Consulta e
Importar. Cada una de esta urls debe tener su respectivo permiso (registro,
consulta, importación)

Url 1: Usuario/registro:
- Exponer un formulario con el campo de textfield para capturar el nombre hacer
las respectivas validaciones de front(utilizar jQuery validate (Requerido y sólo
caracteres A-Z)) y backend igualmente hacer las validaciones de nombre mínimo
de 5 caracteres y que no se repita.

- El envío del formulario (POST) se debe hacer por medio de Ajax Drupal.
- El usuario recibe la retroalimentación por medio de un modal del id que se le
asignó en el registro.
- El modal se debe mostrar con bootstrap 4 con un comando de Ajax
personalizado.
Url 2: Usuario/consulta:
- Mostrar un listado paginados de los registros ingresados.

Url 3: usuario/consulta/excel
- Debe exportar los usuarios en un archivo excel.

3. Url 4: usuario/importar
- Exponer un formulario para subir un archivo(csv) con los nombres de los usuarios para
importar. Utilizar un batch requerido.

Hacer las pruebas de importación con este archivo:
https://drive.google.com/file/d/18O5BzyqAogzIncU73TFqGphoEJruScmH/view

4. Crear una tabla de log de acceso del usuario de eventos como registro y login.

- La tabla log debe contener los siguientes campos: fecha, ip, uid, tipo_log (login/registro).
- Para el log de login utilizar un alter para interceptar el formulario de login, y crear un
submit personalizado.
- Para el log de registro utilizar el hook de insertar un usuario.

Entregar la prueba utilizando pantheon (https://pantheon.io)