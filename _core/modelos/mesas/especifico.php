<?php

class MesaModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $activa;
	private $codigoMesa;
	private $alias;
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

	public function getactiva() {
		return $this->activa;
	}

	public function getcodigoMesa() {
		return $this->codigoMesa;
	}

	public function getalias() {
		return $this->alias;
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

	public function getfecha_registro() {
		return $this->fecha_registro;
	}

	public function __construct($id)
	{

		$id = (int) $id;

		$query = "SELECT  * FROM mesas WHERE idMesa = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Mesa id: {$id} no encontrada.");
		}

		$this->id = $datos[0]['idMesa'];
		$this->idRestaurant = $datos[0]['idRestaurant'];
		$this->activa = $datos[0]['idStatus'];
		$this->codigoMesa = $datos[0]['codigoMesa'];
		$this->alias = $datos[0]['alias'];
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
    public function Eliminar($idMesa)
    {
    	/*$query = "UPDATE mesas SET alias  = '{$alias}' WHERE idMesa = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar reemplazar la Mesa.");
    	}*/

    	$query = "DELETE FROM mesas WHERE idMesa = '{$idMesa}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar la Mesa.");
    	}
    }

	/*=======================================================================
	 *
	 *	SETTER
	 *
    =======================================================================*/
    public function setalias( $alias ) {
        $alias = Filtro::General(strtoupper($alias));
        $this->set("alias", $alias);
        $this->alias = $alias;
    }

    /*public function setIdAreaMonitoreo( $idAreaMonitoreo ) {
        $idAreaMonitoreo = (int) $idAreaMonitoreo;
        $this->set("idAreaMonitoreo", $idAreaMonitoreo);
        $this->idAreaMonitoreo = $idAreaMonitoreo;
    }*/

    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE mesas SET {$columna} = '{$valor}' WHERE idMesa = '{$this->id}'";

        

        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' en la Mesa.");
        }
    }
}