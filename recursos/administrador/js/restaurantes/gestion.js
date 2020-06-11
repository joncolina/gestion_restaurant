/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Tabla
var idTabla = "tabla";
var tabla = new TablaGestion(idTabla);

//Buscador
var buscador = new Buscador("input-buscador", "boton-buscador", "Actualizar");

//Modal
var idModal = "modal-cambiar-acceso";
var idForm = "form-cambiar-acceso";
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

    //Verificamos el buscador
    var buscar = undefined;
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        buscar = parametros['buscar'].replace(/_/g, " ");
    }

    //Consultamos
    RestaurantesModel.Consultar
    ({
        //Parametros
        buscar: buscar,
        beforeSend: () => { tabla.Cargando(); },
        error: (mensaje) => { tabla.Error(); Alerta.Danger(mensaje); },
        success: (data) =>
        {
            //Funcion para actualizar la tabla
            tabla.Actualizar({
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

                        var link = HOST_ADMIN + `Restaurantes/Gestion/${dato.id}/`;

                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            claseActivo = "badge badge-danger";
                        }


                        tbody.innerHTML +=
                        '<tr class="table-sm">' +
                        '   <td>' +
                        '       <a href="'+link+'">' +
                        '           <div class="d-flex align-items-center">' +
                        '               <img class="mr-2 rounded float-left img-thumbnail" style="width: 48px; height: 48px;" src="'+dato.logo+'">' +
                        '               ' + dato.nombre + 
                        '           </div>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td class="no-table" style="vertical-align: middle;">' +
                        '       ' + dato.documento +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + Formato.bool2text( dato.activo ) +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="CambiarAcceso('+i+')">' +
                        '           <i class="fas fa-power-off"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}

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
function ModificarAcceso()
{
    var form = document.getElementById(idForm);
    RestaurantesModel.Eliminar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) => { Loader.Ocultar(); Alerta.Danger(mensaje); },
        success: (data) => {
            Actualizar();
            Loader.Ocultar();
            $("#" + idModal).modal("hide");
            Alerta.Success("Se ha modificado el restaurant exitosamente.");
        }
    });
}