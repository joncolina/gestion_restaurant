<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Modelo ESPECIFICO de COMBOS
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class ComboModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $nombre;
	private $descuento;
	private $activo;
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

	public function getNombre() {
		return $this->nombre;
	}

	public function getDescuento() {
		return $this->descuento;
	}

	public function getactivo() {
		return $this->activo;
	}

	public function getaux_1() {
		return $this->aux_1;
	}

	public function getaux_2() {
		return $this->aux_2;
	}

	public function getaux_3() {
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

		$query = "SELECT  * FROM combos WHERE idCombo = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Combo id: {$id} no encontrada.");
		}
		
		$this->id = $datos[0]['idCombo'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->nombre = $datos[0]['nombre'];
		$this->descuento = $datos[0]['descuento'];
		$this->activo = boolval( $datos[0]['activo'] );
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
		$query = "DELETE FROM combos_platos WHERE idCombo = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar los detalles del combo.");
		}
		
		$query = "DELETE FROM combos WHERE idCombo = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el combo.");
    	}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setNombre( $nombre ) {
        $nombre = Filtro::General(strtoupper($nombre));
        $this->set("nombre", $nombre);
        $this->nombre = $nombre;
	}

    public function setDescuento( $descuento ) {
        $descuento = Filtro::General($descuento);
        $this->set("descuento", $descuento);
        $this->descuento = $descuento;
    }

    public function setActivo( $activo) {
        $activo = (int) $activo;
        $this->set("activo", $activo);
        $this->activo = boolval( $activo );
    }
	
    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE combos SET {$columna} = '{$valor}' WHERE idCombo = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' de la tabla de combos.");
        }
    }
}