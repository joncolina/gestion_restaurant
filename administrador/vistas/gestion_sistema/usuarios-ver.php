<div class="m-2 p-2">
    <div class="card card-header bg-white">
        <h5>
            <?php echo $objUsuario->getNombre(); ?>

            <button class="close" onclick="history.go(-1)">
                <i class="fas fa-xs fa-arrow-left"></i>
            </button>
        </h5>

        <div class="text-muted">
            Registrado desde <?php echo Formato::Fecha( $objUsuario->getFechaRegistro() ); ?>
        </div>
    </div>
</div>

<div class="px-3 py-2 row">
    <div></div>
</div>