/**
 * 
 */
class Web_Sockets
{
    /**
     * 
     */
    private url: string;
    private objAcciones: any;
    private ws?: WebSocket;

    /**
     * 
     * @param url String
     * @param objAcciones Objeto { antes(), onopen(e), onclose(e), onmessage(e), onerror(e) }
     */
    public constructor(url: string, objAcciones: {})
    {
        this.url = url;
        this.objAcciones = objAcciones;
        this.Conectar();
    }

    /**
     * 
     */
    public Conectar()
    {
        if(this.objAcciones.antes != undefined) this.objAcciones.antes();
        this.ws = new WebSocket(this.url);

        this.ws.onopen = (e: any) =>
        {
            console.log("[WS]["+this.url+"] Conexión establecida.");
            if(this.objAcciones.onopen != undefined) {
                this.objAcciones.onopen(e);
            }
        }

        this.ws.onclose = (e: any) =>
        {
            console.warn("[WS]["+this.url+"] Conexión cerrada.");
            if(this.objAcciones.onclose != undefined) {
                this.objAcciones.onclose(e);
            }
        }

        this.ws.onmessage = (e: any) =>
        {
            if(this.objAcciones.onmessage != undefined) {
                this.objAcciones.onmessage(e);
            }

            let body = JSON.parse(e.data);
            if(body.accion == undefined) console.error("[WS]["+this.url+"] No se envio la acción.");
            let accion: string = body.accion;
            let contenido: string = body.contenido;

            switch(accion)
            {
                case "error":
                    console.error(contenido);
                    Alerta.Danger(contenido);
                break;
                
                case "console":
                    console.log(contenido);
                break;
                
                case "function":
                    if(body.parametro == undefined)
                    {
                        //@ts-ignore
                        window[contenido]();
                    }
                    else
                    {
                        //@ts-ignore
                        window[contenido](body.parametro);
                    }
                break;

                default:
                    console.warn("[WS]["+this.url+"] Acción '"+accion+"' invalida.");
                break;
            }
        }

        this.ws.onerror = (e: any) =>
        {
            console.error("[WS]["+this.url+"] Ocurrio un error con la conexión.");
            if(this.objAcciones.onerror != undefined) {
                this.objAcciones.onerror(e);
            }
        }
    }
    
    /**
     * 
     * @param mensaje 
     */
    public send(mensaje: string)
    {
        if(this.ws == undefined) {
            console.error("[WS]["+this.url+"] No se ha enviado el mensaje porque no se ha conectado.");
            return;
        }

        this.ws.send(mensaje);
    }
}