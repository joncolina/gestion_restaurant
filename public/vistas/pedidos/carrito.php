<?php

/**
 * Iniciamos los objetos
 */
$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

/**
 * Creamos la conexión con la BD temporal
 */
Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );

/**
 * Consultamos
 */
$pedidos = PedidosClienteModel::Carrito($objRestaurant->getId(), $objMesa->getId());
$respuesta['data']['cantidad'] = sizeof($pedidos);

/**
 * Retornamos
 */
echo json_encode($respuesta);