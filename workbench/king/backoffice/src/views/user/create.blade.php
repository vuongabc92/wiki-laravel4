@section('title')
{{ trans('backoffice::backoffice.user_title') }}
@show

@section('breadcrumb')
<li><a href=""><i class="fa fa-dashboard"></i> {{ trans('backoffice::backoffice.dashboard') }}</a></li>
<li class="active">{{ trans('backoffice::backoffice.user') }}</li>
@show

@section('pageinfo')
    <h4 class="admin-page-name">{{ trans('backoffice::backoffice.user_title') }}</h4>
@show

@section('body')

<div class="_fwfl">

    {{ Form::open(array('url' => url('/admin/accounts'), 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <h3 class="_fwfl _tb _fs20 form-title"><i class="glyphicon glyphicon-user"></i> {{ trans('backend::form.accounts_create_formtitle') }}</h3>
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
                {{ Form::text('username', '', array('class' => 'form-control', 'id' => 'username', 'placeholder' => trans('backend::form.accounts_username') )) }}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email <sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::email('email', '', array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email')) }}
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
                
                <a href="{{ url('/admin/accounts') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{ trans('backend::form.back') }}</a>
            </div>
        </div>

    {{ Form::close() }}
</div>
@show