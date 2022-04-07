<?php

/*
el código javascript enviará un formulario $_POST con los datos siguientes (similares, esto es un ejemplo):

    array (size=6)
        'nombre' => string 'a' (length=1)
        'descripcion' => string 'b' (length=1)
        'empresamnt' => string 'c' (length=1)
        'contactomnt' => string 'd' (length=1)
        'telefonomnt' => string 'e' (length=1)
        'id' => string '' (length=0)

  Si los datos son correctos se insertarán en la base de datos o se actualizarán. 
  Se insertarán cuando el "ID" vaya sin rellenar, y se actualizarán cuando el ID vaya relleno.

  ESTE METODO DEBERÁ MOSTRAR DONE_UPDATE o DONE_INSERT SI LA OPERACIÓN SE HIZO, en función de la operación realizada.
  SI HAY UN ERROR, DEBERÁ MOSTRAR UN TEXTO DESCRIPTIVO
  POR DEFECTO RETORNA DONE_INSERT
*/
//var_dump($_POST);
//
echo 'DONE_INSERT';