<?php
$objRestaurant = Sesion::getRestaurant();
$idRestaurant = $objRestaurant->getId();
$categorias = CategoriasModel::Listado($idRestaurant);
?>

<div class="m-2 p-2">
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <a href="<?php echo HOST_GERENCIAL."Menus/"; ?>">
                    <div class="pr-2">
                        <i class="fas fa-arrow-left fa-sm"></i>
                    </div>
                </a>
            </div>

            <h5 class="mb-0">
                Registrar combo
            </h5>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 mb-2 col-md-6 mb-md-0">
                    <div class="btn-group">
                        <!--Asignamos el evetno de actualizar aqui -->
                        <button class="btn btn-outline-primary" id="boton-actualizar" onclick="Actualizar()">
                            <i class="fas fa-sync-alt"></i>
                        </button>

                        <!-- Button trigger modal  Nuevo Plato-->
                        <button class="btn btn-primary px-3" data-toggle="modal" data-target="#modal-instrucciones">
                            Instrucciones
                        </button>
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="boton-buscador">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <input type="search" class="form-control" placeholder="Buscar..." id="input-buscador">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <select id="filtro_buscador" class="form-control" onchange="Filtros(this)">
                        <option value="">General</option>
                        <?php
                            foreach($categorias as $categoria)
                            {
                                ?>
                                    <option value="<?php echo $categoria['idCategoria']; ?>">
                                        <?php echo $categoria['nombre']; ?>
                                    </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered mb-0">
                        <thead class="table-sm">
                            <tr>
                                <!-- Solo mostraremos estas columnas -->
                                <th ordenar="true" key="nombre" class="w-auto">Nombre</th>
                                <th ordenar="true" key="categoria" class="w-200px">Categoria</th>
                                <th class="w-50px">Activo</th>
                                <th class="w-100px">Seleccionar</th>
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

        <div class="card-footer" center>
            <button class="btn btn-outline-secondary w-200px" onclick="Limpiar()">
                Limpiar
            </button>

            <button class="btn btn-primary w-200px" onclick="Continuar()">
                Continuar
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-instrucciones">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">Instrucciones</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p class="mb-0">
                    Seleccione los platos que desea agregar al combo.<br>
                    Puede apoyarse del buscador y del filtro.<br>
                    <br>
                    Despues presione <b>Continuar</b> al final de la pagina y rellene los campos faltantes<br>
                    <br>
                    El sistema ordenara los platos por categoria.<br>
                </p>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-registrar">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="mb-0">Registrar combo</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form-registrar" onsubmit="event-preventDefault()">
                    <div class="row">

                        <div class="form-group ml-3" center>
                            <input type="file" id="img-foto-combo-nuevo" class="d-none" accept="image/*" name="img">
                            <label class="foto-plato-muestra border-secondary mb-0" tabindex="0" for="img-foto-combo-nuevo" id="label-foto-combo-nuevo">
                                <img src="<?php echo HOST.IMG_COMBO_DEFECTO; ?>">
                            </label>
                        </div>

                        <div class="form-group col">
                            <label for="input-registrar-nombre" class="mb-0">Nombre</label>
                            <input type="text" id="input-registrar-nombre" required class="form-control" name="nombre" placeholder="Nombre...">
                        </div>

                        <div class="form-group col-12">
                            <label for="input-registrar-descuento" class="mb-0">Descuento</label>
                            <input type="number" id="input-registrar-descuento" min="0" max="100" step="0.01" required class="form-control" name="descuento" placeholder="Descuento...">
                        </div>

                        <div class="form-group col-12">
                            <label for="input-registrar-descripcion" class="mb-0">Descripción</label>
                            <textarea id="input-registrar-descripcion" class="form-control" name="descripcion" placeholder="Descripción..." cols="30" rows="2"></textarea>
                        </div>
                        
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-hover table-striped mb-0">
                                <thead class="table-sm">
                                    <tr>
                                        <th class="w-auto">Categoria</th>
                                        <th class="w-100px">Cant. platos</th>
                                        <th class="w-100px">Selec. cliente</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody-platos">
                                    <tr>
                                        <td colspan="100" center>. . .</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary" onclick="Registrar()">Registrar</button>
            </div>

        </div>
    </div>
</div>