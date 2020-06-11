/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormBasico = "form-basico";
var idFormRedes = "form-redes";

/*================================================================================
 *
 *	
 *
================================================================================*/
$("#opciones-basico").on("show.bs.tab", function(e) { location.hash = "basico/"; });
$("#opciones-redes").on("show.bs.tab", function(e) { location.hash = "redes/"; });
$("#opciones-roles").on("show.bs.tab", function(e) { location.hash = "roles/"; });
$("#opciones-permisos").on("show.bs.tab", function(e) { location.hash = "permisos/"; });
$("#opciones-usuarios").on("show.bs.tab", function(e) { location.hash = "usuarios/"; });

if(location.hash != "")
{
    var hash = location.hash;
    hash = hash.replace("#", "");
    switch(hash)
    {
        case "redes/":
            document.getElementById("opciones-redes").click();
        break;

        case "roles/":
            document.getElementById("opciones-roles").click();
        break;

        case "permisos/":
            document.getElementById("opciones-permisos").click();
        break;

        case "usuarios/":
            document.getElementById("opciones-usuarios").click();
        break;
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("input-basico-activo-aux").onchange = function()
{
    if( document.getElementById("input-basico-activo-aux").checked ) {
        document.getElementById("input-basico-activo").value = "1";
    } else {
        document.getElementById("input-basico-activo").value = "0";
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarBasico()
{
    var form = document.getElementById(idFormBasico);
    RestaurantesModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            Formulario.Sync(idFormBasico);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarBasico()
{
    var form = document.getElementById(idFormBasico);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarRedes()
{
    var form = document.getElementById(idFormRedes);
    RestaurantesModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            Formulario.Sync(idFormRedes);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarRedes()
{
    var form = document.getElementById(idFormRedes);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
var datos_roles = [];
$("#opciones-roles").on("shown.bs.tab", function() { ActualizarRoles(); });

function ActualizarRoles()
{
    var idRestaurant = document.getElementsByName("idRestaurant")[0].value;
    RolesModel.Consultar({
        idRestaurant: idRestaurant,
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
            datos_roles = data;
            Loader.Ocultar();
            var table = document.getElementById("tabla-roles");
            var tbody = table.getElementsByTagName("tbody")[0];
            tbody.innerHTML = "";

            for(var i=0; i<data.length; i++)
            {
                var datos = data[i];
                tbody.innerHTML +=
                '<tr>' +
                '   <td center>' +
                '       ' + datos.id +
                '   </td>' +
                
                '   <td>' +
                '       ' + datos.nombre +
                '   </td>' +
                
                '   <td>' +
                '       ' + datos.descripcion +
                '   </td>' +
                
                '   <td center>' +
                '       <button class="btn btn-sm btn-success" onclick="ModalEditarRol('+i+')"><i class="fas fa-sm fa-edit"></i></button>' +
                '       <button class="btn btn-sm btn-danger" onclick="ModalEliminarRol('+i+')"><i class="fas fa-sm fa-trash-alt"></i></button>' +
                '   </td>' +
                '</tr>';
            }
        }
    });
}

function ModalEditarRol(fila)
{
    var datos = datos_roles[fila];
    var modal = $("#modal-rol-editar");
    var idInput = document.getElementById("id-rol-editar");
    var nombreInput = document.getElementById("nombre-rol-editar");
    var descripcionInput = document.getElementById("descripcion-rol-editar");

    idInput.value = datos.id;
    nombreInput.value = datos.nombre;
    descripcionInput.value = datos.descripcion;

    modal.modal("show");
}

function ModalEliminarRol(fila)
{
    var datos = datos_roles[fila];
    var modal = $("#modal-rol-eliminar");
    var idInput = document.getElementById("id-rol-eliminar");
    var label = document.getElementById("text-rol-eliminar");

    idInput.value = datos.id;
    label.innerHTML = '¿Esta seguro que desea eliminar el rol <b>'+datos.id+' - '+datos.nombre+'</b>?';

    modal.modal("show");
}

function NuevoRol()
{
    var modal = $("#modal-rol-nuevo");
    var form = document.getElementById("form-rol-nuevo");

    RolesModel.Registrar({
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
            ActualizarRoles();
            form.reset();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Se ha registrado el nuevo rol exitosamente.");
        }
    });
}

function ModificarRol()
{
    var modal = $("#modal-rol-editar");
    var form = document.getElementById("form-rol-editar");

    RolesModel.Modificar({
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
            ActualizarRoles();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Se ha modificado el rol exitosamente.");
        }
    });
}

function EliminarRol()
{
    var modal = $("#modal-rol-eliminar");
    var form = document.getElementById("form-rol-eliminar");

    RolesModel.Eliminar({
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
            ActualizarRoles();
            Loader.Ocultar();
            modal.modal("hide");
            Alerta.Success("Se ha eliminado el rol exitosamente.");
        }
    });
}

/*================================================================================
 *
 *	
 *
================================================================================*/
var datos_permisos = [];
$("#opciones-permisos").on("shown.bs.tab", function() { ActualizarPermisos(); });

function ActualizarPermisos()
{
    var idRestaurant = document.getElementsByName("idRestaurant")[0].value;
    PermisosModel.Consultar({
        idRestaurant: idRestaurant,
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
            datos_permisos = data;
            Loader.Ocultar();
            var table = document.getElementById("tabla-permisos");
            var thead = table.getElementsByTagName("thead")[0];
            var tbody = table.getElementsByTagName("tbody")[0];

            thead.innerHTML = "";
            tbody.innerHTML = "";

            var theadData = data.thead;
            var tbodyData = data.tbody;

            var codeHead = "";
            codeHead += "<tr>";
            codeHead += "<td class='w-auto'>Menus / Roles</td>";
            for(var i=0; i<theadData.length; i++)
            {
                codeHead += "<td class=' min-w-100px'>"+theadData[i].nombre+"</td>";
            }
            codeHead += "</tr>";
            thead.innerHTML = codeHead;

            var codeBody = "";
            for(var i=0; i<tbodyData.length; i++)
            {
                codeBody += "<tr>";

                if(tbodyData[i][0].tipo == "A") {
                    codeBody += "<td class='text-truncate min-w-100px'>"+"<i class='"+tbodyData[i][0].img+" mr-2'></i>"+tbodyData[i][0].nombre+"</td>";
                } else {
                    codeBody += "<td class='text-truncate min-w-100px'>"+"<i class='"+tbodyData[i][0].img+" ml-3 mr-2'></i>"+tbodyData[i][0].nombre+"</td>";
                }
               
                for(var j=1; j<tbodyData[i].length; j++)
                {
                    var clases = "";
                    var text = "";

                    if(tbodyData[i][j].valor)
                    {
                        clases = 'text-success';
                        text = "Si";
                    }
                    else
                    {
                        clases = 'text-danger';
                        text = "No";
                    }

                    codeBody +=
                    '<td class="' + clases + ' font-weight-bold position-relative">' +
                    '   ' + text +
                    '   <div class="opcion-flotante-derecha" onclick="CambiarPermiso('+i+', '+j+')"><i class="fas fa-sync-alt"></i></div>' +
                    '</td>';
                }
                codeBody += "</tr>";
            }
            tbody.innerHTML = codeBody;
        }
    });
}

function CambiarPermiso(i, j)
{
    var datos = datos_permisos['tbody'][i][j];
    var form = document.createElement("form");

    var inputIdMenu = document.createElement("input");
    inputIdMenu.setAttribute("type", "hidden");
    inputIdMenu.setAttribute("name", "idMenu");
    inputIdMenu.setAttribute("value", datos.idMenu);

    var inputTipo = document.createElement("input");
    inputTipo.setAttribute("type", "hidden");
    inputTipo.setAttribute("name", "tipo");
    inputTipo.setAttribute("value", datos.tipo);

    var inputIdRol = document.createElement("input");
    inputIdRol.setAttribute("type", "hidden");
    inputIdRol.setAttribute("name", "idRol");
    inputIdRol.setAttribute("value", datos.idRol);

    form.appendChild(inputIdMenu);
    form.appendChild(inputTipo);
    form.appendChild(inputIdRol);

    PermisosModel.Modificar({
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
            ActualizarPermisos();
            Loader.Ocultar();
        }
    });
}





/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("img-logo-restaurant").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-logo-restaurant");
    var img = label.getElementsByTagName("img")[0];

    if(input.files.length <= 0) {
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function(e)
    {
        img.src = e.target.result;
    }

    reader.readAsDataURL( file );
}