<?php

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *  Controlador del INICIO
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class Controlador extends ControladorBase
{
    /*============================================================================
     *
     *  Constructor
     *
    ============================================================================*/
    public function __construct()
    {
        $this->ValidarSesion();

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("modelo_gerencial");
            Template::Iniciar();
        }
    }
    
    /*============================================================================
     *
     *  Destructor
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
        $this->Vista("combos/index");
        $this->Javascript("combos/index");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function registrar()
    {
        $this->Vista("combos/registrar");
        $this->Javascript("combos/registrar");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function modificar($parametros = [])
    {
        if(!isset($parametros[0])) $this->Error("No se ha enviado el ID del combo.");
        $idCombo = $parametros[0];
        try { $objCombo = new ComboModel( $idCombo ); } catch(Exception $e) { $this->Error("ID del combo [{$idCombo}] invalido."); }

        $this->Vista("combos/modificar", ["objCombo" => $objCombo]);
        $this->Javascript("combos/modificar");
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public function crud()
    {
        $this->AJAX("combos/crud");
    }
}