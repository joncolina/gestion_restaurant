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
    }

    //Consultamos
    PlatosModel.Consultar({
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
                        '       <div class="d-flex align-items-center">' +
                        '           <div class="plato-miniatura mr-2">' +
                        '               <img class="float-left" src="'+dato.imagen+'">' +
                        '           </div>' +
                        '           ' + dato.nombre + 
                        '       </div>' +
                        '   </td>' +

                        '   <td style="vertical-align: middle;">' +
                        '       ' + dato.categoria.nombre +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +        
                        '       <button class="btn btn-sm btn-warning" onclick="ModalModificar('+i+')">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +
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

/*================================================================================
 *
 *	
 *
================================================================================*/
function Agregar()
{
    var form = document.getElementById("form-nuevo");
    var modal = $("#staticBackdropnuevoPla");

    PlatosModel.Registrar( {
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
            Alerta.Success("Nuevo Plato Agregado.");
        }
    } );
}

document.getElementById("img-foto-plato-nuevo").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-plato-nuevo");
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

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModalModificar(fila)
{
    var datos = tabla.getData()[fila];
    var modal = $("#staticBackdropmodificaPla");

    var inputId = document.getElementById("idPlato-modificar");
    var img = document.getElementById("label-foto-plato-modificar").getElementsByTagName("img")[0];
    var inputImg = document.getElementById("img-foto-plato-modificar");
    var inputNombre = document.getElementById("MNombrePlato");
    var inputDescripcion = document.getElementById("MDescripPlato");
    var inputCategoria = document.getElementById("MCategoriaPlato");
    var inputCosto = document.getElementById("MPrecioCostoPlato");
    var inputVenta = document.getElementById("MPrecioVentaPlato");
    var inputActivo = document.getElementById("customSwitch2");

    inputId.value = datos.id;
    img.src = datos.imagen;
    inputImg.value = "";
    inputNombre.value = datos.nombre;
    inputDescripcion.value = datos.descripcion;
    inputCategoria.value = datos.categoria.id;
    inputCosto.value = datos.precioCosto;
    inputVenta.value = datos.precioVenta;
    inputActivo.checked = datos.activo;

    modal.modal("show");
}

document.getElementById("img-foto-plato-modificar").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-foto-plato-modificar");
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

function Modificar()
{
    var modal = $("#staticBackdropmodificaPla");
    var form = document.getElementById("form-modificar");

    PlatosModel.Modificar({
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
            Alerta.Success("Plato modificado exitosamente.");
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

    var input = document.getElementById("idPlato-eliminar");
    var label = document.getElementById("label-eliminar");

    input.value = datos.id;
    label.innerHTML = datos.id+" - "+datos.nombre;
    
    modal.modal("show");
}

function Eliminar()
{
    var modal = $("#modal-eliminar");
    var form = document.getElementById("form-eliminar");

    PlatosModel.Eliminar({
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
            Alerta.Success("Plato eliminado exitosamente.");
        }
    });
}