<?php

/**
 * 
 */
class GestionServicio
{
    /**
     * 
     */
    public static function CerrarServicio($clientes, $conn, $objJson)
    {
        foreach($clientes as $cliente)
        {
            if($cliente->objRestaurant->getId() != $conn->objRestaurant->getId()) continue;
            $cliente->close();
        }

        $conn->close();
    }

    /**
     * 
     */
    public static function ActivarServicio($clientes, $conn, $objJson)
    {
        $conn->close();
    }
}