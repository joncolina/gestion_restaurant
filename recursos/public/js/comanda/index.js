function Actualizar()
{
    var contenedor = document.getElementById("contenedor-platos");
    var data = new FormData();

    var parametros = Hash.getParametros();
    if(parametros.categoria != null && parametros.categoria != undefined)
    {
        data.append("categoria", parametros.categoria);
    }

    $.ajax({
        url: HOST_AJAX + "Comanda/Consultar/",
        method: "POST",
        dataType: "JSON",
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function(jqXHR, setting)
        {
            let status = jqXHR.status;
            let statusText = jqXHR.statusText;
            let readyState = jqXHR.readyState;

            contenedor.innerHTML = `<div class="w-100 p-3" center>
                <div class="spinner-grow" role="status"></div>
            </div>`;
        },

        error: function(jqXHR, status, errorThrow)
        {
            let mensaje = jqXHR.responseText;

            console.log(mensaje);
            Alerta.Danger(mensaje);
            contenedor.innerHTML = `<div class="alert alert-danger">
                Error al cargar los datos.
                <button class="float-right btn btn-sm btn-danger" onclick="Actualizar()"><i class="fas fa-sync-alt"></i></button>
            </div>`;
        },

        success: function(respuesta, status, jqXHR)
        {
            let respuestaText = jqXHR.responseText;
            contenedor.innerHTML = '';

            if(respuesta.status == false) {
                console.log(respuesta.data);
                Alerta.Danger(respuesta.mensaje);
                contenedor.innerHTML = `<div class="alert alert-danger">
                    Error al cargar los datos.
                    <button class="float-right btn btn-sm btn-danger" onclick="Actualizar()"><i class="fas fa-sync-alt"></i></button>
                </div>`;
                return;
            }
            
            var categorias = respuesta.data.categorias;
            var code = "";

            for(var categoria of categorias)
            {
                var platos = categoria.platos;

                code += '<div class="card mb-3">';
                code += '   <div class="card-header">';
                code += '       <h5 class="mb-0">'+categoria.nombre+'</h5>';
                code += '   </div>';

                code += '   <div class="card-body">';
                code += '       <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2">';

                for(var plato of platos)
                {
                    code += '<div class="mb-4 d-flex justify-content-center px-2">';
                    code += '   <div class="card card-especial" tabindex="0">';
                    code += '       <img src="'+plato.imagen+'" class="card-img-top border-bottom">';

                    code += '       <div class="card-body">';
                    code += '           <p class="card-text mb-1">';
                    code += '               ' + plato.nombre;
                    code += '           </p>';
                    
                    code += '           <h5 class="card-title mb-0">';
                    code += '               BsS. ' + Formato.Numerico(plato.precio, 2);
                    code += '           </h5>';
                    code += '       </div>';
                    code += '   </div>';
                    code += '</div>';
                }

                code += '       </div>';
                code += '   </div>';
                code += '</div>';
            }

            contenedor.innerHTML = code;
        }
    });
}

Actualizar();

function CambioCategoria(elemento)
{
    var valor = elemento.value;
    var hash = "/";

    if(valor != "") {
        hash = "/categoria="+valor+"/";
    }

    location.hash = hash;
    Actualizar();
}