<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@section('content')

<section id="cart_items">
	<div class="container">
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
	    <h2 class="title text-center">Comparing Items</h2>
	    <div class="row">
	    	@if(sizeof(Cart::instance('comparision')->content()) == 0)
                <p>You did not add any product to compare <a href="/" class="btn btn-default">Choose items first</a></p>
            @else

            @foreach(Cart::instance('comparision')->content() as $item)
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo">
                            <a href="{{ url('product/'.$item->url)}}">
                            <?php $image = $item->model->images->first() ? $item->model->images->first()->image : '';?>
                            <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
                            </a>
                            <h2>Price: {{ $item->model->price}} ETB</h2>
                            <p><b>Type</b>: {{ $item->model->type->name }}</p>
                            <p><b>Name</b>: {{ $item->model->name }}</p>
                            <p><b>About</b>: {{ $item->model->description}}</p>
                            <p><b>Owned by</b>: {{$item->model->owner->name}}</p>
                            <a href="{{ url('item/'.$item->model->url)}}" class="btn btn-default add-to-cart"><i class="fa fa-phone"></i>@lang('item.contact_vendor')</a>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            @guest

                            <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $item->model->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>

                            @else 

                            @if($item->model->user_id == Auth::user()->id)
                                <li class="nav-item"><a class="nav-link" href="{{ url('/manage_item/'.$item->model->id) }}">@lang('item.manage_item')</a></li>
                            @else
                            @if($item->model->wishlist()->where('user_id', Auth::user()->id)->first())
                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlists.view') }}">
                                    <i class="fa fa-plus-square"></i>@lang('item.already_wishlist')</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $item->model->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>
                            @endif  
                            @endif

                            @endguest                              
                        <li class="nav-item">
                            <a class="nav-link" href="compare/remove/{{ $item->rowId}}"><i class="fa fa-plus-square"></i>Remove from compare</a>
                        </li>
                        
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
	    </div>
	</div>
</section>
@endsection
<!-- cush dox shop all view best -->