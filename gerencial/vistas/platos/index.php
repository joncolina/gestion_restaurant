<div class="m-2 p-2">
   
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Gestión de Platos.</h5>
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
                        <button class="btn btn-outline-primary" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevoPla">
                        	<i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="boton-buscador">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <input type="search" class="form-control" placeholder="Buscar..." id="input-buscador">
                    </div>
                </div>
            </div>

            <div id="tabla">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-sm">
                            <tr>
                            	<!-- Solo mostraremos estas columnas -->
                                <th class="w-50px">ID</th>
                                <th class="w-auto">Nombre</th>
                                <th class="w-auto">Precio de Venta</th>
                                <th class="w-100px">Modificar</th>
                                <th class="w-100px">Eliminar</th>
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
    </div>
</div>

<div class="modal fade" id="modal-cambiar-acceso">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white p-3">
                <h5 class="mb-0">Cambiar acceso a restaurant</h5>
            </div>

            <div class="modal-body">
                <form id="form-cambiar-acceso">
                    <input type="hidden" name="idRestaurant" id="id-cambiar-acceso">
                    <label id="label-cambiar-acceso">...</label>
                </form>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-outline-secondary" data-dismiss="modal">
                    Cerrar
                </button>

                <button class="btn btn-dark" id="boton-cambiar-acceso">
                    Seguro
                </button>
            </div>

        </div>
    </div>
</div> 



<!-- Modal Para Agregar.. -->
<div class="modal fade" id="staticBackdropnuevoPla" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-white bg-primary">
        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Plato.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        	<form id="form-nuevo" action="#" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault()">
        		<div class="form-row">
				    <div class="form-group col-md-12">
				      <input type="text" class="form-control" id="NombrePlato" name="NombrePlato" placeholder="Nombre del Plato">
				    </div>
				    <div class="form-group col-md-12">
				      <label for="DescripPlato">Descripción del Plato</label>	
				      <textarea class="form-control" id="DescripPlato" name="DescripPlato" rows="1"></textarea>
				    </div>
				    <div class="form-group col-md-4">
				    	<label for="CategoriaPlato">Categoría</label>
    					<select class="form-control" id="CategoriaPlato" name="CategoriaPlato">
					      <?php
                  $categorias = CategoriasModel::Listado();
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
				    <div class="form-group col-md-4">
				      <label for="PrecioCostoPlato">Precio de Costo</label>	
					  <input type="number" class="form-control" id="PrecioCostoPlato" name="PrecioCostoPlato" placeholder="Precio Costo">	
					</div>
					<div class="form-group col-md-4">
				      <label for="PrecioVentaPlato">Precio de Venta</label>	
					  <input type="number" class="form-control" id="PrecioVentaPlato"name="PrecioVentaPlato" placeholder="Precio Venta">	
					</div>
					
          <div class="custom-control custom-switch">
            <input type="checkbox" checked class="custom-control-input" id="customSwitch1" name="ActivoPlato">
            <label class="custom-control-label" for="customSwitch1">Activo</label>
        </div>

					<div class="form-group col-md-12">
				      <label for="ImagenPlato">Seleccione la Foto</label>	
					  <input type="file" class="form-control-file" id="ImagenPlato" name="ImagenPlato">	
					</div>
				  </div>
        	</form>
        	
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="Agregar()">Aceptar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Para Modificar.. -->
<div class="modal fade" id="staticBackdropmodificaPla" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modificar Plato.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="MImagenActualPlato">Imagen del Plato</label
                      >   
                      <img src="descarga.jpg">
                      <hr>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="MPrecioCostoPlato">Seleccione la Foto</label>  
                      <input type="file" class="form-control-file" id="MImagenPlato" name="MImagenPlato"> 
                    </div>

                    <div class="form-group col-md-12">
                      <input type="text" class="form-control" id="MNombrePlato" name="MNombrePlato" placeholder="Nombre del Plato">
                    </div>
                    <div class="form-group col-md-12">
                      <label for="MDescripPlato">Descripción del Plato</label>   
                      <textarea class="form-control" id="MDescripPlato" name="MDescripPlato" rows="3"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="MCategoriaPlato">Categoría</label>
                        <select class="form-control" id="MCategoriaPlato" name="MCategoríaPlato">
                          <option>Datos de la tabla de Categorías</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="MPrecioCostoPlato">Precio de Costo</label> 
                      <input type="number" class="form-control" id="MPrecioCostoPlato" name="MPrecioCostoPlato" placeholder="Precio Costo">   
                    </div>
                    <div class="form-group col-md-3">
                      <label for="MPrecioVentaPlato">Precio de Venta</label> 
                      <input type="number" class="form-control" id="MPrecioVentaPlato" name="MPrecioVentaPlato" placeholder="Precio Venta">   
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="MRadioPlato" id="MRadio1Plato" value="option1" checked>
                          <label class="form-check-label" for="MRadio1Plato">
                            Activo
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="MRadioPlato" id="MRadio2Plato" value="option2">
                          <label class="form-check-label" for="MRadio2Plato">
                            Inactivo
                          </label>
                        </div>
                    </div>
                    
                  </div>
            </form>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>




