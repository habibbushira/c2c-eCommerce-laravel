<!-- cush dox person all view best -->
@extends('layouts.front.design')

@push('css')
    <link href="{{ asset('css/zoom/xzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zoom/foundation.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zoom/zoom/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zoom/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/zoom/normalize.css') }}" rel="stylesheet">
    <style type="text/css">
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
		<div class="row container">
			<div class="col-md-4 col-sm-12">
				<div class="card" style="margin-bottom: 10px;">
						<div class="card-header">
                            <div class="row">
                                <div class="col-sm-9">
                                    @lang('people.profile')
                                </div>
                                <div class="col-sm-3">
                                    @if($person->customers->count() > 0)
                                    <span class="badge badge-pill badge-secondary">
                                    {{$person->customers->count()}} {{$person->customers->count() == 1 ? app('translator')->getFromJson('people.customer') : app('translator')->getFromJson('people.customers')}}                                
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
				<div class="card-body">
					<div><img src="{{ asset('storage/users/large/'.$person->profile)}}" class="rounded-circle" width="200"/></div>
					<div><b>@lang('register.name'):</b> {{ $person->name}}</div>
                    <div><b>@lang('register.phone_number'):</b> {{ $person->phone_number}}</div>
					<div><b>@lang('register.email'):</b>{{ $person->email}}</div>
                    <div><b>@lang('register.country'):</b> {{ $person->country}}</div>
                    <div><b>@lang('register.region'):</b> {{ $person->region}}</div>
                    <div><b>@lang('register.city'):</b> {{ $person->city}}</div>
                    <div><b>@lang('register.address1'):</b> {{ $person->address1}}</div>
                    <div><b>@lang('register.address2'):</b> {{ $person->address2}}</div>
                    <div><b>@lang('register.joinat'):</b> {{ $person->created_at}}</div>
                    <hr>
                    <div>
                        @guest
                        <p><a href="/login?next=/persons/detail/{{$person->id}}">@lang('login.login')</a> to become a customer</p>
                        
                        @else

                        @if(Auth::user()->id != $person->id)

                        @if($person->hasCustomer(Auth::user()->id))
                        <div class="col-md-6 offset-md-4">
                            <a rel="{{ $person->id }}" rel1="/vendor/remove" href="javascript:" class="btn btn-danger btn-sm deleteRecord">@lang('people.remove_customer')</a>
                        </div>
                        @else
                        <form action="/vendors" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{ $person->id }}" name="person_id"/>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn primary-color">
                                        @lang('people.become_customer')
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                        @endif
                        @endguest
                    </div>
				</div>
			</div>
			</div>
			
			<div class="col-md-8 col-sm-12 padding-right">
				<div class="features_items">
					<h2 class="title text-center">{{ $person->name }} @lang('item.items')</h2>
					@if($person->owned()->where('status', 1)->count() > 0)
						<div class="row">
                    @foreach($person->owned->where('status', 1) as $item)
                    <div class="col-md-3 col-sm-6">
                        <div class="item-image-wrapper">
                            <div class="single-items">
                                    <div class="iteminfo text-center">
                                        <a href="{{ url('item/'.$item->url)}}">
                                        <?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                                        <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
                                        </a>
                                        <h2>{{ $item->price.' '.$item->price_unit}}</h2>
                                        <p>{{ $item->name }}</p>
                                        <a href="{{ url('item/'.$item->url)}}" class="btn btn-default add-to-cart"><i class="fa fa-phone"></i>@lang('item.contact_vendor')</a>
                                    </div>
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
                    @endforeach
                    </div>
        			@else
						<p>@lang('people.no_item_posted', [$person->name])</p>
					@endif
				</div>
			</div>
		</div>
</section>

@endsection

@push('script')
    <script src="{{ asset('js/zoom/xzoom.min.js') }}"></script>
    <script src="{{ asset('js/zoom/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('js/zoom/jquery.hammer.min.js') }}"></script>
    <script src="{{ asset('js/zoom/magnific-popup.js') }}"></script>
    <script src="{{ asset('js/zoom/modernizr.js') }}"></script>
    <script src="{{ asset('js/zoom/setup.js') }}"></script>
    <script type="text/javascript">
        $(".xzoom, .xzoom-gallery").xzoom({zoomWidth: 400, tint: '#333', Xoffset: 15});
    </script>
@endpush