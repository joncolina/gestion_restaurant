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

        if( !Peticion::getEsAjax() )
        {
            Incluir::Template("modelo_gerencial");
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
    public function index()
    {
        /* Esta funcion incluye una vista, posicionante como base en la carpeta 'Vista' */
        $this->Vista("categorias/index");
        /* Esta incluye un JS, posicionandote en 'recursos/gerencial/js/' */
        $this->Javascript("categorias/index");
    }

    /* Aqui lo ideal es que accedamos solo por AJAX, asi que incluimos el archivo
    mediante esta funcion.
    Ya valida de una vez que sera una peticion AJAX, e igual que en vistas, te ubica en la misma carpeta "vistas"*/
    public function crud()
    {
        $this->AJAX("categorias/crud");

        /* Por ahora ya no sera necesario el controlador */
    }
}