<?php
    $objMesa = Sesion::getUsuario();
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion menu-lateral" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="panel-usuario row">
                <div class="ml-2 d-flex">
                    <div class="usuario-miniatura bg-primary border border-primary d-flex justify-content-center align-self-center">
                        <i class="fas fa-utensils w-50 h-50 align-self-center text-white"></i>
                    </div>
                </div>

                <div class="col">
                    <div class="col-12 nombre px-2">
                        <?php echo $objMesa->getAlias(); ?>
                    </div>

                    <div class="col-12 px-2 text-muted">
                        <?php echo $objMesa->getAlias(); ?>
                    </div>
                </div>
            </div>

            <div class="nav">

                <!--====================================================================
                    Seccion por defecto: Inicio
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "welcome") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Welcome/"; ?>">
					<div class="sb-nav-link-icon">
						<i class="fas fa-home"></i>
					</div>
					Inicio
                </a>

                <!--====================================================================
                    Seccion por defecto: Combos
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "combos") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Combos/"; ?>">
					<div class="sb-nav-link-icon">
                        <i class="fas fa-book-open"></i>
					</div>
					Combos
                </a>

                <!--====================================================================
                    Seccion por defecto: Comandas
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "comanda") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Comanda/"; ?>">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    Comanda
                </a>

                <!--====================================================================
                    Seccion por defecto: Pedidos
                =====================================================================-->
                <?php
                    $active = (Peticion::getControlador() == "pedidos") ? 'active' : '';
                ?>

                <a class="nav-link" <?php echo $active; ?> href="<?php echo HOST."Pedidos/"; ?>">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    Pedidos
                </a>

            </div>
        </div>

        <a href="#/Salir/">
            <div class="w-100 p-2 border-top border-primary" onclick="ModalCerrarSesion()">
                <i class="fas fa-shield-alt"></i>
                Cerrar sesión
            </div>
        </a>
    </nav>
</div>