@extends('layouts.front.design')

@section('content')
	
<section>
	<div class="container">
		@if(Session::has('message'))                        
	        <div class="alert alert-success alert-block">
	            <button type="button" class="close" data-dismiss="alert">x</button>
	            <strong>{!! session('message') !!}</strong>
	        </div>
	    @endif
		<div class="features_products"><!--cush features_items-->
			<h2 class="title text-center">@lang('wishlist.title')/h2>
			@if(sizeof($wishlists) == 0)
				<p>@lang('wishlist.no_wishlist')</p>
			@else
			
			<div class="row">
			@foreach($wishlists as $item)
			<div class="col-sm-4">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo text-center">
							<a href="{{ url('item/'.$item->url)}}">
								<?php $image = $item->images->first() ? $item->images->first()->image : '';?>
		                        <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
							</a>
							<h2>{{ $item->min_price}}</h2>
							<p>{{ $item->name }}</p>
							<a href="/item/{{ $item->url}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
						</div>
					</div>
					<div class="choose">
						<ul class="nav nav-pills nav-justified">
							<li><a href="{{ route('wishlists.remove', $item->id) }}"><i class="fa fa-plus-square"></i>@lang('wishlist.remove_wishlist')</a></li>
							<li class="nav-item">
                                <a class="nav-link compare" href="javascript:" rel="{{ $item->id }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_compare')</a>
                            </li>
						</ul>
					</div>
				</div>
			</div>
			@endforeach
			</div>
			@endif
		</div><!-- kush features_items-->	
	</div>
</section>
@endsection