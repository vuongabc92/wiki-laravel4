
@section('title')
    Login
@show

@section('body')

@if(Session::has('authErrors'))
<div class="auth-errors">
    {{ Session::get('authErrors') }}
</div>
@endif

@if(Session::has('authSuccess'))
<div class="auth-success">
    {{ Session::get('authSuccess') }}
</div>
@endif

<div class="container">
    <div class="auth">

        <div class="auth-inside">
            <div class="auth-space">
                <div class="auth-content">
                    <h4 class="auth-welcome"><i class="glyphicon glyphicon-user"></i> Welcome to login!</h4>

                    {{ Form::open(array('method' => 'POST', 'url' => 'admin/auth/login', 'class' => 'auth-form')) }}
                    {{ Form::email('_email', '', array('class' => 'auth-field', 'placeholder' => 'Email')) }}
                    {{ Form::password('_password', array('class' => 'auth-field auth-password', 'placeholder' => 'Password')) }}
                    <span class="auth-remember">
                        <label>
                            {{ Form::checkbox('auth-remember', '1', true, array('class' => 'auth-remember-checkbox')) }}
                            <span class='auth-remember-txt'>Remember login</span>
                        </label>
                    </span>
                    <button type="submit" class="auth-btn">Authenticate</button>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="auth-footer">
                <a class="auth-foot-nav auth-foot-nav-left" href="#">New account</a>
                <a class="auth-foot-nav" href="#">Forgot password?</a>
            </div>
        </div>
    </div>

</div>
@show