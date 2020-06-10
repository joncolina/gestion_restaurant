function ClickBoton()
{
    document.getElementById("form-nuevo").onsubmit();
}

document.getElementById("form-nuevo").onsubmit = function() { Registrar(); }

function Registrar()
{
    var form = document.getElementById("form-nuevo");
    UsuariosModel.Registrar({
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
            var usuario = data.usuario;
            var link = HOST_ADMIN + "Usuarios/Ver/"+usuario+"/";
            location.href = link;
        }
    });
}