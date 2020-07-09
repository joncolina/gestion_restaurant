<?php

/**
 * Tomamos las entradas
 */
$idCombo = Input::POST("idCombo", TRUE);
$platos = Input::POST("platos", TRUE);

/**
 * Definimos los objectos principales
 */
$objCombo = new ComboModel($idCombo);
$objRestaurant = Sesion::getRestaurant();
$objMesa = Sesion::getUsuario();

/**
 * Verificamos que el combo y la mesa pertecezcan al restaurant actual
 */
if($objCombo->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("El combo <b>{$objCombo->getNombre()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

if($objMesa->getIdRestaurant() != $objRestaurant->getId()) {
    throw new Exception("La mesa <b>{$objMesa->getAlias()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
}

/**
 * Validamos el status del servicio
 */
if( $objRestaurant->getStatusServicio() === FALSE ) {
    throw new Exception("El servicio no esta activo.");
}

/**
 * Definimos otras variables
 */
$descuento = $objCombo->getDescuento();

/**
 * Validamos los limites
 */
$categorias = $objCombo->getCategorias();
foreach($categorias as $categoria)
{
    $objCategoria = new CategoriaModel( $categoria['idCategoria'] );
    $limite = $categoria['cantidad'];
    $cantidad_actual = 0;

    foreach($platos as $plato)
    {
        if($plato['cantidad'] < 0) throw new Exception("La cantidad debe ser un numero entero positivo.");
        if($plato['idCategoria'] != $objCategoria->getId()) continue;

        $cantidad_actual += $plato['cantidad'];
    }

    if($cantidad_actual > $limite) {
        throw new Exception("Excedio el limites de platos en la categoria <b>{$objCategoria->getNombre()}</b> del combo <b>{$objCombo->getNombre()}</b><br>[{$cantidad_actual} - {$limite}].");
    }
}

/**
 * Creamos la conexión con la BD temporal
 */
Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );

/**
 * Recorremos todos los platos
 */
foreach($platos as $plato)
{
    /**
     * Creamos el objecto
     */
    $objPlato = new PlatoModel($plato['id']);

    /**
     * Validamos
     */
    if($objPlato->getIdRestaurant() != $objRestaurant->getId()) {
        throw new Exception("El plato <b>{$objPlato->getNombre()}</b> no pertence al restaurant <b>{$objRestaurant->getNombre()}</b>.");
    }

    /**
     * Definimos las variables para guardarlas
     */
    $idRestaurant = $objRestaurant->getId();
    $idMesa = $objMesa->getId();
    $idPlato = $objPlato->getId();
    $nombrePlato = $objPlato->getNombre();
    $idCombo = $objCombo->getId();
    $nombreCombo = $objCombo->getNombre();
    $precioUnitario = bcdiv($objPlato->getPrecioVenta(), '1', 2);
    $cantidad = (int) $plato['cantidad'];
    $descuento = $descuento;
    $nota = $plato['nota'];
    $para_llevar = FALSE;

    /**
     * Guardamos
     */
    PedidosClienteModel::Registrar(
        $idRestaurant,
        $idMesa,
        $idPlato,
        $nombrePlato,
        $idCombo,
        $nombreCombo,
        $precioUnitario,
        $cantidad,
        $descuento,
        $nota,
        $para_llevar
    );
}

/**
 * Guardamos los cambios
 */
Conexion::getSqlite()->Commit();

/**
 * Solo para probar
 */
$respuesta['data'] = [
    "idCombo" => $idCombo,
    "platos" => $platos
];

/**
 * Retornamos la salida
 */
echo json_encode($respuesta);