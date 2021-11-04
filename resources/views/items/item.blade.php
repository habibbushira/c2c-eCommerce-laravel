<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@push('css')
	<link href="{{ asset('css/zoom/xzoom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/zoom/foundation.css') }}" rel="stylesheet">
	<link href="{{ asset('css/zoom/jquery.fancybox.css') }}" rel="stylesheet">
	<link href="{{ asset('css/zoom/magnific-popup.css') }}" rel="stylesheet">
	<link href="{{ asset('css/zoom/normalize.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('rateYo/jquery.rateyo.min.css') }}">
	<style type="text/css">
		/*************************
		*******Cush item Details CSS******
		**************************/

		.item-details{
			overflow:hidden;
		}

		#similar-item {
		  margin-top: 40px;
		}

		#reviews {
		  padding-left: 25px;
		  padding-right: 25px;
		}

		.item-details {
		  margin-bottom: 40px;
		  overflow: hidden;
		  margin-top: 10px;
		}

		.view-item {
		  position: relative;
		}

		.view-item h3 {
		  background: #5f3703;
		  bottom: 0;
		  color: #FFFFFF;
		  font-family: 'Roboto', sans-serif;
		  font-size: 14px;
		  font-weight: 700;
		  margin-bottom: 0;
		  padding: 8px 20px;
		  position: absolute;
		  right: 0;
		}

		#similar-item .carousel-inner .item{
			padding-left:0px;
		}

		#similar-item .carousel-inner .item img {
		  display: inline-block;
		  margin-left: 15px;
		}

		.item-control {
		  position: absolute;
		  top: 35%;
		}
		.item-control i {
		  background: #5f3703;
		  color: #FFFFFF;
		  font-size: 20px;
		  padding: 5px 10px;
		}

		.item-control i:hover{
			background:#ccccc6;
		}

		.item-information {
		  border: 1px solid #F7F7F0;
		  overflow: hidden;
		  padding: 10px;
		  position: relative;
		}

		.newarrival{
			position:absolute;
			top:0;
			left:0
		}

		.item-information h2 {
		  color: #363432;
		  font-family: 'Roboto', sans-serif;
		  font-size: 20px;
		  margin-top: 0;
		}

		.item-information p {
		  color: #696763;
		  font-family: 'Roboto', sans-serif;
		  margin-bottom: 5px;
		}

		.item-information span {
		  display: inline-block;
		  margin-bottom: 8px;
		  margin-top: 18px;
		}

		.item-information span span {
		  color: #5f3703;
		  float: left;
		  font-family: 'Roboto', sans-serif;
		  font-size: 30px;
		  font-weight: 700;
		  margin-right: 20px;
		  margin-top: 0px;
		}
		.item-information span input {
		  border: 1px solid #DEDEDC;
		  color: #696763;
		  font-family: 'Roboto', sans-serif;
		  font-size: 20px;
		  font-weight: 700;
		  height: 33px;
		  outline: medium none;
		  text-align: center;
		  width: 50px;
		}

		.item-information span label {
		  color: #696763;
		  font-family: 'Roboto', sans-serif;
		  font-weight: 700;
		  margin-right: 5px;
		}	


		.shop-details-tab {
		  border: 1px solid #F7F7F0;
		  margin-bottom: 75px;
		  margin-left: 15px;
		  margin-right: 15px;
		  padding-bottom: 10px;
		}
		.shop-details-tab .col-sm-12 {
			padding-left: 0;
			padding-right: 0;
		}


		#reviews ul {
		  background: #FFFFFF;
		  border: 0 none;
		  list-style: none outside none;
		  margin: 0 0 20px;
		  padding: 0;
		}

		#reviews  ul  li {
			display:inline-block;
		}

		#reviews ul li a {
		  color: #696763;
		  display: block;
		  font-family: 'Roboto', sans-serif;
		  font-size: 14px;
		  padding-right: 15px;
		}

		#reviews ul li a i{
			color:#5f3703;
			padding-right:8px;
		}

		#reviews ul li a:hover{
			background:#fff;
			color:#5f3703;
		}

		#reviews p{
			color:#363432;
		}

		#reviews  form span {
		  display: block;
		}

		#reviews form span input {
		  background:#F0F0E9;
		  border: 0 none;
		  color: #A6A6A1;
		  font-family: 'Roboto', sans-serif;
		  font-size: 14px;
		  outline: medium none;
		  padding: 8px;
		  width: 48%;
		}
		#reviews form span input:last-child {
		  margin-left: 3%;
		}

		#reviews textarea {
		  background: #F0F0E9;
		  border: medium none;
		  color: #A6A6A1;
		  height: 195px;
		  margin-bottom: 25px;
		  margin-top: 15px;
		  outline: medium none;
		  padding-left: 10px;
		  padding-top: 15px;
		  resize: none;
		  width: 99.5%;
		}

		#reviews button {
		  background: #5f3703;
		  border: 0 none;
		  border-radius: 0;
		  color: #FFFFFF;
		  font-family: 'Roboto', sans-serif;
		  font-size: 14px;
		}

		.category-tab {
		  overflow: hidden;
		}

		.category-tab ul {
		  background: #5f3703;
		  border-bottom: 1px solid #5f3703;
		  list-style: none outside none;
		  margin: 0 0 30px;
		  padding: 0;
		  width: 100%;
		}

		.category-tab ul li a {
		  border: 0 none;
		  border-radius: 0;
		  color: #B3AFA8;
		  display: block;
		  font-family: 'Roboto', sans-serif;
		  font-size: 14px;
		  text-transform: uppercase;
		}

		.category-tab ul  li  a:hover{
		    background:#5f3703;
		    color:#fff;
		}

		.container{
		    max-width: 95%;
		}

		footer .row{
			margin-left: none;
			max-width: none;
		}
	</style>
@endpush

@section('content')
<section>
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
	<div class="row container">
		<div class="col-md-6 col-sm-12">
			<div class="item-details"><!--item-details-->
				<div class="row">
				<div class="col-sm-5">
					<div class="xzoom-container">
						<?php $image = $itemInfo->images->first() ? $itemInfo->images->first()->image : '';?>
	                    <img class="xzoom" src="{{ asset('storage/items/small/'.$image) }}" xoriginal="{{ asset('/storage/items/large/'.$image) }}" />
					</div>
					<hr>
					<p>@lang('item.owner') <a href="{{ route('person.items', $itemInfo->owner->id) }}">{{$itemInfo->owner->name}}</a></p>
					<p>{{$itemInfo->owner->phone_number}}</p>
				</div>					
				<div class="col-sm-7">						
					<div class="item-information"><!--/item-information-->
						<h2>{{ $itemInfo->name }}</h2>
						<p>{{ $itemInfo->property_status }}</p>
						<p>@lang('sidebar.category'): {{ $itemInfo->type->name}}</p>
						<p></p>

						<div class="choose">
	                        <ul class="nav nav-pills nav-justified">
	                            @guest

	                            <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $itemInfo->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>

	                            @else 

	                            @if($itemInfo->user_id == Auth::user()->id)
	                                <li class="nav-item"><a class="nav-link" href="{{ url('/manage_item/'.$itemInfo->id) }}">@lang('item.manage_item')</a></li>
	                            @else
	                            @if($itemInfo->wishlist()->where('user_id', Auth::user()->id)->first())
	                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlists.view') }}">
	                                    <i class="fa fa-plus-square"></i>@lang('item.already_wishlist')</a></li>
	                            @else
	                                <li class="nav-item"><a class="nav-link" href="{{ route('wishlist.add', $itemInfo->id) }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_wishlist')</a></li>
	                            @endif  
	                            @endif

	                            @endguest                              
	                        <li class="nav-item">
	                            <a class="nav-link compare" href="javascript:" rel="{{ $itemInfo->id }}"><i class="fa fa-plus-square"></i>@lang('item.add_to_compare')</a>
	                        </li>
	                        
	                        </ul>
	                    </div>
                        <hr>
                        <h5>Alternative views</h5>
                        <?php $count = 0; ?>
			        	@foreach($itemInfo->images->chunk(3) as $chunk)
			            <div class="row">  
			                @foreach($chunk as $attribute)						                
			                <div class="col-sm-3 col-md-4">
			                    <div class="product-image-wrapper">
			                        <div class="single-products">
			                            <div class="productinfo text-center">  
									    <a href="{{ asset('/storage/items/large/'.$attribute->image) }}">
									    	<img class="xzoom-gallery" width="80" src="{{ asset('/storage/items/small/'.$attribute->image) }}">
									  	</a>
			                            </div>			                            
			                        </div>
			                    </div>
			                </div>
			                @endforeach
			            </div>
			            	<?php $count++; ?>
			            @endforeach
					</div><!--/item-information-->
				</div>
				</div>
			</div><!--/item-details-->
		</div>
			
		<div class="col-md-6 col-sm-12">
			<div class="category-tab shop-details-tab"><!--category-tab-->
				<div class="col-sm-12">
					<ul class="nav nav-tabs">
						<li class="nav-item"><a class="nav-link active" href="#description" data-toggle="tab">@lang('item.description')</a></li>
						<li class="nav-item"><a class="nav-link" href="#reviews" data-toggle="tab">@lang('item.reviews') {{ $itemInfo->reviews()->count() != 0 ? '('.$itemInfo->reviews()->count().')' : ''}}</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade active show" id="description" >
						<div class="col-sm-12"><p>{{ $itemInfo->description }}</p></div>
					</div>
					<div class="tab-pane fade" id="reviews" >
						<div class="col-sm-12">
							@if($itemInfo->reviews->count() == 0)
								@lang('item.no_review')
							@endif
							@foreach($itemInfo->reviews as $review)
							<ul>
								<li><a><i class="fa fa-user"></i>{{$review->user->name}}</a></li>
								<li><a><i class="fa fa-clock"></i>{{ date("H:i:s",strtotime($review->created_at))}}</a></li>
								<li><a><i class="fa fa-calendar"></i>
								{{ date("d M Y",strtotime($review->created_at))}}</a></li>
								<li><a><i class="fa fa-star"></i>{{$review->rate}}</a></li>
							</ul>
							<p>{{ $review->review}}</p>
							@endforeach

							<p><b>@lang('item.write_ur_review')</b></p>								
							<form action="{{ route('item.review') }}" method="post">
								{{ csrf_field() }}
								<input type="text" value="{{ Auth::user() ? Auth::user()->name : 'Login To Review'}}" disabled />
								<input type="hidden" value="{{ $itemInfo->id }}" name="item_id"/>
								<textarea name="review" required minlength="20"></textarea>
								<b>@lang('item.rating'): </b><div id="rate"></div>
								<input type="hidden" name="rate" id="rateinput" value="5"/>
								
								<div class="form-group row mb-0">
								@guest
									<div class="col-md-4 offset-md-10">
										<span><a href="/login">@lang('header.login')</a></span>
										<span><a href="/register">@lang('header.sign_up')</a></span>
									</div>
								@else
                                <div class="col-md-2 offset-md-10">
                                    <button type="submit" class="btn btn-default pull-right">
										@lang('item.send_review')
									</button>
								</div>
								@endguest
								</div>
							</form>
						</div>
					</div>				
				</div>
			</div><!--/category-tab-->
		</div>
	</div>
</section>
@endsection

@push('script')
	<script type="text/javascript" src="{{ asset('rateYo/jquery.rateyo.min.js') }}"></script>
	<script src="{{ asset('js/zoom/xzoom.min.js') }}"></script>
	<script src="{{ asset('js/zoom/jquery.fancybox.js') }}"></script>
	<script src="{{ asset('js/zoom/jquery.hammer.min.js') }}"></script>
	<script src="{{ asset('js/zoom/magnific-popup.js') }}"></script>
	<script src="{{ asset('js/zoom/modernizr.js') }}"></script>
	<script src="{{ asset('js/zoom/setup.js') }}"></script>
	<script type="text/javascript">
		$("#rate").rateYo({
	        rating: "5",
	        precision: 0,
	        onChange: function(a, b) {
	            $("#rate").rateYo("option", "rating", a);
	            $('#rateinput').val(a);
	        }
	    });

	    $(".xzoom, .xzoom-gallery").xzoom({zoomWidth: 400, tint: '#333', Xoffset: 15});

	</script>
@endpush