<?php

$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

$pedidos = PedidosModel::Carrito($objRestaurant->getId(), $objMesa->getId());
$respuesta['data']['cantidad'] = sizeof($pedidos);

echo json_encode($respuesta);