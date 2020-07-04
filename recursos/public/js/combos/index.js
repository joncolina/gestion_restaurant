function Actualizar()
{
    var contenedor = document.getElementById("contenedor-combos");
    var data = new FormData();

    $.ajax({
        url: HOST_AJAX + "Combos/Consultar/",
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
            
            var combos = respuesta.data.combos;
            var code = "";

            code += '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2">';

            for(var combo of combos)
            {
                code += '<a class="mb-4 d-flex justify-content-center px-2" href="'+HOST+'Combos/Ver/'+combo.id+'/'+'">';
                code += '   <div class="card card-especial" tabindex="0">';
                code += '       <img src="'+combo.imagen+'" class="card-img-top border-bottom">';

                code += '       <div class="card-body">';
                code += '           <h5 class="mb-0">';
                code += '               ' + combo.nombre;
                code += '           </h5>';
                code += '       </div>';
                
                code += '       <div class="card-footer bg-white">';
                code += '           <div class="mb-0 font-weight-bold text-success">';
                code += '               Descuento: ' + Formato.Numerico(combo.descuento, 2) + '%';
                code += '           </div>';
                code += '       </div>';
                code += '   </div>';
                code += '</a>';
            }

            code += '</div>';

            contenedor.innerHTML = code;
        }
    });
}

Actualizar();