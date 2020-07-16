class AJAX
{
    /**
     * Enviar Petición
     * @param objeto
     */
    public static async Enviar(objeto = {
        url: "",
        data: new FormData(),
        method: "POST",
        antes(){},
        error(mensaje: string){},
        ok(datos: string){}
    })
    {
        /**
         * Verificamos cada posición del parametro
         */
        if(objeto.url == undefined || objeto.url == null) throw "[AJAX][Error] -> No se envio la URL.";
        if(objeto.data == undefined || objeto.data == null) objeto.data = new FormData();
        if(objeto.method == undefined || objeto.method == null) objeto.method = "POST";
        if(objeto.antes == undefined || objeto.antes == null) objeto.antes = () => {};
        if(objeto.error == undefined || objeto.error == null) objeto.error = () => {};
        if(objeto.ok == undefined || objeto.ok == null) objeto.ok = () => {};

        try
        {
            /**
             * Ejecutamos ANTES
             */
            objeto.antes();

            /**
             * Enviamos
             */
            var response = await fetch(objeto.url, { method: objeto.method, body: objeto.data });

            try
            {
                /**
                 * Recibimos y convertimos a JSON
                 */
                var respuesta = await response.json();
            }
            catch(e)
            {
                /**
                 * Notificamos el error
                 */
                alert("Ocurrio un error con la petición AJAX.");
                console.error(e);
            }

            /**
             * Guardamos la respuesta
             */
            let error = respuesta.error;
            let cuerpo = respuesta.cuerpo;

            /**
             * Verificamos si hay error
             */
            if(error.status == true)
            {
                //@ts-ignore
                if(AUDITORIA) console.error(cuerpo);
                objeto.error(error.mensaje);
            }
            /**
             * Ejecutamos la función de OK
             */
            else
            {
                objeto.ok(cuerpo);
            }
        }
        catch(mensaje)
        {
            //@ts-ignore
            if(AUDITORIA) {
                console.error(mensaje);
            }
            objeto.error("[AJAX][Error]:\n" + mensaje);
        }
    }
}