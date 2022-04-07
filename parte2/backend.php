<?php
require_once __DIR__.'/setup.php';

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}