var idBotonAcceso = "BotonAcceso";
var idInputUsuario = "input-usuario";
var idInputClave = "input-clave";
$("#" + idInputUsuario).keyup(function (e) {
    if (e.key == "Enter") {
        $("#" + idInputClave).select();
    }
});
$("#" + idInputClave).keyup(function (e) {
    if (e.key == "Enter") {
        Acceder();
    }
});
$("#" + idBotonAcceso).click(function (e) {
    Acceder();
});
function Acceder() {
    if (!ValidarLogin()) {
        return;
    }
    var usuario = $("#" + idInputUsuario).val();
    var clave = $("#" + idInputClave).val();
    var url = HOST_GERENCIAL_AJAX + "Login/Acceder/";
    var method = "POST";
    var dataType = "JSON";
    var data = {
        usuario: usuario,
        clave: clave
    };
    $.ajax({
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        beforeSend: function (jqXHR, setting) {
            Loader.Mostrar();
        },
        success: function (respuesta, status, jqXHR) {
            var respuestaText = jqXHR.responseText;
            if (!respuesta.status) {
                Alerta.Danger(respuesta.mensaje);
                console.error(respuestaText.data);
                Loader.Ocultar();
                $("#" + idInputClave).val("");
                $("#" + idInputUsuario).select();
                return;
            }
            location.reload();
        },
        error: function (jqXHR, status, errorThrow) {
            var mensaje = jqXHR.responseText;
            alert(mensaje);
            Loader.Ocultar();
            $("#" + idInputClave).val("");
            $("#" + idInputUsuario).select();
        }
    });
}
function ValidarLogin() {
    var inputUsuario = $("#" + idInputUsuario);
    var inputClave = $("#" + idInputClave);
    var usuario = inputUsuario.val();
    var clave = inputClave.val();
    if (usuario == "") {
        Alerta.Danger("El usuario no puede estar vacio.");
        inputUsuario.select();
        return false;
    }
    if (clave == "") {
        Alerta.Danger("La contraseña no puede estar vacia.");
        inputClave.select();
        return false;
    }
    return true;
}
