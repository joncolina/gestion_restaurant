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
	/**
     * Listado
     * Array(
     *      condicional: string
     *      cantMostrar: number (> 1)
     *      pagina: number (> 0)
     *      ordenar_por: string
     *      ordenar_tipo: string (ASC / DESC)
     *  )
     */
	public static function Listado($condicional, $par = [])
	{
		/**
         * Iniciar
         */
        $order_by = "";
        $where = "";
        $limit = "";

        /**
         * Where
         */        
        if($condicional != "")
        {
            $where = "WHERE {$condicional}";
        }

        /**
         * Limit
         */
        if(isset($par['cantMostrar']))
        {
            $cantMostrar = (int) $par['cantMostrar'];
            if($cantMostrar < 1) $cantMostrar = 10;
            if(isset($par['pagina']))
            {
                $pagina = (int) $par['pagina'];
                if($pagina < 1) $pagina = 1;
                $inicio = ($pagina - 1) * $cantMostrar;
                $limit = "LIMIT {$inicio}, {$cantMostrar}";
            }
            else
            {
                $limit = "LIMIT {$cantMostrar}";
            }   
        }

        /**
         * Order by
         */
        if(isset($par['ordenar_por']))
        {
            $key = $par['ordenar_por'];
            $type = (isset($par['ordenar_tipo'])) ? $par['ordenar_tipo'] : 'ASC';
            if($type != "ASC" && $type != "DESC") $type = "ASC";
            $order_by = "ORDER BY {$key} {$type}";
        }

        /**
         * Consulta
         */
        $query = "SELECT * FROM restaurantes {$where} {$order_by} {$limit}";
        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }

    /*============================================================================
	 *
	 *	
	 *
	============================================================================*/
    public static function Total($condicional = "")
    {
        $where = ( $condicional != "" ) ? "WHERE {$condicional}" : '';

        $query = "SELECT COUNT(*) AS cantidad FROM restaurantes {$where}";
        $datos = Conexion::getMysql()->Consultar($query);

        $cantidad = (int) $datos[0]['cantidad'];
        return $cantidad;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Existe($documento, $nombre)
    {
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);

        $query = "SELECT COUNT(*) AS cantidad FROM restaurantes WHERE documento = '{$documento}' AND nombre = '{$nombre}'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        if($cantidad > 0) return TRUE;
        else return FALSE;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Registrar($documento, $nombre, $direccion, $telefono, $correo)
    {
        $idRestaurant = Conexion::getMysql()->NextID("restaurantes", "idRestaurant");
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);
        $direccion = Filtro::General($direccion);
        $telefono = Filtro::General($telefono);
        $correo = Filtro::General($correo);
        $activo = (int) TRUE;
        $fecha_registro = Time::get();

        $query = "INSERT INTO restaurantes
        (idRestaurant, documento, nombre, direccion, telefono, correo, activo, fecha_registro)
        VALUES
        ('{$idRestaurant}', '{$documento}', '{$nombre}', '{$direccion}', '{$telefono}', '{$correo}', '{$activo}', '{$fecha_registro}')";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Error al intentar registrar el restaurant.");
        }

        $objRestaurant = new RestaurantModel($idRestaurant);
        return $objRestaurant;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function CantidadResponsables($idRestaurant)
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuarios A, roles B WHERE A.idRol = B.idRol AND B.idRestaurant = '{$idRestaurant}' AND B.responsable = '1' AND A.activo = '1'";
        $datos = Conexion::getMysql()->Consultar($query);
        $cantidad = $datos[0]['cantidad'];

        return $cantidad;
    }
}