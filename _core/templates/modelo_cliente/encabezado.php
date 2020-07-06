<?php
    $objRestaurant = Sesion::getRestaurant();
    $objMesa = Sesion::getUsuario();

    $nombreMesa = $objMesa->getAlias();
    $nombreRestaurant = $objRestaurant->getNombre();

    $cantidadPedidos = sizeof( PedidosModel::Carrito($objRestaurant->getId(), $objMesa->getId()) );
?>

<div class="w-100 m-0">
    <div class="text-left logo">
        <a href="<?php echo HOST_GERENCIAL."Inicio/"; ?>">
            <img src="<?php echo $objRestaurant->getLogo(); ?>">

            <label class="d-none d-sm-inline-block">
                <?php echo Sesion::getRestaurant()->getNombre(); ?>
            </label>
        </a>
    </div>

    <div class="text-right p-2 opciones-contenedor">
        <div class="opciones">
            <button class="btn btn-sm order-1 order-lg-0">
                <i class="fas fa-bell"></i>
                <span class="ml-2">Mesonero</span>
            </button>
        </div>

        <div class="opciones" id="contenedor-pedidos" <?php echo ($cantidadPedidos > 0) ? "cantidad='{$cantidadPedidos}'" : ''; ?>>
            <a class="btn btn-sm order-1 order-lg-0" href="<?php echo HOST."Pedidos/"; ?>">
                <i class="fas fa-clipboard-check"></i>
                <span class="ml-2">Pedidos</span>
            </a>
        </div>

        <div class="opciones" onclick="MenuLateral()">
            <button class="btn btn-sm order-1 order-lg-0">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</div>