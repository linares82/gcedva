<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>{{ "SieScool" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/bower_components/AdminLTE/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="{{ asset('/bower_components/AdminLTE/dist/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />-->
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="{{ asset('/bower_components/AdminLTE/dist/css/ionicons.min.css')}}" rel="stylesheet" type="text/css" />-->
    <!-- Theme style -->
    <link href="{{ asset('/bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap_flc.css')}}">
    

    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset('/bower_components/AdminLTE/dist/css/skins/_all-skins.css')}}" rel="stylesheet" type="text/css" />

	
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/datepicker/datepicker3.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">
    <!--Multiselect-->
    <link rel="stylesheet" href="{{ asset('/lou-multi-select/css/multi-select.css') }}">
	  <!--Zebra datepicker-->
	  <link rel="stylesheet" href=" {{ asset('/zebra_datepicker/public/css/bootstrap.css') }} ">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/bower_components/AdminLTE/plugins/select2/select2.min.css')}}">
    
    <style>
        .spinner {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{asset('/images/spinner.gif')}}") 50% 50% no-repeat #FFF;
          }
        
    </style>
    <script>
        /*$(window).load(function() {
            $('#loading').hide();
        });*/
    </script>
	
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-purple-light sidebar-mini sidebar-collapse">
<div class="wrapper">
    <div class="spinner"></div>
    
    <!-- Header -->
    @include('plantillas/header')

    <!-- Sidebar -->
    @include('plantillas/sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style='heigth:auto;'>
        <!-- Content Header (Page header) -->
        <!--<section class="content-header">
            <h1>
                
                <small></small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <!--<ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            
              @yield('header')
              @yield('content')
            
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('plantillas/footer')

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->



<!-- jQuery 2.1.4 -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ('/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('/bower_components/AdminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset ('/bower_components/AdminLTE/dist/js/demo.js') }}" type="text/javascript"></script>   
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/fastclick/fastclick.min.js') }}"></script>
<!-- Color picker -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<!--Multiselect-->
<script src="{{ asset ('/lou-multi-select/js/jquery.multi-select.js') }}"></script>
<!--Datepicker zebra-->
<script src="{{ asset ('/zebra_datepicker/public/javascript/zebra_datepicker.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/select2/select2.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script>
 jQuery(window).load(function() {				
       jQuery('.spinner').animate({
               'opacity':0},1000,'easeOutCubic',function (){jQuery(this).css('display','none')
               });	
       });

(function() {
  $('.select_seguridad').select2({ width: '100%' });
})();

$("button[type=submit]").click(function(){
    $(this).prop('disabled', true);
    $(this).closest('form').submit();
    //$('#formulario').submit();
});

$('.fecha').Zebra_DatePicker({
    days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            readonly_element: false,
            lang_clear_date: 'Limpiar',
            show_select_today: 'Hoy',
    });

</script>

 @stack('scripts')

 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179639818-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-179639818-1');
  

  
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>