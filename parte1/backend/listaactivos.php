
<?php
require_once ('conf.php');
require_once ('Conexion.php');

//objeto para establecer conexión
$conexion=new Conexion();
$pdo=$conexion->connect();

//variables
$registros=false;

//script para listar todos los regisros
$sql_select="SELECT * FROM activos";
if($pdo){
    echo "conexión establecida: <br>";
    $smtp=$pdo->prepare($sql_select);
    try{
        $smtp->execute();
        $registros=$smtp->fetchAll((PDO::FETCH_ASSOC));
    } catch (Exception $ex) {
        $ex->getMessage();
        echo $ex;
    }
    
}else{
    echo "No se ha establecido conexión con la base de datos";
}
?>
<style>
    table {
    border-collapse: collapse;
    margin: 5px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}
table th,
table td {
    padding: 6px 15px;
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
<form class="actualizarActivos" onSubmit="return false;">                    
    <input type="submit" value="Actualizar lista">
</form>
<table border="1px solid blue">
    <thead>
        <tr>
            <th>Id</th>
            <th class='celda_130'>>Nombre</th>
            <th>Descripción</th>
            <th>Empresa de mantenimiento</th>
            <th>Persona/contacto de mantenimiento</th>
            <th>Teléfono</th>
            <th class='celda_130'>Operaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($registros){
                //var_dump($registros);
                foreach($registros as $registro){
                    echo "<tr>";
                       echo "<td>$registro[id]</td>";
                       echo "<td>$registro[nombre]</td>";
                       echo "<td>$registro[descripcion]</td>";
                       echo "<td>$registro[empresamnt]</td>";
                       echo "<td>$registro[contactomnt]</td>";
                       echo "<td>$registro[telefonomnt]</td>";
                       
                       //espacio para las operaciones
                       echo "<td>";
                            echo '<form class="borrarActivo" onSubmit="return false;">';
                                echo "<input type='hidden' name='idactivo' value=$registro[id]>";
                                echo "<input  class='ope' type='submit' value='¡Borrar!'>";
                            echo "</form>";
                            echo '<form class="editarActivo" onSubmit="return false;">';
                                echo "<input type='hidden' name='idactivo' value=$registro[id]>";
                                echo "<input  class='ope' type='submit' value='Editar'>";
                            echo "</form>";
                        echo "</td>";  
                    echo "</tr>";
                }
                
            }
        ?>
    </tbody>
</table>

