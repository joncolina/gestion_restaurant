<?php

/**
 * Tomamos los parametros
 */
$idPlato = Input::POST("idPlato", TRUE);
$cantidad = (int) Input::POST("cantidad", TRUE);
$observaciones = Input::POST("observaciones", TRUE);

/**
 * Contruimos los objectos
 */
$objPlato = new PlatoModel($idPlato);
$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

/**
 * Validamos los objectos y su relación
 */
if($objPlato->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("El plato <b>{$objPlato->getNombre()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

if($objMesa->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("La mesa <b>{$objMesa->getAlias()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

/**
 * Validamos el status del servicio
 */
if( $objRestaurant->getStatusServicio() === FALSE ) {
    throw new Exception("El servicio no esta activo.");
}

/**
 * Validamos la cantidad
 */
if($cantidad <= 0) throw new Exception("La cantidad debe ser un numero entero positivo.");

/**
 * Construimos las variables
 */
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

/**
 * Registramos el pedido
 */
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

/**
 * Guardamos los cambios
 */
Conexion::getMysql()->Commit();

/**
 * Mostramos
 */
echo json_encode($respuesta);