<!-- cush dox shop all view best -->
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
        @if(Session::has('message'))                        
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! session('message') !!}</strong>
            </div>
        @endif
        @if (sizeof($errors) != 0)
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>There are {{ sizeof($errors) }} errors, please check the fields</strong>
            </div>
        @endif

        <div class="card">
            <div class="card-header">@lang('header.account_setting')</div>

            <div class="card-body">

            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/settings/account') }}">
            	{{ csrf_field() }}
                            
                <div class="form-group row">
                    <label for="password" class="col-sm-3 text-right control-label col-form-label">@lang('login.password')*</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="@lang('profile.current_password')" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="newpassword" class="col-sm-3 text-right control-label col-form-label">@lang('profile.new_password')*</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="@lang('profile.new_password_here')" required>
                        @if ($errors->has('newpassword'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('newpassword')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="confirm_password" class="col-sm-3 text-right control-label col-form-label">@lang('register.confirm_password')*</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="newpassword_confirmation" id="confirm_password" placeholder="@lang('profile.confirm_password')" required>
                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body">
                        <div class="col-md-12 offset-md-10">
                            <button type="submit" class="btn primary-color">@lang('profile.change_password')</button>
                        </div>
                    </div>
                </div>

            </form>
            
            </div>
        </div>        
    </div>
    
    </div>
</div>

</section>
@endsection