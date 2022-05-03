<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/conf/conf.php';
require_once __DIR__.'/conf/conexion.php';
use Jaxon\Jaxon;
use Jaxon\Response\Response;

$jaxon = jaxon();
$jaxon->setOption("js.lib.uri","http://localhost/DWES06/parte2/jaxon-dist");
$jaxon->setOption('core.request.uri', 'backend.php');

//conectamos a la base de datos
$conexion=new Conexion();
$pdo=$conexion->connect();

//if($pdo){
//    $response = new Response();
//    $response->assign('log', 'innerHTML', '<H1>Conexión con la base de datos establecida.</H1>');
//    return $response;
//}
//else{
//    $response = new Response();
//    $response->assign('log', 'innerHTML', '<H1>ERROR: no se ha establecido conexión con la base de datos.</H1>');
//    return $response;
//}

function funcionRegistrada()
{
   
//conectamos a la base de datos
//    $conexion=new Conexion();
//    $pdo=$conexion->connect();
//    $registros=listarActivos($pdo);
    $response = new Response();
    
    $response->assign('listaActivos','style.border', '1px solid black' );
    $response->assign('listaActivos', 'style.padding', '10px 10px');    
    $response->assign('log', 'innerHTML', '<H1>LOGS</H1>');    
    $response->assign('log', 'style.backgroundColor', 'beige');    
    $response->assign('log', 'style.border', '1px solid black');    
    $response->assign('log', 'style.padding', '10px 10px');
    //conectamos a la base de datos
//    $conexion=new Conexion();
//    $pdo=$conexion->connect();
//    if($pdo){
//         $response->append('log', 'innerHTML', '<H5>Conexión con la base de datos establecida.</H5>');
//         $registros=obtenerRegistros($pdo);
//         //var_dump($registros);
//         foreach($registros as $valor){
//             $response->append('log', 'innerHTML', '<span>'.$valor['nombre'].'</span><br>');
//         }
//         //$response->append('log', 'innerHTML', $registros);
//     }else{
//         $response->append('log', 'innerHTML', '<H5>ERROR: no se ha establecido conexión con la base de datos.</H5>');
//     }   
    //$response->append('log', 'innerHTML', 'Ejemplo de log');
    return $response;
}

//Implementa aquí la función listarActivos(), generando una lista de activos
function listarActivos(){
    global $pdo;
    $response=new Response();
    
    if($pdo){
         $response->append('log', 'innerHTML', '<H5>Conexión con la base de datos establecida.</H5>');
         $response->assign('listaActivos', 'innerHTML', '<h3>Listado de activos</h3>');
         $response->append('listaActivos', 'innerHTML',"<table><tr><th>id</th><th class='celda_130'>Nombre</th><th class='celda_130'>Descripción</th><th>Empresa</th><th>Contacto</th><th>Teléfono</th></tr>");
    
         $registros=obtenerRegistros($pdo);
         //var_dump($registros);
         foreach($registros as $valor){
             $response->append('listaActivos', 'innerHTML', '<tr><td>'.$valor['id'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['nombre'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['descripcion'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['empresamnt'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['contactomnt'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['telefonomnt'].'</td></tr>');
         }
         //$response->append('log', 'innerHTML', $registros);
         $response->append('listaActivos', 'innerHTML', '</table>');
     }else{
         $response->append('log', 'innerHTML', '<H5>ERROR: no se ha establecido conexión con la base de datos.</H5>');
     }
    
    return $response;
    
}

//borra un activo con idactivo pasado como argumento
function borrarActivo($id){
    global $pdo;
    $sql="DELETE FROM activos WHERE id=:id";
    $resultado="";
    $registros="";
    $stmt=$pdo->prepare($sql);
    if($id>0){
        try{
            //$stmt=$pdo->prepare($sql);
            $stmt->bindValue('id', $id);
            $stmt->execute();
        } catch (PDOException $ex) {
            $ex->getMessage();
            $error=$ex;
        }
    }else{
        $resultado="El id introducido tiene que ser mayor de 0";
    }
    $response=new Response();
    if($stmt->rowCount()>0){
        $resultado="Registro borrado correctamente";
        $registros=obtenerRegistros($pdo);
            
         
         $response->alert("Registro borrado correctamente");
         $response->append('log', 'innerHTML', '<H5>Conexión con la base de datos establecida.</H5>');
         $response->assign('listaActivos', 'innerHTML', '<h3>Listado de activos</h3>');
         $response->append('listaActivos', 'innerHTML',"<table><tr><th>id</th><th class='celda_130'>Nombre</th><th class='celda_130'>Descripción</th><th>Empresa</th><th>Contacto</th><th>Teléfono</th></tr>");
    
         $registros=obtenerRegistros($pdo);
         //var_dump($registros);
         foreach($registros as $valor){
             $response->append('listaActivos', 'innerHTML', '<tr><td>'.$valor['id'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['nombre'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['descripcion'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['empresamnt'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['contactomnt'].'</td>');
             $response->append('listaActivos', 'innerHTML', '<td>'.$valor['telefonomnt'].'</td></tr>');
         }
         //$response->append('log', 'innerHTML', $registros);
         $response->append('listaActivos', 'innerHTML', '</table>');
    }else{
        $resultado="El id introducido no existe";
    }
         
    
        $response->assign('log', 'innerHTML', $resultado);
        return $response;
}
function obtenerRegistros($pdo){
    $resultado=false;
    $sql="SELECT * FROM activos";
    try{
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $resultado=$stmt->fetchAll((PDO::FETCH_ASSOC));
        
    } catch (Exception $ex) {
        return false;
    }
    return $resultado;
}
//Implementa aquí la función borrarActivo($id), generando como resultado un alert y una nueva lista de activos

//Registra aquí la función listarActivos
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarActivos');

$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'obtenerRegistros');

$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcionRegistrada');

//Registra aquí la función borrarActivo
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'borrarActivo');