<!-- cush dox shop all view best -->
@extends('layouts.app')

@section('content')

<section><!--form-->

<div class="container">            
                        
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
        <div class="card-header">@lang('profile.edit_title')</div>

        <div class="card-body">

        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/settings/user_profile') }}">
        	{{ csrf_field() }}

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">@lang('register.name')*</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ? old('name') : Auth::user()->name}}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name').' | '.Auth::user()->name }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="code" class="col-sm-3 text-right control-label col-form-label">@lang('register.phone_number')*</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : Auth::user()->phone_number}}" required>
                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_number').' | '.Auth::user()->phone_number }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-sm-3 text-right control-label col-form-label">@lang('register.email')</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" value="{{ old('email') ? old('email') : Auth::user()->email}}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email').' | '.Auth::user()->email }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-sm-3 text-right control-label col-form-label">@lang('profile.image')</label>
                                
                        <div class="col-md-9">
                        
                        <div>
                        
                        <input type="file" id="image" name="image"> 
                        
                        @if ($errors->has('image'))
                        
                        <span class="invalid-feedback" role="alert">
                        
                        <strong>{{ $errors->first('image') }}</strong>
                        
                        </span>
                        
                        @endif       
                        
                        </div>  

                        <img style="width:50%" src="{{ asset('storage/users/large/'.Auth::user()->profile)}}"/>
                    </div>
                    </div>
                </div>

                <div class="col-sm-6">
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
                                <option value="Addis Ababa" {{ strcmp(Auth::user()->region, 'Addis Ababa') == 0 ? 'selected' : ''}}> Addis Ababa </option>
                                <option value="Diredewa" {{ strcmp(Auth::user()->region, 'Diredewa') == 0 ? 'selected' : ''}}> Diredewa </option>
                                <option value="Tigray" {{ strcmp(Auth::user()->region, 'Tigray') == 0 ? 'selected' : ''}}> Tigray </option>
                                <option value="Afar" {{ strcmp(Auth::user()->region, 'Afar') == 0 ? 'selected' : ''}}> Afar </option>
                                <option value="Amhara" {{ strcmp(Auth::user()->region, 'Amhara') == 0 ? 'selected' : ''}}> Amhara </option>
                                <option value="Oromia" {{ strcmp(Auth::user()->region, 'Oromia') == 0 ? 'selected' : ''}}> Oromia </option>
                                <option value="Benshangul" {{ strcmp(Auth::user()->region, 'Benshangul') == 0 ? 'selected' : ''}}> Benshangul </option>
                                <option value="Harari" {{ strcmp(Auth::user()->region, 'Harari') == 0 ? 'selected' : ''}}> Harari </option>
                                <option value="Somalia" {{ strcmp(Auth::user()->region, 'Somalia') == 0 ? 'selected' : ''}}> Somalia </option>
                                <option value="Gambella" {{ strcmp(Auth::user()->region, 'Gambella') == 0 ? 'selected' : ''}}> Gambella </option>
                                <option value="South Nations" {{ strcmp(Auth::user()->region, 'South Nations') == 0 ? 'selected' : ''}}> South Nations </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.city')</label>

                        <div class="col-md-6">
                            <input type="text" name="city" class="form-control" value="{{ old('city') ? old('city') : Auth::user()->city}}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.address1')</label>

                        <div class="col-md-6">
                            <input type="text" name="address1" class="form-control" value="{{ old('address1') ? old('address1') : Auth::user()->address1}}" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">@lang('register.address2')</label>

                        <div class="col-md-6">
                            <input type="text" name="address2" class="form-control" value="{{ old('address2') ? old('address2') : Auth::user()->address2}}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-top">
                <div class="card-body">
                    <div class="col-md-12 offset-md-10">
                        <button type="submit" class="btn primary-color">@lang('profile.update')</button>
                    </div>
                </div>
            </div>

        </form>
        
        </div>
    </div>
</div>

</section>
@endsection