@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('message'))                        
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! session('message') !!}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header">Complete the security test</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="@lang('password.reset_password')">
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
                            <input id="email" type="phone_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required placeholder="@lang('register.phone_number')*">

                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 control-label col-form-label">Security Question*</label>
                            <div class="col-sm-6">
                               <select name="query" class="select2 form-control custom-select" required>
                                    <option value="">--Choose One--</option>
                                    @foreach($queries as $query)
                                        <option value="{{ $query->id }}" {{ $query->id == old('query') ? 'selected' : '' }}>{{ $query->query }}</option>
                                    @endforeach
                               </select>
                            </div>
                            <input type="text" name="answer" class="col-sm-3" required placeholder="Write your answer here *"  value="{{ old('answer') }}"/>
                        </div> 

                        <div class="form-group row mb-0">
                            <div class="offset-md-8">
                                <button type="submit" class="btn primary-color">
                                    @lang('password.sent_password_reset_link')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
