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

//Filtros
var filtro = new Filtro("filtros", "form-filtro", "boton-filtro", "Actualizar");

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
    var filtros = undefined;
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        buscar = parametros['buscar'].replace(/_/g, " ");
    }
    else if(parametros['filtros'] == "si")
    {
        filtros = [];
        for(var valor in parametros)
        {
            filtros[valor] = parametros[valor].replace(/_/g, " ");
        }
    }

    //Consultamos
    UsuariosModel.Consultar
    ({
        //Parametros
        buscar: buscar,
        filtros: filtros,
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

                        var link = HOST_GERENCIAL + `Usuarios/Ver/${dato.usuario}/`;

                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            claseActivo = "badge badge-danger";
                        }

                        var claseRol = "badge badge-primary";
                        if(dato.rol.responsable) {
                            claseRol = "badge badge-success";
                        }


                        tbody.innerHTML +=
                        '<tr class="tab le-sm">' +
                        '   <td>' +
                        '       <a href="'+link+'">' +
                        '           <div class="d-flex align-items-center">' +
                        '               <div class="usuario-miniatura mr-2">' +
                        '                   <img class="float-left" src="'+dato.foto+'">' +
                        '               </div>' +
                        '               ' + dato.nombre + 
                        '           </div>' +
                        '       </a>' +
                        '   </td>' +

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.usuario +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseRol+'">' + dato.rol.nombre + '</div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="'+claseActivo+'">' +
                        '           ' + Formato.bool2text( dato.activo ) +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="CambiarActivo('+i+')">' +
                        '           <i class="fas fa-power-off"></i>' +
                        '       </button>' +
                          
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

/*================================================================================
 *
 *	
 *
================================================================================*/
function CambiarActivo(fila)
{
    var datos = tabla.getData()[fila];
    var form = document.createElement("form");

    var inputUsuario = document.createElement("input");
    inputUsuario.setAttribute("type", "hidden");
    inputUsuario.setAttribute("name", "usuario");
    inputUsuario.setAttribute("value", datos.usuario);
    form.appendChild( inputUsuario );

    if(datos.activo) var activo = "0";
    else var activo = "1";
    var inputActivo = document.createElement("input");
    inputActivo.setAttribute("type", "hidden");
    inputActivo.setAttribute("name", "activo");
    inputActivo.setAttribute("value", activo);
    form.appendChild( inputActivo );

    UsuariosModel.Modificar({
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
            Alerta.Success("Cambio de estatus realizado exitosamente.");
        }
    });
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModalEliminar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#modal-eliminar");
    var inputUsuario = document.getElementById("input-eliminar-usuario");
    var text = document.getElementById("text-eliminar");

    inputUsuario.value = datos.usuario;
    text.innerHTML = "¿Esta seguro que desea eliminar el usuario <b>"+datos.usuario+"</b>?";
    modal.modal("show");
}

function Eliminar()
{
    var form = document.getElementById("form-eliminar");
    var modal = $("#modal-eliminar");

    UsuariosModel.Eliminar({
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
            Alerta.Success("Se ha eliminado al usuario exitosamnte.");
        }
    });
}