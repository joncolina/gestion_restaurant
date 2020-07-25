/**
 * ID
 */
var idLista = "lista-pedidos";
var idSelectAreas = "select-areaMonitoreo";
var idDivConexion = "div-conexion";
var idModalConfirmar = "modal-confirmar";
var idConfirmarTextID = "text-confirmar-id";
var idConfirmarInputID = "input-confirmar-id";

 /**
  * Elementos
  */
var lista = document.getElementById(idLista);
var selectAreas = document.getElementById(idSelectAreas);
var divConexion = document.getElementById(idDivConexion);
var modalConfirmar = $("#" + idModalConfirmar);
var textConfirmarID = document.getElementById(idConfirmarTextID);
var inputConfirmarID = document.getElementById(idConfirmarInputID);

/**
 * 
 */
var ArrayPedidos = [];

/**
 * Web Socket
 */
const URL_WEB_SOCKET = HOST_SOCKET + AREA_GERENCIAL + "/monitoreo-cocina/" + ID_RESTAURANT + "/" + ID_USUARIO + "/";
const ACCIONES_WEB_SOCKET = {
    antes: function() {
        lista.innerHTML = `<div class="list-group-item py-3" center>
            <div class="spinner-grow" role="status"></div>
        </div>`;
        
        divConexion.className = "badge badge-secondary";
        divConexion.style.cursor = "default";
        divConexion.removeAttribute("onclick");
        divConexion.innerHTML = `<i class="fas fa-server"></i> Conectando...`;
    },

    onopen: function(e) {
        divConexion.className = "badge badge-success";
        divConexion.style.cursor = "default";
        divConexion.removeAttribute("onclick");
        divConexion.innerHTML = `<i class="fas fa-server"></i> Conectado`;
        ActualizarFiltro();
    },

    onmessage: function(e) {
        var objJson = JSON.parse(e.data);
        if(objJson.accion != undefined && objJson.accion == "error") {
            lista.innerHTML = `<div class="list-group-item list-group-item-danger" center>${objJson.contenido}</div>`;
        }
    },

    onclose: function(e) {
        Alerta.Warning("Servicios de pedidos cerrado.");
        divConexion.className = "badge badge-danger";
        divConexion.style.cursor = "pointer";
        divConexion.setAttribute("onclick", "ConectarWS()");
        divConexion.innerHTML = `<i class="fas fa-server"></i> No conectado`;
    },

    onerror: function(e) {
        lista.innerHTML = `<div class="list-group-item list-group-item-danger" center>Ocurrio un error con el servicio de pedidos.</div>`;
    }
};

var ws = undefined;
ConectarWS();
function ConectarWS() {
    ws = new Web_Sockets(URL_WEB_SOCKET, ACCIONES_WEB_SOCKET);
}

/**
 * 
 */
function ActualizarTodo()
{
    ws.send( JSON.stringify({
        accion: "ActualizarTodo"
    }) );
}

/**
 * 
 */
function ActualizarFiltro()
{
    ws.send(JSON.stringify({
        accion: "CambiarFiltro",
        idAreaMonitoreo: selectAreas.value
    }));
}

/**
 * 
 */
function MostrarPedidos(body)
{
    var datos = body.datos;
    var total = body.total;

    lista.innerHTML = "";

    if(total > 0)
    {
        for(var pedido of datos)
        {
            AgregarPedido(pedido);
        }
    }
    else
    {
        lista.setAttribute("vacio", "true");
        lista.innerHTML = `<div class="list-group-item" center>No se encontraron resultados.</div>`;
    }
}

/**
 * 
 * @param {*} pedido 
 */
function AgregarPedido(pedido)
{
    if(typeof(pedido) == "string") {
        pedido = JSON.parse(pedido);
    }

    var indexPedidos = ArrayPedidos.length;
    ArrayPedidos[indexPedidos] = pedido;

    if(lista.getAttribute("vacio") == "true") {
        lista.removeAttribute("vacio");
        lista.innerHTML = "";
    }

    if(pedido.observaciones == "") {
        pedido.observaciones = `<span class="text-muted">(Vacio)</span>`;
    } else {
        pedido.observaciones = `<b>${pedido.observaciones}</b>`;
    }

    lista.innerHTML += `<div class="list-group-item list-group-item-action" style="cursor: pointer;" idPedidoDetalle="${pedido.idPedidoDetalle}" onclick="ModalConfirmar('${indexPedidos}')">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <h5 class="mb-0">${pedido.plato.nombre}</h5>
            <span class="badge badge-primary badge-pill">Cant. ${pedido.cantidad}</span>
        </div>

        <p class="mb-0">Observaciones: ${pedido.observaciones}</p>
        <small>${pedido.fecha} a las ${pedido.hora}</small>
    </div>`;
}

/**
 * 
 * @param {*} pedidos 
 */
function NuevosPlatos(pedidos)
{
    for(var pedido of pedidos)
    {
        AgregarPedido(pedido);
    }
}

function ModalConfirmar(indexPedidos)
{
    var datos = ArrayPedidos[indexPedidos];

    textConfirmarID.innerHTML = datos.idPedidoDetalle;
    inputConfirmarID.value = datos.idPedidoDetalle;

    modalConfirmar.modal("show");
}

function Confirmar()
{
    var idPedidoDetalle = inputConfirmarID.value;
    var bodyMsj = JSON.stringify({accion: "CambiarStatus", idPedidoDetalle: idPedidoDetalle});

    ws.send(bodyMsj);
    modalConfirmar.modal("hide");
}

function QuitarPedido(body)
{
    var idPedidoDetalle = body;
    var elementos = lista.getElementsByClassName("list-group-item");
    for(var elemento of elementos)
    {
        var idPedidoDetalleTemp = elemento.getAttribute("idPedidoDetalle");
        if(idPedidoDetalleTemp == null || idPedidoDetalleTemp == undefined) continue;

        if(idPedidoDetalleTemp == idPedidoDetalle) {
            elemento.remove();
        }
    }
    
    elementos = lista.getElementsByClassName("list-group-item");
    if(elementos.length == 0)
    {
        lista.setAttribute("vacio", "true");
        lista.innerHTML = `<div class="list-group-item" center>No se encontraron resultados.</div>`;
    }
}