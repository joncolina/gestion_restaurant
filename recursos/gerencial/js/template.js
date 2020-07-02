function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}
function CerrarSesion() {
    var url = HOST_GERENCIAL_AJAX + "Salir/";
    var method = "POST";
    var dataType = "json";
    var data = {};
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType,
        beforeSend: function (jqXHR, setting) {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;
            Loader.Mostrar();
        },
        success: function (respuesta, status, jqXHR) {
            var respuestaText = jqXHR.responseText;
            if (respuesta.status) {
                location.href = HOST_GERENCIAL + "Login/";
            }
            else {
                Alerta.Danger(respuesta.mensaje);
                console.error(respuesta.data);
                Loader.Ocultar();
            }
        },
        error: function (jqXHR, status, errorThrow) {
            var mensaje = jqXHR.responseText;
            alert(mensaje);
            Loader.Ocultar();
        }
    });
}