<?php

//@TODO Recuperar estos datos desde el fichero .env
$DB_CONNECTION = "mysql";
$DB_HOST = "hl13.dinaserver.com";
$DB_PORT = "3306";
$DB_DATABASE = "dev_biblioteca";
$DB_USERNAME = "dev_biblioteca";
$DB_PASSWORD = "pkvgigjv73";
$Connection = new PDO("mysql:dbname=$DB_DATABASE;host=$DB_HOST;charset=utf8", $DB_USERNAME, $DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));


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
        $Sql = "INSERT INTO bib_biblioteca SET nombre = '" . preg_replace('([^A-Za-z0-9 ()])', '_', $Nombre) . "' , autor = '" . preg_replace('([^A-Za-z0-9 ()])', '_', $Autor) . "' , leido = ".$Leidos." , posicion = '".$Posicion."' , origen = '".$Origen."' ";
        echo $Sql."\n";
        $stmt = $Connection->prepare($Sql);
        $stmt->execute();
        return $Connection->lastInsertId();
    } catch (PDOexception $e) {
        print_r($e);
    }
}