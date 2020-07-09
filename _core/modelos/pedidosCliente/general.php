<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	modelo GENERAL de PEDIDOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidosClienteModel
{
    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public static function Carrito($idRestaurant, $idMesa)
    {
        $idRestaurant = (int) $idRestaurant;
        $idMesa = (int) $idMesa;
        $status = 0;

        $query = "SELECT * FROM pedidos WHERE idRestaurant = '{$idRestaurant}' AND idMesa = '{$idMesa}' AND status = '{$status}'";
        $datos = Conexion::getSqlite()->Consultar($query);

        return $datos;
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
	public static function Registrar($idRestaurant, $idMesa, $idPlato, $nombrePlato, $idCombo, $nombreCombo, $precioUnitario, $cantidad, $descuento, $nota, $para_llevar)
	{
		//Busca el ID maximo e incrementa en 1
		$idPedido = Conexion::getSqlite()->NextID("pedidos", "idPedido");
		$idRestaurant = (int) $idRestaurant;
		$idMesa = (int) $idMesa;
        $idPlato = (int) $idPlato;
        $nombrePlato = Filtro::General($nombrePlato);
        $idCombo = (int) $idCombo;
        $nombreCombo = Filtro::General($nombreCombo);
        $precioUnitario = $precioUnitario;
        $cantidad = (int) $cantidad;
        $descuento = $descuento;
        $precioTotal = bcdiv($precioUnitario * $cantidad * (1 - ($descuento / 100)), '1', 2);
        $nota = Filtro::General($nota);
        $para_llevar = boolval( $para_llevar );
        $status = 0;
		$fecha_registro = Time::get();
		
		$query = "INSERT  INTO pedidos (idPedido, idRestaurant, idMesa, idPlato, nombrePlato, idCombo, nombreCombo, precioUnitario, cantidad, descuento, precioTotal, nota, para_llevar, status, fecha_registro)
			VALUES
			('{$idPedido}', '{$idRestaurant}', '{$idMesa}', '{$idPlato}', '{$nombrePlato}', '{$idCombo}', '{$nombreCombo}', '{$precioUnitario}', '{$cantidad}', '{$descuento}', '{$precioTotal}', '{$nota}', '{$para_llevar}', '{$status}', '{$fecha_registro}')"
		;
		$respuesta = Conexion::getSqlite()->Ejecutar( $query );
		if($respuesta == FALSE) {
			throw new Exception("Ocurrio un error al intentar registrar el pedido.");
		}

		$objPedido = new PedidoClienteModel($idPedido);
		return $objPedido;
	}
}