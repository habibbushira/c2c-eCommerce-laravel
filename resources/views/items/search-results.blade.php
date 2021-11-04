<!-- cush dox shop all view best -->
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

	    @if(Session::has('message_error'))                        
	        <div class="alert alert-warning alert-block">
	            <button type="button" class="close" data-dismiss="alert">x</button>
	            <strong>{!! session('message_error') !!}</strong>
	        </div>
	    @endif

	    <div class="row">
						
			<div class="col-sm-12">
				<div class="features_items"><!--features_items-->
					<h2 class="title text-center">Search Results</h2>
					@if(sizeof($items) == 0)
						<p>@lang('item.no_item_avaialble')</p>
					@else
					
					<p>{{ sizeof($items) }} result(s) for '{{ request()->input('query')}}'</p>
					<div class="row">
					@foreach($items as $item)
					<div class="col-md-3 col-sm-6">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center">
									<a href="{{ url('product/'.$item->url)}}">
										<?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                                    	<img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
									</a>
									<h2>ETB {{ $item->price}}</h2>
									<p>{{ $item->name }}</p>
									<p>{{ $item->description }}</p>
									<p><b>{{ $item->property_status }}</b></p>
									<p>{{ $item->owner->name }}</p>
									<a href="{{ url('item/'.$item->url)}}" class="btn btn-default add-to-cart"><i class="fa fa-phone"></i>@lang('item.contact_vendor')</a>
								</div>
							</div>
							<div class="choose">
		                        <ul class="nav nav-pills nav-justified">
		                            @guest

		                            <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $item->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>

		                            @else 

		                            @if($item->user_id == Auth::user()->id)
		                                <li class="nav-item"><a class="nav-link" href="{{ url('/manage_item/'.$item->id) }}">@lang('item.manage_item')</a></li>
		                            @else
		                            @if($item->wishlist()->where('user_id', Auth::user()->id)->first())
		                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlists.view') }}">
		                                    <i class="fa fa-plus-square"></i>@lang('item.already_wishlist')</a></li>
		                            @else
		                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $item->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>
		                            @endif  
		                            @endif

		                            @endguest                              
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
				</div><!--features_items-->	
			</div>
		</div>
	</div>
</section> <!--/#cart_items-->
@endsection