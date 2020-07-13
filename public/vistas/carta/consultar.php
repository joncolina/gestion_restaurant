<?php

$idCategoria = Input::POST("categoria", FALSE);
$objRestaurant = Sesion::getRestaurant();
$data['categorias'] = [];

if($idCategoria === FALSE) {
    $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
} else {
    $objCategoria = new CategoriaModel( $idCategoria );
    $categorias = CategoriasModel::Listado( $objRestaurant->getId(), $objCategoria->getId() );
}

foreach($categorias as $categoria)
{
    $datos = PlatosModel::ListadoCliente( $objRestaurant->getId(), $categoria['idCategoria'] );
    $platos = [];

    foreach($datos as $dato)
    {
        $objPlato = new PlatoModel($dato['idPlato']);

        array_push($platos, [
            "id" => $objPlato->getId(),
            "categoria" => [
                "id" => $categoria['idCategoria'],
                "nombre" => $categoria['nombre']
            ],
            "nombre" => $objPlato->getNombre(),
            "descripcion" => $objPlato->getDescripcion(),
            "imagen" => $objPlato->getImagen(),
            "precio" => $objPlato->getPrecioVenta()
        ]);
    }

    array_push($data['categorias'], [
        "id" => $categoria['idCategoria'],
        "nombre" => $categoria['nombre'],
        "platos" => $platos
    ]);
}

$respuesta['data'] = $data;
echo json_encode($respuesta);