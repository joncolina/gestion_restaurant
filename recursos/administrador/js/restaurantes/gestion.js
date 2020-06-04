/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Opciones
var idBotonActualizar = "boton-actualizar";

//Tabla
var idTabla = "tabla";
var tabla = new TablaGestion(idTabla);

//Buscador
var idInputBuscador = "input-buscador";
var idBotonBuscador = "boton-buscador";
var buscador = new Buscador(idInputBuscador, idBotonBuscador, "Actualizar");

//Modal
var idModal = "modal-cambiar-acceso";
var idForm = "form-cambiar-acceso";
var idBotonGuardar = "boton-cambiar-acceso";
var idLabelText = "label-cambiar-acceso";
var idInputId = "id-cambiar-acceso";

/*================================================================================
 *
 *	Actualizar datos
 *
================================================================================*/

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();

/*--------------------------------------------------------------------------------
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

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Restaurantes/CRUD/",
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
            let mensaje = jqXHR.responseText;
            alert("Error del sistema:\n"+mensaje);
            tabla.Error();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;

            if(!respuesta.status) {
                tabla.Error();
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                return;
            }

            tabla.Actualizar(respuesta.data);
        }
    });
}

/*================================================================================
 *
 *	EVENTOS DE LA TABLA
 *
================================================================================*/
$("#"+idTabla).on("ActualizarTabla", function(e)
{
    var tbody = e.detail.tbody;
    var data = e.detail.data;
    var inicio = e.detail.inicio;
    var fin = e.detail.fin;

    tbody.innerHTML = '';

    if(data.length == 0) {
        tbody.innerHTML =
        '<tr>' +
        '   <td colspan="100">' +
        '       <h4 class="text-center">No se encontraron resultados.</h4>' +
        '   </td>' +
        '</tr>';
        return;
    }

    for(var i=inicio; i<fin; i++)
    {
        let dato = data[i];
        if(dato == undefined) continue;

        var link = HOST_ADMIN + `Restaurantes/Gestion/${dato.id}/`;

        var claseActivo = "text-success font-weight-bold";
        if(!dato.activo) {
            claseActivo = "text-danger font-weight-bold";
        }


        tbody.innerHTML +=
        '<tr>' +
        '   <td>' +
        '       <a href="'+link+'">' + dato.nombre + '</a>' +
        '   </td>' +

        '   <td class="no-table">' +
        '       ' + dato.documento +
        '   </td>' +

        '   <td center class="'+claseActivo+'">' +
        '       ' + Formato.bool2text( dato.activo ) +
        '   </td>' +

        '   <td center>' +        
        '       <button class="btn btn-sm btn-dark" onclick="CambiarAcceso('+i+')">' +
        '           <i class="fas fa-sync-alt"></i>' +
        '       </button>' +
        '   </td>' +
        '</tr>';
    }
});

/*================================================================================
 *
 *	CAMBIAR ACCESO
 *
================================================================================*/
function CambiarAcceso(fila)
{
    var datos = tabla.getData()[fila];
    var label = document.getElementById(idLabelText);
    var inputId = document.getElementById(idInputId);

    inputId.setAttribute("value", datos.id);

    if(datos.activo) {
        label.innerHTML = '¿Esta seguro que desea <b>desactivar</b> el restaurant <b>'+datos.nombre+'</b>?';
    } else {
        label.innerHTML = '¿Esta seguro que desea <b>activar</b> el restaurant <b>'+datos.nombre+'</b>?';
    }

    $("#" + idModal).modal("show");
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
document.getElementById(idBotonGuardar).onclick = function(e) { ModificarAcceso(); }

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function ModificarAcceso()
{
    /**
     * Definimos la tabla
     */
    var data = AnalizarForm(idForm);
    data.accion = "ELIMINAR";

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Restaurantes/CRUD/",
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
            
            Loader.Mostrar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        error: function(jqXHR, status, errorThrow)
        {
            let mensaje = jqXHR.responseText;
            alert("Error del sistema:\n"+mensaje);
            Loader.Ocultar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;

            if(!respuesta.status) {
                tabla.Error();
                console.log(respuesta.data);
                Loader.Ocultar();
                return;
            }

            Actualizar();
            Loader.Ocultar();
            $("#" + idModal).modal("hide");
            Alerta.Success("Se ha modificado el restaurant exitosamente.");
        }
    });
}