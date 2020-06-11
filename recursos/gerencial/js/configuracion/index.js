/*================================================================================
 *
 *	
 *
================================================================================*/
var idFormBasico = "form-basico";
var idFormRedes = "form-redes";

/*================================================================================
 *
 *	
 *
================================================================================*/
$("#opciones-basico").on("show.bs.tab", function(e) { location.hash = "basico/"; });
$("#opciones-redes").on("show.bs.tab", function(e) { location.hash = "redes/"; });
$("#opciones-roles").on("show.bs.tab", function(e) { location.hash = "roles/"; });
$("#opciones-permisos").on("show.bs.tab", function(e) { location.hash = "permisos/"; });
$("#opciones-usuarios").on("show.bs.tab", function(e) { location.hash = "usuarios/"; });

if(location.hash != "")
{
    var hash = location.hash;
    hash = hash.replace("#", "");
    switch(hash)
    {
        case "redes/":
            document.getElementById("opciones-redes").click();
        break;

        case "roles/":
            document.getElementById("opciones-roles").click();
        break;

        case "permisos/":
            document.getElementById("opciones-permisos").click();
        break;

        case "usuarios/":
            document.getElementById("opciones-usuarios").click();
        break;
    }
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarBasico()
{
    var form = document.getElementById(idFormBasico);
    RestaurantesModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            Formulario.Sync(idFormBasico);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarBasico()
{
    var form = document.getElementById(idFormBasico);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
function ModificarRedes()
{
    var form = document.getElementById(idFormRedes);
    RestaurantesModel.Modificar({
        formulario: form,
        beforeSend: () => { Loader.Mostrar(); },
        error: (mensaje) =>
        {
            Loader.Ocultar();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            Formulario.Sync(idFormRedes);
            Loader.Ocultar();
            Alerta.Success("Restaurant modificado exitosamente.");
        }
    });
}

/*--------------------------------------------------------------------------------
 * 
--------------------------------------------------------------------------------*/
function LimpiarRedes()
{
    var form = document.getElementById(idFormRedes);
    form.reset();
}

/*================================================================================
 *
 *	
 *
================================================================================*/
document.getElementById("img-logo-restaurant").onchange = function()
{
    var input = this;
    var label = document.getElementById("label-logo-restaurant");
    var img = label.getElementsByTagName("img")[0];

    if(input.files.length <= 0) {
        return;
    }

    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function(e)
    {
        img.src = e.target.result;
    }

    reader.readAsDataURL( file );
}