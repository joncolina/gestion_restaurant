<div class="m-2 p-2">
    <div class="card">
        <div class="card-body p-3">
            <h5 class="mb-0">
                <a href="#" onclick="history.go(-1)">
                    <div class="float-left px-1 mr-2 text-dark">
                        <i class="fas fa-xs fa-arrow-left"></i>
                    </div>
                </a>

                <?php echo $objRestaurant->getNombre(); ?>

                <a href="#more-info" data-toggle="collapse">
                    <div class="float-right px-2">
                        <i class="fas fa-xs fa-info"></i>
                    </div>
                </a>
            </h5>

            <div class="collapse" id="more-info">
                <br>

                <div>
                    <b>ID:</b> <?php echo $objRestaurant->getId(); ?><br>
                    <b>Documento:</b> <?php echo $objRestaurant->getDocumento(); ?><br>
                </div>

                <div class="text-muted">
                    <b>Registro:</b> <?php echo Formato::Fecha( $objRestaurant->getFechaRegistro() ); ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="my-3">
        <nav>
            <div class="nav nav-tabs" id="opciones">
                <a center class="nav-item nav-link active text-truncate w-20" id="opciones-basico" data-toggle="tab" href="#basico">Basico</a>
                <a center class="nav-item nav-link text-truncate w-20" id="opciones-redes" data-toggle="tab" href="#redes">Redes sociales</a>
                <a center class="nav-item nav-link text-truncate w-20" id="opciones-roles" data-toggle="tab" href="#roles">Roles</a>
                <a center class="nav-item nav-link text-truncate w-20" id="opciones-permisos" data-toggle="tab" href="#permisos">Permisos</a>
                <a center class="nav-item nav-link text-truncate w-20" id="opciones-usuarios" data-toggle="tab" href="#usuarios">Usuarios</a>
            </div>

            <div class="tab-content card border-top-0 rounded-0" id="tab-content">

                <!-- BASICO -->
                <div class="tab-pane fade show active" id="basico">
                    <form id="form-basico" class="card-body">
                        Basico
                    </form>
                </div>
                <!-- Fin BASICO -->

                <!-- REDES -->
                <div class="tab-pane fade" id="redes">
                    <form id="form-redes" class="card-body">
                        Redes sociales
                    </form>
                </div>
                <!-- Fin REDES -->

                <!-- ROLES -->
                <div class="tab-pane fade" id="roles">
                    <form id="form-roles" class="card-body">
                        Roles
                    </form>
                </div>
                <!-- Fin ROLES -->

                <!-- PERMISOS -->
                <div class="tab-pane fade" id="permisos">
                    <form id="form-permisos" class="card-body">
                        Permisos
                    </form>
                </div>
                <!-- Fin PERMISOS -->

                <!-- USUARIOS -->
                <div class="tab-pane fade" id="usuarios">
                    <form id="form-usuarios" class="card-body">
                        Usuarios
                    </form>
                </div>
                <!-- Fin USUARIOS -->


            </div>
        </nav>
    </div>
</div>