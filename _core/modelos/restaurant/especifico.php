<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de RESTAURANTES
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RestaurantModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $documento;
    private $razonSocial;
    private $nombreFantasia;
    private $direccion;
    private $telefono;
    private $correo;
    private $fecha_registro;
    
	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }
    
    public function getDocumento() {
        return $this->documento;
    }
    
    public function getRazonSocial() {
        return $this->razonSocial;
    }
    
    public function getNombreFantasia() {
        return $this->nombreFantasia;
    }
    
    public function getDireccion() {
        return $this->direccion;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getCorreo() {
        return $this->correo;
    }
    
    public function getFechaRegistro() {
        return $this->fecha_registro;
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idRestaurant)
    {
        $idRestaurant = (int) $idRestaurant;

        $query = "SELECT * FROM restaurantes WHERE idRestaurant = '{$idRestaurant}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El restaurant (id: {$idRestaurant}) no esta registrado.");
        }

        $this->id = $datos[0]['idRestaurant'];
        $this->documento = $datos[0]['documento'];
        $this->razonSocial = $datos[0]['razonSocial'];
        $this->nombreFantasia = $datos[0]['nombreFantasia'];
        $this->direccion = $datos[0]['direccion'];
        $this->telefono = $datos[0]['telefono'];
        $this->correo = $datos[0]['correo'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public function Eliminar()
    {
        $query = "DELETE FROM restaurantes WHERE idRestaurant = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar eliminar el restaurant.");
        }
    }
}