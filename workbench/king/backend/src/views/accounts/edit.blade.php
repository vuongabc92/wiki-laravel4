@section('title')
    Edit account
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="{{ url('/admin/accounts') }}">accounts</a></li>
<li class="active">edit account</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">Edit account</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($user, array('url' => url('/admin/accounts/' . $user->id), 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="glyphicon glyphicon-user"></i> Edit account</h3>
            </div>
        </div>
        @if(count($errors) > 0)
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{HTML::ul($errors->all())}}
                </div>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('username', null, array('class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label class="_tb">
                        {{ Form::checkbox('is_active', 1) }} Active this account
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Role <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                @if(count($roles) > 0)
                    @define $listRole = array()
                    @foreach($roles as $role)
                        @define $listRole[$role->id] = $role->role
                    @endforeach
                    {{ Form::select('role', $listRole, $user->role_id, array('class' => 'form-control')) }}
                @else
                    <span class="_fwfl _mt5">
                        <span class="label label-danger">NO-ROLES-AVAILABLE</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirmation" class="col-sm-2 control-label">Repassword <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password-confirmation', 'placeholder' => 'Password confirmation')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <sup class="text-danger">*</sup> mean the field must be filled or selected.
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                @if(count($roles) > 0)
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                @else
                    <button type="button" class="btn btn-danger disabled"><i class="fa fa-remove"></i> You can not save due to no roles available</button>
                @endif
                <a href="{{ url('/admin/accounts') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show