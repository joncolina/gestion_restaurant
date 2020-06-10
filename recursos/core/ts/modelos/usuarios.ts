class UsuariosModel
{
    //@ts-ignore
    private static url = HOST_ADMIN_AJAX + "Usuarios/CRUD/";
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
        if(peticion.succes == undefined) peticion.succes = (data: any) => {};

        let data = new FormData();
        data.append("accion", "CONSULTAR");
        if(peticion.buscar != undefined)
        {
            data.append("buscar", peticion.buscar);
        }
        else if(peticion.filtros != undefined)
        {
            data.append("filtros", "si");
            for(var key in peticion.filtros)
            {
                data.append(key, peticion.filtros[key]);
            }
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
        if(peticion.formulario == undefined) console.error("Modelo Usuario -> Registrar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.succes == undefined) peticion.succes = (data: any) => {};

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
        if(peticion.formulario == undefined) console.error("Modelo Usuario -> Eliminar:\nSe debe enviar el formulario.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.succes == undefined) peticion.succes = (data: any) => {};

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
        if(peticion.succes == undefined) peticion.succes = (data: any) => {};

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