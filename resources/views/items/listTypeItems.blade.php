@extends('layouts.front.design')

@section('content')
<div class="container">
    <div class="features_items">
        <h2 class="title text-center">{{$type->name}}</h2>
        <?php $count = 0;
        $items = $type->items()->where('status', 1)->get(); ?>
        @foreach($items->chunk(4) as $chunk)
        <div class="carousel-item  {{ $count == 0 ? 'active' : ''}}">
        <div class="row">
            @foreach($chunk as $item)
            <div class="col-md-4 col-sm-6">
                <div class="product-image-wrapper">
                    <div class="single-items">
                        <div class="iteminfo text-center">
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
        </div>
        </div>
    @endforeach
    </div>
</div>
@endsection