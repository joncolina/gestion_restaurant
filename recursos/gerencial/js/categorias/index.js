/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Tabla
var idTabla = "tabla";
/* Esta clase prepara una tabla (le anexa el empaginado) */
var tabla = new TablaGestion(idTabla);

//Buscador
var idInputBuscador = "input-buscador";
var idBotonBuscador = "boton-buscador";
//Esta clase recibe 3 parametros
//Id del input del buscador
//Id del boton del buscador
//Funcion a ejecutar (string) cuando se haga submit [Actualizar]
var buscador = new Buscador(idInputBuscador, idBotonBuscador, "Actualizar");

/*--------------------------------------------------------------------------------
 * 
 * Aqui lo que hacemos es solicitar la informacion mediante AJAX.
 * Podemos imprimirla directo en PHP y es mas rapido, pero no podemos actualizar la data en tiempo real
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    //Definimos el tbody
    var table = document.getElementById(idTabla);
    var tbody = table.getElementsByTagName("tbody")[0];

    //Definimos la data
    var data = { accion: "CONSULTAR" };

    //Verificamos el buscador
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        data['buscar'] = parametros['buscar'];
        data['buscar'] = data['buscar'].replace(/_/g, " ");
    }

    //Este sera un ejemplo
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        // Debemos primero preparar el CRUD antes de hacer la consulta
        url: HOST_GERENCIAL_AJAX+"categorias/CRUD/",
        method: "POST",
        dataType: "JSON",
        data: data,

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        beforeSend: function(jqXHR, setting)
        {
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            tabla.Cargando();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        error: function(jqXHR, status, errorThrow)
        {
        	// Idealmente nunca deberiamos caes aqui, ya que hasta los errores que se generen
        	// Tienen su formato con el array de respuesta
        	// Pero por si acaso se pone
            let mensaje = jqXHR.responseText;
            alert("Error del sistema:\n"+mensaje);
            tabla.Error();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
        	// La respuesta es en JSON, pero por si acaso aqui esta en texto plano
            let respuestaText = jqXHR.responseText;

        	// Si ocurre algun error deberia indicarlo con respuesta.status = false
        	// y caemos aqui
            if(!respuesta.status) {
                tabla.Error();
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                return;
            }

            /* Este es otro metodo de la tabla, no es para que imprima la data
            Si no para que me genere los eventos para rellenar */
            tabla.Actualizar(respuesta.data);

            //Mostramos lo que recibamos por consola
            console.log(respuesta);
        }
    });
}

//Ejecutamos la funcion actualizar al cargar la pagina o de inmediato
Actualizar();

/*================================================================================
 *
 *	EVENTOS DE LA TABLA
 *
================================================================================*/
$("#"+idTabla).on("ActualizarTabla", function(e)
{
	//El evento ya me trae los elementos como el tbody
	//El inicio y el fin los elementos a mostrar
	var tbody = e.detail.tbody;
    var data = e.detail.data;
    var inicio = e.detail.inicio;
    var fin = e.detail.fin;

    //Borramos el contenido del tbody
    tbody.innerHTML = '';

    //Si no hay data mostramos esto
    if(data.length == 0) {
        tbody.innerHTML =
        '<tr>' +
        '   <td colspan="100">' +
        '       <h4 class="text-center">No se encontraron resultados.</h4>' +
        '   </td>' +
        '</tr>';
        return;
    }

    //Usaremos los limites que manda el evento ya que estan sincronizados con
    //la paginación
    for(var i=inicio; i<fin; i++)
    {
    	//Verificamos que la data no sea nula
        let dato = data[i];
        if(dato == undefined) continue;

        //Aqui imprimimos la data
        tbody.innerHTML +=
        '<tr>' +
        '   <td>' +
        '       ' + dato.idCategoria +
        '   </td>' +

        '   <td>' +
        '       ' + dato.nombre +
        '   </td>' +

        '   <td>' +
        '       ' + dato.Enviar +
        '   </td>' +

        '   <td center>' +        
        '       <button class="btn btn-sm btn-warning">' +
        '           <i class="fas fa-edit"></i>' +
        '       </button>' +
        '   </td>' +
        '   <td center>' +        
        '       <button class="btn btn-sm btn-danger">' +
        '           <i class="fas fa-trash-alt"></i>' +
        '       </button>' +
        '   </td>' +
        '</tr>';
    }
});