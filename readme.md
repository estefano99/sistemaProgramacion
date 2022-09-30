# Proveedores
## Crud
  Altas : 
*  Manda a la pagina darDeAlta.php
   Luego envía la el form por post a altaproveedores.php. Lo recibe e inserta los datos en la base de datos.

  Update:
*  Mediante un "a" mando el id que lo traigo del foreach de la consulta de todos los proveedores al archivo "modificar.php".
*  En "modificar.php" muestro un formulario con los campos a modificar y mando la data a "modificadoProveedor.php" por metodo POST
*  En "modificadoProveedor.php" modifico los campos guardo el nombre del modificado para mostrarlo en el mensaje de confimarcion en el   otro achivo con header("location:proveedores.php?upd=$nombreModificado");

Delete o baja logica:

*  El boton abre mediante onclick una funcion de js (confirm) si acepta devuelve true y manda la pagina de eliminarProveedores.php con el "a" el cual cambia el estado a 0, en caso de cancelar devuelve false y queda en la misma pagina
   

