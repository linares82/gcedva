<?php $menu = app('App\Http\Controllers\MenusController'); ?>
<?php $msj = app('App\Http\Controllers\HomeController'); ?>
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="<?php echo route('home'); ?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">CRM</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">CRMScool</span>
	</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                <!--Alertas de Avisos-->
                <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success"><?php echo $msj->tieneAvisos(); ?> </span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tienes mensajes: </li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                      <li><!-- start message -->
                        <a href="<?php echo e(route('home')); ?>">
                          <h4>
                            <?php echo $msj->tieneAvisos(); ?> Sin leer.
                          </h4>
                        </a>
                      </li><!-- end message -->
                    </ul><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                  </li>
                </ul>
              </li>
                <!--fin alertas de avisos-->
                
                
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Accesos Comunes</a>
                    <ul class="dropdown-menu" role="menu">
                    <?php echo $menu->armaMenu2(43); ?> 

                  </ul>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if(Auth::user()): ?>
                        Plantel: <?php echo Cache::remember('razon', 30, function(){
                                return DB::table('plantels as p')
                            ->join('empleados as e', 'e.plantel_id','=', 'p.id')
                            ->where('e.user_id', Auth::user()->id)->value('razon');
                            });; ?>

                        
                        
                        <?php endif; ?>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                        <?php if(Auth::guest()): ?>
                            Invitado
                        <?php else: ?>
                            Empleado: <?php echo Cache::remember('nombre', 30, function(){
                                return DB::table('empleados')->where('user_id', Auth::user()->id)->value('nombre'); 
                            });; ?>

                        <?php endif; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                                                <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <form method="POST">
                                    <a href=" <?php echo route('users.editPerfil', Auth::user()->id); ?> " class="btn btn-default btn-flat">Editar Usuario</a>
                                    <a href=" <?php echo url('logout'); ?> " class="btn btn-default btn-flat">Salir</a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>



<!-- Left side column. contains the sidebar 