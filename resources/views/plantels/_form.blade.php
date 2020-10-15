<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab1">Plantel</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab2">Documentos</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab3">Parametros</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <fieldset>
                    <div class="box box-default">
                      <div class="box-body"> 
                      <div class="form-group col-md-4 @if($errors->has('cve_plantel')) has-error @endif">
                         <label for="cve_plantel-field">Clave Plantel</label>
                         {!! Form::text("cve_plantel", null, array("class" => "form-control input-sm", "id" => "cve_plantel-field")) !!}
                         @if($errors->has("cve_plantel"))
                          <span class="help-block">{{ $errors->first("cve_plantel") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('tpo_plantel_id')) has-error @endif">
                         <label for="tpo_plantel_id-field">Tipo Plantel</label>
                         {!! Form::select("tpo_plantel_id", $list["TpoPlantel"], null, array("class" => "form-control select_seguridad", "id" => "tpo_plantel_id-field")) !!}
                         @if($errors->has("tpo_plantel_id"))
                          <span class="help-block">{{ $errors->first("tpo_plantel_id") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('razon')) has-error @endif">
                         <label for="razon-field">Razon Social</label>
                         {!! Form::text("razon", null, array("class" => "form-control input-sm", "id" => "razon-field")) !!}
                         @if($errors->has("razon"))
                          <span class="help-block">{{ $errors->first("razon") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('denominacion')) has-error @endif">
                        <label for="denominacion-field">Denominacion</label>
                        {!! Form::text("denominacion", null, array("class" => "form-control input-sm", "id" => "denominacion-field")) !!}
                        @if($errors->has("denominacion"))
                         <span class="help-block">{{ $errors->first("denominacion") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('nombre_corto')) has-error @endif">
                        <label for="nombre_corto-field">Razón Social(Contabilidad)</label>
                        {!! Form::text("nombre_corto", null, array("class" => "form-control input-sm", "id" => "nombre_corto-field")) !!}
                        @if($errors->has("nombre_corto"))
                         <span class="help-block">{{ $errors->first("nombre_corto") }}</span>
                        @endif
                     </div>
                      <div class="form-group col-md-4 @if($errors->has('rfc')) has-error @endif">
                         <label for="rfc-field">RFC</label>
                         {!! Form::text("rfc", null, array("class" => "form-control input-sm", "id" => "rfc-field")) !!}
                         @if($errors->has("rfc"))
                          <span class="help-block">{{ $errors->first("rfc") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('cve_incorporacion')) has-error @endif">
                         <label for="cve_incorporacion-field">Clave Incorporacion</label>
                         {!! Form::text("cve_incorporacion", null, array("class" => "form-control input-sm", "id" => "cve_incorporacion-field")) !!}
                         @if($errors->has("cve_incorporacion"))
                          <span class="help-block">{{ $errors->first("cve_incorporacion") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('rvoe')) has-error @endif">
                         <label for="rvoe-field">Banco y cuenta </label>
                         {!! Form::text("rvoe", null, array("class" => "form-control input-sm", "id" => "cve_incorporacion-field")) !!}
                         @if($errors->has("rvoe"))
                          <span class="help-block">{{ $errors->first("rvoe") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('cct')) has-error @endif">
                         <label for="cct-field">Cuenta CLABE</label>
                         {!! Form::text("cct", null, array("class" => "form-control input-sm", "id" => "cct-field")) !!}
                         @if($errors->has("cct"))
                          <span class="help-block">{{ $errors->first("cct") }}</span>
                         @endif
                      </div>
                      <!--<div class="form-group col-md-4 @if($errors->has('cuenta_contable')) has-error @endif">
                        <label for="cuenta_contable-field">Cuenta Contable</label>
                        {!! Form::text("cuenta_contable", null, array("class" => "form-control input-sm", "id" => "cuenta_contable-field")) !!}
                        @if($errors->has("cuenta_contable"))
                         <span class="help-block">{{ $errors->first("cuenta_contable") }}</span>
                        @endif
                     </div>
                    -->
                    <div class="form-group col-md-4 @if($errors->has('matriz_id')) has-error @endif">
                        <label for="matriz_id-field">Matriz</label>
                        {!! Form::select("matriz_id", $matrices, null, array("class" => "form-control select_seguridad", "id" => "matriz_id-field")) !!}
                        @if($errors->has("matriz_id"))
                         <span class="help-block">{{ $errors->first("matriz_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('cuenta_p_id')) has-error @endif">
                        <label for="cuenta_p_id-field">Cuenta Contable</label>
                        {!! Form::select("cuenta_p_id", $list["CuentaP"], null, array("class" => "form-control select_seguridad", "id" => "cuenta_p_id-field")) !!}
                        @if($errors->has("cuenta_p_id"))
                         <span class="help-block">{{ $errors->first("cuenta_p_id") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('cve_multipagos')) has-error @endif">
                        <label for="cve_multipagos-field">Clave Multipagos</label>
                        {!! Form::text("cve_multipagos", null, array("class" => "form-control input-sm", "id" => "cve_multipagos-field")) !!}
                        @if($errors->has("cve_multipagos"))
                         <span class="help-block">{{ $errors->first("cve_multipagos") }}</span>
                        @endif
                     </div>
                     <div class="form-group col-md-4 @if($errors->has('concepto_multipagos_id')) has-error @endif">
                        <label for="concepto_multipagos_id-field">Conceptos Multipago *<input type="checkbox" id="seleccionar_conceptos">Seleccionar Todo</label>
                        {!! Form::select("concepto_multipagos_id[]", $lista_conceptosMultipago, $plantel->conceptoMultipagos, array("class" => "form-control select_seguridad", "id" => "concepto_multipagos_id-field", 'multiple'=>true)) !!}
                        @if($errors->has("concepto_multipagos_id"))
                          <span class="help-block">{{ $errors->first("concepto_multipagos_id") }}</span>
                        @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('forma_pago_id')) has-error @endif">
                        <label for="forma_pago_id-field">Formas Pago Multipago *<input type="checkbox" id="seleccionar_conceptos">Seleccionar Todo</label>
                        {!! Form::select("forma_pago_id[]", $lista_formaPagos, $plantel->formaPagos, array("class" => "form-control select_seguridad", "id" => "forma_pago_id-field", 'multiple'=>true)) !!}
                        @if($errors->has("forma_pago_id"))
                          <span class="help-block">{{ $errors->first("forma_pago_id") }}</span>
                        @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('regimen_fiscal')) has-error @endif">
                        <label for="regimen_fiscal-field">Régimen Fiscal</label>
                        {!! Form::text("regimen_fiscal", null, array("class" => "form-control input-sm", "id" => "regimen_fiscal-field")) !!}
                        @if($errors->has("regimen_fiscal"))
                          <span class="help-block">{{ $errors->first("regimen_fiscal") }}</span>
                        @endif
                      </div>
                  </div>
                  <div class="box box-default">
                      <div class="box-body">
                      <div class="form-group col-md-4 @if($errors->has('calle')) has-error @endif">
                         <label for="calle-field">Calle</label>
                         {!! Form::text("calle", null, array("class" => "form-control input-sm", "id" => "calle-field")) !!}
                         @if($errors->has("calle"))
                          <span class="help-block">{{ $errors->first("calle") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('no_int')) has-error @endif">
                         <label for="no_int-field">No. int.</label>
                         {!! Form::text("no_int", null, array("class" => "form-control input-sm", "id" => "no_int-field")) !!}
                         @if($errors->has("no_int"))
                          <span class="help-block">{{ $errors->first("no_int") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('no_ext')) has-error @endif">
                         <label for="no_ext-field">No. ext.</label>
                         {!! Form::text("no_ext", null, array("class" => "form-control input-sm", "id" => "no_ext-field")) !!}
                         @if($errors->has("no_ext"))
                          <span class="help-block">{{ $errors->first("no_ext") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('colonia')) has-error @endif">
                         <label for="colonia-field">Colonia</label>
                         {!! Form::text("colonia", null, array("class" => "form-control input-sm", "id" => "colonia-field")) !!}
                         @if($errors->has("colonia"))
                          <span class="help-block">{{ $errors->first("colonia") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('cp')) has-error @endif">
                         <label for="cp-field">C.P.</label>
                         {!! Form::text("cp", null, array("class" => "form-control input-sm", "id" => "cp-field")) !!}
                         @if($errors->has("cp"))
                          <span class="help-block">{{ $errors->first("cp") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('municipio')) has-error @endif">
                         <label for="municipio-field">Municipio</label>
                         {!! Form::text("municipio", null, array("class" => "form-control input-sm", "id" => "municipio-field")) !!}
                         @if($errors->has("municipio"))
                          <span class="help-block">{{ $errors->first("municipo") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('estado')) has-error @endif">
                         <label for="estado-field">Estado</label>
                         {!! Form::text("estado", null, array("class" => "form-control input-sm", "id" => "estado-field")) !!}
                         @if($errors->has("estado"))
                          <span class="help-block">{{ $errors->first("estado") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('estado_id')) has-error @endif">
                         <label for="estado_id-field">Estado</label>
                         {!! Form::select("estado_id", $list["Estado"], null, array("class" => "form-control select_seguridad", "id" => "estado_id-field")) !!}
                         @if($errors->has("estado_id"))
                          <span class="help-block">{{ $errors->first("estado_id") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('tel')) has-error @endif">
                         <label for="tel-field">Teléfono</label>
                         {!! Form::text("tel", null, array("class" => "form-control input-sm", "id" => "tel-field")) !!}
                         @if($errors->has("tel"))
                          <span class="help-block">{{ $errors->first("tel") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('mail')) has-error @endif">
                         <label for="mail-field">Correo Electrónico</label>
                         {!! Form::text("mail", null, array("class" => "form-control input-sm", "id" => "mail-field")) !!}
                         @if($errors->has("mail"))
                          <span class="help-block">{{ $errors->first("mail") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('pag_web')) has-error @endif">
                         <label for="pag_web-field">Página Web</label>
                         {!! Form::text("pag_web", null, array("class" => "form-control input-sm", "id" => "pag_web-field")) !!}
                         @if($errors->has("pag_web"))
                          <span class="help-block">{{ $errors->first("pag_web") }}</span>
                         @endif
                      </div>
                      <div class="form-group col-md-4 @if($errors->has('lectivo_id')) has-error @endif">
                         <label for="lectivo_id-field">Periodo Lectivo</label>
                         {!! Form::select("lectivo_id", $list["Lectivo"], null, array("class" => "form-control select_seguridad", "id" => "lectivo_id-field")) !!}
                         @if($errors->has("lectivo_id"))
                          <span class="help-block">{{ $errors->first("lectivo_id") }}</span>
                         @endif
                      </div>
                      
                      <div class="form-group col-md-4 @if($errors->has('st_plantel_id')) has-error @endif">
                         <label for="st_plantel_id-field">Estatus</label>
                         {!! Form::select("st_plantel_id", $list["StPlantel"], null, array("class" => "form-control select_seguridad", "id" => "st_plantel_id-field")) !!}
                         @if($errors->has("st_plantel_id"))
                          <span class="help-block">{{ $errors->first("st_plantel_id") }}</span>
                         @endif
                      </div>
                    </div>
                  </div>
                    <div class="box box-default" style>
                      <div class="box-body">
                      <div class="form-group col-md-4 @if($errors->has('director_id')) has-error @endif">
                        <label for="director_id-field">Director</label>
                        {!! Form::select("director_id", $directores, null, array("class" => "form-control select_seguridad", "id" => "director_id-field")) !!}
                        @if($errors->has("director_id"))
                         <span class="help-block">{{ $errors->first("director_id") }}</span>
                        @endif
                     </div>
                      <div class="form-group col-md-4 @if($errors->has('responsable_id')) has-error @endif">
                            <label for="responsable_id-field">Responsable</label>
                            {!! Form::select("responsable_id", $responsables, null, array("class" => "form-control select_seguridad", "id" => "responsable_id-field")) !!}
                            @if($errors->has("responsable_id"))
                             <span class="help-block">{{ $errors->first("responsable_id") }}</span>
                            @endif
                         </div>
                      <div class="form-group col-md-4 @if($errors->has('enlace_lugar')) has-error @endif">
                            <label for="enlace_lugar-field">Enlace Lugar</label>
                            {!! Form::text("enlace_lugar", null, array("class" => "form-control input-sm", "id" => "enlace_lugar-field")) !!}
                            @if($errors->has("enlace_lugar"))
                             <span class="help-block">{{ $errors->first("enlace_lugar") }}</span>
                            @endif
                         </div>
                          <div class="form-group col-md-4 @if($errors->has('enlace')) has-error @endif">
                            <label for="enlace-field">Enlace</label>
                            {!! Form::text("enlace", null, array("class" => "form-control input-sm", "id" => "enlace-field")) !!}
                            @if($errors->has("enlace"))
                             <span class="help-block">{{ $errors->first("enlace") }}</span>
                            @endif
                         </div>
                         <div class="form-group col-md-4 @if($errors->has('cve_estatal')) has-error @endif">
                            <label for="cve_estatal-field">Clave Estatal</label>
                            {!! Form::text("cve_estatal", null, array("class" => "form-control input-sm", "id" => "cve_estatal-field")) !!}
                            @if($errors->has("cve_estatal"))
                             <span class="help-block">{{ $errors->first("cve_estatal") }}</span>
                            @endif
                         </div>
                          <div class="form-group col-md-4 @if($errors->has('cve_centro')) has-error @endif">
                            <label for="cve_centro-field">Clave Centro Trabajo</label>
                            {!! Form::text("cve_centro", null, array("class" => "form-control input-sm", "id" => "cve_centro-field")) !!}
                            @if($errors->has("cve_centro"))
                             <span class="help-block">{{ $errors->first("cve_centro") }}</span>
                            @endif
                         </div>
                    </div>
                    </div>
                    
                    <div class="form-group col-md-4 @if($errors->has('logo')) has-error @endif">
                       <label for="logo-field">Logo</label>
                       {!! Form::text("logo", null, array("class" => "form-control input-sm", "id" => "logo-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('logo_file') !!}
                       @if (isset($plantel))
                       <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->logo) !!}" alt="Logo" height="100"> </img>
                       @endif
                       @if($errors->has("logo"))
                        <span class="help-block">{{ $errors->first("logo") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('slogan')) has-error @endif">
                       <label for="slogan-field">Slogan</label>
                       {!! Form::text("slogan", null, array("class" => "form-control input-sm", "id" => "slogan-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('slogan_file') !!}
                       @if (isset($plantel))
                       <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->slogan) !!}" alt="Logo" height="100"> </img>
                       @endif
                       @if($errors->has("slogan"))
                        <span class="help-block">{{ $errors->first("slogan") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('membrete')) has-error @endif">
                       <label for="membrete-field">Membrete</label>
                       {!! Form::text("membrete", null, array("class" => "form-control input-sm", "id" => "membrete-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('membrete_file') !!}
                       @if (isset($plantel))
                       <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->membrete) !!}" alt="Logo" height="100"> </img>
                       @endif
                       @if($errors->has("membrete"))
                        <span class="help-block">{{ $errors->first("membrete") }}</span>
                       @endif
                    </div>
                    <div class="form-group col-md-4 @if($errors->has('img_firma')) has-error @endif">
                       <label for="img_firma-field">Firma</label>
                       {!! Form::text("img_firma", null, array("class" => "form-control input-sm", "id" => "membrete-field", 'readonly'=>'readonly')) !!}
                       {!! Form::file('img_firma_file') !!}
                       @if (isset($plantel))
                       <img src="{!! asset('imagenes/planteles/'.$plantel->id.'/'.$plantel->img_firma) !!}" alt="Logo" height="100"> </img>
                       @endif
                       @if($errors->has("img_firma"))
                        <span class="help-block">{{ $errors->first("img_firma") }}</span>
                       @endif
                    </div>
            </fieldset> 
        </div>
        <div id="tab2" class="tab-pane">
            @if(isset($plantel))
            <fieldset>
                <div class="form-group col-md-4 @if($errors->has('doc_plantel_id')) has-error @endif">
                    <label for="doc_plantel_id-field">Documento</label>
                    {!! Form::select("doc_plantel_id", $list1["DocPlantel"], null, array("class" => "form-control select_seguridad", "id" => "doc_plantel_id-field", 'style'=>'width:100%')) !!}
                    @if($errors->has("doc_plantel_id"))
                    <span class="help-block">{{ $errors->first("doc_plantel_id") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fec_vigencia')) has-error @endif">
                    <label for="fec_vigencia-field">Fecha Vigencia</label>
                    {!! Form::text("fec_vigencia", null, array("class" => "form-control input-sm", "id" => "fec_vigencia-field")) !!}
                    @if($errors->has("fec_vigencia"))
                    <span class="help-block">{{ $errors->first("fec_vigencia") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Adjuntar Archivo
                            <input type="file"  id="file" name="file" class="cliente_archivo" >
                            <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 
                            <input type="hidden"  id="file_hidden" name="file_hidden" >
                        </div>
                        <button class="btn btn-success btn-xs" id="btn_archivo"> <span class="glyphicon glyphicon-ok">Cargar</span> </btn>
                        <br/>
                        <p class="help-block"  >Max. 20MB</p>
                        <div id="texto_notificacion">
                        </div>
                </div>
                <div class="form-group col-md-6">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Documento Agregados</th><th>Link</th><th>Vigencia</th><th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plantel->docPlantelPlantels as $doc)
                                <tr>
                                    <td>
                                        {{$doc->docPlantel->name}}
                                    </td>
                                    <td>
                                        <a href="{{ asset('/imagenes/plantels/'.$plantel->id."/".$doc->archivo) }}" target="_blank">Ver</a>
                                    </td>
                                    <td>
                                        {{$doc->fec_vigencia}}
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-danger" href="{{url('docPlantelPlantels/destroy', $doc->id)}}">Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-6">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Documentos Faltantes</th><th>Obligatorio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentos_faltantes as $df)
                                <tr>
                                    <td>
                                        {{ $df->name }}
                                    </td>
                                    <td>
                                        @if($df->bnd_obligatorio == 1)
                                        <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></button>
                                        @else
                                        <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                                        

                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </fieldset>
            @endif
            
            
        </div>

        <div id="tab3" class="tab-pane">
            @if(isset($plantel))
            <fieldset>
                <div class="form-group col-md-4 @if($errors->has('cns_empleado')) has-error @endif">
                    <label for="cns_empleado-field">Consecutivo Empleado</label>
                    {!! Form::text("cns_empleado", null, array("class" => "form-control input-sm", "id" => "cns_empleado-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("cns_empleado"))
                     <span class="help-block">{{ $errors->first("cns_empleado") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-4 @if($errors->has('cns_alumno')) has-error @endif">
                    <label for="cns_alumno-field">Consecutivo Alumno</label>
                    {!! Form::text("cns_alumno", null, array("class" => "form-control input-sm", "id" => "cns_alumno-field", 'readonly'=>'readonly')) !!}
                    @if($errors->has("cns_alumno"))
                     <span class="help-block">{{ $errors->first("cns_alumno") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-4 @if($errors->has('consecutivo')) has-error @endif">
                    <label for="consecutivo-field">Consecutivo Ticket</label>
                    {!! Form::text("consecutivo", null, array("class" => "form-control input-sm", "id" => "consecutivo-field")) !!}
                    @if($errors->has("consecutivo"))
                     <span class="help-block">{{ $errors->first("consecutivo") }}</span>
                    @endif
                 </div>    
                 <div class="form-group col-md-4 @if($errors->has('consecutivo_pago')) has-error @endif">
                    <label for="consecutivo_pago-field">Consecutivo Pago</label>
                    {!! Form::text("consecutivo_pago", null, array("class" => "form-control input-sm", "id" => "consecutivo_pago-field")) !!}
                    @if($errors->has("consecutivo_pago"))
                     <span class="help-block">{{ $errors->first("consecutivo") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-4 @if($errors->has('cve_vinculacion')) has-error @endif">
                    <label for="cve_vinculacion-field">Clave Vinculacion</label>
                    {!! Form::text("cve_vinculacion", null, array("class" => "form-control input-sm", "id" => "cve_vinculacion-field")) !!}
                    @if($errors->has("cve_vinculacion"))
                     <span class="help-block">{{ $errors->first("cve_vinculacion") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-4 @if($errors->has('csc_vinculacion')) has-error @endif">
                    <label for="csc_vinculacion-field">Consecutivo Vinculacion</label>
                    {!! Form::text("csc_vinculacion", null, array("class" => "form-control input-sm", "id" => "csc_vinculacion-field")) !!}
                    @if($errors->has("csc_vinculacion"))
                     <span class="help-block">{{ $errors->first("csc_vinculacion") }}</span>
                    @endif
                 </div>
                 <div class="form-group col-md-4 @if($errors->has('meta_venta')) has-error @endif" style="clear:left;">
                    <label for="meta_venta-field">Meta Total Empleado</label>
                    {!! Form::text("meta_venta", null, array("class" => "form-control input-sm", "id" => "meta_venta-field")) !!}
                    @if($errors->has("meta_venta"))
                    <span class="help-block">{{ $errors->first("meta_venta") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('meta_total')) has-error @endif">
                    <label for="meta_total-field">Meta Total</label>
                    {!! Form::text("meta_total", null, array("class" => "form-control input-sm", "id" => "meta_total-field")) !!}
                    @if($errors->has("meta_total"))
                    <span class="help-block">{{ $errors->first("meta_total") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fcuenta')) has-error @endif">
                    <label for="fcuenta-field">Cuenta Facturacion</label>
                    {!! Form::text("fcuenta", null, array("class" => "form-control input-sm", "id" => "fcuenta-field")) !!}
                    @if($errors->has("meta_total"))
                    <span class="help-block">{{ $errors->first("fcuenta") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fusuario')) has-error @endif">
                    <label for="fusuario-field">Usuario Facturacion</label>
                    {!! Form::text("fusuario", null, array("class" => "form-control input-sm", "id" => "fusuario-field")) !!}
                    @if($errors->has("fusuario"))
                    <span class="help-block">{{ $errors->first("fusuario") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('fpassword')) has-error @endif">
                    <label for="fpassword-field">Password Facturación</label>
                    {!! Form::text("fpassword", null, array("class" => "form-control input-sm", "id" => "fpassword-field")) !!}
                    @if($errors->has("fpassword"))
                    <span class="help-block">{{ $errors->first("fpassword") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('serie_factura')) has-error @endif">
                    <label for="serie_factura-field">Serie Factura</label>
                    {!! Form::text("serie_factura", null, array("class" => "form-control input-sm", "id" => "serie_factura-field")) !!}
                    @if($errors->has("serie_factura"))
                    <span class="help-block">{{ $errors->first("serie_factura") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4 @if($errors->has('folio_facturados')) has-error @endif">
                    <label for="folio_facturados-field">Folio Factura</label>
                    {!! Form::text("folio_facturados", null, array("class" => "form-control input-sm", "id" => "folio_facturados-field")) !!}
                    @if($errors->has("folio_facturados"))
                    <span class="help-block">{{ $errors->first("folio_facturados") }}</span>
                    @endif
                </div>
                
            </fieldset>
            <div class="box box-default">
                <div class="box-body">
                
                <div class="form-group col-md-12 @if($errors->has('clausulas_cotizacion')) has-error @endif">
                   <label for="clausulas_cotizacion-field">Clausulas Cotizacion</label>
                   {!! Form::textArea("clausulas_cotizacion", null, array("class" => "form-control input-sm", "id" => "clausulas_cotizacion-field", 'rows'=>5)) !!}
                   @if($errors->has("clausulas_cotizacion"))
                    <span class="help-block">{{ $errors->first('clausulas_cotizacion') }}</span>
                   @endif
                </div>      
                </div>
                
            </div>
            @endif
            
            
        </div>
    </div>
@push('scripts')
<!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        // Replace the <textarea id="detalle-field"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('clausulas_cotizacion-field');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    $('#fec_vigencia-field').Zebra_DatePicker({
                        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                                months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                readonly_element: false,
                                lang_clear_date: 'Limpiar',
                                show_select_today: 'Hoy',
                        });
                        
    $(document).on("click", "#btn_archivo", function (e) {
        e.preventDefault();
        if($('#doc_plantel_id-field option:selected').val()==0){
            alert("Elegir Documento para Cargar");
        }
        var miurl = "{{route('plantels.cargarImg')}}";
        // var fileup=$("#file").val();
        var divresul = "texto_notificacion";

        var data = new FormData();
        data.append('file', $('#file')[0].files[0]);
        data.append('doc_plantel_id', $('#doc_plantel_id-field option:selected').val());
        data.append('fec_vigencia', $('#fec_vigencia-field').val());
        @if(isset($plantel))
            data.append('plantel', {{$plantel->id}});
        @endif

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
            //dataType: "json",
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function () {
                $("#" + divresul + "").html($("#cargador_empresa").html());
            },
            //una vez finalizado correctamente
            success: function (data) {
                if (confirm('¿Deseas Actualizar la Página?')){
                    location.reload();
                }

            },
            //si ha ocurrido un error
            error: function (data) {


            }
        });
    })
    $(document).ready(function() {
  $('#seleccionar_conceptos').change(function(){
    if( $(this).is(':checked') ) {
      $("#concepto_multipagos_id-field > option").prop("selected","selected");
            $("#concepto_multipagos_id-field").trigger("change");
    }else{
      $("#concepto_multipagos_id-field > option").prop("selected","selected");
            $('#concepto_multipagos_id-field').val(null).trigger('change');
    }
  });
});
    </script>
@endpush
