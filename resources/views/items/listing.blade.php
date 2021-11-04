<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@push('css')

	<style type="text/css">
		.img_container {
		  position: relative;
		  text-align: center;
		  color: white;
		}

		.centered {
		  position: absolute;
		  top: 0px;
  		  left: 0px;
		  width: 100%;
		  height: 100%;
		  background-color: rgba(255, 255, 255, 0.5);
		}
	</style>
@endpush
@section('content')
	
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				@include('layouts.front.sidebar')
			</div>
			
			<div class="col-sm-9 padding-right">
				<div class="features_items"><!-- 1995 features_items 20-->
					<h2 class="title text-center">@lang('header.my_items')</h2>
					@if(sizeof($items) == 0)
						<p>@lang('message.no_items_available')</p>
					@else
					
					<div class="row">
					@foreach($items as $item)
					<div class="col-md-3 col-sm-6">
						<div class="product-image-wrapper">
							<div class="single-products">
								<div class="productinfo text-center">
									<a href="{{ $item->status == 1 ? url('item/'.$item->url) : url('/manage_item/'.$item->id)}}">
                                    <?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                                    <div class="img_container">
                                    	<img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
									  	<div class="centered" style=" {{ $item->status == 1 ? 'display: none' : ''}} "><h6 style="text-align: center; color: RED;">Disabled</h6></div>
									</div>
                                    </a>
									<h2>{{ $item->price.' ETB'}}</h2>
									<p>{{ $item->name }}</p>
								</div>
							</div>
							<div class="choose">
                                <ul class="nav nav-pills nav-justified">
		                            @if($item->user_id == Auth::user()->id)
		                                <li class="nav-item"><a class="nav-link" href="{{ url('/manage_item/'.$item->id) }}">@lang('item.manage_item')</a></li>
		                            @endif
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
				</div><!--features_items 04-->	
			</div>
		</div>
	</div>
</section>

@endsection