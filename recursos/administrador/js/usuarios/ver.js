/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormPersonal = "form-personal";
var idFormCuenta = "form-cuenta";

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("input-cuenta-activo-aux").onchange = function()
{
    if( document.getElementById("input-cuenta-activo-aux").checked ) {
        document.getElementById("input-cuenta-activo").value = "1";
    } else {
        document.getElementById("input-cuenta-activo").value = "0";
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function LimpiarPersonal()
{
    document.getElementById(idFormPersonal).reset();
}

function GuardarPersonal()
{
    var form = document.getElementById(idFormPersonal);

    UsuariosModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            Formulario.Sync(idFormPersonal);
            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function LimpiarCuenta()
{
    document.getElementById(idFormCuenta).reset();
}

function GuardarCuenta()
{
    var form = document.getElementById(idFormCuenta);

    UsuariosModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            document.getElementById("input-cuenta-clave").value = "";
            Formulario.Sync(idFormCuenta);
            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}