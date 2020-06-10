class PlatosModel
{
    //@ts-ignore
    private static url = HOST_GERENCIAL_AJAX + "Platos/CRUD/";
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
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        let data = new FormData();
        data.append("accion", "CONSULTAR");
        if(peticion.buscar != undefined) {
            data.append("buscar", peticion.buscar);
        }

        let acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };

        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        if(peticion.formulario == undefined) console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "REGISTRAR");

        let acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };

        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        if(peticion.formulario == undefined) console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "ELIMINAR");

        let acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };

        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        if(peticion.formulario == undefined) console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        //Definimos la data
        let data: any = new FormData( peticion.formulario );
        data.append("accion", "MODIFICAR");

        let acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };

        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    }
}