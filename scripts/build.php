<?php

//@TODO Recuperar estos datos desde el fichero .env
$DB_CONNECTION = "mysql";
$DB_HOST = "127.0.0.1";
$DB_PORT = "3306";
$DB_DATABASE = "biblioteca";
$DB_USERNAME = "debian";
$DB_PASSWORD = "debian";
$Connection = new PDO("mysql:dbname=$DB_DATABASE;host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);


$csvLibros = file_get_contents('libros_leidos.csv');
$Lineas = explode("\n",$csvLibros);
foreach ($Lineas as $Linea) {
    $Campos = str_getcsv($Linea,',','"');
    set($Connection, $Campos[0], $Campos[1], "", $Campos[2], 1);
}

$csvLibros = file_get_contents('libros_deseados.csv');
$Lineas = explode("\n",$csvLibros);
foreach ($Lineas as $Linea) {
    $Campos = str_getcsv($Linea,',','"');
    set($Connection, $Campos[0], $Campos[1], $Campos[2], "", 0);
}

function set($Connection, $Nombre, $Autor, $Posicion, $Origen, $Leidos) {
    try {
        $Sql = "INSERT INTO bib_biblioteca SET nombre = '" . $Nombre . "' , autor = '" . $Autor . "' , leido = ".$Leidos." , posicion = '".$Posicion."' , origen = '".$Origen."' ";
        echo $Sql."\n";
        $stmt = $Connection->prepare($Sql);
        $stmt->execute();
        return $Connection->lastInsertId();
    } catch (PDOexception $e) {
        print_r($e);
    }
}