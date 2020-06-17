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

    //Verificamos el buscador
    var buscar = undefined;
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        buscar = parametros['buscar'].replace(/_/g, " ");
        buscar = data['buscar'].replace(/_/g, " ");
    }

    //Consultamos
    MesasModel.Consultar({
        buscar: buscar,
        beforeSend: () =>
        {
            tabla.Cargando();
        },
        error: (mensaje) =>
        {
            tabla.Error();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            //Funcion para actualizar la tabla
            tabla.Actualizar({
                //Parametros
                data: data,
                //Accion para actualizarla
                accion: (tbody, data, inicio, fin) =>
                {
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
                        '       ' + dato.idMesa +
                        '   </td>' +

                        '   <td>' +
                        '       ' + dato.alias +
                        '   </td>' +

                        '   <td>' +
                        '       ' + dato.idStatus +
                        '   </td>' +

                        '   <td center>' +        
                        '       <button class="btn btn-sm btn-warning" onclick="ModalModificar('+i+')">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '   <td center>' +        
                        '       <button class="btn btn-sm btn-danger" onclick="ModalEliminar('+i+')">' +
                        '           <i class="fas fa-trash-alt"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}

//Ejecutamos la funcion actualizar al cargar la pagina o de inmediato
Actualizar();

function Agregar()
{
   
    var form = document.getElementById("form-nuevo");
    var modal = $("#staticBackdropnuevaMesa");

    MesasModel.Registrar( {
        formulario: form,
        beforeSend: function()
        {
            Loader.Mostrar();
        },
        error: function(mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: function(data)
        {
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
            form.reset();
            Alerta.Success("Nueva Mesa Agregada.");
        }
    } );
}

function ModalModificar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropModificaMesa");
    var inputId = document.getElementById("MIdMesa");
    var inputalias = document.getElementById("Maliasmesa");

    inputId.value = datos.idMesa;
    inputalias.value = datos.alias;
   
    modal.modal("show");
}

function Modificar()
{
    var form = document.getElementById("form-modificar");
    var modal = $("#staticBackdropModificaMesa");

    MesasModel.Modificar({
        formulario: form,
        beforeSend: function()
        {
            Loader.Mostrar();
        },
        error: function(mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: function(data)
        {
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Mesa Modificada con Exito.");
        }
    });
}

function ModalEliminar(fila)
{
    
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropeliminaMesa");
    var inputId = document.getElementById("EidMesa");
    var text = document.getElementById("EText");

    inputId.value = datos.idMesa;
    text.innerHTML = "¿Esta seguro que desea eliminar la Mesa <b>"+datos.alias+"</b>?";
    modal.modal("show");
}

function Eliminar()
{

    var form = document.getElementById("form-eliminarmesa");
    var modal = $("#staticBackdropeliminaMesa");

    MesasModel.Eliminar({
        formulario: form,
        beforeSend: function()
        {
            Loader.Mostrar();
        },
        error: function(mensaje)
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: function(data)
        {
            Actualizar();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Categoría Eliminada Con Exito.");
        }
    });
}