@extends('layouts.front.design')

@push('css')
<style type="text/css">

    .carousel-indicators li {
        background: #C4C4BE;
    }

    .carousel-indicators li.active {
        background: #5f3703;
    }

    .get {
        background: #5f3703;
        border: 0 none;
        border-radius: 0;
        color: #FFFFFF;
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        font-weight: 300;
        margin-top: 23px;
    }

    .control-carousel {
        position: absolute;
        top: 50%;
        font-size: 60px;
        color: #C2C2C1;
    }

    .control-carousel:hover {
        color: #5f3703;
    }

    .right {
        right: 0;
    }

    .item-control {
      position: absolute;
      top: 41%;
    }

    .item-control i {
      color: #613803;
      font-size: 20px;
      padding: 4px 10px;
    }

    .item-control i:hover {
      color: #b56b0a;
    }
</style>
@endpush

@section('content')

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
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                        <li data-target="#slider-carousel" data-slide-to="3"></li>
                    </ol>
                    
                    <div class="carousel--inner">
                        <div class="carousel-item active">
                            <div class="row">
                            <div class="col-sm-6">
                                <h2>@lang('index.featured_items')</h2>
                                <p>@lang('index.featured_p')</p>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('storage/banner/girl1.jpg') }}" class="girl img-responsive" alt="" />
                            </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2>@lang('index.recently_uploaded_items')</h2>
                                    <p>@lang('index.recently_uploaded_items_p')</p>
                                    <a href="/recent_items" class="btn btn-default get">@lang('index.view_now')</a>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{ asset('storage/banner/girl3.jpg') }}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                                            
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div> 
            </div>
        </div>
    </div>
</section><!--/slider 1995-->
    
<section>
    <div class="container">
        @include('partials.recomended')
        <hr>
        <h4>@lang('index.featured_items')</h4>
        @foreach($items->chunk(4) as $chunk)
        <div class="row">
            @foreach($chunk as $item)
            <div class="col-md-3 col-sm-6">
                <div class="product-image-wrapper">
                    <div class="single-items">
                        <div class="productinfo text-center">
                            <a href="{{ url('item/'.$item->url)}}">
                            <?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                            <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
                            </a>

                            <h2>{{ 'ETB '.$item->price}}</h2>

                            <p>{{ $item->name }}</p>
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
        </div>`
        @endforeach
        {{$items->links()}}
    </div>
</section>

@endsection