<script>
    const ID_RESTAURANT = '<?php echo Sesion::getRestaurant()->getId(); ?>';
    const ID_USUARIO = '<?php echo Sesion::getUsuario()->getId(); ?>';
</script>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 position-relative">
                Pedidos
                <div class="position-absolute" style="top: 0px; right: 0px;">
                    <div class="badge badge-danger" id="div-conexion">
                        <i class="fas fa-server"></i>
                        No conectado
                    </div>
                </div>
            </h5>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary" onclick="ActualizarTodo()">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>

                        <select class="form-control" onchange="ActualizarFiltro()" id="select-areaMonitoreo">
                            <?php
                                $areas = AreasMonitoreoModel::Listado();
                                foreach($areas as $area)
                                {
                                    ?>
                                        <option value="<?php echo $area['idAreaMonitoreo']; ?>">
                                            <?php echo $area['nombre']; ?>
                                        </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <div class="border border-primary rounded-top bg-primary text-white font-weight-bold p-2">
                    Pedidos pendientes
                </div>

                <div class="list-group" id="lista-pedidos">
                    <div class="list-group-item py-2" center>. . .</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirmar">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">
                    Confirmar pedido
                    <button class="close" data-dismiss="modal">&times;</button>
                </h5>
            </div>
            
            <div class="modal-body">
                ¿Esta seguro que desea cambiar el status al pedido <b>N° <span id="text-confirmar-id">X</span></b>?
                <input type="hidden" id="input-confirmar-id">
            </div>
            
            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary w-100px" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-primary w-100px" onclick="Confirmar()">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>