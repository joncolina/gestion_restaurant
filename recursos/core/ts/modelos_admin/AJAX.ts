function EnviarPeticionAJAX(url: string, method: string, dataType: string, data: any, acciones: any)
{
    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
        * Parametros principales
        ------------------------------------------------------------------------*/
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        /*------------------------------------------------------------------------
        * 
        ------------------------------------------------------------------------*/
        beforeSend: function(jqXHR, setting)
        {
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            acciones.beforeSend();
        },

        /*------------------------------------------------------------------------
        * 
        ------------------------------------------------------------------------*/
        error: function(jqXHR, status, errorThrow)
        {
            let mensaje = jqXHR.responseText;
            acciones.error("Error grave: " + mensaje);
        },

        /*------------------------------------------------------------------------
        * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;

            if(!respuesta.status) {
                acciones.error( respuesta.mensaje );
                //@ts-ignore
                if(AUDITORIA) {
                    console.error(respuesta.data);
                }
                return;
            }

            acciones.success(respuesta.data);
        }
    });
}