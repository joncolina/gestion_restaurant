<?php
    $objRestaurant = Sesion::getRestaurant();
    $categorias = CategoriasModel::Listado( $objRestaurant->getId() );
?>

<div class="card card-header sub-header">
    <h5 class="mb-0 d-flex align-items-center">
        <a href="<?php echo HOST."Welcome/"; ?>">
            <div class="float-right">
                <div class="pr-2">
                    <i class="fas fa-sm fa-arrow-left"></i>
                </div>
            </div>
        </a>

        Comanda

        <div class="position-absolute" style="right: 5px;">
            <div class="input-group input-group-sm w-150px">
                <select class="form-control" onchange="CambioCategoria(this)">
                    <option value="">General</option>
                    <?php
                        foreach($categorias as $categoria)
                        {
                            ?>
                                <option value="<?php echo $categoria['idCategoria']; ?>">
                                    <?php echo $categoria['nombre']; ?>
                                </option>
                            <?php
                        }
                    ?>
                </select>
            </div>        
        </div>
    </h5>
</div>

<div class="m-especial p-2" id="contenedor-platos"></div>