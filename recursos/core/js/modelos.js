"use strict";
var UsuariosModel = (function () {
    function UsuariosModel() {
    }
    UsuariosModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.succes == undefined)
            peticion.succes = function (data) { };
        var data = new FormData();
        data.append("accion", "CONSULTAR");
        if (peticion.buscar != undefined) {
            data.append("buscar", peticion.buscar);
        }
        $.ajax({
            url: this.url,
            method: this.method,
            dataType: this.dataType,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (jqXHR, setting) {
                var status = jqXHR.status;
                var statusText = jqXHR.statusText;
                var readyState = jqXHR.readyState;
                peticion.beforeSend();
            },
            error: function (jqXHR, status, errorThrow) {
                var mensaje = jqXHR.responseText;
                peticion.error("Error grave: " + mensaje);
            },
            success: function (respuesta, status, jqXHR) {
                var respuestaText = jqXHR.responseText;
                if (!respuesta.status) {
                    peticion.error();
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    UsuariosModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.succes == undefined)
            peticion.succes = function (data) { };
        var data = new FormData(peticion.formulario);
        data.append("accion", "REGISTRAR");
        $.ajax({
            url: this.url,
            method: this.method,
            dataType: this.dataType,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (jqXHR, setting) {
                var status = jqXHR.status;
                var statusText = jqXHR.statusText;
                var readyState = jqXHR.readyState;
                peticion.beforeSend();
            },
            error: function (jqXHR, status, errorThrow) {
                var mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },
            success: function (respuesta, status, jqXHR) {
                var respuestaText = jqXHR.responseText;
                if (!respuesta.status) {
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    UsuariosModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.succes == undefined)
            peticion.succes = function (data) { };
        var data = new FormData(peticion.formulario);
        data.append("accion", "ELIMINAR");
        $.ajax({
            url: this.url,
            method: this.method,
            dataType: this.dataType,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (jqXHR, setting) {
                var status = jqXHR.status;
                var statusText = jqXHR.statusText;
                var readyState = jqXHR.readyState;
                peticion.beforeSend();
            },
            error: function (jqXHR, status, errorThrow) {
                var mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },
            success: function (respuesta, status, jqXHR) {
                var respuestaText = jqXHR.responseText;
                if (!respuesta.status) {
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    UsuariosModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.succes == undefined)
            peticion.succes = function (data) { };
        var data = new FormData(peticion.formulario);
        data.append("accion", "MODIFICAR");
        $.ajax({
            url: this.url,
            method: this.method,
            dataType: this.dataType,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (jqXHR, setting) {
                var status = jqXHR.status;
                var statusText = jqXHR.statusText;
                var readyState = jqXHR.readyState;
                peticion.beforeSend();
            },
            error: function (jqXHR, status, errorThrow) {
                var mensaje = jqXHR.responseText;
                peticion.error(mensaje);
            },
            success: function (respuesta, status, jqXHR) {
                var respuestaText = jqXHR.responseText;
                if (!respuesta.status) {
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    UsuariosModel.url = HOST_ADMIN_AJAX + "Gestion_Sistema/CRUD_Usuarios/";
    UsuariosModel.method = "POST";
    UsuariosModel.dataType = "JSON";
    return UsuariosModel;
}());
