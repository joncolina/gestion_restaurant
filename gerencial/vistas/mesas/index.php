<div>
	<h5>Nuevas Mesas</h5>
</div>

<div class="m-2 p-2">
   
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Registro de Nuevas Mesas.</h5>
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
                        <button class="btn btn-outline-primary" id="boton-nuevopla" data-toggle="modal" data-target="#staticBackdropnuevaMesa">
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
                                <th class="w-auto">Información de Mesa</th>
                                <th class="w-auto">Status</th>
                                <th class="w-100px">Modificar</th>
                                <th class="w-100px">Eliminar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="100">
                                    <h2 center>Buscando Datos...</h2>
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
<div class="modal fade" id="staticBackdropnuevaMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Nueva Mesa.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        	<form action="#" method="post" enctype="">
        		<div class="form-row">
  				    <div class="form-group col-md-12">
                <label for="aliasmesa">Información de Mesa (Alias)</label> 
  				      <input type="text" class="form-control" id="aliasmesa" name="aliasmesa" placeholder="Información de Mesa">
  				    </div>  
              <div class="form-group col-md-12">
                  <label for="CodigoMesa">Código Mesa (Generado Por el Sistema)</label> 
                  <input type="text" class="form-control" id="CodigoMesa" name="CodigoMesa" readonly>
              </div>  
    					<div class="form-group col-md-6">
    						<div class="form-check form-check-inline">
    						  <input class="form-check-input" type="radio" name="RadioStatusMesa" id="Radio1Mesa" value="option1" checked>
    						  <label class="form-check-label" for="Radio1Mesa">
    						    Activa
    						  </label>
    						</div>
    						<div class="form-check form-check-inline">
    						  <input class="form-check-input" type="radio" name="RadioStatusMesa" id="Radio2Mesa" value="option2">
    						  <label class="form-check-label" for="Radio2Mesa">
    						    Inactiva
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



<!-- Modal Para Modificar Mesas.. -->
<div class="modal fade" id="staticBackdropModificaMesa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modifica la Mesa.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="#" method="post" enctype="">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="Maliasmesa">Información de Mesa (Alias)</label> 
                <input type="text" class="form-control" id="Maliasmesa" name="Maliasmesa" placeholder="Información de Mesa">
              </div>  
              <div class="form-group col-md-12">
                  <label for="MCodigoMesa">Código Mesa (Generado Por el Sistema)</label> 
                  <input type="text" class="form-control" id="MCodigoMesa" name="MCodigoMesa" readonly>
              </div>  
              <div class="form-group col-md-6">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="MRadioStatusMesa" id="MRadio1Mesa" value="option1" checked>
                  <label class="form-check-label" for="MRadio1Mesa">
                    Activa
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="MRadioStatusMesa" id="MRadio2Mesa" value="option2">
                  <label class="form-check-label" for="MRadioStatusMesa">
                    Inactiva
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