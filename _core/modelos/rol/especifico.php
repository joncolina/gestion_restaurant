<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de ROL
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class RolModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $id;
    private $idRestaurant;
    private $nombre;
    private $fecha_registro;

	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getId() {
        return $this->id;
    }

    public function getIdRestaurant() {
        return $this->idRestaurant;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

	/*============================================================================
	 *
	 *	Setter
	 *
    ============================================================================*/
    public function setNombre($nombre) {
        $nombre = Filtro::General($nombre);

        $query = "UPDATE roles SET nombre = '{$nombre}' WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Consultar($query);
        if($respuesta) {
            throw new Exception("Ocurrio un problema al intentar modificar el nombre del rol.");
        }

        $this->nombre = $nombre;
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($idRol)
    {
        $idRol = (int) $idRol;

        $query = "SELECT * FROM roles WHERE idRol = '{$idRol}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El rol {$idRol} no esta registrado.");
        }

        $this->id = $datos[0]['idRol'];
        $this->idRestaurant = $datos[0]['idRestaurant'];
        $this->nombre = $datos[0]['nombre'];
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public function Eliminar($idReemplazo)
    {
        $idReemplazo = (int) $idReemplazo;

        $query = "UPDATE usuarios SET idRol = '{$idReemplazo}' WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar aplicar el rol de reemplazo.");
        }

        $query = "DELETE permisos_a WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar limpiar la tabla de los permisos (A).");
        }

        $query = "DELETE permisos_b WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar limpiar la tabla de los permisos (B).");
        }

        $query = "DELETE roles WHERE idRol = '{$this->id}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if(!$respuesta) {
            throw new Exception("Ocurrio un error al intentar eliminar el rol.");
        }
    }
}