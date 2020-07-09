<?php

$objRestaurant = Sesion::getRestaurant();

if($objRestaurant->getStatusServicio())
{
    $archivo = $objRestaurant->getRutaDB();
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

    $resultado = Conexion::getSQLite()->Ejecutar($query);
    if($resultado === FALSE) {
        throw new Exception("Ocurrio un error al intentar iniciar la base de datos.");
    }

    Conexion::getSQLite()->Commit();
}

echo json_encode($respuesta);