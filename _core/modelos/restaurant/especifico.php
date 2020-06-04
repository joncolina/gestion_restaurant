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
    private $nombre;
    private $direccion;
    private $telefono;
    private $correo;
    private $logo;
    private $facebook;
    private $twitter;
    private $instagram;
    private $whatsapp;
    private $activo;
    private $aux_1;
    private $aux_2;
    private $aux_3;
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
    
    public function getNombre() {
        return $this->nombre;
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

    public function getLogo() {
        return $this->logo;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function getWhatsapp() {
        return $this->whatsapp;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getAux1() {
        return $this->aux_1;
    }

    public function getAux2() {
        return $this->aux_2;
    }

    public function getAux3() {
        return $this->aux_3;
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
        $this->nombre = $datos[0]['nombre'];
        $this->direccion = $datos[0]['direccion'];
        $this->telefono = $datos[0]['telefono'];
        $this->correo = $datos[0]['correo'];
        $this->logo = $datos[0]['logo'];
        $this->facebook = $datos[0]['facebook'];
        $this->twitter = $datos[0]['twitter'];
        $this->instagram = $datos[0]['instagram'];
        $this->whatsapp = $datos[0]['whatsapp'];
        $this->activo = boolval( $datos[0]['activo'] );
        $this->aux_1 = $datos[0]['aux_1'];
        $this->aux_2 = $datos[0]['aux_2'];
        $this->aux_3 = $datos[0]['aux_3'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Setter
	 *
    ============================================================================*/
    public function setActivo($activo)
    {
        $activo = (int) $activo;

        $query = "UPDATE restaurantes SET activo = '{$activo}' WHERE idRestaurant = '{$this->id}'";
        $resp = Conexion::getMysql()->Ejecutar($query);
        if($resp === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar 'activo' en el restaurant.");
        }

        $this->activo = boolval( $activo );
    }
}