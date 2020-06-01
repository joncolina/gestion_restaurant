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

                <form id="form-personal">
                    <input type="hidden" name="usuario" value="<?php echo $objUsuario->getUsuario(); ?>">

                    <div class="form-group">
                        <label for="usuario-nombre" class="mb-1">Nombre:</label>
                        <input type="text" name="nombre" id="usuario-nombre" class="form-control"
                        placeholder="Usuario..." value="<?php echo $objUsuario->getNombre(); ?>">
                    </div>

                    <div class="form-group">
                        <label for="usuario-cedula" class="mb-1">Cedula:</label>
                        <input type="number" name="cedula" id="usuario-cedula" class="form-control"
                        placeholder="Cedula..." value="<?php echo $objUsuario->getCedula(); ?>">
                    </div>
                </form>

                <div center>
                    <button class="btn btn-outline-secondary w-100px" id="boton-limpiar-personal">
                        Limpiar
                    </button>

                    <button class="class btn btn-success w-100px" id="boton-guardar-personal">
                        Guardar
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-12 mb-3 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Datos de la cuenta</h5>
            </div>

            <div class="card-body">

                <form id="form-cuenta">
                    <input type="hidden" name="usuario" value="<?php echo $objUsuario->getUsuario(); ?>">

                    <div class="form-group">
                        <label class="mb-1">Usuario:</label>
                        <input type="text" class="form-control" disabled value="<?php echo strtoupper( $objUsuario->getUsuario() ); ?>">
                    </div>

                    <div class="form-group">
                        <label for="usuario-clave" class="mb-1">Nueva Contraseña:</label>
                        <input type="password" name="clave" id="usuario-clave" class="form-control"
                        placeholder="Contraseña...">
                    </div>
                </form>

                <div center>
                    <button class="btn btn-outline-secondary w-100px" id="boton-limpiar-cuenta">
                        Limpiar
                    </button>

                    <button class="class btn btn-success w-100px" id="boton-guardar-cuenta">
                        Guardar
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>