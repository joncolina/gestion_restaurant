function CambioClave(event, element)
{
    var boton = document.getElementById("boton-guardar-clave");
    
    if(element.value == "") {
        boton.className = "btn btn-outline-secondary";
    } else {
        boton.className = "btn btn-success";
    }
}

function GuardarClave()
{
    var form = document.getElementById("form-cuenta");
    var inputClave = document.getElementById("usuario-clave");

    AdminUsuariosModel.Modificar({
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
            inputClave.value = "";
            var boton = document.getElementById("boton-guardar-clave");
            boton.className = "btn btn-outline-secondary";
            Loader.Ocultar();
            Alerta.Success("Cuenta modificada exitosamente.");
        }
    });
}