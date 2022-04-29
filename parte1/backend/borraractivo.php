<?php

//Operacion a implementar siguiendo la línea de las otras operaciones.
require_once ('conf.php');
require_once ('Conexion.php');

//objeto para establecer conexión
$conexion=new Conexion();
$pdo=$conexion->connect();

//variables
$registros=false;
$resultado="";


//variables
$error=false;
$id=0;

//Recibirá $_POST['id'] con el id del activo a obtener.
//verificamos si hay conexión
if(!$pdo){
    return 'echo "<br>Error: no se puede conectar con la base de datos"';
}
//verificamos si se ha recibido el 'idactivo' formulario
if($_SERVER['REQUEST_METHOD']=='POST'){
    //filtramos los datos que han llegado via POST
    
    $_id=filter_input(INPUT_POST, 'idactivo', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    if(is_numeric($_id) && $_id> 0){
            $id=$_id;
            $registros=borrarActivo($pdo, $id);
        }else{
          $id=false;
    }
    if($registros){
        return 'DONE_DELETE';
        
    }else{
        return 'ERROR_DELETE';
    }
}

//borramos el activo pasado como argumento
function borrarActivo(PDO $pdo, $id){
    $result=false;
    $sql_delete="DELETE FROM activos WHERE id=:id";
    try{
        $stmt=$pdo->prepare($sql_delete);
        $stmt->bindValue('id', $id);
        $stmt->execute();
    } catch (Exception $ex) {
        $ex->getMessage();
        echo $ex;
        $result=false;
    }
     //si el numeros de registros e mayor de 0 se devuelve 1 que confirma la operación correcta
        return $result=$stmt->rowCount() > 0 ? 1 : false;
}