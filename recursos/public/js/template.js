/**==================================================================
 * Cerrar Sesión
 ===================================================================*/
 // Variables
var cerrar_sesion = {
    modal: "modal-cerrarSesion",
    form: "form-cerrarSesion",
    boton: "boton-cerrarSesion"
};

//Modal
function ModalCerrarSesion()
{
    var modal = $("#" + cerrar_sesion.modal);

    modal.modal("show");
}

//Evento
$("#" + cerrar_sesion.modal).on("hidden.bs.modal", function(e)
{
    location.hash = "/";
    document.getElementById(cerrar_sesion.form).reset();
});

//Boton
document.getElementById(cerrar_sesion.boton).onclick = function() { CerrarSesion(); }

//Cerrar sesión
function CerrarSesion()
{
    var url = HOST_AJAX + "Salir/";
    var method = "POST";
    var dataType = "json";
    var data = new FormData( document.getElementById(cerrar_sesion.form) );

    if(Formulario.Validar(cerrar_sesion.form) == false) return;

    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function (jqXHR, setting)
        {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;
            Loader.Mostrar();
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;
            if (respuesta.status)
            {
                location.href = HOST + "Login/";
            }
            else
            {
                console.error(respuesta.data);
                Loader.Ocultar();
                Alerta.Danger(respuesta.mensaje);
            }
        },

        error: function (jqXHR, status, errorThrow)
        {
            var mensaje = jqXHR.responseText;
            console.error("Error: " + mensaje);
            Loader.Ocultar();
            alert(mensaje);
        }
    });
}

/**==================================================================
 * Menu lateral
 ===================================================================*/
function MenuLateral()
{
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled")
    {
        document.body.className = "sb-nav-fixed";
    }
    else
    {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}

/**==================================================================
 * Actualizar el numero de los pedidos
 ===================================================================*/
function ActualizarPedidos()
{
    var data = new FormData();
    data.append("accion", "TOTAL");

    $.ajax({
        url: HOST_AJAX + "Pedidos/Carrito/",
        method: "POST",
        data: data,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function (jqXHR, setting)
        {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;
        },

        error: function (jqXHR, status, errorThrow)
        {
            var mensaje = jqXHR.responseText;
            console.error("Error: " + mensaje);
            Alerta.Danger(mensaje);
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;

            if(respuesta.status == false) {
                console.error(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                return;
            }

            var cantidad = respuesta.data.cantidad;

            if(cantidad > 0) {
                document.getElementById("contenedor-pedidos").setAttribute("cantidad", cantidad);
            } else {
                document.getElementById("contenedor-pedidos").removeAttribute("cantidad");
            }
        }
    });
}

/**==================================================================
 * Ver los pedidos
 ===================================================================*/
 /**
  * Variables
  */
 var arrayPedidos = [];

 /**
  * Función de consulta
  */
function VerPedidos()
{
    var modal = $("#consultar-pedidos-mesa");
    var data = new FormData();
    data.append("accion", "CONSULTA");

    $.ajax({
        url: HOST_AJAX + "Pedidos/Carrito/",
        method: "POST",
        dataType: "JSON",
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function (jqXHR, setting)
        {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;

            Loader.Mostrar();
        },

        error: function (jqXHR, status, errorThrow)
        {
            var mensaje = jqXHR.responseText;
            console.error("Error: " + mensaje);
            Alerta.Danger(mensaje);

            Loader.Ocultar();
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;

            if(respuesta.status == false) {
                console.error(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }

            var tbody = document.getElementById("tbody-pedidos-mesa-general");
            var pedidos = respuesta.data.pedidos;
            arrayPedidos = pedidos;
            var montoTotal = 0;

            var code = "";
            var index = 0;
            for(var pedido of pedidos)
            {
                var img = pedido.plato.imagen;
                var nombre = pedido.plato.nombre;
                var status = "";
                var statusClase = "";
                
                montoTotal = Number(montoTotal) + Number(pedido.precioTotal);

                switch(pedido.status.id)
                {
                    case 0: // SIN CONFIRMAR
                        status = pedido.status.nombre;
                        statusClase = "badge badge-success";
                    break;

                    case 1: // CONFIRMADO
                        status = "EN ESPERA";
                        statusClase = "badge badge-warning";
                    break;

                    case 2: // COCINADO
                        status = "EN ESPERA";
                        statusClase = "badge badge-warning";
                    break;

                    case 3: // DESPACHADO
                        status = pedido.status.nombre;
                        statusClase = "badge badge-primary";
                    break;

                    case 4: // PAGADO
                        status = pedido.status.nombre;
                        statusClase = "badge badge-dark";
                    break;

                    case 5: // CANCELADO
                        status = pedido.status.nombre;
                        statusClase = "badge badge-danger";
                    break;
                }

                code += `<tr>
                    <td class="text-truncate">
                        <div class="d-flex align-items-center">
                            <div class="plato-miniatura mr-2">
                                <img class="float-left" src="${img}">
                            </div>

                            ${nombre}
                        </div>
                    </td>

                    <td center class="text-truncate" style="vertical-align: middle;">
                        <div class="${statusClase}">${status}</div>
                    </td>

                    <td center class="text-truncate" style="vertical-align: middle;">
                        <button class="btn btn-sm btn-danger" style="width: 32px;" onclick="EliminarPedidoGeneral(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        <button class="btn btn-sm btn-primary" style="width: 32px;" onclick="VerPedidoGeneral(${index})">
                            <i class="fas fa-info"></i>
                        </button>
                    </td>
                </tr>`;

                index += 1;
            }

            if(index == 0)
            {
                code += `<tr>
                    <td colspan="100">
                        <h5 center>
                            No se encontraron resultados.
                        </h5>
                    </td>
                </tr>`;

                document.getElementById("boton-confirmar-todos-los-pedidos").setAttribute("disabled", "");
                document.getElementById("boton-confirmar-todos-los-pedidos").removeAttribute("onclick");
            }
            else
            {
                document.getElementById("boton-confirmar-todos-los-pedidos").removeAttribute("disabled");
                document.getElementById("boton-confirmar-todos-los-pedidos").setAttribute("onclick", "ConfirmarTodosLosPedidosGeneral()");
            }

            tbody.innerHTML = code;
            document.getElementById("consultar-pedidos-mesa-total").innerHTML = "BsS. "+Formato.Numerico(montoTotal, 2);

            Loader.Ocultar();
            modal.modal("show");
        }
    });
}

/**==================================================================
 * Ver pedido
 ===================================================================*/
function VerPedidoGeneral(fila)
{
    var datos = arrayPedidos[fila];
    var modal = $("#consultar-pedidos-mesa-info");

    var img = document.getElementById("pedidos-mesa-info-img");
    var nombre = document.getElementById("pedidos-mesa-info-nombre");
    var categoria = document.getElementById("pedidos-mesa-info-categoria");
    var precioUnitario = document.getElementById("pedidos-mesa-info-precioUnitario");
    var cantidad = document.getElementById("pedidos-mesa-info-cantidad");
    var descuento = document.getElementById("pedidos-mesa-info-descuento");
    var precioTotal = document.getElementById("pedidos-mesa-info-precioTotal");
    var nota = document.getElementById("pedidos-mesa-info-observaciones");

    var montoUnitario = Number(datos.precioUnitario);
    var montoTotal = Number(datos.precioTotal);
    var montoDescuento = Number(datos.precioTotal) * (1 - (Number(datos.descuento) / 100));

    img.src = datos.plato.imagen;
    nombre.innerHTML = datos.plato.nombre;
    categoria.innerHTML = datos.categoria.nombre;
    precioUnitario.value = "BsS. " + Formato.Numerico(montoUnitario, 2);
    cantidad.value = Formato.Numerico(datos.cantidad, 0);
    descuento.value = Formato.Numerico(datos.descuento, 2) + "%";
    precioTotal.value = "BsS. " + Formato.Numerico(montoDescuento, 2);
    nota.value = datos.nota;

    modal.modal("show");
}

/**==================================================================
 * Eliminar pedido
 ===================================================================*/
function EliminarPedidoGeneral(fila)
{
    var datos = arrayPedidos[fila];
    var msj = "¿Esta seguro que desea eliminar el pedido?";

    if(datos.combo.id != null) {
        msj += "\nEl pedido esta asociado al combo '"+datos.combo.nombre+"', se eliminara todos los pedidos asociados a ese combo.";
    }
    
    var r = confirm(msj);
    if(r == false) return;

    var data = new FormData();
    data.append("accion", "ELIMINAR");
    data.append("id", datos.id);
    $.ajax({
        url: HOST_AJAX + "Pedidos/Carrito/",
        method: "POST",
        dataType: "JSON",
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function (jqXHR, setting)
        {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;

            Loader.Mostrar();
        },

        error: function (jqXHR, status, errorThrow)
        {
            var mensaje = jqXHR.responseText;
            console.error("Error: " + mensaje);
            Alerta.Danger(mensaje);

            Loader.Ocultar();
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;

            if(respuesta.status == false) {
                console.error(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }

            Loader.Ocultar();
            VerPedidos();
            ActualizarPedidos();
        }
    });
}

/**==================================================================
 * Confirmar todos los pedidos
 ===================================================================*/
function ConfirmarTodosLosPedidosGeneral()
{
    var msj = "¿Esta seguro que desea confirmar los pedidos?";
    var r = confirm(msj);
    if(r == false) return;

    var data = new FormData();
    data.append("accion", "CONFIRMAR");
    $.ajax({
        url: HOST_AJAX + "Pedidos/Carrito/",
        method: "POST",
        dataType: "JSON",
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function (jqXHR, setting)
        {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;

            Loader.Mostrar();
        },

        error: function (jqXHR, status, errorThrow)
        {
            var mensaje = jqXHR.responseText;
            console.error("Error: " + mensaje);
            Alerta.Danger(mensaje);

            Loader.Ocultar();
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;

            if(respuesta.status == false) {
                console.error(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }

            Loader.Ocultar();
            VerPedidos();
            ActualizarPedidos();
        }
    });
}