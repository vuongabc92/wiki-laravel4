@section('title')
    {{ trans('backend::main.accounts_currentedit_title') }}
@show

@section('breadcrumb')
<li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> {{ trans('backend::main.layouts_master_dashboard') }}</a></li>
<li class="active">{{ trans('backend::main.accounts_currentedit_accinfo') }}</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">{{ trans('backend::main.accounts_currentedit_pagetitle') }}</h4>
@show

@section('body')
<div class="">

    {{ Form::model($user, array('url' => url('/admin/account/current-save'), 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="form-title _tb _fs20"><i class="fa fa-gear"></i> {{ trans('backend::form.accounts_currentedit_formtitle') }}</h3>
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
        <div class="form-group has-error has-feedback">
            <label class="col-sm-2 control-label">{{ trans('backend::form.accounts_role') }}</label>
            <div class="col-sm-9">
                {{ Form::text('role', $user->getRole()->role, array('class' => 'form-control', 'disabled')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="old-password" class="col-sm-2 control-label">Old password</label>
            <div class="col-sm-9">
                {{ Form::password('old_password', array('class' => 'form-control', 'id' => 'old-password', 'placeholder' => 'Old password' )) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">{{ trans('backend::form.accounts_pass') }}</label>
            <div class="col-sm-9">
                {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => trans('backend::form.accounts_pass') )) }}
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirmation" class="col-sm-2 control-label">{{ trans('backend::form.accounts_repass') }}</label>
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
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('backend::form.save') }}</button>
            </div>
        </div>
    {{ Form::close() }}
</div>
@show