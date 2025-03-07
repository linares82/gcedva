<div class="form-group col-md-4 @if($errors->has('name')) has-error @endif">
      <label for="name-field">Jornada</label>
      {!! Form::text("name", null, array("class" => "form-control input-sm", "id" => "name-field")) !!}
      @if($errors->has("name"))
      <span class="help-block">{{ $errors->first("name") }}</span>
      @endif
   </div>
@if(isset($jornada))
<div class="row">
</div>
<h3>Definir el horario para cada dia de la jornada</h3>
   <hr/>
<div class="form-group col-md-4 @if($errors->has('dia_id')) has-error @endif">
   <label for="dia_id-field">Dia</label>
   {!! Form::select("dia_id", $dias, null, array("class" => "form-control select_seguridad", "id" => "dia_id-field")) !!}
   @if($errors->has("dia_id"))
   <span class="help-block">{{ $errors->first("dia_id") }}</span>
   @endif
</div>
   <div class="form-group col-md-4 @if($errors->has('h_inicio')) has-error @endif">
   <label for="h_inicio-field">H. Inicio (24 hrs 00:00:00)</label>
   <div class="input-group bootstrap-timepicker timepicker">
      {!! Form::text("h_inicio", null, array("class" => "form-control input-sm timepicker", "id" => "h_inicio-field")) !!}
      <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
      </div><!-- /.input group -->
   
   @if($errors->has("h_inicio"))
      <span class="help-block">{{ $errors->first("h_inicio") }}</span>
   @endif
</div>

<div class="form-group col-md-4 @if($errors->has('h_fin')) has-error @endif">
   <label for="h_fin-field">H. Fin (24 hrs 00:00:00)</label>
   <div class="input-group bootstrap-timepicker timepicker">
      {!! Form::text("h_fin", null, array("class" => "form-control input-sm timepicker", "id" => "h_fin-field")) !!}
      <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
      </div><!-- /.input group -->
   
   @if($errors->has("h_fin"))
      <span class="help-block">{{ $errors->first("h_fin") }}</span>
   @endif
</div>
<table class="table table-condensed table-striped">
   <thead>
      <th>Dia</th>
      <th>H. Inicio</th>
      <th>H. Fin</th>
      <th></th>
   </thead>
   <tbody>
      
      @foreach($jornada->scholarDays as $day)
      <tr>
         <td>{{$day->dia->name}}</td>
         <td>{{$day->h_inicio}}</td>
         <td>{{$day->h_fin}}</td>
         <td></td>
      </tr>
      @endforeach
   </tbody>
</table>
@endif
@push('scripts')
<script>
   $('.timepicker').timepicker(
      {
         minuteStep: 1,
         showSeconds: true,
         showMeridian: false,
         defaultTime: false
      }
   );
</script>

@endpush