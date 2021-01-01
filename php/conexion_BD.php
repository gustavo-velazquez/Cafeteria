<?php

    $servidor = "localhost";
    $usuario = "root";
    $contrasenia = "";
    $basededatos = "cafeatlantico";

    $conexion = mysqli_connect($servidor,$usuario,$contrasenia) or die("No se hapodio conectar al servidor de Base de Datos.");

        
    $db = mysqli_select_db($conexion,$basededatos);

?>