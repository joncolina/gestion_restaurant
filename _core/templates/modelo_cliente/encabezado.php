<?php
    $objRestaurant = Sesion::getRestaurant();
    $objMesa = Sesion::getUsuario();

    $nombreMesa = $objMesa->getAlias();
    $nombreRestaurant = $objRestaurant->getNombre();

    if( $objRestaurant->getStatusServicio() ) {
        Conexion::IniciarSQLite( $objRestaurant->getRutaDB() );
        $pedidos = PedidosDetallesClienteModel::SinConfirmar( $objRestaurant->getId(), $objMesa->getId() );
        $cantidadPedidos = sizeof( $pedidos );
    } else {
        $cantidadPedidos = 0;
    }
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
                <span class="ml-2">Camarero</span>
            </button>
        </div>

        <div class="opciones" id="contenedor-pedidos" <?php echo ($cantidadPedidos > 0) ? "cantidad='{$cantidadPedidos}'" : ''; ?>>
            <button class="btn btn-sm order-1 order-lg-0" onclick="VerPedidos()">
                <i class="fas fa-clipboard-check"></i>
                <span class="ml-2">Pedidos</span>
            </button>
        </div>

        <div class="opciones" onclick="MenuLateral()">
            <button class="btn btn-sm order-1 order-lg-0">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</div>