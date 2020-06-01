<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Controlador del RESTURANTES
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

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("modelo_admin");
            Template::Iniciar();
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
    public function registrar()
    {
        $this->Vista("restaurantes/registrar");
        $this->Javascript("resturantes/registrar");
    }

    public function gestion()
    {
        $this->Vista("restaurantes/gestion");
        $this->Javascript("resturantes/gestion");
    }
}