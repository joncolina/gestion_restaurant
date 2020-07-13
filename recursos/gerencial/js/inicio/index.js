function CambiarServicio()
{
    var msj = "¿Esta seguro que desea modificar el servicio?";
    var r = confirm(msj);
    if(r == false) return;

    var data = new FormData();

    $.ajax({
        url: HOST_GERENCIAL_AJAX + "Mesas/Servicio/",
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
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },

        success: function (respuesta, status, jqXHR)
        {
            var respuestaText = jqXHR.responseText;
            if (respuesta.status == false)
            {
                console.error(respuesta.data);
                Loader.Ocultar();
                Alerta.Danger(respuesta.mensaje);
                return;
            }
            
            location.reload();
        }
    });
}