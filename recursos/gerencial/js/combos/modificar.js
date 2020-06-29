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

//Platos seleccionados
var categorias = [];
var platos = [];

//Registrar
var idModificar = {
    modal: "modal-modificar",
    form: "form-modificar"
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

                        var textoActivo = "Si";
                        var claseActivo = "badge badge-success";
                        if(!dato.activo) {
                            textoActivo = "No";
                            claseActivo = "badge badge-danger";
                        }

                        var checkStatus = "";
                        for(var index=0; index<platos.length; index++) {
                            if(platos[index].id == dato.id) {
                                checkStatus = "checked";
                                break;
                            }
                        }

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr style="cursor: pointer;" onclick="ClickRow(\''+i+'\', \''+dato.id+'\')">' +
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
                        '       <div class="'+claseActivo+'">' +
                        '       ' + textoActivo +
                        '       </div>' +
                        '   </td>' +

                        '   <td center style="vertical-align: middle;">' +
                        '       <div class="custom-control custom-switch">' +
                        '           <input type="checkbox" '+checkStatus+' class="custom-control-input" id="check-id-'+dato.id+'">' +
                        '           <label class="custom-control-label" for="check-id-'+dato.id+'"></label>' +
                        '       </div>' +
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
 * 
 * 
--------------------------------------------------------------------------------*/
function ClickRow(index, id)
{
    var check = document.getElementById("check-id-"+id);
    check.checked = !check.checked;
    ClickCheckBox(index, id);
}

function ClickCheckBox(index, id)
{
    var datos = tabla.getData()[index];
    var check = document.getElementById("check-id-"+id);

    if(check.checked)
    {
        platos.push({
            id: datos.id,
            nombre: datos.nombre
        });
    }
    else
    {
        for(var i=0; i<platos.length; i++) {
            if(platos[i].id == id) {
                platos.splice(i, 1);
                break;
            }
        }
    }
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Continuar()
{
    var modal = $("#" + idModificar.modal);

    if(platos.length == 0) {
        Alerta.Danger("Para continuar debe seleccionar al menos un plato.");
        return;
    }

    CombosModel.AnalizarPlatos({
        platos: platos,

        antes: function()
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
            Loader.Ocultar();
            modal.modal("show");

            platos = data.platos;
            var categorias_detalles = data.categorias;

            var tbody = document.getElementById("tbody-platos");
            tbody.innerHTML = "";

            var index = 0;
            for(var categoria_det of categorias_detalles)
            {
                var cantidad_defecto = 1;
                for(var categoria of categorias) {
                    if(categoria_det.id == categoria.id) {
                        cantidad_defecto = categoria.cantidad;
                        break;
                    }
                }

                tbody.innerHTML += `<tr>
                    <td style="vertical-align: center;" left>
                        ${categoria_det.nombre}
                    </td>

                    <td style="vertical-align: center;" center>
                        ${categoria_det.cantidad}
                    </td>

                    <td style="vertical-align: center;" center>
                        <div class="input-group input-group-sm">
                        <input type="hidden" name="categorias[${index}][id]" value="${categoria_det.id}" />
                            <input type="number" class="form-control" name="categorias[${index}][cantidad]" required max="${categoria_det.cantidad}" value="${cantidad_defecto}" />
                        </div>
                    </td>
                </tr>`;

                index += 1;
            }
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Modificar()
{
    var form = document.getElementById(idModificar.form);
    var modal = $("#" + idModificar.modal);

    if(platos.length == 0) {
        Alerta.Danger("Para continuar debe seleccionar al menos un plato.");
        return;
    }
    
    if( Formulario.Validar(idModificar.form) == false ) return;

    CombosModel.Modificar({
        formulario: form,
        platos: platos,

        antes: function()
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
            location.href = HOST_GERENCIAL + "Combos/";
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Filtros(input)
{
    var valor = input.value;
    var hash = "/";
    if(valor != "") {
        hash = '/buscar=categoria-'+valor+"/";
    }

    location.hash = hash;
    Actualizar();
}

/*--------------------------------------------------------------------------------
 * 
 * 
 * 
--------------------------------------------------------------------------------*/
function Limpiar()
{
    platos = [];
    Actualizar();
}