function Aumentar(idElemento)
{
    var inputCantidad = document.getElementById(idElemento);

    if(ValidarFormulario(inputCantidad.closest("form")) == false) {
        Alerta.Danger("No puede seleccionar mas productos de esta categoria.");
        return;
    }

    if(isNaN(inputCantidad.value)) {
        inputCantidad.value = 1;
    } else {
        inputCantidad.value = Number(inputCantidad.value) + 1;
    }

    CambiarFormulario(inputCantidad.closest("form"));
}

function Disminuir(idElemento)
{
    var inputCantidad = document.getElementById(idElemento);

    if(isNaN(inputCantidad.value) || inputCantidad.value < 1) {
        inputCantidad.value = 0;
    } else {
        inputCantidad.value = Number(inputCantidad.value) - 1;
    }

    CambiarFormulario(inputCantidad.closest("form"));
}

function ValidarFormulario(form)
{
    var elementos = form.elements;
    var limite = form.getAttribute("limite");
    var cantidad = 0;

    for(var elemento of elementos)
    {
        if(isNaN(elemento.value) || elemento.value < 1) {
            elemento.value = 0;
        } else {
            cantidad += Number(elemento.value);
        }
    }

    if(cantidad >= limite) {
        return false;
    } else {
        return true;
    }
}

function CambiarFormulario(form)
{
    var elementos = form.elements;
    var idCategoria = form.getAttribute("idCategoria");
    var labelCategoria = document.getElementById("label-cantCategoria-"+idCategoria);
    var cantidad = 0;

    for(var elemento of elementos)
    {
        if(isNaN(elemento.value) || elemento.value < 1) {
            elemento.value = 0;
        } else {
            cantidad += Number(elemento.value);
        }
    }
    
    labelCategoria.innerHTML = cantidad;
}