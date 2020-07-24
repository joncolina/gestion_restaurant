<?php

/**
 * 
 */
class GestionAccionesCliente
{
    /**
     * 
     */
    public static function RegistroPlato($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedido)) {
            $conn->send("No se ha enviado el ID del pedido.");
            return;
        }

        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send("No se ha enviado el ID del detalle del pedido.");
            return;
        }

        $idPedido = $objJson->idPedido;
        $idPedidoDetalle = $objJson->idPedidoDetalle;
        $objRestaurant = $conn->objRestaurant;
        $objMesa = $conn->objUsuario;

        echo "Registro de plato: [{$objRestaurant->getNombre()}][{$objMesa->getAlias()}][Pedido: {$idPedido}][Detalle: {$idPedidoDetalle}]\n";
    }

    /**
     * 
     */
    public static function EliminarPlato($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send("No se ha enviado el ID del detalle del pedido.");
            return;
        }

        $idPedidoDetalle = $objJson->idPedidoDetalle;
        $objRestaurant = $conn->objRestaurant;
        $objMesa = $conn->objUsuario;
        echo "Eliminación de plato: [{$objRestaurant->getNombre()}][{$objMesa->getAlias()}][Detalle: {$idPedidoDetalle}]\n";
    }

    /**
     * 
     */
    public static function RegistroCombo($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedido)) {
            $conn->send("No se ha enviado el ID del pedido.");
            return;
        }

        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send("No se ha enviado el ID del detalle del pedido.");
            return;
        }

        $idPedido = $objJson->idPedido;
        $idPedidoDetalle = $objJson->idPedidoDetalle;
        $objRestaurant = $conn->objRestaurant;
        $objMesa = $conn->objUsuario;
        $stringDetalle = implode("-", $idPedidoDetalle);

        echo "Registro de combo: [{$objRestaurant->getNombre()}][{$objMesa->getAlias()}][Pedido: {$idPedido}][Detalle: {$stringDetalle}]\n";
    }

    /**
     * 
     */
    public static function EliminarCombo($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedidoDetalle)) {
            $conn->send("No se ha enviado el ID del detalle del pedido.");
            return;
        }

        $idPedidoDetalle = $objJson->idPedidoDetalle;
        $objRestaurant = $conn->objRestaurant;
        $objMesa = $conn->objUsuario;
        $stringDetalle = implode("-", $idPedidoDetalle);

        echo "Eliminación de plato: [{$objRestaurant->getNombre()}][{$objMesa->getAlias()}][Detalle: {$stringDetalle}]\n";
    }

    /**
     * 
     */
    public static function PedidoConfirmado($clientes, $conn, $objJson)
    {
        if(!isset($objJson->idPedido)) {
            $conn->send("No se ha enviado el ID del pedido.");
            return;
        }

        $idPedido = $objJson->idPedido;
        $objRestaurant = $conn->objRestaurant;
        $objMesa = $conn->objUsuario;

        echo "Confirmación de pedido: [{$objRestaurant->getNombre()}][{$objMesa->getAlias()}][Pedido: {$idPedido}]\n";
        
        GestionMonitoreoCocina::AgregarPedido($clientes, $conn, $objJson);
    }
}