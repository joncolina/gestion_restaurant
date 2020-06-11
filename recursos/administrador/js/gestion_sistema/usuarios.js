/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");

//Tabla
var idTable = "tabla";
var tabla = new TablaGestion(idTable);

//Modal nuevo
var idModalNuevo = "modal-nuevo";
var idFormNuevo = "form-nuevo";

//Modal eliminar
var idModalEliminar = "modal-eliminar";
var idFormEliminar = "form-eliminar";
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
    
    //Verificamos el buscador
    var buscar = undefined;
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        buscar = parametros['buscar'].replace(/_/g, " ");
    }

    //Consultamos
    AdminUsuariosModel.Consultar
    ({
        //Parametros
        buscar: buscar,
        beforeSend: () => { tabla.Cargando(); },
        error: (mensaje) => { tabla.Error(); Alerta.Danger(mensaje); },
        success: (data) =>
        {
            //Funcion para actualizar la tabla
            tabla.Actualizar({
                //Parametros
                data: data,
                //Accion para actualizarla
                accion: (tbody, data, inicio, fin) =>
                {
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
                }
            });
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
Actualizar();





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
function Nuevo()
{
    var form = document.getElementById(idFormNuevo);
    AdminUsuariosModel.Registrar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) => { Loader.Ocultar(); Alerta.Danger(mensaje); },
        success: (data) => {
            var usuario = data.usuario;
            var link = HOST_ADMIN + "Gestion_Sistema/Usuarios/"+usuario+"/";
            location.href = link;
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
function Eliminar()
{
    var form = document.getElementById(idFormEliminar);
    AdminUsuariosModel.Eliminar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) => { Loader.Ocultar(); Alerta.Danger(mensaje); },
        success: (data) => {
            Actualizar();
            Loader.Ocultar();
            $("#"+idModalEliminar).modal("hide");
            var usuario = data.usuario;
            Alerta.Success("Usuario <b>"+usuario+"</b> eliminado exitosamente.");
        }
    });
}