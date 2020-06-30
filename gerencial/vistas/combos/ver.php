<div class="m-2 p-2">
    <div class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-3">
                <img src="<?php echo $objCombo->getImagen(); ?>" class="card-img rounded-0" alt="Error image" style="height: 162px; object-position: center center; object-fit: cover;">
            </div>
            
            <div class="col-md-9">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><?php echo $objCombo->getNombre(); ?></h5>
                </div>

                <div class="card-body py-2 px-3">
                    <div style="height: 48px;">
                    <?php echo $objCombo->getDescripcion(); ?>
                    </div>
                </div>
                
                <div class="card-footer bg-white">
                    <div class="font-weight-bold <?php echo ($objCombo->getDescuento() > 0) ? 'text-success' : 'text-dark' ?>">
                        <?php echo "Descuento: {$objCombo->getDescuento()}%"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $descuento = bcdiv( $objCombo->getDescuento() / 100, '1', 2 );
        $categorias = $objCombo->getCategorias();
        foreach($categorias as $categoria)
        {
            $objCategoria = new CategoriaModel( $categoria['idCategoria'] );
            $idCategoria = $categoria['idCategoria'];
            $cantidadPlatos = $categoria['cantidad'];
            $platos = $objCombo->getPlatos( $objCategoria->getId() );

            ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <?php echo "{$objCategoria->getNombre()} (Seleccionadas <b id='label-cantCategoria-{$idCategoria}'>0</b> de {$cantidadPlatos})"; ?>
                        </h5>
                    </div>

                    <div class="card-body">
                        <form class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 px-2" limite="<?php echo $cantidadPlatos; ?>" idCategoria="<?php echo $idCategoria; ?>" id="<?php echo 'form-categoria-'.$idCategoria; ?>" onsubmit="event.preventDefault()" onchange="CambiarFormulario(this)">
                            <?php
                                foreach($platos as $plato)
                                {
                                    $objPlato = new PlatoModel( $plato['idPlato'] );
                                    $idPlato = $objPlato->getId();
                                    $precioOriginal = $objPlato->getPrecioVenta();
                                    $precioDescuento = $precioOriginal * (1 - $descuento);

                                    ?>
                                        <div class="mb-3 d-flex justify-content-center px-2">
                                            <div class="card card-especial-sm" tabindex="0">
                                                <img src="<?php echo $objPlato->getImagen(); ?>" class="card-img-top border-bottom">

                                                <div class="card-body p-3">
                                                    <p class="card-text mb-1">
                                                        <?php echo $objPlato->getNombre(); ?>
                                                    </p>

                                                    <h6 class="card-title mb-0 text-muted" style="text-decoration: line-through;">
                                                        BsS. <?php echo Formato::Numero( $precioOriginal ); ?>
                                                    </h6>

                                                    <h5 class="card-title mb-0 text-success">
                                                        BsS. <?php echo Formato::Numero( $precioDescuento ); ?>
                                                    </h5>

                                                    <div class="form-row mt-2 justify-content-end">
                                                        <div class="form-group col-2 mb-0">
                                                            <button class="btn btn-sm btn-primary" style="width: 32px;" onclick="Disminuir('<?php echo 'input-plato-'.$idPlato; ?>')">
                                                                <b>-</b>
                                                            </button>
                                                        </div>

                                                        <div class="form-group col-2 mb-0">
                                                            <input type="text" class="form-control form-control-sm bg-white" disabled style="width: 32px;" center value="0" min="0" id="<?php echo 'input-plato-'.$idPlato; ?>">
                                                        </div>

                                                        <div class="form-group col-2 mb-0">
                                                            <button class="btn btn-sm btn-primary" style="width: 32px;" onclick="Aumentar('<?php echo 'input-plato-'.$idPlato; ?>')">
                                                                <b>+</b>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </form>
                    </div>
                </div>
            <?php
        }
    ?>
</div>