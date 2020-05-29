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
    private const KEY_ADMIN = "ADMIN_".SEGURIDAD_KEY;
    private const KEY = SEGURIDAD_KEY;
    private static $resturant;
    private static $usuario;
    private static $ip;

    /*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public static function getResturant() {
        return self::$resturant;
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
    public static function Crear($idResturant, $usuario)
    {
        $ip = IP_CLIENTE;

        $string = $idResturant."-".$usuario."-".$ip;
        $_SESSION[self::KEY] = $string;
    }

    public static function CrearAdmin($usuario)
    {
        $ip = IP_CLIENTE;

        $string = $usuario."-".$ip;
        $_SESSION[self::KEY_ADMIN] = $string;
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

        $idResturant = $contentArray[0];
        $usuario = $contentArray[1];
        $ip = $contentArray[2];

        try {
            $objResturant = new RestaurantModel($idResturant);
            self::$resturant = $objResturant;
        } catch(Exception $e) {
            return FALSE;
        }

        try {
            $objUsuario = new UsuarioModel($usuario);
            self::$usuario = $objUsuario;
        } catch(Exception $e) {
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
}