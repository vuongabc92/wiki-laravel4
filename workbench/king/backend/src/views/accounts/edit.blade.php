@section('title')
    {{ trans('backend::main.accounts_edit_title') }}
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> {{ trans('backend::main.layouts_master_dashboard') }}</a></li>
<li><a href="{{ url('/admin/accounts') }}">{{ trans('backend::main.accounts_index_acc') }}</a></li>
<li class="active">{{ trans('backend::main.accounts_edit_editacc') }}</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">{{ trans('backend::main.accounts_edit_title') }}</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::model($user, array('url' => url('/admin/accounts/' . $user->id), 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="glyphicon glyphicon-user"></i> {{ trans('backend::form.accounts_edit_formtitle') }}</h3>
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
            <label for="username" class="col-sm-2 control-label">{{ trans('backend::form.accounts_username') }} <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::text('username', null, array('class' => 'form-control', 'id' => 'username', 'placeholder' => trans('backend::form.accounts_username'))) }}
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
                        {{ Form::checkbox('is_active', 1) }} {{ trans('backend::form.isactive') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('backend::form.accounts_role') }} <sup class="text-danger">*</sup></label>
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
            <label for="password" class="col-sm-2 control-label">{{ trans('backend::form.accounts_pass') }} <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => trans('backend::form.accounts_pass'))) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirmation" class="col-sm-2 control-label">{{ trans('backend::form.accounts_repass') }} <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'password-confirmation', 'placeholder' => trans('backend::form.accounts_passconfirm'))) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <sup class="text-danger">*</sup> {{ trans('backend::form.required') }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                @if(count($roles) > 0)
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('backend::form.save') }}</button>
                @else
                    <button type="button" class="btn btn-danger disabled"><i class="fa fa-remove"></i> {{ trans('backend::form.accounts_cannotsave') }}</button>
                @endif
                <a href="{{ url('/admin/accounts') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{ trans('backend::form.back') }}</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show