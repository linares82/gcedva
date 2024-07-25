@php
    //dd($errors);
@endphp
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-md-4 form-group">
    <label for="name">Nombre</label>
    <input type="name" class="form-control" id="name" placeholder="Nombre" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $model->name }}">
</div>
<div class="col-md-4 form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ (Session::has('errors')) ? old('email', '') : $model->email }}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    @if(session('validaEmail'))
    <p class="help-block">{{session('validaEmail')}}</p>
    @endif
    
</div>
<div class="col-md-4 form-group">
    <label for="password">Password</label>
    <input type="text" class="form-control" id="password" placeholder="Password" name="password">
    @if(Route::currentRouteName() == 'usuariosF.edit')
        <div class="alert alert-info">
          <span class="fa fa-info-circle"></span> Leave the password field blank if you wish to keep it the same.
        </div>
    @endif
</div>

<div class="row"></div>

<div class="form-group">
    <label for="roles">Roles</label>
    <select name="roles[]" id="roles" multiple class="select_seguridad form-control">
        @foreach($roles as $index => $role)
            <option value="{{ $index }}" {{ ((in_array($index, old('roles', []))) || ( ! Session::has('errors') && $model->roles->contains('id', $index))) ? 'selected' : '' }}>{{ $role }}</option>
        @endforeach
    </select>
</div>