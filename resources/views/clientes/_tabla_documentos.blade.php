<div class="form-group col-md-12">
    <div class="box box-danger">
        <label>Documentos Servidor</label>
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Subido por</th><th>Documentos</th><th>Recibido</th><th>Obligatorio</th><th>Link</th><th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cliente->pivotDocCliente as $doc)
                <tr>
                    <td>{{ $doc->usu_alta->name }}</td>
                    <td>
                        {{$doc->docAlumno->name}}
                    </td>
                    <td>
                        @if($doc->doc_entregado==1)
                        SI
                        @else
                        @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                        <div id='doc_recibido'>
                            <a class="btn btn-warning btn-xs btn_recibir_doc" 
                                data-documento='{{ $doc->id }}'> Recibir
                            </a>
                            <div id="spinner_doc_recibido" style="display:none;">
                                ...guardando
                            </div>
                        </div>
                        @endif
                        @endif
                    </td>
                    <td>
                        @if($doc->docAlumno->doc_obligatorio==1)
                        SI
                        @else
                        NO
                        @endif
                    </td>
                    <td>
                        @if(!is_null($doc->archivo))
                        @php
                            $cadena_img = explode('/', $doc->archivo);
                            $inicio_url=substr($doc->archivo, 0,4);
                        @endphp
                            @if($inicio_url=="http")
                                <a href="{{asset("imagenes/clientes/".$cliente->id."/".end($cadena_img))}}" target="_blank">Ver</a>    
                            @endif
                        
                        @else
                            @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                            <div id="div_archivo{{ $doc->id }}">
                            <div class="btn btn-xs btn-file">
                                <i class="fa fa-paperclip"></i> Adjuntar
                                <input type="file"  id="file{{ $doc->id }}" name="file" class="cliente_archivo" >
                                <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                                <input type="hidden"  id="file_hidden" name="file_hidden" >
                            </div>
                            <button class="btn btn-success btn-xs btn_archivo" id="btn_archivo{{ $doc->id }}"
                                data-doc_id="{{ $doc->doc_alumno_id }}"
                                data-documento='{{ $doc->id }}'> 
                                <span class="glyphicon glyphicon-ok">Max. 200KB</span> 
                            </button>
                            <br/>
                            <div id="texto_notificacion{{ $doc->id }}">

                            </div>
                            </div>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($inicio_url=="http")
                            @if(!is_null($doc->archivo) and ($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados'))) 
                            <a class="btn btn-xs btn-danger" href="{{route('pivotDocClientes.destroy', $doc->id)}}">Eliminar</a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="form-group col-md-12">
    <div class="box box-success">
        <label>Documentos Portal Space</label>
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Subido por</th><th>Documentos</th><th>Recibido</th><th>Obligatorio</th><th>Link</th><th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cliente->pivotDocCliente as $doc)
                <tr>
                    <td>{{ $doc->usu_alta->name }}</td>
                    <td>
                        {{$doc->docAlumno->name}}
                    </td>
                    <td>
                        @if($doc->doc_entregado==1)
                        SI
                        @else
                        @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                        <div id='doc_recibido'>
                            <a class="btn btn-warning btn-xs btn_recibir_doc" 
                                data-documento='{{ $doc->id }}'> Recibir
                            </a>
                            <div id="spinner_doc_recibido" style="display:none;">
                                ...guardando
                            </div>
                        </div>
                        @endif
                        @endif
                    </td>
                    <td>
                        @if($doc->docAlumno->doc_obligatorio==1)
                        SI
                        @else
                        NO
                        @endif
                    </td>
                    <td>
                        @if(!is_null($doc->archivo))
                        @php
                            $cadena_img = explode('/', $doc->archivo);
                            $inicio_url=substr($doc->archivo, 0,4);
                        @endphp
                            @if($inicio_url<>"http")
                                <a href="{{$doc->image_url}}" target="_blank">Ver</a>
                            @endif
                        @else
                            @if($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados')) 
                            <div id="div_archivo_space{{ $doc->id }}">
                                <div class="btn btn-xs btn-file">
                                    <i class="fa fa-paperclip"></i> Seleccionar Archivo
                                    <input type="file"  id="file_space{{ $doc->id }}" name="file" accept=".pdf" class="cliente_archivo" >
                                    <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                                    <input type="hidden"  id="file_hidden" name="file_hidden" >
                                </div>

                                <button class="btn btn-success btn-xs btn_archivo_space" id="btn_archivo{{ $doc->id }}"
                                    data-doc_id="{{ $doc->doc_alumno_id }}"
                                    data-documento='{{ $doc->id }}'> 
                                    <span class="glyphicon glyphicon-ok">Gardar(Max. 200KB)</span> 
                                </button>
                                <br/>
                                <div id="texto_notificacion{{ $doc->id }}">

                                </div>
                            </div>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($inicio_url<>"http")
                            @if(!is_null($doc->archivo) and ($cliente->bnd_doc_oblig_entregados<>1 or Auth::user()->can('clientes.edit_bnd_doc_oblig_entregados'))) 
                            <a class="btn btn-xs btn-danger" href="{{route('pivotDocClientes.destroy', $doc->id)}}">Eliminar</a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>