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

//Ver
var idVer = {
    modal: "modal-ver"
};

//Eliminar
var idEliminar = {
    modal: "modal-eliminar",
    form: "form-eliminar",
    boton: "botom-eliminar",
    inputId: "input-idCombo-eliminar",
    textNombre: "label-nombre-eliminar"
};

/*--------------------------------------------------------------------------------
 * 
 * Actualizar
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
    CombosModel.Consultar({
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

                        var textoActivo = "Si";
                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            textoActivo = "No";
                            claseActivo = "badge badge-danger";
                        }

                        var linkModificar = HOST_GERENCIAL+"Combos/Modificar/"+dato.id+"/";
                        var linkVer = HOST_GERENCIAL+"Combos/Ver/"+dato.id+"/";

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       <div class="d-flex align-items-center">' +
                        '           <div class="plato-miniatura mr-2">' +
                        '               <img class="float-left" src="'+dato.imagen+'">' +
                        '           </div>' +
                        '           ' + dato.nombre + 
                        '       </div>' +
                        '   </td>' +

                        '   <td style="vertical-align: middle;" center>' +
                        '       ' + Formato.Numerico( dato.descuento, 2 ) + "%" +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + textoActivo +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <a class="btn btn-sm btn-success" href="'+linkVer+'">' +
                        '           <i class="fas fa-eye"></i>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <a class="btn btn-sm btn-warning" href="'+linkModificar+'">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
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

/*--------------------------------------------------------------------------------
 * 
 * Ver
 * 
--------------------------------------------------------------------------------*/
function ModalVer(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#" + idVer.modal);
    
    modal.modal("show");
}

/*--------------------------------------------------------------------------------
 * 
 * Eliminar
 * 
--------------------------------------------------------------------------------*/
function ModalEliminar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#" + idEliminar.modal);
    var inputId = document.getElementById(idEliminar.inputId);
    var textNombre = document.getElementById(idEliminar.textNombre);

    inputId.value = datos.id;
    textNombre.innerHTML = datos.nombre;

    modal.modal("show");
}

function Eliminar()
{
    var modal = $("#" + idEliminar.modal);
    var form = document.getElementById(idEliminar.form);

    CombosModel.Eliminar({
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
            Alerta.Success("Se ha eliminado el combo exitosamente.");
        }
    });
}