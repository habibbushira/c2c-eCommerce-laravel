<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@push('css')
<style type="text/css">
	.productinfo{
		position: relative;
		display: inline-block;
		font-size: 0;
	}

	.productinfo .rmImage{
		position: absolute;
		top: 5px;
		right: 8px;
		z-index: 10;
		background-color: #FFF;
		padding: 4px 3px;
		color: #000;
		font-weight: bold;
		cursor: pointer;
		text-align: center;
		font-size: 22px;
		line-height: 10px;
		border-radius: 50%;
		border: 1px solid red;
		opacity: 0.5;
	}

	.productinfo:hover .rmImage{
		opacity: 1;
	}

	.hide{
		position: absolute;
		top: 5%;
		left: 0px;
		width: 100%;
		height: 100%;
		z-index: 15;
		background-color: rgba(255, 255, 255, 0.5);
	}
</style>
@endpush

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
    
    	<form method="POST" action="{{ url('/manage_item/'.$item->id) }}" aria-label="@lang('item.item_info')">
            @csrf
	        <div class="card">  
		        <div class="card-header">{{$item->name.' - '}} @lang('item.item_info')
		        	<div class="row" style="float: right;">
		            	<button type="submit" class="btn primary-color" name="update" style="margin-right: 10px;">@lang('item.update')</button>
		            	 
		            	<a href="javascript:" class="btn {{$item->status == 1 ? 'btn-danger' : 'btn-success'}} btn-sm disableItem" rel="{{$item->id}}" rel1="{{$item->status}}">
		            		@if($item->status == 1) @lang('item.disable') @else @lang('item.enable') @endif
		            	</a>
		            </div>
		        </div>
		        <div class="card-body">	            
		            <div class="row">
		            <div class="col-sm-6 ml-2">
		            	<div class="form-group row">
		                    <input id="type" type="text" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" value="{{ $item->type->name }}" required autofocus placeholder="@lang('item.type')*" autocomplete="on">

		                    @if ($errors->has('type'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('type') }}</strong>
		                        </span>
		                    @endif
		                </div>

		                <div class="form-group row">
		                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $item->name }}" required autofocus placeholder="@lang('item.name')*">

		                    @if ($errors->has('name'))
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $errors->first('name') }}</strong>
		                        </span>
		                    @endif
		                </div>

		                <div class="form-group row">
		                    <input id="price" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="@lang('item.price')*" name="price" required value="{{ $item->price }}">

		                    @if ($errors->has('price'))
		                        <span class="invalid-feedback" role="alert">
		                        	<strong>{{ $errors->first('price') }}</strong>
		                        </span>
		                    @endif
		                </div>

		                <div class="form-group row">
		                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="@lang('item.description')*" name="description" required>{{$item->description}}</textarea>

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
		                      For Sale: <input type="radio" name="status" value="For Sale" {{ strcmp($item->property_status, 'For Sale') == 0 ? 'checked' : ''}}>
		                    </label>
		                    <label>
		                      For Rent: <input type="radio" name="status" value="For Rent" {{ strcmp($item->property_status, 'For Rent') == 0 ? 'checked' : ''}}>
		                    </label>
		                </div> 
		            </div>
	            	</div>
		     	</div>
	    	</div>
	    </form>

    <form method="POST" action="{{ route('image.upload') }}" enctype="multipart/form-data" 
            aria-label="@lang('item.item_info')">
    	<div class="card">  
	        <div class="card-header">{{$item->name.' - '}} @lang('item.images')
	        </div>
	        <div class="card-body">	        	
                @foreach($item->images->chunk(3) as $chunk)
	            <div class="row">  
	                @foreach($chunk as $attribute)						                
	                <div class="col-md-3">
	                    <div class="product-image-wrapper">
	                        <div class="single-products">
	                            <div class="productinfo text-center">  
=	                            	<span class="rmImage" title="remove image" rel="{{$attribute->id}}" rel1="{{$attribute->image}}">&times;</span>
							    	<img class="img-rounded" src="{{ asset('/storage/items/small/'.$attribute->image) }}">
=	                            </div>          
	                        </div>
	                    </div>
	                </div>
	                @endforeach
	            </div>
	            @endforeach

	            @csrf
	            <input type="hidden" value="{{$item->id}}" name="id"/>
                <div class="form-group row mt-2">
                    <input type="file" name="images[]" multiple id="gallery-photo-add"><button type="submit" class="btn primary-color">
                            @lang('item.upload')
                        </button>
                </div>
                <div class="gallery row">
	                    
                </div>
	        </div>
	    </div>
	</form>
</div>

<div class="hide" style=" {{ $item->status == 1 ? 'display: none' : ''}} ">
	<h5 style="margin-top: 40px; text-align: center;">The item has been disabled, click the enable button to active again <br> <a href="javascript:" class="btn primary-color disableItem" rel="{{$item->id}}" rel1="{{$item->status}}"> @lang('item.enable')</a></h5>
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

    $('.disableItem').click(function(){
        var id = $(this).attr('rel');
        var rel1 = $(this).attr('rel1');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this",
            icon: "warning", 
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if(willDelete){
                $.ajax({
            		url: "/item/status", 
            		method: 'post',
            		data: {itemId: id, _token: "{{ csrf_token() }}", status: rel1},
            		success: function(data){
	            		if(data){
	            			swal("Item status has been updated",{
			                    icon:"success",
			                });
			                location.reload(true);
	            		}
            		}
        		});   
            }
        });
    });

    $('.rmImage').click(function(){
        var imageId = $(this).attr('rel');
        var img = $(this).attr('rel1');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this",
            icon: "warning", 
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if(willDelete){
            	$.ajax({
            		url: "/item/image/remove", 
            		method: 'post',
            		data: {id: imageId, _token: "{{ csrf_token() }}", image: img},
            		success: function(data){
	            		if(data){
	            			swal("The product has been removed",{
			                    icon:"success",
			                });
			                location.reload(true);
	            		}
            		}
        		}); 
            	              
            }
        });
    });
});
</script>

@endpush