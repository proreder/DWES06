<?php
var_dump($_POST);

//verificamos si se ha recibido el formulario
if($_SERVER['REQUEST_METHOD']=='POST'){
    //filtramos los datos que han llegado via POST
    $nombre=filter_input(INPUT_POST, 'nombre', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $descripcion=filter_input(INPUT_POST, 'descripcion', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $empresamnt=filter_input(INPUT_POST, 'empresamnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $contactomnt=filter_input(INPUT_POST, 'contactomnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $telefonomnt=filter_input(INPUT_POST, 'telefonomnt', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    $_id=filter_input(INPUT_POST, 'nombre', FILTER_CALLBACK, ['options' => 'saneaCadena']);
    if(is_numeric($_id) && $_id> 0){
            $id=$_id;
        }else{
            echo 'No hay id.';
            $id=false;
        }
    //guardamos los datos llegados via post en el array asociativo
    $data = ['nombre' => $nombre, 'descripcion' => $descripcion, 'empresamnt' => $empresamnt, 
            'contactomnt' => $contactomnt, 'telefonomnt' => $telefonomnt];
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
        $peticion = new Peticion();
        $peticion->validate($data, $rules);
        if($peticion->error()){
            $array=$peticion->error();
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
     *                    telefono, empresa, nombre->se ha de cumplir la expresión regular
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
                                $this->addError($item,ucwords($item). ' required');
                            }
                            break;

                        case 'minLen':
                            if(strlen($item_value) < $rule_value){
                                $this->addError($item, ucwords($item). ' tiene que ser mínimo de '.$rule_value. ' carácteres');
                            }       
                            break;

                        case 'maxLen':
                            if(strlen($item_value) > $rule_value){
                                $this->addError($item, ucwords($item). ' tiene que ser máximo de  '.$rule_value. ' carácteres');
                            }
                            break;

                        case 'numeric':
                            if(!ctype_digit($item_value) && $rule_value){
                                $this->addError($item, ucwords($item). ' tiene que ser numérico');
                            }
                            break;
                            
                            case 'alpha':
                            if(!ctype_alpha($item_value) && $rule_value){
                                $this->addError($item, ucwords($item). ' tiene que ser carácteres alfabéticos');
                            }
                        case 'telefono':
                            $regex='/^((?:\d{3}[ -]\d{2}[ -]\d{2}[ -]\d{2})|(?:\d{3}[ -]\d{3}[ -]\d{3})|(?:\d{9}))(?:[;](?1))*$/';
                            if(!preg_match($regex, $item_value) & $item_value!==""){
                                $this->addError($item, ucwords($item). ' el teléfono no tiene el formato correcto');
                            }
                            break;
                        case 'nombre':
                            $regex='/^([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\']+[\s])+([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])+[\s]?([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])?$/';
                            if(preg_match($regex, $rule_value) >0 ){
                                $this->addError($item, ucwords($item). ' el nombre no tiene el formato correcto');
                            }
                            break;
                        case 'empresa':
                            $regex="/^(\w)+\s{1}(\w)+[.,]+(\w)+[.,]$/";
                            if(preg_match($regex, $rule_value) >0 ){
                                $this->addError($item, ucwords($item). ' el nombre de empresa no tiene el formato correcto');
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
echo 'DONE_INSERT';