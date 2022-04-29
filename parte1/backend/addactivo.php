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


//verificamos si hay conexión
if(!$pdo){
    return 'echo "<br>Error: no se puede conectar con la base de datos"';
}

//verificamos si se ha recibido el formulario
if($_SERVER['REQUEST_METHOD']=='POST'){
    //filtramos los datos que han llegado via POST
    $nombre=filter_input(INPUT_POST, 'nombre', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $descripcion=filter_input(INPUT_POST, 'descripcion', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $empresamnt=filter_input(INPUT_POST, 'empresamnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $contactomnt=filter_input(INPUT_POST, 'contactomnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $telefonomnt=filter_input(INPUT_POST, 'telefonomnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $_id=filter_input(INPUT_POST, 'id', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    if(is_numeric($_id) && $_id> 0){
            $id=$_id;
        }else{
           
            $id=false;
        }
    //guardamos los datos llegados via post en el array asociativo
    $data = ['nombre' => $nombre, 'descripcion' => $descripcion, 'empresamnt' => $empresamnt, 
            'contactomnt' => $contactomnt, 'telefonomnt' => $telefonomnt];
    $datos= checkCoherence($data);
    
    //Verificamos que los datos son validos
    if($datos){
        
        $res=guardar($pdo, $datos, $id);
        if($res>=1){
            
            echo $resultado;
        }else{
            return 'echo "<br>Error: el registro no se ha podido guardar en la base de datos"';
        }
    }
    
}

//guardamos los datos en la base de datos
function guardar($pdo, $datos, $id){
    global $resultado;
    $result=0;
    
    //sentencias sql
    $sql_insert="INSERT INTO activos (nombre, descripcion, empresamnt, contactomnt, telefonomnt) VALUES (:nombre, :descripcion, :empresamnt, :contactomnt, :telefonomnt)";
    $sql_update="UPDATE activos SET nombre=:nombre, descripcion=:descripcion, empresamnt=:empresamnt, contactomnt=:contactomnt, telefonomnt=:telefonomnt WHERE id=:id";
                        
    //$datos['id']=121;
    //si no hay id se realiza un INSERT, si hay id un UPDATE
    if(!$id){
        $sql=$sql_insert;
        $accion="DONE_INSERT";
    }else{
        $accion="DONE_UPDATE";
        $sql=$sql_update;
    }
    try{
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue('nombre', $datos['nombre']);
        $stmt->bindValue('descripcion', $datos['descripcion']);
        $stmt->bindValue('empresamnt', $datos['empresamnt']);
        $stmt->bindValue('contactomnt', $datos['contactomnt']);
        $stmt->bindValue('telefonomnt', $datos['telefonomnt']);
        if($id){
            $stmt->bindValue('id', $id);
        }
        $stmt->execute();
        if($result=$stmt->rowCount()){
            $resultado=$accion;
        }
        
    } catch (Exception $ex) {
        
        echo '<br>'.$ex->getMessage();
        $result=-2;
    }
                        
    return $result;
}

 function checkCoherence($data){
        $array=[];
        //verifica si la longitud no supera los campos del la base de datos
        
        //$data = ['nombre' => $this->nombre, 'descripcion' => $this->descripcion, 'empresamnt' => $this->empresamnt, 
        //         'contactomnt' => $this->contactomnt, 'telefonomnt' => $this->telefonomnt];
        $rules = [
            'nombre' => ['required', 'minLen' => 2,'maxLen' => 45, 'nombre'],
            'descripcion' => ['maxLen' => 255, 'nombre'],
            'empresamnt' => ['maxLen' => 45, 'empresa'],
            'contactomnt' => ['maxLen' => 45, 'nombre'],
            'telefonomnt' => ['maxLen' => 45 ,'telefono']
            
        ];
        //$peticion = new Peticion();
        validate($data, $rules);
        if(!error()){
            //echo 'no hay errores';
            $array=$data;
        } 
        return $array;
    }

/************************************************************/
    /************************************************************/
    /** VALIDACIONES  añadidas por Juan Francisco Vico 02.2022 **/
    /* obtenido de: https://dev.to/mofiqul/how-do-you-write-your-php-validator-3dc1
    /************************************************************/
    /************************************************************/
    
    
    $_errors = [];
    /**
     * 
     * @param type $src array asociativo que contienen los datos introducidos en el formulario
     * @param type $rules array asociativo que contiene el formato de datos que se ha de complir, 
     *                    required->requerido, minLen->longitud minima, maxLen->máxima longitud
     *                    telefono, empresa, nombre
     */
    function validate($src, $rules = [] ){

        foreach($src as $item => $item_value){
            if(key_exists($item, $rules)){
                foreach($rules[$item] as $rule => $rule_value){

                    if(is_int($rule))
                         $rule = $rule_value;

                    switch ($rule){
                        case 'required':
                            if(empty($item_value) && $rule_value){
                                addError($item,ucwords($item). ' required');
                            }
                            break;

                        case 'minLen':
                            if(strlen($item_value) < $rule_value){
                                addError($item, ucwords($item). ' tiene que ser mínimo de '.$rule_value. ' carácteres');
                            }       
                            break;

                        case 'maxLen':
                            if(strlen($item_value) > $rule_value){
                                addError($item, ucwords($item). ' tiene que ser máximo de  '.$rule_value. ' carácteres');
                            }
                            break;

                        case 'numeric':
                            if(!ctype_digit($item_value) && $rule_value){
                                addError($item, ucwords($item). ' tiene que ser numérico');
                            }
                            break;
                            
                            case 'alpha':
                            if(!ctype_alpha($item_value) && $rule_value){
                                addError($item, ucwords($item). ' tiene que ser carácteres alfabéticos');
                            }
                        case 'telefono':
                            $regex='/^((?:\d{3}[ -]\d{2}[ -]\d{2}[ -]\d{2})|(?:\d{3}[ -]\d{3}[ -]\d{3})|(?:\d{9}))(?:[;](?1))*$/';
                            if(!preg_match($regex, $item_value) & $item_value!==""){
                                addError($item, ucwords($item). ' el teléfono no tiene el formato correcto');
                            }
                            break;
                        case 'nombre':
                            $regex='/^([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\']+[\s])+([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])+[\s]?([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])?$/';
                            if(preg_match($regex, $rule_value) >0 ){
                                addError($item, ucwords($item). ' el nombre no tiene el formato correcto');
                            }
                            break;
                        case 'empresa':
                            $regex="/^(\w)+\s{1}(\w)+[.,]+(\w)+[.,]$/";
                            if(preg_match($regex, $rule_value) >0 ){
                                addError($item, ucwords($item). ' el nombre de empresa no tiene el formato correcto');
                            }
                            break;
                    }
                }
            }
        }    
    }
    /**
     * 
     * @param type $item key del array que contiene el error
     * @param type $error texto que contiene la key que ha generado el error
     */
    function addError($item, $error){
        $_errors[$item][] = $error;
    }

    /**
     * 
     * @return boolean true si se han producido errores
     */
    function error(){
        if(empty($_errors)) return false;
        return $_errors;
    }
    
    /**
 * 
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
//echo 'DONE_INSERT';
//echo $resultado;