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
        if( Sesion::ValidarAdmin() )
        {
            header("location: ".HOST_ADMIN."Inicio/");
            exit;
        }

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("login");
            Template::Iniciar( "Administración de " . SISTEMA_NOMBRE );
        }
    }
    
    /*============================================================================
	 *
	 *	Destructor
	 *
    ============================================================================*/
    public function __destruct()
    {
        if(!Peticion::getEsAjax()) {
            Template::Finalizar();
        }
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function index()
    {
        $this->Vista("login/index");
        $this->Javascript("login/index");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function acceder()
    {
        $this->AJAX("login/acceder");
    }
}