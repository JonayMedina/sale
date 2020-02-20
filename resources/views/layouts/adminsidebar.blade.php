<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link " href="#"><i class="icon-home"></i> Inicio</a>
                    </li>
                    <li class="nav-title">

                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-line-chart"></i> Ventas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-file-pdf-o"></i> Facturas</a>
                            </li>
                            <li @click="menu=14" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-file-pdf-o"></i> Cotizaciones</a>
                            </li>
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-address-book-o"></i> Clientes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-cart-plus"></i> Compras</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-folder-open"></i> Ingresos</a>
                            </li>
                            <li @click="menu=4" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-address-book-o"></i> Proveedores</a>
                            </li>
                            <li @click="menu=11" class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-file"></i> Retenciones</a>
                              </li>
                        </ul>
                    </li>
                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-archive"></i> Productos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Categorías</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Artículos</a>
                            </li>
                        </ul>
                    </li>

                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-user-circle"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-users"></i> Usuarios</a>
                            </li>
                          <!--   <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="fa fa-address-card-o"></i> Roles</a>
                            </li> -->
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Cuentas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Cuentas por Pagar</a>
                            </li>
                            <li @click="menu=10" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Cuentas por Cobrar</a>
                            </li>
                        </ul>
                    </li>


                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-support"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>
                    <li @click="menu=13" class="nav-item">

                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">DS</span></a>
                    </li>
                    <li @click="menu=15" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Datos Empresa</a>
                    </li>
                    <li @click="menu=16" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> I.v.a.</a>
                    </li>
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Gastos</a>
                    </li>



                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>