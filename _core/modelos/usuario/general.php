<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class UsuariosModel
{
	/*============================================================================
	 *
	 *	
	 *
	============================================================================*/
	public static function Listado($valor = "")
	{
        $valor = Filtro::General($valor);

		if($valor == "")
        {
            $query = "SELECT * FROM usuarios ORDER BY usuario ASC";
        }
        else
        {
            $query = "SELECT * FROM usuarios WHERE
            usuario LIKE '%{$valor}%' OR
            nombre LIKE '%{$valor}%' OR
            cedula LIKE '%{$valor}%'
            ORDER BY usuario ASC";
        }

        $datos = Conexion::getMysql()->Consultar($query);
        return $datos;
    }
    
	/*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Existe($usuario)
    {
        $usuario = Filtro::General($usuario);

        $query = "SELECT COUNT(*) AS cantidad FROM usuarios WHERE usuario = '{$usuario}'";
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
    public static function Registrar($usuario, $idRestaurant, $clave, $documento, $nombre, $idRol, $direccion, $telefono, $correo)
    {
        $usuario = Filtro::General($usuario);
        $idRestaurant = (int) $idRestaurant;
        $clave = Filtro::General($clave);
        $documento = Filtro::General($documento);
        $nombre = Filtro::General($nombre);
        $idRol = (int) $idRol;
        $direccion = Filtro::General($direccion);
        $telefono = Filtro::General($telefono);
        $correo = Filtro::General($correo);
        $activo = (int) TRUE;
        $fecha_registro = Time::get();

        $query = "INSERT INTO usuarios
        (usuario, idRestaurant, clave, documento, nombre, idRol, direccion, telefono, correo, activo, fecha_registro)
        VALUES
        ('{$usuario}', '{$idRestaurant}', '{$clave}', '{$documento}', '{$nombre}', '{$idRol}', '{$direccion}', '{$telefono}', '{$correo}', '{$activo}', '{$fecha_registro}')";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar registrar el usuario.<br>{$query}");
        }

        $objUsuario = new UsuarioModel($usuario);
        return $objUsuario;
    }
}