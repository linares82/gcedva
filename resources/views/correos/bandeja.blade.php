
@extends('plantillas.admin_template')

@include('correos._common')

@section('header')

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Mailbox</li>
  </ol>

  <div class="">
    <h3>
        <i class="glyphicon glyphicon-align-justify"></i> MailBox
    </h3>

</div>
    
@endsection  

@section('content')
<div class="row">
    <div class="col-md-3">
      <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>
          <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            @foreach($aFolder as $oFolder)
            <li class="active">
                <a href="{{ route('correos.bandeja', ['carpeta'=>$oFolder->name]) }}"> 
                    <span class="label label-primary pull-right"></span>
                    {{ $oFolder->name }}
                </a>
            </li>
            @endforeach
          </ul>
        </div><!-- /.box-body -->
      </div><!-- /. box -->
      
    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Inbox</h3>
          <div class="box-tools pull-right">
            <div class="has-feedback">
              <input type="text" class="form-control input-sm" placeholder="Search Mail">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            <div class="btn-group">
              <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div><!-- /.btn-group -->
            <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
              {{$aMessage->links()}}
            </div><!-- /.pull-right -->
          </div>
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <thead>
                    <th></th><th></th><th>De:</th><th>Asunto</th><th>Adjuntos</th><th>Fecha</th>
                </thead>
              <tbody>
                @foreach($aMessage as $oMessage)
                <tr>
                  <td>
                    <div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                        <input type="checkbox" value={{$oMessage->getUid()}} style="position: absolute; opacity: 0;">
                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                        </ins>
                    </div>
                  </td>
                  <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                  <td class="mailbox-name"><a href="read-mail.html">{{$oMessage->getFrom()[0]->personal}}({{$oMessage->getFrom()[0]->mail}})</a></td>
                  <td class="mailbox-subject">{{$oMessage->getSubject()}}</td>
                  <td class="mailbox-attachment">{{$oMessage->getAttachments()->count() > 0 ? 'yes' : 'no'}}</td>
                  <td class="mailbox-date">{{$oMessage->date}}</td>
                </tr>
                @endforeach
              </tbody>
            </table><!-- /.table -->
          </div><!-- /.mail-box-messages -->
        </div><!-- /.box-body -->
        <div class="box-footer no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
            <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            <div class="btn-group">
              <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div><!-- /.btn-group -->
            <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
              {{$aMessage->links()}}
            </div><!-- /.pull-right -->
          </div>
        </div>
      </div><!-- /. box -->
      
    </div><!-- /.col -->
  </div>
@endsection  