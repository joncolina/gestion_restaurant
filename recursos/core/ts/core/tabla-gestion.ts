/// <reference path="hash.ts" />

/*================================================================================
 *--------------------------------------------------------------------------------
 *
 *	Tabla Gestion
 *
 *--------------------------------------------------------------------------------
================================================================================*/
class TablaGestion
{
    /*============================================================================
	 *
	 *	Atributos
	 *
	============================================================================*/
    private idContenedorTabla: string;
    private cantMostrar: number = 10;
    private idInfoPag: string = "infoEmpaginado";
    private idBotonesPag: string = "botonesEmpagiando";
    private offsetPaginacion: number = 2;
    private data: object[] = [];
    private accion: any;

    public getData() {
        return this.data;
    }

    /*============================================================================
	 *
	 *	Constructor
	 *
	============================================================================*/
    public constructor(idContenedorTabla: string)
    {
        this.idContenedorTabla = idContenedorTabla;
        let contenedor = document.getElementById(this.idContenedorTabla);
        if(contenedor == null) {
            console.error(`La tabla de gestión [id: ${idContenedorTabla}] no existe.`);
            return;
        }

        let empaginado = document.createElement("div");
        empaginado.setAttribute("class", "mt-2 row mx-0");
        empaginado.setAttribute("id", "mt-2 row mx-0");
        empaginado.innerHTML =        
        '<div class="col-12 col-md-6 mb-2 mb-md-0 px-0">' +
        '   <div class="h-100 d-flex align-items-center justify-content-center justify-content-md-start" id="'+this.idInfoPag+'">' +
        '       ...' +
        '   </div>' +
        '</div>' +
        
        '<div class="col-12 col-md-6 px-0">' +
        '   <ul class="pagination justify-content-center justify-content-md-end mb-0" id="'+this.idBotonesPag+'">' +
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">Anterior</a>' +
        '       </li>' +
        
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">...</a>' +
        '       </li>' +
        
        '       <li class="page-item disabled">' +
        '           <a class="page-link" tabindex="-1">Siguiente</a>' +
        '       </li>' +
        '   </ul>' +
        '</div>';

        contenedor.appendChild(empaginado);
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Cargando()
    {
        let contenedor = document.getElementById(this.idContenedorTabla);
        let table = contenedor?.getElementsByTagName("table")[0];
        let tbody = table?.getElementsByTagName("tbody")[0]!;

        tbody.innerHTML =
        '<tr>' +
        '   <td colspan="100" center>' +
        '       <div class="spinner-grow m-2">' +
        '           <span class="sr-only">Cargando...</span>' +
        '       </div>' +
        '   </td>' +
        '</tr>';
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Error()
    {
        let contenedor = document.getElementById(this.idContenedorTabla);
        let table = contenedor?.getElementsByTagName("table")[0];
        let tbody = table?.getElementsByTagName("tbody")[0]!;

        tbody.innerHTML =
        '<tr class="table-danger">' +
        '   <td colspan="100" center>' +
        '       <h4 class="m-2">Error al actualizar</h4>' +
        '   </td>' +
        '</tr>';
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    public Actualizar(objecto: any = { data: [], accion: {} })
    {
        this.data = objecto.data;
        this.accion = objecto.accion;
        let data = this.data;

        /*------------------------------------------------------------------------
		 *	Definimos los parametros que vamos a utilizar en este metodo
		------------------------------------------------------------------------*/
        let parametros = Hash.getParametros();
        let pagina: number = 1;
        let cantMostrar: number = this.cantMostrar;
        let totalData: number = data.length;
        let totalPaginas: number = 0;
        let inicio: number = 0;
        let fin: number = 0;
        
        /*------------------------------------------------------------------------
		 *	Verificamos si se envio la cantidad a mostrar y la validamos
        ------------------------------------------------------------------------*/
        if(parametros['mostrar'] != undefined && !isNaN(parametros['mostrar'])) cantMostrar = Number(parametros['mostrar']);
        if(cantMostrar < 1) cantMostrar = this.cantMostrar;

        /*------------------------------------------------------------------------
		 *	Calculamos la cantidad total de paginas
		------------------------------------------------------------------------*/
        if(parametros['pagina'] != undefined && !isNaN(parametros['pagina'])) pagina = Number(parametros['pagina']);
        //@ts-ignore
        totalPaginas = Math.trunc( totalData / cantMostrar );
        if(totalData % cantMostrar > 0) totalPaginas += 1;

        /*------------------------------------------------------------------------
		 *	Verificamos si se envio la pagina y la validamos
		------------------------------------------------------------------------*/
        if(pagina < 1) pagina = 1;
        if(pagina > totalPaginas) pagina = totalPaginas;

        /*------------------------------------------------------------------------
		 *	Calculamos el inicio y fin de los elementos a mostrar
		------------------------------------------------------------------------*/
        inicio = (pagina - 1) * cantMostrar;
        fin = inicio + cantMostrar;
        if(fin > totalData) fin = totalData;

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        let tbody = document.getElementById(this.idContenedorTabla)!.getElementsByTagName("tbody")[0];
        objecto.accion(tbody, data, inicio, fin);

        /*------------------------------------------------------------------------
         * Construimos el empaginado
		------------------------------------------------------------------------*/
        this.ActualizarPaginado(inicio, fin, totalData, pagina, totalPaginas);
    }

    /*============================================================================
	 *
	 *	
	 *
    ============================================================================*/
    private ActualizarPaginado(inicio: number, fin: number, total: number, paginaActual: number, totalPagina: number)
    {
        /*------------------------------------------------------------------------
         * Variables
        ------------------------------------------------------------------------*/
        //Elementos
        let contenedor = document.getElementById(this.idContenedorTabla)!;
        let info = document.getElementById(this.idInfoPag)!;
        let botones = document.getElementById(this.idBotonesPag)!;
        //Numeros
        let botonInicio: number = 1;
        let botonFin: number = totalPagina;
        let offset: number = this.offsetPaginacion;
        //Condiciones
        let puntosInicio: boolean = true;
        let puntosFin: boolean = true;

        /*------------------------------------------------------------------------
         * Calculos
        ------------------------------------------------------------------------*/
        botonInicio = paginaActual - offset;
        if(botonInicio < 1) botonInicio = 1;

        botonFin = paginaActual + offset;
        if(botonFin > totalPagina) botonFin = totalPagina;

        if(botonInicio <= 1) puntosInicio = false;
        if(botonFin >= totalPagina) puntosFin = false;

        if(totalPagina == 0) {
            info.innerHTML = ``;
            botones.innerHTML = ``;
            return;
        }

        /*------------------------------------------------------------------------
         * Información del empaginado
        ------------------------------------------------------------------------*/
        info.innerHTML = `Mostrando ${inicio+1} a ${fin} resultados de ${total}.`;

        /*------------------------------------------------------------------------
         * Botones del empagiando
        ------------------------------------------------------------------------*/
        //Boton ANTERIOR
        botones.innerHTML = "";
        if(paginaActual <= 1)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">Anterior</span>` +
            '</li>';
        }
        else
        {
            botones.innerHTML +=
            '<li class="page-item">' +
            `   <a class="page-link" page="${paginaActual - 1}">Anterior</a>` +
            '</li>';
        }

        //...
        if(puntosInicio)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">...</span>` +
            '</li>';
        }

        //Botones
        for(let i=botonInicio; i<=botonFin; i++)
        {
            if(paginaActual == i)
            {
                botones.innerHTML +=
                '<li class="page-item active">' +
                `   <span class="page-link">${i}</span>` +
                '</li>';
            }
            else
            {
                botones.innerHTML +=
                '<li class="page-item">' +
                `   <a class="page-link" page="${i}">${i}</a>` +
                '</li>';
            }
        }

        //...
        if(puntosFin)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">...</span>` +
            '</li>';
        }

        //Boton SIGUIENTE
        if(paginaActual >= totalPagina)
        {
            botones.innerHTML +=
            '<li class="page-item disabled">' +
            `   <span class="page-link">Siguiente</span>` +
            '</li>';
        }
        else
        {
            botones.innerHTML +=
            '<li class="page-item">' +
            `   <a class="page-link" page="${paginaActual + 1}">Siguiente</a>` +
            '</li>';
        }

        /*------------------------------------------------------------------------
         * Eventos de los botones
        ------------------------------------------------------------------------*/
        let botonesArray = document.getElementsByTagName("a");
        for(let i=0; i<botonesArray.length; i++)
        {
            botonesArray[i].onclick = (e) =>
            {
                let pageString: string = botonesArray[i].getAttribute("page")!;
                if(pageString == undefined || pageString == null) return; 
                let page: number = Number(pageString);
                if(isNaN(page)) return;

                let parametros: any = Hash.getParametros();
                parametros['pagina'] = page;

                let url = Hash.Parametro2String(parametros);
                Hash.set(url);

                this.Actualizar({
                    data: this.data,
                    accion: this.accion
                });
            }
        }
    }
}