"use strict";
var AdminUsuariosModel = (function () {
    function AdminUsuariosModel() {
    }
    AdminUsuariosModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    AdminUsuariosModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    AdminUsuariosModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    AdminUsuariosModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    AdminUsuariosModel.url = HOST_ADMIN_AJAX + "Gestion_Sistema/CRUD_Usuarios/";
    AdminUsuariosModel.method = "POST";
    AdminUsuariosModel.dataType = "JSON";
    return AdminUsuariosModel;
}());
var CategoriasModel = (function () {
    function CategoriasModel() {
    }
    CategoriasModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    CategoriasModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    CategoriasModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    CategoriasModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    CategoriasModel.url = HOST_GERENCIAL_AJAX + "Categorias/CRUD/";
    CategoriasModel.method = "POST";
    CategoriasModel.dataType = "JSON";
    return CategoriasModel;
}());
var MesasModel = (function () {
    function MesasModel() {
    }
    MesasModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    MesasModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    MesasModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    MesasModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    MesasModel.url = HOST_GERENCIAL_AJAX + "Mesas/CRUD/";
    MesasModel.method = "POST";
    MesasModel.dataType = "JSON";
    return MesasModel;
}());
var PermisosModel = (function () {
    function PermisosModel() {
    }
    PermisosModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.idRestaurant == undefined)
            console.error("PermisosModel -> Consultar:\nNo se ha enviado el ID del restaurant.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
        var data = new FormData();
        data.append("accion", "CONSULTAR");
        data.append("idRestaurant", peticion.idRestaurant);
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    PermisosModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("PermisosModel -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    PermisosModel.url = HOST_ADMIN_AJAX + "Permisos/CRUD/";
    PermisosModel.method = "POST";
    PermisosModel.dataType = "JSON";
    return PermisosModel;
}());
var PlatosModel = (function () {
    function PlatosModel() {
    }
    PlatosModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    PlatosModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    PlatosModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    PlatosModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    PlatosModel.url = HOST_GERENCIAL_AJAX + "Platos/CRUD/";
    PlatosModel.method = "POST";
    PlatosModel.dataType = "JSON";
    return PlatosModel;
}());
var RestaurantesModel = (function () {
    function RestaurantesModel() {
    }
    RestaurantesModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    RestaurantesModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RestaurantesModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Restaurantes -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RestaurantesModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("Modelo Usuario -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RestaurantesModel.url = HOST_ADMIN_AJAX + "Restaurantes/CRUD/";
    RestaurantesModel.method = "POST";
    RestaurantesModel.dataType = "JSON";
    return RestaurantesModel;
}());
var RolesModel = (function () {
    function RolesModel() {
    }
    RolesModel.Consultar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.idRestaurant == undefined)
            console.error("RolesModel -> Consultar:\nNo se ha enviado el ID del restaurant.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
        var data = new FormData();
        data.append("accion", "CONSULTAR");
        data.append("idRestaurant", peticion.idRestaurant);
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
                    peticion.error(respuesta.mensaje);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    RolesModel.Eliminar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("RolesModel -> Eliminar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RolesModel.Modificar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("RolesModel -> Modificar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RolesModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.formulario == undefined)
            console.error("RolesModel -> Registrar:\nSe debe enviar el formulario.");
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
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
    RolesModel.url = HOST_ADMIN_AJAX + "Roles/CRUD/";
    RolesModel.method = "POST";
    RolesModel.dataType = "JSON";
    return RolesModel;
}());
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
        else if (peticion.filtros != undefined) {
            data.append("filtros", "si");
            for (var key in peticion.filtros) {
                data.append(key, peticion.filtros[key]);
            }
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
                    peticion.error(respuesta.mensaje);
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
                    console.log(respuesta.data);
                    return;
                }
                peticion.success(respuesta.data);
            }
        });
    };
    UsuariosModel.url = HOST_ADMIN_AJAX + "Usuarios/CRUD/";
    UsuariosModel.method = "POST";
    UsuariosModel.dataType = "JSON";
    return UsuariosModel;
}());
