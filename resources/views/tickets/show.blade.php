@extends('plantillas.admin_template')

@include('tickets._common')

@section('header')

    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li><a href="{{ route('tickets.index') }}">@yield('ticketsAppTitle')</a></li>
        <li class="active">{{ $ticket->name }}</li>
    </ol>


    <div class="page-header">
        <h1>@yield('ticketsAppTitle') / Mostrar {{ $ticket->id }}

            {!! Form::model($ticket, [
            'route' => ['tickets.destroy', $ticket->id],
            'method' => 'delete',
            'style' => 'display: inline;',
            'onsubmit' => "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false
            };",
            ]) !!}
            <div class="btn-group pull-right" role="group" aria-label="...">
                @permission('ticket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('tickets.edit', $ticket->id) }}"><i
                            class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ticket.destroy')
                        <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i>
                            < /button>
                                @endpermission
                    </div>
                    {!! Form::close() !!}

                </h1>
            </div>
        @endsection

        @section('content')
            @if (isset($message) and $message != '0')
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ $message }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">

                <div class="col-md-8">
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nome">ID:</label>
                                    {{ $ticket->id }}
                                </div>
                                <div class="form-group">
                                    <label for="categoria_ticket_name">CATEGORIA:</label>
                                    {{ $ticket->categoriaTicket->name }}
                                </div>
                                <div class="form-group">
                                    <label for="detalle">NOMBRE CORTO:</label>
                                    <p class="form-control-static">{{ $ticket->nombre_corto }}</p>
                                </div>

                                <div class="form-group">
                                    <label for="fecha">FECHA:</label>
                                    {{ $ticket->fecha }}
                                </div>
                                <div class="form-group">
                                    <label for="asignado_a">ASIGNADO A:</label>
                                    {{ $ticket->asignado_a }}
                                </div>
                                <div class="form-group">
                                    <label for="st_ticket_name">ESTATUS:</label>
                                    {{ $ticket->stTicket->name }}
                                </div>

                            </div>
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label for="detalle">DETALLE:</label>
                                    {{ $ticket->detalle }}
                                </div>
                                <div class="form-group">
                                    <label for="etiquetas">Etiquetas:</label>
                                    @foreach ($ticket->etiquetas as $etiqueta)
                                        <span class="badge bg-blue">{{ $etiqueta->name }}</span>

                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="usu_alta_id">ALTA:</label>
                                    {{ $ticket->usu_alta->name }}
                                </div>
                                <div class="form-group">
                                    <label for="usu_mod_id">U. MODIFICACION:</label>
                                    {{ $ticket->usu_mod->name }}
                                </div>

                                <div class="row"></div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                                    <a class="btn btn-success btn-xs" href="{{ route('tickets.edit', $ticket->id) }}">Editar</a>
                                    <div class="form-group col-md-4">
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> Adjuntar Archivo
                                            <input type="file" id="file1" name="file1" class="email_archivo"
                                                data-class_resultado="texto_notificacion1">
                                        </div>
                                        <p class="help-block">Solo jpg</p>
                                        <div id="texto_notificacion1">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">


                    <div class="form-group">
                        <a class="btn btn-success btn-xs"
                            href="{{ route('avancesTickets.create', ['ticket' => $ticket->id]) }}">Crear Comentario</a>
                    </div>
                    <div class="row">
                    </div>

                    <ul class="timeline">
                        <!-- timeline time label -->
                        @foreach ($ticket->avancesTickets as $avance)
                            <li class="time-label">
                                <span class="bg-purple">
                                    {{ $avance->created_at }}
                                </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header"><strong>{{ $avance->usu_alta->name }}</strong> -
                                        @if ($avance->bnd_notificacion == 1)
                                            Notificacion
                                        @else
                                            Nota
                                        @endif
                                    </h3>
                                    <div class="timeline-body">
                                        {{ $avance->detalle }}
                                    </div>
                                    <div class="timeline-footer">
                                        @if ($avance->bnd_notificacion == 0)
                                            <a class="btn btn-primary btn-xs"
                                                href="{{ route('avancesTickets.edit', $avance->id) }}">Editar</a>
                                        @else
                                            <a class="btn btn-primary btn-xs"
                                                href="{{ route('avancesTickets.toTelegram', [$avance->usu_alta_id, $avance->asignado_a, $avance->id]) }}">Reenviar</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        <!-- END timeline item -->
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>



                </div>
                <div class="row">
                    <div style="display: none;" id="cargador_empresa" align="center">
                        <br>
                        <label style="color:#FFF; background-color:#ABB6BA; text-align:center">&nbsp;&nbsp;&nbsp;Espere... &nbsp;&nbsp;&nbsp;</label>
                    
                        <img src="{{asset('images/ajax-loader.gif')}}" align="middle" alt="cargador"> &nbsp;<label style="color:#ABB6BA">Realizando envio ...</label>
                    
                        <br>
                        <hr style="color:#003" width="50%">
                        <br>
                    </div>
                </div>

                <a class="btn btn-link" href="{{ route('tickets.index') }}"><i class="glyphicon glyphicon-backward"></i>
                    Lista</a>
            @endsection

            @push('scripts')


                <script>
                    $(document).on("change", ".email_archivo", function(e) {

                        var miurl = '{{ url('/tickets/carga_archivo_correo') }}';
                        // var fileup=$("#file").val();
                        var divresul = $(this).data('class_resultado');

                        var data = new FormData();
                        //console.log($(this)[0].files[0]);
                        data.append('file1', $(this)[0].files[0]);
                        /*data.append('file1', $('#file1')[0].files[0]);
                            data.append('file2', $('#file2')[0].files[0]);
                            data.append('file3', $('#file3')[0].files[0]);
                    */
                        //console.log(data);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('#_token').val()
                            }
                        });
                        $.ajax({
                            url: miurl,
                            type: 'POST',

                            // Form data
                            //datos del formulario
                            data: data,
                            //necesario para subir archivos via ajax
                            cache: false,
                            contentType: false,
                            processData: false,
                            //mientras enviamos el archivo
                            beforeSend: function() {
                                $("#" + divresul + "").html($("#cargador_empresa").html());
                            },
                            //una vez finalizado correctamente
                            success: function(data) {

                                var codigo =
                                    '<div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>' +
                                    data + '</a><span class="mailbox-attachment-size"> </span></div>';
                                $("#" + divresul + "").html(codigo);

                            },
                            complete:function(data){
                                console.log(data);
                            },
                            //si ha ocurrido un error
                            error: function(data) {
                                $("#" + divresul + "").html(data);

                            }
                        });

                    })

                </script>
            @endpush
