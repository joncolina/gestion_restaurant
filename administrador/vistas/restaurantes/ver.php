<div class="m-2 p-2">
    <div class="card">
        <div class="card-body p-3">
            <h5 class="mb-0">
                <a href="<?php echo HOST_ADMIN."Restaurantes/Gestion/"; ?>">
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
                <a center class="nav-item nav-link active text-truncate w-25" id="opciones-basico" data-toggle="tab" href="#basico">Basico</a>
                <a center class="nav-item nav-link text-truncate w-25" id="opciones-redes" data-toggle="tab" href="#redes">Redes sociales</a>
                <a center class="nav-item nav-link text-truncate w-25" id="opciones-roles" data-toggle="tab" href="#roles">Roles</a>
                <a center class="nav-item nav-link text-truncate w-25" id="opciones-permisos" data-toggle="tab" href="#permisos">Permisos</a>
            </div>
        </nav>

        <div class="tab-content card border-top-0 rounded-0" id="tab-content">

            <!-- BASICO -->
            <div class="tab-pane fade show active" id="basico">
                <form id="form-basico" class="card-body" onsubmit="event.preventDefault()" enctype="multipart/form-data">
                    <input type="hidden" name="idRestaurant" value="<?php echo $objRestaurant->getId(); ?>">

                    <div class="row justify-content-center">
                        <div class="ml-3 mb-3">
                            <input type="file" id="img-logo-restaurant" class="d-none" accept="image/*" name="img">
                            <label class="logo-muestra border-secondary bg-light mb-0" tabindex="0" for="img-logo-restaurant" id="label-logo-restaurant">
                                <img src="<?php echo $objRestaurant->getLogo(); ?>">
                            </label>
                        </div>

                        <div class="col-12 col-sm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-0" for="input-basico-documento">Documento</label>
                                        <input type="text" id="input-basico-documento" name="documento" class="form-control" value="<?php echo $objRestaurant->getDocumento(); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-0" for="input-basico-nombre">Nombre</label>
                                        <input type="text" id="input-basico-nombre" name="nombre" class="form-control" value="<?php echo $objRestaurant->getNombre(); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-direccion">Dirección</label>
                                <textarea id="input-basico-direccion" name="direccion" class="form-control" cols="30" rows="2"><?php echo $objRestaurant->getDireccion(); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-telefono">Telefono</label>
                                <input type="tel" id="input-basico-telefono" name="telefono" class="form-control" value="<?php echo $objRestaurant->getTelefono(); ?>">
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-correo">Correo</label>
                                <input type="email" id="input-basico-correo" name="correo" class="form-control" value="<?php echo $objRestaurant->getCorreo(); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="custom-control custom-switch">
                                <?php
                                    $checked = "";
                                    if($objRestaurant->getActivo()) $checked = "checked";
                                    $value = (int) $objRestaurant->getActivo();
                                ?>
                                <input type="hidden" name="activo" id="input-basico-activo" value="<?php echo $value; ?>">
                                <input type="checkbox" <?php echo $checked ?> id="input-basico-activo-aux" class="custom-control-input">
                                <label for="input-basico-activo-aux" class="custom-control-label">Activo</label>
                            </div>
                        </div>
                    </div>

                </form>

                <div center class="card-footer">
                    <button class="btn btn-outline-secondary w-100px" onclick="LimpiarBasico()">Limpiar</button>
                    <button class="btn btn-primary w-100px" onclick="ModificarBasico()">Guardar</button>
                </div>
            </div>
            <!-- Fin BASICO -->

            <!-- REDES -->
            <div class="tab-pane fade" id="redes">
                <form id="form-redes" class="card-body" onsubmit="event.preventDefault()">
                    <input type="hidden" name="idRestaurant" value="<?php echo $objRestaurant->getId(); ?>">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-whatsapp">Whatsapp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fab fa-whatsapp"></i>
                                        </span>
                                    </div>
                                    <input type="tel" name="whatsapp" id="input-basico-whatsapp" class="form-control" value="<?php echo $objRestaurant->getWhatsapp(); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-instagram">Instagram</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fab fa-instagram"></i> </span>
                                        <span class="input-group-text"> instagram.com/ </span>
                                    </div>
                                    <input type="text" name="instagram" id="input-basico-instagram" class="form-control" value="<?php echo $objRestaurant->getInstagram(); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-twitter">Twitter</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fab fa-twitter"></i> </span>
                                        <span class="input-group-text"> twitter.com/ </span>
                                    </div>
                                    <input type="text" name="twitter" id="input-basico-twitter" class="form-control" value="<?php echo $objRestaurant->getTwitter(); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="mb-0" for="input-basico-facebook">Facebook</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fab fa-facebook-f"></i> </span>
                                        <span class="input-group-text"> facebook.com/ </span>
                                    </div>
                                    <input type="text" name="facebook" id="input-basico-facebook" class="form-control" value="<?php echo $objRestaurant->getFacebook(); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>

                <div center class="card-footer">
                    <button class="btn btn-outline-secondary w-100px" onclick="LimpiarRedes()">Limpiar</button>
                    <button class="btn btn-primary w-100px" onclick="ModificarRedes()">Guardar</button>
                </div>
            </div>
            <!-- Fin REDES -->

            <!-- ROLES -->
            <div class="tab-pane fade" id="roles">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-rol-nuevo">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="tabla-roles">
                            <thead class="table-sm">
                                <tr>
                                    <th class="w-50px">ID</th>
                                    <th class="w-200px">Nombre</th>
                                    <th class="w-auto">Descripcion</th>
                                    <th class="w-100px">Opciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="100">
                                        <h2 center>. . .</h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-rol-nuevo">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white p-3">
                            <h5>Nuevo Rol</h5>
                        </div>

                        <div class="modal-body">
                            <form id="form-rol-nuevo" onsubmit="event.preventDefault()">
                                <input type="hidden" name="idRestaurant" value="<?php echo $objRestaurant->getId(); ?>">

                                <div class="form-group mb-3">
                                    <span>Nombre:</span>
                                    <input type="text" name="nombre" class="form-control">
                                </div>

                                <div class="form-group">
                                    <span>Descripción:</span>
                                    <input type="text" name="descripcion" class="form-control">
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer bg-light">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-primary" onclick="NuevoRol()">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-rol-editar">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white p-3">
                            <h5>Modificar Rol</h5>
                        </div>

                        <div class="modal-body">
                            <form id="form-rol-editar" onsubmit="event.preventDefault()">
                                <input type="hidden" name="idRol" id="id-rol-editar">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text w-100px">Nombre</span>
                                    </div>

                                    <input type="text" name="nombre" id="nombre-rol-editar" class="form-control">
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text w-100px">Descripción</span>
                                    </div>

                                    <input type="text" name="descripcion" id="descripcion-rol-editar" class="form-control">
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer bg-light">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-success" onclick="ModificarRol()">Modificar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-rol-eliminar">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white p-3">
                            <h5>Eliminar Rol</h5>
                        </div>

                        <div class="modal-body">
                            <form id="form-rol-eliminar" onsubmit="event.preventDefault()">
                                <input type="hidden" name="idRol" id="id-rol-eliminar">
                                <label id="text-rol-eliminar">...</label>

                                <br>

                                <div class="form-group">
                                    <label for="idReemplazo-rol-editar">Rol de reemplazo</label>
                                    <select name="idRolReemplazo" id="idReemplazo-rol-editar" class="form-control">
                                        <?php
                                            $roles = RolesModel::Listado($objRestaurant->getId());
                                            foreach($roles AS $rol)
                                            {
                                                ?>
                                                    <option value="<?php echo $rol['idRol']; ?>">
                                                        <?php echo $rol['nombre']; ?>
                                                    </option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer bg-light">
                            <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-danger" onclick="EliminarRol()">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin ROLES -->

            <!-- PERMISOS -->
            <div class="tab-pane fade" id="permisos">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="tabla-permisos">
                            <thead class="table-sm"></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Fin PERMISOS -->

        </div>
    </div>
</div>