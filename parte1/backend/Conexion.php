<?php

class Conexion{
/**
 * Archivo de configuración para conectar con la base de datos usando PDO. 
 * La información a almacenará será DSN, usuario y contraseña, y se almacenará 
 * en las constantes: 
 * DB_DSN, DB_USER, DB_PASSWD.
 */
function connect(){
        //creamos un objeto de la conexión con la base de datos y esperamos la excepción
        try{
            $connDB = new PDO(DB_DSN, DB_USER, DB_PASSWD);
            $connDB -> setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $ex){
            echo "<br>Error: ".$ex->getCode();
            echo "<br>Error: ".$ex->getMessage();
        }
        //si hay error devolvemos el objeto que contiene la conexión con la tabla INCMOTIV
        if(!isset($ex)){
            return $connDB;

        }else{
            return null;
        }
    }
}
