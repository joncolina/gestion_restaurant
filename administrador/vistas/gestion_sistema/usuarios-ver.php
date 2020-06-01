<div class="p-2 m-2">
    <div class="card card-header bg-white">
        <h5 class="mb-0">
            <?php echo $objUsuario->getNombre(); ?>
            <button class="close" onclick="history.go(-1)">
                <i class="fas fa-xs fa-arrow-left"></i>
            </button>
        </h5>

        <div class="text-muted">
            Fecha de registro: <?php echo Formato::Fecha( $objUsuario->getFechaRegistro() ); ?>
        </div>
    </div>
</div>