<?php

class PlatilloModel
{
	/*=======================================================================
	 *
	 *	Atributos
	 *
    =======================================================================*/
	private $id;
	private $idRestaurant;
	private $idCategoria;
	private $idTipo;
	private $nombre;
	private $descripcion;
	private $imagen;
	private $activo;
	private $precioCosto;
	private $precioVenta;
	private $idStatus;
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

	public function getidCategoria() {
		return $this->idCategoria;
	}

	
	public function getNombre() {
		return $this->nombre;
	}

	public function getdescripcion() {
		return $this->descripcion;
	}

	public function getimagen() {
		return $this->imagen;
	}
	public function getactivo() {
		return $this->activo;
	}
	public function getprecioCosto() {
		return $this->precioCosto;
	}
	public function getprecioVenta() {
		return $this->precioVenta;
	}
	public function getidStatus() {
		return $this->idStatus;
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

	public function __construct($id)
	{
		$id = (int) $id;

		$query = "SELECT  * FROM platos WHERE idPlato = '{$id}'";
		$datos = Conexion::getMysql()->Consultar( $query );
		if(sizeof($datos) <= 0) {
			throw new Exception("Plato id: {$id} no encontrada.");
		}

	

		$this->id = $datos[0]['idPlato'];
		$this->idRestaurant  = $datos[0]['idRestaurant'];
		$this->idCategoria  = $datos[0]['idCategoria'];
		$this->nombre  = $datos[0]['nombre'];
		$this->descripcion  = $datos[0]['descripcion'];
		$this->imagen  = $datos[0]['imagen'];
		$this->activo  = $datos[0]['activo'];
		$this->precioCosto  = $datos[0]['precioCosto'];
		$this->precioVenta  = $datos[0]['precioVenta'];
		$this->idStatus  = $datos[0]['idStatus'];
		$this->aux_1  = $datos[0]['aux_1'];
		$this->aux_2  = $datos[0]['aux_2'];
		$this->aux_3  = $datos[0]['aux_3'];
		$this->fecha_registro  = $datos[0]['fecha_registro'];
	}

	/*=======================================================================
	 *
	 *	ELIMINAR
	 *
    =======================================================================*/
    public function Eliminar()
    {
    	$query = "DELETE FROM platos WHERE idPlato = '{$this->id}'";
    	$respuesta = Conexion::getMysql()->Ejecutar( $query );
    	if($respuesta === FALSE) {
    		throw new Exception("Ocurrio un error al intentar eliminar el Plato.");
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

    public function setdescripcion( $descripcion ) {
        $descripcion = Filtro::General(strtoupper($descripcion));
        $this->set("descripcion", $descripcion);
        $this->descripcion = $descripcion;
    }

    public function setimagen( $imagen) {
        $imagen= Filtro::General(strtoupper($imagen));
        $this->set("imagen", $imagen);
        $this->imagen = $imagen;
    }

    public function setactivo( $activo) {
        $activo = Filtro::General($activo);
        $this->set("activo", $activo);
        $this->activo = $activo;
    }

    public function setprecioCosto( $precioCosto) {
        $precioCosto = (int) $precioCosto;
        $this->setprecioCosto("precioCosto", $precioCosto);
        $this->precioCosto = new PlatilloModel( $precioCosto );
    }

    public function setprecioVenta( $precioVenta) {
        $precioVenta = (int) $precioVenta;
        $this->setprecioVenta("precioVenta", $precioVenta);
        $this->precioVenta = new PlatilloModel( $precioVenta );
    }

    public function setidStatus( $idStatus) {
        $idStatus= Filtro::General($idStatus);
        $this->setidStatus("idStatus", idStatus);
        $this->idStatus = $idStatus;
    }

    public function setaux_1( $aux_1) {
        $aux_1 = Filtro::General(strtoupper( $aux_1));
        $this->setaux_1("aux_1", $aux_1);
        $this->aux_1 = $aux_1;
    }

    public function setaux_2( $aux_2) {
        $aux_2 = Filtro::General(strtoupper($aux_2));
        $this->setaux_1("aux_2", $aux_2);
        $this->aux_2 = $aux_2;
    }

    public function setaux_3( $aux_3) {
        $aux_3 = Filtro::General(strtoupper($aux_3));
        $this->setaux_3("aux_3", $aux_3);
        $this->aux_3 = $aux_3;
    }


    /*=======================================================================
	 *
	 *	
	 *
    =======================================================================*/
    public function set($columna, $valor)
    {
        $query = "UPDATE platos SET {$columna} = '{$valor}' WHERE idPlato = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar '{$columna}' de la tabla de Platos.");
        }
    }
}