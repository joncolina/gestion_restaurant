<?php
    $objRestaurant = Sesion::getRestaurant();
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

        Combos
    </h5>
</div>

<div class="m-especial p-2" id="contenedor-combos"></div>