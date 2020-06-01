/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Opciones
var idBotonActualizar = "boton-actualizar";
//Buscador
var idInputBuscador = "input-buscador";
var idBotonBuscador = "boton-buscador";
var buscador = new Buscador(idInputBuscador, idBotonBuscador, "Actualizar");
//Tabla
var idTable = "tabla";
var tabla = new TablaGestion(idTable);
//Modal nuevo
var idModalNuevo = "modal-nuevo";
var idFormNuevo = "form-nuevo";
var idBotonNuevo = "boton-nuevo";
//Modal eliminar
var idModalEliminar = "modal-eliminar";
var idFormEliminar = "form-eliminar";
var idBotonEliminar = "boton-eliminar";
var idTextUsuarioEliminar = "text-usuario-eliminar";
var idInputUsuarioEliminar = "input-usuario-eliminar";

/*================================================================================
 *
 *	Actualizar datos
 *
================================================================================*/
function Actualizar()
{
    //Definimos el tbody
    var table = document.getElementById(idTable);
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
        url: HOST_ADMIN_AJAX+"Gestion_Sistema/CRUD_Usuarios/",
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

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
$("#"+idBotonActualizar).on("click", function(e) { Actualizar(); });

/*================================================================================
 *
 *	EVENTOS DE LA TABLA
 *
================================================================================*/
$("#"+idTable).on("ActualizarTabla", function(e)
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
        var link = HOST_ADMIN + `Gestion_Sistema/Usuarios/${dato.usuario}/`;

        tbody.innerHTML +=
        '<tr>' +
        '   <td>' +
        '       ' + dato.nombre +
        '   </td>' +

        '   <td class="no-movil">' +
        '       ' + Formato.Numerico( dato.cedula ) +
        '   </td>' +

        '   <td class="no-movil">' +
        '       ' + ( dato.usuario ).toUpperCase() +
        '   </td>' +

        '   <td center>' +
        '       <a class="btn btn-sm btn-success text-white" href="'+link+'">' +
        '           <i class="fas fa-eye"></i>' +
        '       </a>' +
        
        '       <button class="btn btn-sm btn-danger" onclick="ModalEliminar('+i+')">' +
        '           <i class="fas fa-trash-alt"></i>' +
        '       </button>' +
        '   </td>' +
        '</tr>';
    }
});

/*================================================================================
 *
 *	Nuevo Usuario
 *
================================================================================*/
$("#" + idModalNuevo).on("hidden.bs.modal", function(e)
{
    $("#"+idFormNuevo)[0].reset();
});

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
$("#" + idBotonNuevo).on("click", function(e) { Nuevo(); });

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Nuevo()
{
    //Definimos la data
    var data = AnalizarForm(idFormNuevo);
    data.accion = "REGISTRAR";

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Gestion_Sistema/CRUD_Usuarios/",
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
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }
            
            location.href = HOST_ADMIN + "Gestion_Sistema/Usuarios/"+respuesta.data.usuario+"/";
        }
    });
}

/*================================================================================
 *
 *	Eliminar
 *
================================================================================*/
function ModalEliminar(fila)
{
    var dato = tabla.getData()[fila];
    $("#" + idInputUsuarioEliminar).val(dato.usuario);
    $("#" + idTextUsuarioEliminar)[0].innerHTML = dato.nombre;
    $("#" + idModalEliminar).modal("show");
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
$("#" + idBotonEliminar).on("click", function(e) { Eliminar(); });

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function Eliminar()
{
    //Definimos la data
    var data = AnalizarForm(idFormEliminar);
    data.accion = "ELIMINAR";

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Gestion_Sistema/CRUD_Usuarios/",
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
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }
            
            Actualizar();
            Loader.Ocultar();
            $("#" + idModalEliminar).modal("hide");
            Alerta.Success("Usuario <b>"+respuesta.data.nombre+"</b> eliminado exitosamente.");
        }
    });
}