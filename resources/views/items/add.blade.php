@extends('layouts.front.design')

@section('content')
<div class="content">
	@if(Session::has('message'))                        
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('message') !!}</strong>
        </div>
    @endif

    @if(Session::has('message_error'))                        
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('message_error') !!}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">@lang('item.item_info')</div>
        <div class="card-body">
            <form method="POST" action="{{ route('item.post') }}" enctype="multipart/form-data" 
            aria-label="@lang('item.item_info')">
            @csrf
            <div class="row">
            <div class="col-sm-6 ml-2">
            	<div class="form-group row">
                    <input id="type" type="text" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" value="{{ old('type') }}" required autofocus placeholder="@lang('item.type')*" autocomplete="on">

                    @if ($errors->has('type'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="@lang('item.name')*">

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <input id="price" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="@lang('item.price')*" name="price" required value="{{ old('price') }}">

                    @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="@lang('item.description')*" name="description" required></textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-5 ml-2">
                <label>What is the property status? </label>
                <div class="form-group row ml-2">                    
                    <br>
                    <label>
                      For Sale: <input type="radio" name="status" value="For Sale">
                    </label>
                    <label>
                      For Rent: <input type="radio" name="status" value="For Rent">
                    </label>
                </div>                
                <div class="gallery row">
                    
                </div>
                <div class="form-group row mt-2">
                    <input type="file" name="images[]" multiple id="gallery-photo-add">
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-10">
                        <button type="submit" class="btn primary-color">
                            @lang('item.post')
                        </button>
                    </div>
                </div>
            </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')

<script type="text/javascript">
    $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img col-sm-3 ml-2 mt-2>')).attr('width', '300px').attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });

    $('#type').autocomplete({
        source: @json($types)
    });
});
</script>

@endpush