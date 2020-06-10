<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Inicio de sesión
 *
 *--------------------------------------------------------------------------------
================================================================================*/

/*================================================================================
 * Tomamos los parametros
================================================================================*/
$usuario = Input::POST("usuario");
$clave = Input::POST("clave");

/*================================================================================
 * Validamos el usuario y la contraseña
================================================================================*/
$objUsuario = new UsuarioModel($usuario);

if($objUsuario->getClave() != $clave) {
    throw new Exception("Contraseña incorrecta");
}

$objRestaurant = new RestaurantModel( $objUsuario->getIdRestaurant() );

if($objRestaurant->getActivo() === FALSE) {
    throw new Exception("EL restaurant <b>".$objRestaurant->getNombre()."</b> no esta activo.");
}

if($objUsuario->getActivo() === FALSE) {
    throw new Exception("EL usuario <b>".$objUsuario->getNombre()."</b> no esta activo.");
}

/*================================================================================
 * Iniciamos la sesión
================================================================================*/
Sesion::Crear($objRestaurant->getId(), $objUsuario->getUsuario());

/*================================================================================
 * Retornamos la salida
================================================================================*/
echo json_encode( $respuesta );