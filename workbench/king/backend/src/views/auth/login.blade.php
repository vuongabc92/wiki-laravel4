
@section('title')
    Login
@show

@section('body')

<div class="container">
    <div class="auth">

        <div class="_fwfl _bgw _r3 _sd auth-inside">
            <div class="auth-space">
                <div class="auth-content">
                    <h4 class="_fwfl _tb auth-welcome"><i class="glyphicon glyphicon-user"></i> {{ trans('backend::main.auth_login_welcome') }}!</h4>

                    {{ Form::open(array('method' => 'POST', 'url' => 'admin/auth/login', 'class' => '_fwfl')) }}
                    {{ Form::email('_email', '', array('class' => '_fwfl _r3 _ff0 auth-field', 'placeholder' => 'Email')) }}
                    {{ Form::password('_password', array('class' => '_fwfl _r3 _ff0 auth-field auth-password', 'placeholder' => trans('backend::form.auth_login_pass'))) }}
                    <span class="_fwfl auth-remember">
                        <label>
                            {{ Form::checkbox('auth-remember', '1', true, array('class' => '_fl _fc0 auth-remember-checkbox')) }}
                            <span class='_fl _tb auth-remember-txt'>{{ trans('backend::main.auth_login_remember') }}</span>
                        </label>
                    </span>
                    <button type="submit" class="_fwfl _fc0 _r3 _tw _bgb _fwb auth-btn">{{ trans('backend::main.auth_login_authenticate') }}</button>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="_fwfl auth-footer">
                <a class="_w50 _fl _tb _td_i _tc auth-foot-nav auth-foot-nav-left" href="#">{{ trans('backend::main.auth_login_newacc') }}</a>
                <a class="_w50 _fl _tb _td_i _tc auth-foot-nav" href="#">{{ trans('backend::main.auth_login_forgotpass') }}?</a>
            </div>
        </div>
    </div>

</div>
@show