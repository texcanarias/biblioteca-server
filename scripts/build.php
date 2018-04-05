<?php

//@TODO Recuperar estos datos desde el fichero .env
$DB_CONNECTION = "mysql";
$DB_HOST = "hl13.dinaserver.com";
$DB_PORT = "3306";
$DB_DATABASE = "dev_biblioteca";
$DB_USERNAME = "dev_biblioteca";
$DB_PASSWORD = "pkvgigjv73";
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
        $Sql = "INSERT INTO bib_biblioteca SET nombre = '" . limpiar($Nombre) . "' , autor = '" . limpiar($Autor) . "' , leido = ".limpiar($Leidos)." , posicion = '". limpiar($Posicion)."' , origen = '".limpiar($Origen)."' ";
        echo $Sql."\n";
        $stmt = $Connection->prepare($Sql);
        $stmt->execute();
        return $Connection->lastInsertId();
    } catch (PDOexception $e) {
        print_r($e);
    }
}

function limpiar($cadena){
   //Rememplazamos caracteres especiales latinos
   $find = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ä' , 'ë' , 'ï' , 'ö', 'ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü'];
   $repl = ['a', 'e', 'i', 'o', 'u', 'n', 'a' , 'e' , 'i' , 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U'];
   $cadena = str_replace($find, $repl, $cadena);    
   return $cadena;
}