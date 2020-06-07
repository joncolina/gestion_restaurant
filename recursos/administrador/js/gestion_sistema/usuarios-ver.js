/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Personal
var idFormPersonal = "form-personal";
var idBotonLimpiarPersonal = "boton-limpiar-personal";
//Cuenta
var idFormCuenta = "form-cuenta";
var idBotonLimpiarCuenta = "boton-limpiar-cuenta";
//Inputs
var idInputNombre = "usuario-nombre";
var idInputCedula = "usuario-cedula";
var idInputClave = "usuario-clave";





/*================================================================================
 *
 *	
 *
================================================================================*/
$("#" + idBotonLimpiarPersonal).on("click", function(e)
{
    $("#" + idFormPersonal)[0].reset();
});

/*================================================================================
 * 
================================================================================*/
function GuardarPersonal()
{
    //Definimos la data
    var form = document.getElementById(idFormPersonal);
    UsuariosModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) => { Loader.Ocultar(); Alerta.Danger(mensaje); },
        success: (data) => {
            $("#" + idInputNombre).attr("value", data.nombre);
            $("#" + idInputCedula).attr("value", data.cedula);

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
$("#" + idBotonLimpiarCuenta).on("click", function(e)
{
    $("#" + idFormCuenta)[0].reset();
});

/*================================================================================
 * 
================================================================================*/
function GuardarCuenta()
{
    //Definimos la data
    var form = document.getElementById(idFormCuenta);
    UsuariosModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) => { Loader.Ocultar(); Alerta.Danger(mensaje); },
        success: (data) => {
            $("#" + idInputClave).attr("value", "");
            $("#" + idInputClave).val("");
            
            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}