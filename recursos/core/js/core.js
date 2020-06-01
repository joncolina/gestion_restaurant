"use strict";
var Alerta = (function () {
    function Alerta() {
    }
    Alerta.Iniciar = function () {
        var div = document.createElement("div");
        div.setAttribute("class", "contenedor-alertas p-3");
        div.setAttribute("id", this.id);
        document.body.appendChild(div);
    };
    Alerta.Agregar = function (mensaje, tipo) {
        var contenedor = document.getElementById(this.id);
        if (contenedor == null || contenedor == undefined) {
            this.Iniciar();
            contenedor = document.getElementById(this.id);
        }
        var alerta = document.createElement("div");
        var cantidad = contenedor.getElementsByClassName("alert").length;
        var id = "alerta-sistema-" + cantidad;
        if (cantidad == 10) {
            alert(mensaje);
            return;
        }
        alerta.setAttribute("class", "alert alert-" + tipo + " alert-dismissible fade show");
        alerta.setAttribute("id", id);
        alerta.innerHTML =
            '<button class="close" data-dismiss="alert">' +
                '   <span>&times;</span>' +
                '</button>' +
                mensaje;
        contenedor.append(alerta);
        setTimeout(function () { $("#" + id).alert("close"); }, 5000);
    };
    Alerta.Primary = function (mensaje) {
        this.Agregar(mensaje, "primary");
    };
    Alerta.Secondary = function (mensaje) {
        this.Agregar(mensaje, "secondary");
    };
    Alerta.Success = function (mensaje) {
        this.Agregar(mensaje, "success");
    };
    Alerta.Danger = function (mensaje) {
        this.Agregar(mensaje, "danger");
    };
    Alerta.Warning = function (mensaje) {
        this.Agregar(mensaje, "warning");
    };
    Alerta.Info = function (mensaje) {
        this.Agregar(mensaje, "info");
    };
    Alerta.Light = function (mensaje) {
        this.Agregar(mensaje, "light");
    };
    Alerta.Dark = function (mensaje) {
        this.Agregar(mensaje, "dark");
    };
    Alerta.id = "contendor-alertas-general";
    return Alerta;
}());
var Buscador = (function () {
    function Buscador(idInputBuscador, idBotonBuscador, funcionBuscar) {
        this.idInputBuscador = idInputBuscador;
        this.idBotonBuscador = idBotonBuscador;
        this.funcionBuscar = funcionBuscar;
        var input = document.getElementById(this.idInputBuscador);
        var boton = document.getElementById(this.idBotonBuscador);
        if (input == null || input == undefined) {
            console.error("Input del buscador no existe.");
            return;
        }
        if (boton == null || boton == undefined) {
            console.error("Boton del buscador no existe.");
            return;
        }
        this.AsignarActividad();
    }
    Buscador.prototype.AsignarActividad = function () {
        var input = document.getElementById(this.idInputBuscador);
        var boton = document.getElementById(this.idBotonBuscador);
        var thisObj = this;
        input.onkeyup = function (e) {
            if (e.key == "Enter") {
                boton.click();
            }
        };
        boton.onclick = function (e) {
            var valor = input.value;
            Buscar(valor);
        };
        function Buscar(valor) {
            var parametros = [];
            if (valor != "") {
                parametros['buscar'] = valor;
            }
            var hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            window[thisObj.funcionBuscar]();
        }
    };
    return Buscador;
}());
var Filtro = (function () {
    function Filtro(idCollapse, idForm, idBoton, funcionBuscar) {
        this.idCollapse = idCollapse;
        this.idForm = idForm;
        this.idBoton = idBoton;
        this.funcionBuscar = funcionBuscar;
        var collapse = document.getElementById(this.idCollapse);
        var form = document.getElementById(this.idForm);
        var boton = document.getElementById(this.idBoton);
        if (collapse == null || collapse == undefined) {
            console.error("Collapse del filtro no existe.");
            return;
        }
        if (form == null || form == undefined) {
            console.error("Form del filtro no existe.");
            return;
        }
        if (boton == null || boton == undefined) {
            console.error("Boton del filtro no existe.");
            return;
        }
        this.AsignarAcciones();
    }
    Filtro.prototype.AsignarAcciones = function () {
        var collapse = document.getElementById(this.idCollapse);
        var form = document.getElementById(this.idForm);
        var boton = document.getElementById(this.idBoton);
        var thisObj = this;
        boton.onclick = function (e) {
            Filtro();
        };
        function Filtro() {
            var parametros = [];
            var cant = 0;
            for (var i = 0; i < form.elements.length; i++) {
                var elemento = form.elements[i];
                var name_1 = elemento.name;
                var valor = elemento.value;
                if (valor == "")
                    continue;
                cant += 1;
                parametros[name_1] = valor;
            }
            if (cant > 0) {
                parametros['filtros'] = "si";
            }
            var hash = "/" + Hash.Parametro2String(parametros);
            hash = hash.replace(/ /g, "_");
            location.hash = hash;
            window[thisObj.funcionBuscar]();
            $("#" + thisObj.idCollapse).collapse("hide");
        }
    };
    return Filtro;
}());
var Formulario = (function () {
    function Formulario() {
    }
    Formulario.Sync = function (idForm) {
        var form = document.getElementById(idForm);
        for (var i = 0; i < form.elements.length; i++) {
            var input = form.elements[i];
            if (input.type == "select-one") {
                var options = input.getElementsByTagName("option");
                var indexSelected = input.selectedIndex;
                for (var j = 0; j < options.length; j++) {
                    options[j].removeAttribute("selected");
                }
                options[indexSelected].setAttribute("selected", "");
            }
            else if (input.type == "checkbox") {
                if (input.checked) {
                    input.setAttribute("checked", "");
                }
                else {
                    input.removeAttribute("checked");
                }
            }
            else {
                input.setAttribute("value", input.value);
            }
        }
        form.reset();
    };
    Formulario.Cambio = function (idForm) {
        var form = document.getElementById(idForm);
        var cambio = false;
        for (var i = 0; i < form.elements.length; i++) {
            var input = form.elements[i];
            if (input.type == "select-one") {
                var option = input.selectedOptions[0];
                var selected = option.getAttribute("selected");
                if (selected == null) {
                    cambio = true;
                    break;
                }
            }
            else if (input.type == "checkbox") {
                if (input.checked && input.getAttribute("checked") == null) {
                    cambio = true;
                    break;
                }
                if (!input.checked && input.getAttribute("checked") != null) {
                    cambio = true;
                    break;
                }
            }
            else {
                var valor = input.value;
                var origial = input.getAttribute("value");
                if (origial != valor) {
                    cambio = true;
                    break;
                }
            }
        }
        return cambio;
    };
    return Formulario;
}());
var Formato = (function () {
    function Formato() {
    }
    Formato.Numerico = function (numero, decimales) {
        if (decimales === void 0) { decimales = 0; }
        if (typeof (numero) == "string")
            numero = parseFloat(numero);
        numero = Number(numero).toFixed(decimales);
        var numeroString = String(numero);
        var numeroArray = numeroString.split(".");
        var parteEntera = numeroArray[0];
        var parteDecimal = numeroArray[1];
        var salida = "";
        for (var i = 0; i < parteEntera.length; i++) {
            if ((parteEntera.length - i) % 3 == 0 && i != 0) {
                salida += ".";
            }
            salida += parteEntera[i];
        }
        if (parteDecimal != undefined && parteDecimal != null) {
            salida += "," + parteDecimal;
        }
        return salida;
    };
    Formato.bool2text = function (valorBool) {
        if (valorBool) {
            return "Si";
        }
        else {
            return "No";
        }
    };
    return Formato;
}());
var Hash = (function () {
    function Hash() {
    }
    Hash.get = function () {
        var salida = location.hash;
        return salida;
    };
    Hash.set = function (hash) {
        location.hash = "/" + hash;
    };
    Hash.getParametros = function () {
        var salida = [];
        var hash = location.href.replace(HOST, "");
        var hashArray = hash.split("/");
        hashArray = hashArray.filter(function (valor) { return valor.length > 0; });
        for (var i = 0; i < hashArray.length; i++) {
            var valor = hashArray[i];
            var valorArray = valor.split("=");
            if (valorArray.length != 2)
                continue;
            salida[valorArray[0]] = valorArray[1];
        }
        return salida;
    };
    Hash.Parametro2String = function (inputObject) {
        var salida = "";
        for (var key in inputObject) {
            var valor = key + "=" + inputObject[key] + "/";
            salida += valor;
        }
        return salida;
    };
    return Hash;
}());
var Loader = (function () {
    function Loader() {
    }
    Loader.Mostrar = function () {
        var div = document.createElement("div");
        div.setAttribute("class", "pantalla-oscura");
        div.innerHTML =
            '<div class="modal show" id="' + this.id + '" data-backdrop="static">' +
                '   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">' +
                '       <div class="modal-content">' +
                '           <div class="modal-body text-center text-defecto p-5">' +
                '               <div class="spinner-grow">' +
                '                   <span class="sr-only"></span>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>';
        document.body.appendChild(div);
        $("#" + this.id).modal("show");
    };
    Loader.Ocultar = function () {
        $("#" + this.id).modal("hide");
        $(".pantalla-oscura").remove();
    };
    Loader.id = "loader-general";
    return Loader;
}());
function AnalizarForm(idForm) {
    var form = document.getElementById(idForm);
    var elementos = form.elements;
    var data = {};
    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];
        if (elemento.type == "checkbox") {
            var nombre = elemento.name;
            var valor = elemento.checked ? "1" : "0";
            data[nombre] = valor;
        }
        else {
            var nombre = elemento.name;
            var valor = elemento.value;
            data[nombre] = valor;
        }
    }
    return data;
}
var TablaGestion = (function () {
    function TablaGestion(idContenedorTabla) {
        this.cantMostrar = 10;
        this.idInfoPag = "infoEmpaginado";
        this.idBotonesPag = "botonesEmpagiando";
        this.offsetPaginacion = 2;
        this.data = [];
        this.idContenedorTabla = idContenedorTabla;
        var contenedor = document.getElementById(this.idContenedorTabla);
        if (contenedor == null) {
            console.error("La tabla de gesti\u00F3n [id: " + idContenedorTabla + "] no existe.");
            return;
        }
        var empaginado = document.createElement("div");
        empaginado.setAttribute("class", "mt-2 row mx-0");
        empaginado.setAttribute("id", "mt-2 row mx-0");
        empaginado.innerHTML =
            '<div class="col-12 col-md-6 mb-2 mb-md-0 px-0">' +
                '   <div class="h-100 d-flex align-items-center justify-content-center justify-content-md-start" id="' + this.idInfoPag + '">' +
                '       ...' +
                '   </div>' +
                '</div>' +
                '<div class="col-12 col-md-6 px-0">' +
                '   <ul class="pagination justify-content-center justify-content-md-end mb-0" id="' + this.idBotonesPag + '">' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">Anterior</a>' +
                '       </li>' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">...</a>' +
                '       </li>' +
                '       <li class="page-item disabled">' +
                '           <a class="page-link" tabindex="-1">Siguiente</a>' +
                '       </li>' +
                '   </ul>' +
                '</div>';
        contenedor.appendChild(empaginado);
    }
    TablaGestion.prototype.getData = function () {
        return this.data;
    };
    TablaGestion.prototype.Cargando = function () {
        var contenedor = document.getElementById(this.idContenedorTabla);
        var table = contenedor === null || contenedor === void 0 ? void 0 : contenedor.getElementsByTagName("table")[0];
        var tbody = table === null || table === void 0 ? void 0 : table.getElementsByTagName("tbody")[0];
        tbody.innerHTML =
            '<tr>' +
                '   <td colspan="100" center>' +
                '       <div class="spinner-grow m-2">' +
                '           <span class="sr-only">Cargando...</span>' +
                '       </div>' +
                '   </td>' +
                '</tr>';
    };
    TablaGestion.prototype.Error = function () {
        var contenedor = document.getElementById(this.idContenedorTabla);
        var table = contenedor === null || contenedor === void 0 ? void 0 : contenedor.getElementsByTagName("table")[0];
        var tbody = table === null || table === void 0 ? void 0 : table.getElementsByTagName("tbody")[0];
        tbody.innerHTML =
            '<tr class="table-danger">' +
                '   <td colspan="100" center>' +
                '       <h4 class="m-2">Error al actualizar</h4>' +
                '   </td>' +
                '</tr>';
    };
    TablaGestion.prototype.Actualizar = function (data) {
        var parametros = Hash.getParametros();
        var pagina = 1;
        var cantMostrar = this.cantMostrar;
        var totalData = data.length;
        var totalPaginas = 0;
        var inicio = 0;
        var fin = 0;
        this.data = data;
        if (parametros['mostrar'] != undefined && !isNaN(parametros['mostrar']))
            cantMostrar = Number(parametros['mostrar']);
        if (cantMostrar < 1)
            cantMostrar = this.cantMostrar;
        if (parametros['pagina'] != undefined && !isNaN(parametros['pagina']))
            pagina = Number(parametros['pagina']);
        totalPaginas = Math.trunc(totalData / cantMostrar);
        if (totalData % cantMostrar > 0)
            totalPaginas += 1;
        if (pagina < 1)
            pagina = 1;
        if (pagina > totalPaginas)
            pagina = totalPaginas;
        inicio = (pagina - 1) * cantMostrar;
        fin = inicio + cantMostrar;
        if (fin > totalData)
            fin = totalData;
        var evento = new CustomEvent("ActualizarTabla", { 'detail': {
                tbody: document.getElementById(this.idContenedorTabla).getElementsByTagName("tbody")[0],
                data: data,
                inicio: inicio,
                fin: fin
            } });
        document.getElementById(this.idContenedorTabla).dispatchEvent(evento);
        this.ActualizarPaginado(inicio, fin, totalData, pagina, totalPaginas);
    };
    TablaGestion.prototype.ActualizarPaginado = function (inicio, fin, total, paginaActual, totalPagina) {
        var _this = this;
        var contenedor = document.getElementById(this.idContenedorTabla);
        var info = document.getElementById(this.idInfoPag);
        var botones = document.getElementById(this.idBotonesPag);
        var botonInicio = 1;
        var botonFin = totalPagina;
        var offset = this.offsetPaginacion;
        var puntosInicio = true;
        var puntosFin = true;
        botonInicio = paginaActual - offset;
        if (botonInicio < 1)
            botonInicio = 1;
        botonFin = paginaActual + offset;
        if (botonFin > totalPagina)
            botonFin = totalPagina;
        if (botonInicio <= 1)
            puntosInicio = false;
        if (botonFin >= totalPagina)
            puntosFin = false;
        if (totalPagina == 0) {
            info.innerHTML = "";
            botones.innerHTML = "";
            return;
        }
        info.innerHTML = "Mostrando " + (inicio + 1) + " a " + fin + " resultados de " + total + ".";
        botones.innerHTML = "";
        if (paginaActual <= 1) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">Anterior</span>" +
                    '</li>';
        }
        else {
            botones.innerHTML +=
                '<li class="page-item">' +
                    ("   <a class=\"page-link\" page=\"" + (paginaActual - 1) + "\">Anterior</a>") +
                    '</li>';
        }
        if (puntosInicio) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">...</span>" +
                    '</li>';
        }
        for (var i = botonInicio; i <= botonFin; i++) {
            if (paginaActual == i) {
                botones.innerHTML +=
                    '<li class="page-item active">' +
                        ("   <span class=\"page-link\">" + i + "</span>") +
                        '</li>';
            }
            else {
                botones.innerHTML +=
                    '<li class="page-item">' +
                        ("   <a class=\"page-link\" page=\"" + i + "\">" + i + "</a>") +
                        '</li>';
            }
        }
        if (puntosFin) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">...</span>" +
                    '</li>';
        }
        if (paginaActual >= totalPagina) {
            botones.innerHTML +=
                '<li class="page-item disabled">' +
                    "   <span class=\"page-link\">Siguiente</span>" +
                    '</li>';
        }
        else {
            botones.innerHTML +=
                '<li class="page-item">' +
                    ("   <a class=\"page-link\" page=\"" + (paginaActual + 1) + "\">Siguiente</a>") +
                    '</li>';
        }
        var botonesArray = document.getElementsByTagName("a");
        var _loop_1 = function (i) {
            botonesArray[i].onclick = function (e) {
                var pageString = botonesArray[i].getAttribute("page");
                if (pageString == undefined || pageString == null)
                    return;
                var page = Number(pageString);
                if (isNaN(page))
                    return;
                var parametros = Hash.getParametros();
                parametros['pagina'] = page;
                var url = Hash.Parametro2String(parametros);
                Hash.set(url);
                _this.Actualizar(_this.data);
            };
        };
        for (var i = 0; i < botonesArray.length; i++) {
            _loop_1(i);
        }
    };
    return TablaGestion;
}());
function MenuLateral() {
    if (document.body.className == "sb-nav-fixed sb-sidenav-toggled") {
        document.body.className = "sb-nav-fixed";
    }
    else {
        document.body.className = "sb-nav-fixed sb-sidenav-toggled";
    }
}
function CerrarSesion() {
    var url = HOST_AJAX + "Salir/";
    var method = "POST";
    var dataType = "json";
    var data = {};
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType,
        beforeSend: function (jqXHR, setting) {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;
            Loader.Mostrar();
        },
        success: function (respuesta, status, jqXHR) {
            var respuestaText = jqXHR.responseText;
            if (respuesta.status) {
                location.href = HOST + "Login/";
            }
            else {
                Alerta.Danger(respuesta.mensaje);
                Loader.Ocultar();
            }
        },
        error: function (jqXHR, status, errorThrow) {
            var mensaje = jqXHR.responseText;
            Alerta.Danger(mensaje);
            Loader.Ocultar();
        }
    });
}
