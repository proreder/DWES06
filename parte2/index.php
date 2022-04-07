<?php
require_once __DIR__.'/setup.php';

$jaxonCss = $jaxon->getCss();
$jaxonJs = $jaxon->getJs();
$jaxonScript = $jaxon->getScript();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listar y borrar activos</title>
    <?php echo $jaxonCss ?>
</head>
<body>

<div id="listaActivos">
    //GENERAR AQUÍ LISTA DE ACTIVOS:<br>
    id activo / nombre activo<br>    
</div>
<input type="button" onclick="alert ('Debes implementar la función de listar activos');" value="¡Actualizar lista de activos!">

<br>
<br>

<form id="borrarActivo" onSubmit="return false;">
    <label> ID Activo:<input id="idactivo" type="text" name="idactivo"></label>
    <br>
    <input type="button" onclick="alert ('Debes implementar la función de borrar. Antes de borrar debe pedir confirmación. Después de borrar debe actualizarse la lista de activos.');" value="¡Borrar!">
</form>

<BR>

<div id='log'>
    LOG:
</div>

<?php echo $jaxonJs ?>

<?php echo $jaxonScript ?>
    
<script>
    <?php echo rq()->call('funcionRegistrada'); ?>
</script>

</body>
</html>