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
                        <h1 style="color: #FDF600;">HERO</h1>
                        <p class="text-muted" style="color: #FDF600 !important;">Register to your account</p>
                        <form method="POST" action="{{ route('register_post') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #FDF600 !important;">
                                        <svg class="c-icon">
                                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="ID" name="username" required autofocus>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #FDF600 !important;">
                                        <svg class="c-icon">
                                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="e-mail" name="email" required autofocus>
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #FDF600 !important;">
                                        <svg class="c-icon">
                                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="password" name="password" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" style="color: #FDF600 !important;" type="submit">Register</button>
                                </div>
                        </form>
                        <div class="col-6 text-right">
                            <a href="{{ route('login') }}" class="btn btn-primary" style="color: #FDF600 !important;">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection