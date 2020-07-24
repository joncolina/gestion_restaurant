<?php

/**
 * 
 */
$idRestaurant = Sesion::getRestaurant()->getId();
$idUsuario = Sesion::getUsuario()->getId();
$urlWebSocket = SOCKET["URL"]."PUBLIC/menus-pedidos/{$idRestaurant}/{$idUsuario}/";
require_once(BASE_DIR."_core/APIs/vendor/autoload.php");

/**
 * Parametros
 */
$accion = Input::POST("accion", TRUE);

/**
 * Iniciamos los objetos
 */
$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

/**
 * Verificamos el status del servicio
 */
if( $objRestaurant->getStatusServicio() === FALSE ) {
    throw new Exception("Servicio no activo.");
}

/**
 * Creamos la conexión con la BD temporal
 */
Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );

switch($accion)
{
    case "TOTAL":
        $pedidos = PedidosDetallesClienteModel::SinConfirmar( $objRestaurant->getId(), $objMesa->getId() );
        $pedidosSinConfirmar = sizeof( $pedidos );

        $respuesta['cuerpo']['cantidad'] = $pedidosSinConfirmar;
    break;

    case "CONSULTA":
        $condicional = "idRestaurant = '{$objRestaurant->getId()}' AND idMesa = '{$objMesa->getId()}'";
        $pedidos = PedidosDetallesClienteModel::Listado( $condicional );
        $dataPedidos = [];

        foreach($pedidos as $pedido)
        {
            $objPlato = new PlatoModel( $pedido['idPlato']);
            $objCategoria = new CategoriaModel( $objPlato->getIdCategoria() );

            if($pedido['idCombo'] == 0 AND $pedido['nombreCombo'] == "") {
                $pedido['idCombo'] = NULL;
                $pedido['nombreCombo'] = NULL;
            }

            array_push($dataPedidos, [
                "id" => $pedido['idPedidoDetalle'],
                "plato" => [
                    "id" => $objPlato->getId(),
                    "nombre" => $objPlato->getNombre(),
                    "descripcion" => $objPlato->getDescripcion(),
                    "imagen" => $objPlato->getImagen()
                ],
                "categoria" => [
                    "id" => $objCategoria->getId(),
                    "nombre" => $objCategoria->getNombre()
                ],
                "combo" => [
                    "id" => $pedido['idCombo'],
                    "nombre" => $pedido['nombreCombo']
                ],
                "precioUnitario" => $pedido['precioUnitario'],
                "cantidad" => $pedido['cantidad'],
                "descuento" => $pedido['descuento'],
                "precioTotal" => $pedido['precioTotal'],
                "nota" => $pedido['nota'],
                "para_llevar" => boolval( $pedido['para_llevar'] ),
                "status" => [
                    "id" => (int) $pedido['status'],
                    "nombre" => STATUS_PEDIDOS[ $pedido['status'] ]
                ],
                "fecha_registro" => $pedido['fecha_registro']
            ]);
        }

        $respuesta['cuerpo']['pedidos'] = $dataPedidos;
    break;

    case "ELIMINAR":
        $idPedidoDetalle = Input::POST("id", TRUE);
        $objPedidoDetalle = new PedidoDetallesClienteModel($idPedidoDetalle);
        $objPedido = new PedidoClienteModel($objPedidoDetalle->getIdPedido());

        if($objPedido->getIdRestaurant() != $objRestaurant->getId()) {
            throw new Exception("No puede realizar operaciones con pedidos de otros restaurantes.");
        }

        if($objPedido->getIdMesa() != $objMesa->getId()) {
            throw new Exception("No puede realizar operaciones con pedidos de otras mesas.");
        }

        $client = new WebSocket\Client($urlWebSocket);

        if($objPedidoDetalle->getIdCombo() == 0)
        {
            $idPedidoDetalleEliminado = $objPedidoDetalle->Eliminar();
            $client->send(json_encode([
                "accion" => "EliminarPlato",
                "idPedidoDetalle" => $idPedidoDetalleEliminado
            ]));
        }
        else
        {
            $arrayIdPedidosEliminados = $objPedidoDetalle->EliminarPorCombo();
            $client->send(json_encode([
                "accion" => "EliminarCombo",
                "idPedidoDetalle" => $arrayIdPedidosEliminados
            ]));
        }

        $client->close();

        /**
         * 
         */
        Conexion::getSqlite()->Commit();
    break;

    case "CONFIRMAR":
        $objPedido = PedidosClienteModel::Abierto( $objRestaurant->getId(), $objMesa->getId() );
        if($objPedido === FALSE) {
            throw new Exception("La mesa actual no tiene pedidos abierto.");
        }

        $objPedido->setAbierto(FALSE);

        $detalles = $objPedido->getDetalles();
        foreach($detalles as $detalle)
        {
            $objDetalle = new PedidoDetallesClienteModel($detalle['idPedidoDetalle']);
            $objDetalle->setStatus(1);
        }

        $client = new WebSocket\Client($urlWebSocket);
        $client->send(json_encode([
            "accion" => "PedidoConfirmado",
            "idPedido" => $objPedido->getId()
        ]));
        $client->close();
        
        Conexion::getSqlite()->Commit();
    break;

    default:
        throw new Exception("Acción invalida.");
    break;
}