"use strict";
function EnviarPeticionAJAX(url, method, dataType, data, acciones) {
    $.ajax({
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (jqXHR, setting) {
            var status = jqXHR.status;
            var statusText = jqXHR.statusText;
            var readyState = jqXHR.readyState;
            acciones.beforeSend();
        },
        error: function (jqXHR, status, errorThrow) {
            var mensaje = jqXHR.responseText;
            acciones.error("Error grave: " + mensaje);
        },
        success: function (respuesta, status, jqXHR) {
            var respuestaText = jqXHR.responseText;
            if (!respuesta.status) {
                acciones.error(respuesta.mensaje);
                if (AUDITORIA) {
                    console.error(respuesta.data);
                }
                return;
            }
            acciones.success(respuesta.data);
        }
    });
}
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CategoriasModel.url = HOST_GERENCIAL_AJAX + "Categorias/CRUD/";
    CategoriasModel.method = "POST";
    CategoriasModel.dataType = "JSON";
    return CategoriasModel;
}());
var CombosModel = (function () {
    function CombosModel() {
    }
    CombosModel.Consultar = function (peticion) {
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CombosModel.AnalizarPlatos = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.platos == undefined)
            throw "CombosModel [AnalizarPlatos]: No se han enviado los platos.";
        if (peticion.beforeSend == undefined)
            peticion.beforeSend = function () { };
        if (peticion.error == undefined)
            peticion.error = function (mensaje) { };
        if (peticion.success == undefined)
            peticion.success = function (data) { };
        var data = new FormData();
        data.append("accion", "ANALIZAR-PLATOS");
        data.append("platos", JSON.stringify(peticion.platos));
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CombosModel.Registrar = function (peticion) {
        if (peticion === void 0) { peticion = {}; }
        if (peticion.platos == undefined)
            throw "CombosModel [AnalizarPlatos]: No se han enviado los platos.";
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
        data.append("platos", JSON.stringify(peticion.platos));
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CombosModel.Eliminar = function (peticion) {
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CombosModel.Modificar = function (peticion) {
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    CombosModel.url = HOST_GERENCIAL_AJAX + "Combos/CRUD/";
    CombosModel.method = "POST";
    CombosModel.dataType = "JSON";
    return CombosModel;
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    MesasModel.url = HOST_GERENCIAL_AJAX + "Mesas/CRUD/";
    MesasModel.method = "POST";
    MesasModel.dataType = "JSON";
    return MesasModel;
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    RestaurantesModel.url = HOST_GERENCIAL_AJAX + "Configuracion/CRUD_Restaurantes/";
    RestaurantesModel.method = "POST";
    RestaurantesModel.dataType = "JSON";
    return RestaurantesModel;
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
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
        var acciones = {
            beforeSend: peticion.beforeSend,
            error: peticion.error,
            success: peticion.success
        };
        EnviarPeticionAJAX(this.url, this.method, this.dataType, data, acciones);
    };
    UsuariosModel.url = HOST_GERENCIAL_AJAX + "Usuarios/CRUD/";
    UsuariosModel.method = "POST";
    UsuariosModel.dataType = "JSON";
    return UsuariosModel;
}());
