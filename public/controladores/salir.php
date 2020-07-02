<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del INICIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Controlador extends ControladorBase
{
    /*============================================================================
	 *
	 *	Constructor
	 *
    ============================================================================*/
    public function __construct()
    {
        $this->ValidarSesion();
    }
    
    /*============================================================================
	 *
	 *	Destructor
	 *
    ============================================================================*/
    public function __destruct()
    {
        
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function index()
    {
        $respuesta = [];
        $respuesta['status'] = TRUE;
        $respuesta['mensaje'] = "";
        $respuesta['data'] = [];

        $objMesa = Sesion::getUsuario();
        $clave = Input::POST("clave", TRUE);

        if($objMesa->getClave() != $clave) {
            throw new Exception("Contraseña incorrecta.");
        }

        $objMesa->setStatus("DISPONIBLE");
        Sesion::CerrarCliente();
        Conexion::getMysql()->Commit();

        if( Peticion::getEsAjax() ) {
            echo json_encode( $respuesta );
        } else {
            header("location: ".HOST."Login/");
        }
    }
}