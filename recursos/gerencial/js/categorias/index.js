/*================================================================================
 *
 *	Variables
 *
================================================================================*/
//Tabla
var idTabla = "tabla";
/* Esta clase prepara una tabla (le anexa el empaginado) */
var tabla = new TablaGestion(idTabla);

//Buscador
var idInputBuscador = "input-buscador";
var idBotonBuscador = "boton-buscador";
//Esta clase recibe 3 parametros
//Id del input del buscador
//Id del boton del buscador
//Funcion a ejecutar (string) cuando se haga submit [Actualizar]
var buscador = new Buscador(idInputBuscador, idBotonBuscador, "Actualizar");

/*--------------------------------------------------------------------------------
 * 
 * Aqui lo que hacemos es solicitar la informacion mediante AJAX.
 * Podemos imprimirla directo en PHP y es mas rapido, pero no podemos actualizar la data en tiempo real
 * 
--------------------------------------------------------------------------------*/
function Actualizar()
{
    //Definimos el tbody
    var table = document.getElementById(idTabla);
    var tbody = table.getElementsByTagName("tbody")[0];

    //Verificamos el buscador
    var buscar = undefined;
    var parametros = Hash.getParametros();
    if(parametros['buscar'] != undefined && parametros['buscar'] != "")
    {
        buscar = parametros['buscar'].replace(/_/g, " ");
        buscar = data['buscar'].replace(/_/g, " ");
    }

    //Consultamos
    CategoriasModel.Consultar({
        buscar: buscar,
        beforeSend: () =>
        {
            tabla.Cargando();
        },
        error: (mensaje) =>
        {
            tabla.Error();
            Alerta.Danger(mensaje);
        },
        success: (data) =>
        {
            //Funcion para actualizar la tabla
            tabla.Actualizar({
                //Parametros
                data: data,
                //Accion para actualizarla
                accion: (tbody, data, inicio, fin) =>
                {
                    //Borramos el contenido del tbody
                    tbody.innerHTML = '';

                    //Si no hay data mostramos esto
                    if(data.length == 0) {
                        tbody.innerHTML =
                        '<tr>' +
                        '   <td colspan="100">' +
                        '       <h4 class="text-center">No se encontraron resultados.</h4>' +
                        '   </td>' +
                        '</tr>';
                        return;
                    }

                    //Usaremos los limites que manda el evento ya que estan sincronizados con
                    //la paginación
                    for(var i=inicio; i<fin; i++)
                    {
                        //Verificamos que la data no sea nula
                        let dato = data[i];
                        if(dato == undefined) continue;

                        //Aqui imprimimos la data
                        tbody.innerHTML +=
                        '<tr>' +
                        '   <td>' +
                        '       ' + dato.idCategoria +
                        '   </td>' +

                        '   <td>' +
                        '       ' + dato.nombre +
                        '   </td>' +

                        '   <td>' +
                        '       ' + dato.Enviar +
                        '   </td>' +

                        '   <td center>' +        
                        '       <button class="btn btn-sm btn-warning">' +
                        '           <i class="fas fa-edit"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '   <td center>' +        
                        '       <button class="btn btn-sm btn-danger">' +
                        '           <i class="fas fa-trash-alt"></i>' +
                        '       </button>' +
                        '   </td>' +
                        '</tr>';
                    }
                }
            });
        }
    });
}

//Ejecutamos la funcion actualizar al cargar la pagina o de inmediato
Actualizar();