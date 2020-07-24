<?php
    if( Sesion::getRestaurant()->getStatusServicio() ===  FALSE )
    {
        ?>
            <div class="position-fixed w-100" style="bottom: 0px; right: 0px;">
                <div center class="alert alert-danger mb-0 w-100 border-top-0 border-left-0 border-right-0 rounded-0">
                    Servicio no activo
                </div>
            </div>

            <div style="width: 100%; height: 50px;"></div>
        <?php
    }
?>