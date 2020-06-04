<?php
/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Modelo ESPECIFICO de USUARIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class UsuarioModel
{
	/*============================================================================
	 *
	 *	Atributos
	 *
    ============================================================================*/
    private $usuario;
    private $idRestaurant;
    private $clave;
    private $nombre;
    private $cedula;
    private $rol;
    private $fecha_registro;
    
	/*============================================================================
	 *
	 *	Getter
	 *
    ============================================================================*/
    public function getUsuario() {
        return $this->usuario;
    }

    public function getIdRestaurant() {
        return $this->idRestaurant;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getRol() {
        return $this->rol;
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

        $query = "UPDATE usuarios SET nombre = '{$nombre}' WHERE usuario = '{$this->usuario}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar el nombre.");
        }

        $this->nombre = $nombre;
    }

    public function setCedula($cedula) {
        $cedula = Filtro::General($cedula);

        $query = "UPDATE usuarios SET cedula = '{$cedula}' WHERE usuario = '{$this->usuario}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar la cedula.");
        }

        $this->cedula = $cedula;
    }

    public function setClave($clave) {
        $clave = Filtro::General($clave);

        $query = "UPDATE usuarios SET clave = '{$clave}' WHERE usuario = '{$this->usuario}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar el clave.");
        }

        $this->clave = $clave;
    }

    public function setRol($idRol) {
        $idRol = Filtro::General($idRol);

        $query = "UPDATE usuarios SET idRol = '{$idRol}' WHERE usuario = '{$this->usuario}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar modificar el rol.");
        }

        $this->rol = new RolModel($idRol);
    }
    
	/*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct($usuario)
    {
        $usuario = Filtro::General($usuario);

        $query = "SELECT * FROM usuarios WHERE usuario = '{$usuario}'";
        $datos = Conexion::getMysql()->Consultar($query);
        if(sizeof($datos) <= 0) {
            throw new Exception("El usuario {$usuario} no esta registrado.");
        }

        $this->usuario = $datos[0]['usuario'];
        $this->idRestaurant = $datos[0]['idRestaurant'];
        $this->clave = $datos[0]['clave'];
        $this->nombre = $datos[0]['nombre'];
        $this->cedula = $datos[0]['cedula'];

        $idRol = $datos[0]['idRol'];
        $this->rol = new RolModel($idRol);
        
        $this->fecha_registro = $datos[0]['fecha_registro'];
    }
    
	/*============================================================================
	 *
	 *	Eliminar
	 *
    ============================================================================*/
    public function Eliminar()
    {
        $query = "DELETE FROM usuarios WHERE usuario = '{$this->usuario}'";
        $respuesta = Conexion::getMysql()->Ejecutar($query);
        if($respuesta === FALSE) {
            throw new Exception("Ocurrio un error al intentar eliminar el usuario.");
        }
    }
}