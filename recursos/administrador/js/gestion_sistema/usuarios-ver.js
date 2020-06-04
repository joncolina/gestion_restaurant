/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Personal
var idFormPersonal = "form-personal";
var idBotonLimpiarPersonal = "boton-limpiar-personal";
var idBotonGuardarPersonal = "boton-guardar-personal";
//Cuenta
var idFormCuenta = "form-cuenta";
var idBotonLimpiarCuenta = "boton-limpiar-cuenta";
var idBotonGuardarCuenta = "boton-guardar-cuenta";
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
$("#" + idBotonGuardarPersonal).on("click", function(e) { GuardarPersonal(); });

/*================================================================================
 * 
================================================================================*/
function GuardarPersonal()
{
    //Definimos la data
    var data = AnalizarForm(idFormPersonal);
    data.accion = "MODIFICAR";

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Gestion_Sistema/CRUD_Usuarios/",
        method: "POST",
        dataType: "JSON",
        data: data,

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        beforeSend: function(jqXHR, setting)
        {
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            Loader.Mostrar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        error: function(jqXHR, status, errorThrow)
        {
            let mensaje = jqXHR.responseText;
            alert("Error del sistema:\n"+mensaje);
            Loader.Ocultar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;

            if(!respuesta.status) {
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }

            $("#" + idInputNombre).attr("value", respuesta.data.nombre);
            $("#" + idInputCedula).attr("value", respuesta.data.cedula);

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
$("#" + idBotonGuardarCuenta).on("click", function(e) { GuardarCuenta(); });

/*================================================================================
 * 
================================================================================*/
function GuardarCuenta()
{
    //Definimos la data
    var data = AnalizarForm(idFormCuenta);
    data.accion = "MODIFICAR";

    //AJAX
    $.ajax
    ({
        /*------------------------------------------------------------------------
         * Parametros principales
        ------------------------------------------------------------------------*/
        url: HOST_ADMIN_AJAX+"Gestion_Sistema/CRUD_Usuarios/",
        method: "POST",
        dataType: "JSON",
        data: data,

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        beforeSend: function(jqXHR, setting)
        {
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            Loader.Mostrar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        error: function(jqXHR, status, errorThrow)
        {
            let mensaje = jqXHR.responseText;
            alert("Error del sistema:\n"+mensaje);
            Loader.Ocultar();
        },

        /*------------------------------------------------------------------------
         * 
        ------------------------------------------------------------------------*/
        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;

            if(!respuesta.status) {
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
                return;
            }
            
            $("#" + idInputClave).attr("value", "");
            
            Loader.Ocultar();
            Alerta.Success("Usuario modificado exitosamente.");
        }
    });
}