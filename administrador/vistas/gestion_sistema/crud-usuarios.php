<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	CRUD DE LOS USUARIOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$accion = Input::POST("accion");

/*================================================================================
 * 
================================================================================*/
switch($accion)
{
    case "CONSULTAR":
        $buscar = Input::POST("buscar", FALSE);

        if($buscar === FALSE) {
            $usuarios = AdminUsuariosModel::Listado();
        } else {
            $usuarios = AdminUsuariosModel::Listado( $buscar );
        }

        $datos = [];
        for($I=0; $I<sizeof($usuarios); $I++)
        {
            $datos[$I] = [
                "nombre" => $usuarios[$I]['nombre'],
                "cedula" => $usuarios[$I]['cedula'],
                "usuario" => $usuarios[$I]['usuario'],
                "fecha_registro" => $usuarios[$I]['fecha_registro']
            ];
        }

        $respuesta['data'] = $datos;
    break;

    case "CONSULTAR-UNICO":
        $usuario = Input::POST("usuario");

        $objUsuario = new AdminUsuarioModel($usuario);

        $respuesta['data'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    case "REGISTRAR":
        $nombre = Input::POST("nombre");
        $cedula = Input::POST("cedula");
        $usuario = Input::POST("usuario");
        $clave = Input::POST("clave");

        if( AdminUsuariosModel::Existe( $usuario ) ) {
            throw new Exception("El usuario '{$usuario}' ya existe.");
        }

        $objUsuario = AdminUsuariosModel::Registrar($usuario, $clave, $nombre, $cedula);
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    case "MODIFICAR":
        
    break;

    case "ELIMINAR":
        $usuario = Input::POST("usuario");
        $objUsuario = new AdminUsuarioModel($usuario);

        if($objUsuario->getUsuario() == Sesion::getUsuario()->getUsuario()) {
            throw new Exception("No puede eliminar su usuario loggeado.");
        }

        $objUsuario->Eliminar();
        Conexion::getMysql()->Commit();

        $respuesta['data'] = [
            "nombre" => $objUsuario->getNombre(),
            "cedula" => $objUsuario->getCedula(),
            "usuario" => $objUsuario->getUsuario(),
            "fecha_registro" => $objUsuario->getFechaRegistro()
        ];
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}

/*================================================================================
 * Retornamos la salida
================================================================================*/
echo json_encode( $respuesta );