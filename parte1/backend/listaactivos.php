<?php
?>
<style>
    table {
    border-collapse: collapse;
    margin: 25px 0;
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
    padding: 12px 15px;
}
</style>
<form class="actualizarActivos" onSubmit="return false;">                    
    <input type="submit" value="Actualizar lista">
</form>
<table border="1px solid blue">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Empresa de mantenimiento</th>
            <th>Persona/contacto de mantenimiento</th>
            <th>Teléfono</th>
            <th>Operaciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                10
            </td>
            <td>
                Piscina
            </td>
            <td>
                Mantenimiento de la piscina
            </td>
            <td>
                Piscinas S.L.
            </td>
            <td>
                Juan Piscinas
            </td>
            <td>
                123-12-12-12
            </td>
            <td>
                <form class="borrarActivo" aonSubmit="return false;">
                    <input type='hidden' name='idactivo' value='10'>
                    <input type="submit" value="¡Borrar!">
                </form>
                <form class="editarActivo" onSubmit="return false;">
                    <input type='hidden' name='idactivo' value='11'>
                    <input type="submit" value="Editar">
                </form>
            </td>
        </tr>
    </tbody>
</table>
