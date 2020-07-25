<?php

/**
 * 
 */
class Peticion
{
    /**
     * 
     */
    private static $area = null;
    private static $archivo = null;
    private static $objRestaurant = null;
    private static $objUsuario = null;

    /**
     * 
     */
    public static function Iniciar($conexion)
    {
        $path = $conexion->httpRequest->getUri()->getPath();
        $arrayPath = explode("/", $path);
        $arrayPath = array_filter($arrayPath);
        $arrayPath = array_values($arrayPath);

        if(sizeof($arrayPath) < 4) {
            self::$area = null;
            self::$archivo = null;
            self::$objUsuario = null;
            self::$objRestaurant = null;
            throw new Exception("Petición con parametros insuficientes.");
        }

        $area = $arrayPath[0];
        $archivo = $arrayPath[1];
        $idRestaurant = $arrayPath[2];
        $idUsuario = $arrayPath[3];
        
        self::$area = $area;
        self::$archivo = $archivo;

        try {
            self::$objRestaurant = new RestaurantModel( $idRestaurant );
        } catch(Exception $e) {
            self::$objRestaurant = null;
            throw new Exception("Restaurant 'id: {$idRestaurant}' no valido.");
        }

        switch(self::$area)
        {
            case AREA_GERENCIAL:
                try {
                    self::$objUsuario = new UsuarioModel( $idUsuario );
                } catch(Exception $e) {
                    self::$objUsuario = null;
                    throw new Exception("Usuario 'id: {$idUsuario}' no valido.");
                }
            break;

            default:
                try {
                    self::$objUsuario = new MesaModel( $idUsuario );
                } catch(Exception $e) {
                    self::$objUsuario = null;
                    throw new Exception("Mesa 'id: {$idUsuario}' no valido.");
                }
            break;
        }

        if(!self::$objRestaurant->getStatusServicio()) {
            throw new Exception("El servicio de restaurant no esta activo.");
        }
    }

    /**
     * 
     */
    public static function getArea() {
        return self::$area;
    }

    /**
     * 
     */
    public static function getArchivo() {
        return self::$archivo;
    }

    /**
     * 
     */
    public static function getRestaurant() {
        return self::$objRestaurant;
    }

    /**
     * 
     */
    public static function getUsuario() {
        return self::$objUsuario;
    }
}