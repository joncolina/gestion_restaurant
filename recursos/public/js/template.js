var cerrar_sesion = {
    modal: "modal-cerrarSesion",
    form: "form-cerrarSesion",
    boton: "boton-cerrarSesion"
};

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

function ModalCerrarSesion()
{
    var modal = $("#" + cerrar_sesion.modal);

    modal.modal("show");
}

$("#" + cerrar_sesion.modal).on("hidden.bs.modal", function(e)
{
    location.hash = "/";
    document.getElementById(cerrar_sesion.form).reset();
});

document.getElementById(cerrar_sesion.boton).onclick = function() { CerrarSesion(); }

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

function ActualizarPedidos()
{
    var data = new FormData();

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
                console.error(respuesta.mensaje);
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

function VerPedidos()
{
    var modal = $("#consultar-pedidos-mesa");
    modal.modal("show");
}