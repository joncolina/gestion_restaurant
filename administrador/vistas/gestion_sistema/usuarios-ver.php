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
<div class="col-12 mb-3 col-md-6 mb-md-0">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Datos personales</h5>
            </div>

            <div class="card-body">

                <form></form>
                
            </div>
        </div>
    </div>

    <div class="col-12 mb-3 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Datos de la cuenta</h5>
            </div>

            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>