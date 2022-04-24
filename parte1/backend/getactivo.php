
<?php
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
            obtenerRegistro($id);
        }else{
          $id=false;
    }
    
}



//si hay id realizamos la consulta a la base de datos
function obtenerRegistro($id_){
    $resultado=false;
    $sql_select="SELECT * FROM activos WHERE id=:id";
    try{
        $stmt=$pdo->prepare($sql_select);
        $stmt->bindValue('id', $id_);
        $stmt->execute();
        $registro=$stmt->fetch(FECTH::ASSOC);
    } catch (Exception $ex) {
        //En caso de error deberá retornar un objeto JSON como el siguiente:
            
            echo json_encode ([
              'error' => 'Error en la recuperación del activo'
            ]);
    }
    
    if($registro){
        
    }else{
        
    }
    
}   
    




echo "ID=".$id;
//Deberá generar una respuesta en json con los datos del activo indicado en $_POST[id]
echo json_encode ([
  'nombre' => 'Piscina',
  'descripcion' => 'Mantenimiento de piscina',
  'empresamnt' => 'Piscinas S.L.',
  'contactomnt' => 'Juan Piscinas',
  'telefonomnt' => '650623056',
  'id' => $id]);

//En caso de error deberá retornar un objeto JSON como el siguiente:
/*
echo json_encode ([
  'error' => 'Descripción del error'
);
*/
 /* 
 * @param string $valor cadena de entrada para validar y sanear
 * @return string si es una cadena se devuelve la cadena de entrada o se 
 *                se devuelve false si la cadena de entrada no es string
 */
function saneaCadena($valor){
    //elimina los espacios
    $_valor=trim($valor);
    //elimina los caracteres especiales y los combierte en entidads html
    $_valor= htmlspecialchars($_valor);
    //Eliminar las barras invertidas
    $cadena= stripcslashes($_valor);
    $esCadena= is_string($cadena) ? $cadena : false;
    return $esCadena;
}