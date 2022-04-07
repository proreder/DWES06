<?php
require_once __DIR__.'/vendor/autoload.php';

use Jaxon\Jaxon;
use Jaxon\Response\Response;

$jaxon = jaxon();
$jaxon->setOption("js.lib.uri","http://localhost/DWES06/parte2/jaxon-dist");
$jaxon->setOption('core.request.uri', 'backend.php');

function funcionRegistrada()
{
    $response = new Response();
    $response->assign('listaActivos','style.border', '1px solid black' );
    $response->assign('listaActivos', 'style.padding', '10px 10px');    
    $response->assign('log', 'innerHTML', '<H1>LOGS</H1>');    
    $response->assign('log', 'style.backgroundColor', 'beige');    
    $response->assign('log', 'style.border', '1px solid black');    
    $response->assign('log', 'style.padding', '10px 10px');    
    $response->append('log', 'innerHTML', 'Ejemplo de log');
    return $response;
}

//Implementa aquí la función listarActivos(), generando una lista de activos
//Implementa aquí la función borrarActivo($id), generando como resultado un alert y una nueva lista de activos


$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcionRegistrada');
//Registra aquí la función listarActivos
//Registra aquí la función borrarActivo