@extends('layouts.app')

@section('content')

<section><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                @if(Session::has('message_error')) 
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>{!! session('message_error') !!}</strong>
                    </div>
                @endif

                @if($errors->has('user_name'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! $errors->first('user_name') !!}</strong>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">@lang('login.login')</div>
                    <div class="card-body">
                    
                    <form method="POST" action="{{ route('login') }}" aria-label="@lang('login.login')">
                            @csrf
                    <div class="form-group row">
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-4 col-form-label text-md-right">@lang('login.username')</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('email') ? old('email') : old('phone_number') }}" required autofocus>
                        </div>
                    </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('login.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        @lang('login.remember_me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn primary-color">
                                    @lang('login.login')
                                </button>
                            </div>

                            <div class="col-md-8 offset-md-4">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang('login.forget_password')
                                </a>

                                <a class="btn btn-link" href="{{ route('register') }}">
                                    @lang('login.need_new_account')
                                </a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection