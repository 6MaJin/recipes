@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">

        <div class="row justify-content-center card">
            <div id="reg" class="card-header logo text-center"><img class="img-fluid" src="/img/visika2.png" alt=""></div>
            <div id="reg" class="card-body justify-content-center text-center">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @guest
                    @if (Route::has('login'))
                        <div class=" nav-item justify-content-center">
                            <a class="btn btn-success nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </div>
                    @endif

                    @if (Route::has('register'))
                        <div class="nav-item justify-content-center mt-3">
                            <a class="btn btn-success nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
@endsection
