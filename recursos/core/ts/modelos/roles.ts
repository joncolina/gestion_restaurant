class RolesModel
{
    //@ts-ignore
    private static url = HOST_ADMIN_AJAX + "Roles/CRUD/";
    private static method = "POST";
    private static dataType = "JSON";

    /*===============================================================================
     *
     * Consultar
     * 
     * Parametros: {
     *  buscar: string,
     *  beforeSend: () => {},
     *  error: (mensaje: string) => {},
     *  success: (data: object[]) => {}
     * }
     * 
    ===============================================================================*/
    public static Consultar(peticion: any = {})
    {
        if(peticion.idRestaurant == undefined) console.error("RolesModel -> Consultar:\nNo se ha enviado el ID del restaurant.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        let data = new FormData();
        data.append("accion", "CONSULTAR");
        data.append("idRestaurant", peticion.idRestaurant);

        //AJAX
        $.ajax
        ({
            /*------------------------------------------------------------------------
            * Parametros principales
            ------------------------------------------------------------------------*/
            url: this.url,
            method: this.method,
            dataType: this.dataType,
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

                peticion.beforeSend();
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            error: function(jqXHR, status, errorThrow)
            {
                let mensaje = jqXHR.responseText;
                peticion.error("Error grave: " + mensaje);
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            success: function(respuesta, status, jqXHR)
            {
                let respuestaText = jqXHR.responseText;

                if(!respuesta.status) {
                    peticion.error( respuesta.mensaje );
                    return;
                }

                peticion.success(respuesta.data);
            }
        });
    }

    /*===============================================================================
     *
     * Eliminar
     * 
     * Parametros: {
     *  formulario: Elemento Formulario,
     *  beforeSend: () => {},
     *  error: (mensaje: string) => {},
     *  success: (data: object[]) => {}
     * }
     * 
    ===============================================================================*/
    public static Eliminar(peticion: any = {})
    {
        if(peticion.formulario == undefined) console.error("RolesModel -> Eliminar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "ELIMINAR");

        //AJAX
        $.ajax
        ({
            /*------------------------------------------------------------------------
            * Parametros principales
            ------------------------------------------------------------------------*/
            url: this.url,
            method: this.method,
            dataType: this.dataType,
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

                peticion.beforeSend();
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            error: function(jqXHR, status, errorThrow)
            {
                let mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            success: function(respuesta, status, jqXHR)
            {
                let respuestaText = jqXHR.responseText;

                if(!respuesta.status) {
                    peticion.error(respuesta.mensaje);
                    return;
                }
                
                peticion.success(respuesta.data);
            }
        });
    }

    /*===============================================================================
     *
     * Modificar
     * 
     * Parametros: {
     *  formulario: Elemento Formulario,
     *  beforeSend: () => {},
     *  error: (mensaje: string) => {},
     *  success: (data: object[]) => {}
     * }
     * 
    ===============================================================================*/
    public static Modificar(peticion: any = {})
    {
        if(peticion.formulario == undefined) console.error("RolesModel -> Modificar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "MODIFICAR");

        //AJAX
        $.ajax
        ({
            /*------------------------------------------------------------------------
            * Parametros principales
            ------------------------------------------------------------------------*/
            url: this.url,
            method: this.method,
            dataType: this.dataType,
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

                peticion.beforeSend();
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            error: function(jqXHR, status, errorThrow)
            {
                let mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            success: function(respuesta, status, jqXHR)
            {
                let respuestaText = jqXHR.responseText;

                if(!respuesta.status) {
                    peticion.error( respuesta.mensaje );
                    return;
                }
                
                peticion.success(respuesta.data);
            }
        });
    }

    /*===============================================================================
     *
     * Registrar
     * 
     * Parametros: {
     *  formulario: Elemento Formulario,
     *  beforeSend: () => {},
     *  error: (mensaje: string) => {},
     *  success: (data: object[]) => {}
     * }
     * 
    ===============================================================================*/
    public static Registrar(peticion: any = {})
    {
        if(peticion.formulario == undefined) console.error("RolesModel -> Registrar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "REGISTRAR");

        //AJAX
        $.ajax
        ({
            /*------------------------------------------------------------------------
            * Parametros principales
            ------------------------------------------------------------------------*/
            url: this.url,
            method: this.method,
            dataType: this.dataType,
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

                peticion.beforeSend();
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            error: function(jqXHR, status, errorThrow)
            {
                let mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },

            /*------------------------------------------------------------------------
            * 
            ------------------------------------------------------------------------*/
            success: function(respuesta, status, jqXHR)
            {
                let respuestaText = jqXHR.responseText;

                if(!respuesta.status) {
                    peticion.error( respuesta.mensaje );
                    return;
                }
                
                peticion.success(respuesta.data);
            }
        });
    }
}