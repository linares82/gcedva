@extends('plantillas.admin_template')

@section('header')
@endsection

@section('content')

    <div class="row ">
        <div class="col-md-12">
            <!-- Main content -->
            <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3>47</h3>
                    <p>Pendientes del mes</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Concretados del Mes</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                    <h3>44</h3>
                    <p>Asignados en el mes</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3>65</h3>
                    <p>Rechazados</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas Información <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
            <!-- Main row -->
        </div>
    </div>

@endsection
