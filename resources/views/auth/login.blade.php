@extends('auth.authbase')

@section('head')

<style type="text/css">
    .container {
        max-width: 600px;
    }
</style>
<script src="{{ asset('js/login.js') }}"></script>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4" style="background-color: #2475C0;">
                    <div class="card-body">
                        <h1 style="color: #FDF600; text-align: center;">HERO</h1>
                        <p class="text-muted" style="color: #FDF600 !important; text-align: center;">用户账号登录</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #FDF600 !important;">
                                        <svg class="c-icon">
                                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="账号" name="username" required autofocus>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #FDF600 !important;">
                                        <svg class="c-icon">
                                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="密码" name="password" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" style="color: white;" for="remember">
                                            记住密码
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div style="display:flex;">
                                <button class="btn btn-primary px-4" style="color: #FDF600 !important; margin:auto;" type="submit">登录</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection