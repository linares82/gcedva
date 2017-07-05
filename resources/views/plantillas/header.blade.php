<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{!! route('home') !!}" class="logo">
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
                
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        
                        <!--DB::table('entidads')->where('id', Auth::user()->entidad_id)->value('nombre') -->
                        
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                        @if (Auth::guest())
                            Invitado
                        @else
                            {!!Auth::user()->name !!}
                        @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                                                <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! url('users/perfil')."/".Auth::user()->id !!}" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <form method="POST" src>
                                <a href=" {!! url('logout') !!} " class="btn btn-default btn-flat">Salir</a>
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