
<link href="/css/auth/login.css" rel="stylesheet">

<div id="app">
    <div class="container" id="login-container">
        <div class="login">
            <h1>
                <img src="/images/pi_logo.png">
            </h1>
            <form method="post" action="{{ route('login') }}">
                {{ csrf_field() }}
                <input type="text" name="email" placeholder="Username" required="required" />
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                
                <input type="password" name="password" placeholder="Password" required="required" />
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                <button type="submit" class="btn btn-primary btn-block btn-large">Login</button>
            </form>
        </div>
    </div>
</div>