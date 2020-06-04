<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de RESTAURANTES
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RestaurantesModel
{
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($valor = "")
	{
		if($valor == "")
        {
            $query = "SELECT * FROM restaurantes ORDER BY nombreFantasia ASC";
        }
        else
        {
            $query = "SELECT * FROM restaurantes WHERE
            documento LIKE '%{$valor}%' OR
            razonSocial LIKE '%{$valor}%' OR
            nombreFantasia LIKE '%{$valor}%'
            ORDER BY nombreFantasia ASC";
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
}