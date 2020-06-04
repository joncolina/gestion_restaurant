// Example starter JavaScript for disabling form submissions if there are invalid fields
(function()
{
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('validacion_campos');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

/**
 * Creamos las variables con los ID que se van a utilizar
 */
var idFormRegistro = "form-registro";
var idBotonRegistro = "boton-registro";

/**
 * Creamos los elementos
 */
var formulario = document.getElementById(idFormRegistro);
var boton = document.getElementById(idBotonRegistro);

/**
 * Evento para cuando se haga submit al formulario
 */
formulario.addEventListener("submit", function(e)
{
  /**
   * Anulamos la redireccion de la pagina o evento
   */
  event.preventDefault();
  event.stopPropagation();

  /**
   * Verificamos el status del formulario 
   */
  if(formulario.checkValidity() === false) {
    Alerta.Danger("Debe rellenar todos los campos.");
    return;
  }

  /**
   * Validamos las contraseñas
   */
  var clave1 = document.getElementById("ClaveGerente").value;
  var clave2 = document.getElementById("Clave2Gerente").value;
  if(clave1 != clave2) {
    Alerta.Danger("Las contraseñas del usuario deben ser iguales.");
    return;
  }

  /**
   * Tomamos los datos del formulario
   */
  var data = AnalizarForm(idFormRegistro);
  data.accion = "REGISTRAR";

  /**
   * Enviamos por AJAX
   * 
   * URL ya definidas:
   * 
   * HOST -> Url base
   * HOST_AJAX -> Url base + AJAX
   * 
   * HOST_ADMIN -> Url base de la sección admin
   * HOST_ADMIN_AJAX -> Url base de la sección admin + AJAX
   * 
   * HOST_GERENCIAL -> Url base de la sección gerencial
   * HOST_GERENCIAL_AJAX -> Url base de la sección gerencial + AJAX
   */
  $.ajax({
    /*------------------------------------------------------------------------
        * Parametros principales
    ------------------------------------------------------------------------*/
    url: HOST_ADMIN_AJAX + "Restaurantes/CRUD/",
    method: "POST",
    dataType: "JSON",
    data: data,

    /*------------------------------------------------------------------------
    * Antes de enviar
    ------------------------------------------------------------------------*/
    beforeSend: (jqXHR, setting) =>
    {
        let status = jqXHR.status;
        let statusText = jqXHR.statusText;
        let readyState = jqXHR.readyState;

        /**
         * Agregamos una ventana de carga
         */
        Loader.Mostrar();
    },

    /*------------------------------------------------------------------------
    * Error
    ------------------------------------------------------------------------*/
    error: (jqXHR, status, errorThrow) =>
    {
        let mensaje = jqXHR.responseText;

        /**
         * Notificamos el error y quitamos la ventana de carga
         */
        alert(mensaje);
        Loader.Ocultar();
    },

    /*------------------------------------------------------------------------
    * Exitoso
    ------------------------------------------------------------------------*/
    success: (respuesta, status, jqXHR) =>
    {
        let respuestaText = jqXHR.responseText;

        /**
         * Estructura de la respuesta
         * 
         * status: booleano [Indica si la operación fue exitosa o generemo un error]
         * mensaje: string [Mensaje de error, en caso de aplicar]
         * data: object[] [En caso de error o exito, aqui se encuentra la data que se desee enviar del back al front]
         */

        /**
         * Validamos el status de la operación
         */
        if(!respuesta.status) {
          /**
           * Esta es la zona de error controlado
           */
          Alerta.Danger(respuesta.mensaje);
          console.log(respuesta.data);
          Loader.Ocultar();
          return;
        }

        /**
         * En caso de exito, redirigimos al perfil del resturant
         */
        var id = respuesta.data.id;
        var link = HOST_ADMIN + "Restaurantes/Gestion/"+id+"/";
        location.href = link;
    }
  });
}, false);