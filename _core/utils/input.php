<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Input
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Input
{
	/*============================================================================
	 *
	 *	POST
	 *
	============================================================================*/
    public static function POST($key, $obligatorio = TRUE)
    {
        if($obligatorio)
        {
            if(!isset($_POST[$key])) {
                throw new Exception("Error, no se enviado el parametro '{$key}' por POST.");
            }

            return $_POST[$key];
        }
        else
        {
            if(!isset($_POST[$key])) {
                return FALSE;
            } else {
                return $_POST[$key]; 
            }
        }
    }

	/*============================================================================
	 *
	 *	GET
	 *
	============================================================================*/
    public static function GET($key, $obligatorio = TRUE)
    {
        if($obligatorio)
        {
            if(!isset($_GET[$key])) {
                throw new Exception("Error, no se enviado el parametro '{$key}' por GET.");
            }

            $salida = str_replace("/", "", $_GET[$key]);
            return $salida;
        }
        else
        {
            if(!isset($_GET[$key])) {
                return FALSE;
            } else {
                $salida = str_replace("/", "", $_GET[$key]);
                return $salida;
            }
        }
    }
}