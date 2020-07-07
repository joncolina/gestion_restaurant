function ClickBoton()
{
    document.getElementById("form-nuevo").onsubmit();
}

document.getElementById("form-nuevo").onsubmit = function() { Registrar(); }

function Registrar()
{
    var form = document.getElementById("form-nuevo");

    if(Formulario.Validar("form-nuevo") == false) return;

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
            var id = data.id;
            var link = HOST_GERENCIAL + "Usuarios/Ver/"+id+"/";
            location.href = link;
        }
    });
}