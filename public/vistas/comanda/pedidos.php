<?php

$idPlato = Input::POST("idPlato", TRUE);
$cantidad = (int) Input::POST("cantidad", TRUE);
$observaciones = Input::POST("observaciones", TRUE);

$objPlato = new PlatoModel($idPlato);
$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

if($objPlato->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("El plato <b>{$objPlato->getNombre()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

if($objMesa->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("La mesa <b>{$objMesa->getAlias()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

if($cantidad <= 0) throw new Exception("La cantidad debe ser un numero entero positivo.");

$idRestaurant = $objRestaurant->getId();
$idMesa = $objMesa->getId();
$idPlato = $objPlato->getId();
$nombrePlato = $objPlato->getNombre();
$idCombo = FALSE;
$nombreCombo = FALSE;
$precioUnitario = bcdiv($objPlato->getPrecioVenta(), '1', 2);
$cantidad = (int) $cantidad;
$descuento = 0;
$nota = $observaciones;
$para_llevar = FALSE;

PedidosModel::Registrar(
    $idRestaurant,
    $idMesa,
    $idPlato,
    $nombrePlato,
    $idCombo,
    $nombreCombo,
    $precioUnitario,
    $cantidad,
    $descuento,
    $nota,
    $para_llevar
);

Conexion::getMysql()->Commit();

echo json_encode($respuesta);