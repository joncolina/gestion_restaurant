<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo GENERAL de ADMIN_USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class AdminUsuariosModel
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
            $query = "SELECT * FROM adm_usuarios ORDER BY usuario ASC";
        }
        else
        {
            $query = "SELECT * FROM adm_usuarios WHERE
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

        $query = "SELECT COUNT(*) AS cantidad FROM adm_usuarios WHERE usuario = '{$usuario}'";
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
    public static function Registrar($usuario, $clave, $nombre, $cedula)
    {
        $usuario = Filtro::General($usuario);
        $clave = Filtro::General($clave);
        $nombre = Filtro::General($nombre);
        $cedula = Filtro::General($cedula);
        $fecha_registro = Time::get();

        $query = "INSERT INTO adm_usuarios (usuario, clave, nombre, cedula, fecha_registro) VALUES ('{$usuario}', '{$clave}', '{$nombre}', '{$cedula}', '{$fecha_registro}')";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar registrar el usuario.<br>".Conexion::getMysql()->getError());
        }

        $objUsuario = new AdminUsuarioModel($usuario);
        return $objUsuario;
    }
}