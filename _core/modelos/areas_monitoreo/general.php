<?php

class AreasMonitoreoModel
{
	public static function Listado()
	{
        $query = "SELECT * FROM areas_monitoreo ORDER BY idAreaMonitoreo ASC";
		$datos = Conexion::getMysql()->Consultar($query);
		return $datos;
	}
}