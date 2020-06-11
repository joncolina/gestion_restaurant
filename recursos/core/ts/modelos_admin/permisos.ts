class PermisosModel
{
    //@ts-ignore
    private static url = HOST_ADMIN_AJAX + "Permisos/CRUD/";
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
        if(peticion.idRestaurant == undefined) console.error("PermisosModel -> Consultar:\nNo se ha enviado el ID del restaurant.");
        if(peticion.beforeSend == undefined) peticion.beforeSend = () => {};
        if(peticion.error == undefined) peticion.error = (mensaje: string) => {};
        if(peticion.success == undefined) peticion.success = (data: any) => {};

        let data = new FormData();
        data.append("accion", "CONSULTAR");
        data.append("idRestaurant", peticion.idRestaurant);

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
        if(peticion.formulario == undefined) console.error("PermisosModel -> Modificar:\nSe debe enviar el formulario.");
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