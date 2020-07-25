<?php

$idRestaurant = Sesion::getRestaurant()->getId();
$idUsuario = Sesion::getUsuario()->getId();
$urlWebSocket = SOCKET["URL"].AREA_GERENCIAL."/mesas-servicio/{$idRestaurant}/{$idUsuario}/";
require_once(BASE_DIR."_core/APIs/vendor/autoload.php");
$objRestaurant = Sesion::getRestaurant();

if($objRestaurant->getStatusServicio())
{
    $archivo = $objRestaurant->getRutaDB();

    $client = new WebSocket\Client($urlWebSocket);
    $client->send(json_encode([
        "accion" => "CerrarServicio"
    ]));
    $client->close();

    unlink($archivo);
}
else
{
    Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );

    $fArchivo = fopen(BASE_DIR."database_temporary/estructura.txt", "r");
    $query = "";

    while(!feof($fArchivo))
    {
        $linea = fgets($fArchivo);
        if($query != "") $query .= "\n";
        $query .= $linea;
    }

    fclose($fArchivo);

    $queryArray = explode(";", $query);
    foreach($queryArray as $query)
    {
        if($query == "") continue;
        $resultado = Conexion::getSQLite()->Ejecutar($query);
        if($resultado === FALSE) {
            throw new Exception("Ocurrio un error al intentar iniciar la base de datos.");
        }
    }

    $client = new WebSocket\Client($urlWebSocket);
    $client->send(json_encode([
        "accion" => "ActivarServicio"
    ]));
    $client->close();

    Conexion::getSQLite()->Commit();
}