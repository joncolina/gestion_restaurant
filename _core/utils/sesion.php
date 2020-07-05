<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Sesión
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Sesion
{
    /*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private const KEY_CLIENTE = "CLIENTE_".SEGURIDAD_KEY;
    private const KEY_ADMIN = "ADMIN_".SEGURIDAD_KEY;
    private const KEY = SEGURIDAD_KEY;
    private static $restaurant;
    private static $usuario;
    private static $ip;

    /*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public static function getRestaurant() {
        return self::$restaurant;
    }

    public static function getUsuario() {
        return self::$usuario;
    }

    public static function getIp() {
        return self::$ip;
    }

    /*============================================================================
	 *
	 *	Iniciar
	 *
    ============================================================================*/
    public static function Iniciar()
    {
        session_start();
    }

    /*============================================================================
	 *
	 *	Crear
	 *
    ============================================================================*/
    public static function Crear($idRestaurant, $idUsuario)
    {
        $ip = IP_CLIENTE;

        $string = $idRestaurant."-".$idUsuario."-".$ip;
        $_SESSION[self::KEY] = $string;
    }

    public static function CrearAdmin($usuario)
    {
        $ip = IP_CLIENTE;

        $string = $usuario."-".$ip;
        $_SESSION[self::KEY_ADMIN] = $string;
    }

    public static function CrearCliente($idRestaurant, $idMesa)
    {
        $ip = IP_CLIENTE;

        $string = $idRestaurant."-".$idMesa."-".$ip;
        $_SESSION[self::KEY_CLIENTE] = $string;
    }

    /*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public static function Cerrar()
    {
        $_SESSION[self::KEY] = "";
        unset($_SESSION[self::KEY]);
    }

    public static function CerrarAdmin()
    {
        $_SESSION[self::KEY_ADMIN] = "";
        unset($_SESSION[self::KEY_ADMIN]);
    }

    public static function CerrarCliente()
    {
        $_SESSION[self::KEY_CLIENTE] = "";
        unset($_SESSION[self::KEY_CLIENTE]);
    }

    /*============================================================================
	 *
	 *	Validar
	 *
    ============================================================================*/
    public static function Validar()
    {
        if(!isset($_SESSION[self::KEY])) {
            return FALSE;
        }
        
        $contentText = $_SESSION[self::KEY];
        $contentArray = explode("-", $contentText);

        if(sizeof($contentArray) != 3) {
            return FALSE;
        }

        $idRestaurant = $contentArray[0];
        $idUsuario = $contentArray[1];
        $ip = $contentArray[2];

        try {
            $objRestaurant = new RestaurantModel($idRestaurant);
            self::$restaurant = $objRestaurant;
        } catch(Exception $e) {
            return FALSE;
        }

        try {
            $objUsuario = new UsuarioModel($idUsuario);
            self::$usuario = $objUsuario;
        } catch(Exception $e) {
            return FALSE;
        }
        
        if($objUsuario->getIdRestaurant() != $objRestaurant->getId()) {
            return FALSE;
        }

        if($objUsuario->getActivo() === FALSE) {
            return FALSE;
        }

        if($objRestaurant->getActivo() === FALSE) {
            return FALSE;
        }

        if($ip !== IP_CLIENTE) {
            return FALSE;
        }

        return TRUE;
    }

    public static function ValidarAdmin()
    {
        if(!isset($_SESSION[self::KEY_ADMIN])) {
            return FALSE;
        }
        
        $contentText = $_SESSION[self::KEY_ADMIN];
        $contentArray = explode("-", $contentText);

        if(sizeof($contentArray) != 2) {
            return FALSE;
        }

        $usuario = $contentArray[0];
        $ip = $contentArray[1];

        try {
            $objUsuario = new AdminUsuarioModel($usuario);
            self::$usuario = $objUsuario;
        } catch(Exception $e) {
            return FALSE;
        }

        if($ip !== IP_CLIENTE) {
            return FALSE;
        }

        return TRUE;
    }

    public static function ValidarCliente()
    {
        if(!isset($_SESSION[self::KEY_CLIENTE])) {
            return FALSE;
        }
        
        $contentText = $_SESSION[self::KEY_CLIENTE];
        $contentArray = explode("-", $contentText);

        if(sizeof($contentArray) != 3) {
            return FALSE;
        }

        $idRestaurant = $contentArray[0];
        $idMesa = $contentArray[1];
        $ip = $contentArray[2];

        try {
            $objRestaurant = new RestaurantModel($idRestaurant);
            self::$restaurant = $objRestaurant;
        } catch(Exception $e) {
            return FALSE;
        }

        try {
            $objUsuario = MesasModel::BuscarPorUsuario($idMesa);
            self::$usuario = $objUsuario;
        } catch(Exception $e) {
            return FALSE;
        }

        if($objUsuario->getStatus() != "OCUPADA") {
            return FALSE;
        }

        if($objRestaurant->getActivo() === FALSE) {
            return FALSE;
        }

        if($ip !== IP_CLIENTE) {
            return FALSE;
        }

        return TRUE;
    }
}