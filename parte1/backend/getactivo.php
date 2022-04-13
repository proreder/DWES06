<<<<<<< HEAD
<?php

//Recibirá $_POST['id'] con el id del activo a obtener.

//Deberá generar una respuesta en json con los datos del activo indicado en $_POST[id]
echo json_encode ([
  'nombre' => 'Piscina',
  'descripcion' => 'Mantenimiento de piscina',
  'empresamnt' => 'Piscinas S.L.',
  'contactomnt' => 'Juan Piscinas',
  'telefonomnt' => '650623056',
  'id' => '10']);

//En caso de error deberá retornar un objeto JSON como el siguiente:
/*
echo json_encode ([
  'error' => 'Descripción del error'
);

=======
<?php

//Recibirá $_POST['id'] con el id del activo a obtener.

//Deberá generar una respuesta en json con los datos del activo indicado en $_POST[id]
echo json_encode ([
  'nombre' => 'Piscina',
  'descripcion' => 'Mantenimiento de piscina',
  'empresamnt' => 'Piscinas S.L.',
  'contactomnt' => 'Juan Piscinas',
  'telefonomnt' => '650623056',
  'id' => '10']);

//En caso de error deberá retornar un objeto JSON como el siguiente:
/*
echo json_encode ([
  'error' => 'Descripción del error'
);

>>>>>>> a9aababa3e162563c8a0d8265b11f163590f7164
*/