

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

                    {{ Form::open(array('method' => 'POST', 'url' => url('admin/auth/password/remind'), 'class' => '_fwfl')) }}
                        {{ Form::email('email', '', array('class' => '_fwfl _r3 _ff0 auth-field _mb5', 'placeholder' => 'Email')) }}
                        <button type="submit" class="_fwfl _fc0 _r3 _tw _bgb _fwb _mt5 auth-btn">Get password</button>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="_fwfl auth-footer">
                <a class="_w50 _fl _tb _td_i _tc auth-foot-nav auth-foot-nav-left" href="#">{{ trans('backend::main.auth_login_newacc') }}</a>
                <a class="_w50 _fl _tb _td_i _tc auth-foot-nav" href="{{ url('admin/auth/login') }}">{{ trans('backend::main.auth_login_forgotpass') }}?</a>
            </div>
        </div>
    </div>

</div>
@show


<form action="" method="POST">
    <input type="email" name="email">
    <input type="submit" value="Send Reminder">
</form>