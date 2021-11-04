@extends('layouts.app')

@section('content')

<div class="container">
	@if(Session::has('message'))                        
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('message') !!}</strong>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('register.register2')</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register2') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.country')</label>

                            <div class="col-md-6">
                                <input type="text" value="Ethiopia" name="country" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.region')</label>

                            <div class="col-md-6">
                                <select name="region" required class="form-control" >
                                	<option>-- Select One--</option>
                                	<option value="Addis Ababa"> Addis Ababa </option>
                                	<option value="Diredewa"> Diredewa </option>
                                	<option value="Tigray"> Tigray </option>
                                	<option value="Afar"> Afar </option>
                                	<option value="Amhara"> Amhara </option>
                                	<option value="Oromia"> Oromia </option>
                                	<option value="Benshangul"> Benshangul </option>
                                	<option value="Harari"> Harari </option>
                                	<option value="Somalia"> Somalia </option>
                                	<option value="Gambella"> Gambella </option>
                                	<option value="South Nations"> South Nations </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.city')</label>

                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.address1')</label>

                            <div class="col-md-6">
                                <input type="text" name="address1" class="form-control" />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.address2')</label>

                            <div class="col-md-6">
                                <input type="text" name="address2" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn primary-color">
                                    @lang('register.finish_register')
                                </button>
                                <br /><br />
                                <a href="/">@lang('register.skip_for_now')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection