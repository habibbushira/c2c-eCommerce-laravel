@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card col-sm-8 ml-5">
        <div class="card-header">@lang('register.register_account')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" aria-label="@lang('register.register')">
            @csrf
                <div class="form-group row">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="@lang('register.name')*">

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required placeholder="@lang('register.phone_number')*">

                    @if ($errors->has('phone_number'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="@lang('login.password')*" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('register.confirm_password')*" required>
                </div>  

                <div class="form-group row">
                    <label for="name" class="col-sm-2 control-label col-form-label">Security Question*</label>
                    <div class="col-sm-6">
                       <select name="query" class="select2 form-control custom-select" required>
                            <option value="">--Choose One--</option>
                            @foreach($queries as $query)
                                <option value="{{ $query->id }}">{{ $query->query }}</option>
                            @endforeach
                       </select>
                    </div>
                    <input type="text" name="answer" class="col-sm-3" required placeholder="Write your answer here *" />
                </div>          

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-6">
                        <button type="submit" class="btn primary-color">
                            @lang('register.register')
                        </button>

                        <a class="btn btn-link" href="{{ route('login') }}">
                            @lang('register.already_have_account')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection