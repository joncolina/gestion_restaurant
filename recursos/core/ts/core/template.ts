/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Mostrar y Ocultar el menu lateral
 *
 *--------------------------------------------------------------------------------
================================================================================*/
function MenuLateral()
{
    if(document.body.className == "sb-nav-fixed sb-sidenav-toggled")
    {
        document.body.className = "sb-nav-fixed";
    }
    else
    {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Cerrar sesión mediante AJAX
 *
 *--------------------------------------------------------------------------------
================================================================================*/
function CerrarSesion()
{
    /*============================================================================
	 *
	 *	Iniciamos las variables del AJAX
	 *
	============================================================================*/
    // @ts-ignore
    let url: string = HOST_AJAX+"Salir/";
    let method = "POST";
    let dataType = "json";
    let data = {};

    /*============================================================================
	 *
	 *	LLamamos al AJAX
	 *
	============================================================================*/
    $.ajax({
        /*------------------------------------------------------------------------
		 * Parametros principales
		------------------------------------------------------------------------*/
        url: url,
        method: method,
        data: data,
        dataType: dataType,

        /*------------------------------------------------------------------------
		 * Antes de enviar
		------------------------------------------------------------------------*/
        beforeSend: (jqXHR, setting) =>
        {
            //Variables de importancia
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            //Mostramos la pantalla oscura
            Loader.Mostrar();
        },

        /*------------------------------------------------------------------------
		 * Exitoso
		------------------------------------------------------------------------*/
        success: (respuesta, status, jqXHR) =>
        {
            //Respuesta en texto plano
            let respuestaText = jqXHR.responseText;

            if(respuesta.status)
            {
                //Redirigimos al Login
                // @ts-ignore
                location.href = HOST+"Login/";
            }
            else
            {
                //Notificamos
                Alerta.Danger(respuesta.mensaje);
                //Quitamos la pantalla oscura
                Loader.Ocultar();
            }
        },

        /*------------------------------------------------------------------------
		 * Error
		------------------------------------------------------------------------*/
        error: (jqXHR, status, errorThrow) =>
        {
            //Detalles del error
            let mensaje = jqXHR.responseText;
            //Notificamos
            Alerta.Danger(mensaje);
            //Quitamos la pantalla oscura
            Loader.Ocultar();
        }
    });
}