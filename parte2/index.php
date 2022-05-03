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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php echo $jaxonCss ?>
    <style>
        table {
            
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        table th {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        table th,
        table td {
            padding: 6px 15px;
            border: 1px solid black;
        }
        .ope{
            font-size: .8em;
            margin-left: 10px;
            float: left;
        }
        .celda_130{
            width: 130px;
        }
</style>
</head>
<body>

<div id="listaActivos">
    <!--//GENERAR AQUÍ LISTA DE ACTIVOS:<br>
    id activo / nombre activo<br>    -->
</div>
<!--<input type="button" onclick="alert ('Debes implementar la función de listar activos');" value="¡Actualizar lista de activos!">-->

    <form id="listar" onSubmit="return false;">
          <!--<input type="button" onclick="jaxon_listaActivos(jaxon.$('click').value); return false;" value="¡Actualizar lista de activos!">-->
          <input type="submit" onClick="jaxon_listarActivos();" name="click" id="click" value="¡Actualizar lista de activos!">
    </form>
<br>
<br>

<form id="borrarActivo" onSubmit="return false;">
    <label> ID Activo:<input id="idactivo" type="text" name="idactivo"></label>
    <br>
    <input type="button" onclick="jaxon_borrarActivo(jaxon.$('idactivo').value);" id="borrar" value="¡Borrar!">
</form>

<BR>

<div id='log'>
    LOG:
</div>

<?php echo $jaxonJs ?>

<?php echo $jaxonScript ?>
    
<script>
 <?php echo rq()->call('funcionRegistrada');?>
  
 <?php echo rq()->call('listarActivos');?>
    
 </script>
 <script>
     $("#borrar").click(function () {
        $("#borrarActivo")[0].reset();
    });
 </script>
 
</body>
</html>