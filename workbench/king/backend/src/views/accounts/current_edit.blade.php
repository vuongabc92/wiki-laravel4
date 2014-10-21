@section('title')
    Account setting
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active">account</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Account info</h4>
@show

@section('body')
<div class="">

    {{ Form::model($user, array('url' => url('/admin/account/current-save'), 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="form-title"><i class="glyphicon glyphicon-user"></i> Change your account info</h3>
            </div>
        </div>
        @if(count($errors) > 0)
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="alert alert-danger">
                    {{HTML::ul($errors->all())}}
                </div>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-9">
                {{ Form::text('username', null, array('class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-9">
                {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email')) }}
            </div>
        </div>
        <div class="form-group has-error has-feedback">
            <label class="col-sm-2 control-label">Role</label>
            <div class="col-sm-9">
                {{ Form::text('role', $user->role->role, array('class' => 'form-control', 'disabled')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-9">
                {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirmation" class="col-sm-2 control-label">Password 2</label>
            <div class="col-sm-9">
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password-confirmation', 'placeholder' => 'Password confirmation')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    {{ Form::close() }}
</div>
@show