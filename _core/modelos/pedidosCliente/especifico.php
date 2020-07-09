<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de PEDIDOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class PedidoClienteModel
{
    /*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $idMesa;
	private $idPlato;
	private $nombrePlato;
	private $idCombo;
	private $nombreCombo;
	private $precioUnitario;
	private $cantidad;
	private $descuento;
	private $precioTotal;
	private $nota;
	private $para_llevar;
	private $status;
	private $aux_1;
	private $aux_2;
	private $aux_3;
    private $fecha_registro;
    
    /*=======================================================================
	 *
	 *	GETTER
	 *
    =======================================================================*/
	public function getId() {
        return $this->id;
    }

    public function getIdRestaurant() {
        return $this->idRestaurant;
    }

    public function getIdMesa() {
        return $this->idMesa;
    }

    public function getIdPlato() {
        return $this->idPlato;
    }

    public function getNombrePlato() {
        return $this->nombrePlato;
    }

    public function getIdCombo() {
        return $this->idCombo;
    }

    public function getNombreCombo() {
        return $this->nombreCombo;
    }

    public function getPrecioUnitario() {
        return $this->precioUnitario;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function getPrecioTotal() {
        return $this->precioTotal;
    }

    public function getNota() {
        return $this->nota;
    }

    public function getPara_llevar() {
        return $this->para_llevar;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAux_1() {
        return $this->aux_1;
    }

    public function getAux_2() {
        return $this->aux_2;
    }

    public function getAux_3() {
        return $this->aux_3;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM pedidos WHERE idPedido = '{$id}'";
		$datos = Conexion::getSqlite()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Pedido id: {$id} no encontrado.");
		}
		
		$this->id = $datos[0]['idPedido'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
        $this->idMesa = $datos[0]['idMesa'];
        $this->idPlato = $datos[0]['idPlato'];
        $this->nombrePlato = $datos[0]['nombrePlato'];
        $this->idCombo = $datos[0]['idCombo'];
        $this->nombreCombo = $datos[0]['nombreCombo'];
        $this->precioUnitario = $datos[0]['precioUnitario'];
        $this->cantidad = $datos[0]['cantidad'];
        $this->descuento = $datos[0]['descuento'];
        $this->precioTotal = $datos[0]['precioTotal'];
        $this->nota = $datos[0]['nota'];
        $this->para_llevar = $datos[0]['para_llevar'];
        $this->status = $datos[0]['status'];
		$this->aux_1 = $datos[0]['aux_1'];
		$this->aux_2 = $datos[0]['aux_2'];
		$this->aux_3 = $datos[0]['aux_3'];
		$this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
    /*=======================================================================
	 *
	 *	ELIMINAR
	 *
    =======================================================================*/
    public function Eliminar()
    {		
		$query = "DELETE FROM pedidos WHERE idPedido = '{$this->id}'";
    	$respuesta = Conexion::getSqlite()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el pedido.");
    	}
    }
}