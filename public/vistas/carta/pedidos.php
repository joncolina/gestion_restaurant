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
 * Creamos la conexión con la BD temporal
 */
Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );

/**
 * Validamos si hay un pedido abierto
 */
$objPedido = PedidosClienteModel::Abierto( $objRestaurant->getId(), $objMesa->getId() );
if($objPedido === FALSE) {
    $objPedido = PedidosClienteModel::Registrar( $objRestaurant->getId(), $objMesa->getId() );
}

/**
 * 
 */
$objCategoria = new CategoriaModel($objPlato->getidCategoria());

/**
 * Construimos las variables
 */
$idPedido = $objPedido->getId();
$idPlato = $objPlato->getId();
$nombrePlato = $objPlato->getNombre();
$idCombo = NULL;
$nombreCombo = NULL;
$idAreaMonitoreo = $objCategoria->getIdAreaMonitoreo();
$precioUnitario = bcdiv($objPlato->getPrecioVenta(), '1', 2);
$cantidad = (int) $cantidad;
$descuento = 0;
$nota = $observaciones;
$para_llevar = FALSE;

/**
 * Registramos el pedido
 */
$objPedidoDetalle = PedidosDetallesClienteModel::Registrar(
    $idPedido,
    $idPlato,
    $nombrePlato,
    $idCombo,
    $nombreCombo,
    $idAreaMonitoreo,
    $precioUnitario,
    $cantidad,
    $descuento,
    $nota,
    $para_llevar
);

/**
 * 
 */
$idRestaurant = Sesion::getRestaurant()->getId();
$idUsuario = Sesion::getUsuario()->getId();
$urlWebSocket = SOCKET["URL"]."PUBLIC/carta-pedidos/{$idRestaurant}/{$idUsuario}/";
require_once(BASE_DIR."_core/APIs/vendor/autoload.php");
$client = new WebSocket\Client($urlWebSocket);
$client->send(json_encode([
    "accion" => "RegistroPlato",
    "idPedido" => $objPedido->getId(),
    "idPedidoDetalle" => $objPedidoDetalle->getId()
]));
$client->close();

/**
 * Guardamos los cambios
 */
Conexion::getSqlite()->Commit();