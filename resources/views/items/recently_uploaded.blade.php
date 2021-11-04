<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@section('content')

<section>
    <div class="container">
        <div class="row">            
            <div class="features_items"><!--toyba features_items 20-->
                <h2 class="title text-center">@lang('item.recently_uploaded_items')</h2>
                @if(sizeof($items) == 0)
                    <p>@lang('message.no_item_available')</p>
                @else

                <?php $count = 0; ?>
                @foreach($items->chunk(4) as $chunk)
                    <div class="carousel-item  {{ $count == 0 ? 'active' : ''}}">
                    <div class="row">
                        @foreach($chunk as $item)
                        <div class="col-sm-3 col-md-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="{{ url('item/'.$item->url)}}">
                                        <?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                                        <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
                                        </a>
                                        <h2>{{ 'ETB '.$item->price}}</h2>
                                        <p>{{ $item->name }}</p>
                                        <p>
                                            <?php 
                                            $date = new DateTime($item->created_at);
                                            $interval = $date->diff(now());
                                            $diff = '';

                                            if($interval->y > 0)
                                                $diff .= $interval->y.' year';
                                            if($interval->m > 0)
                                                $diff .= $interval->m.' month';

                                            if($interval->d > 0){
                                                if($interval->y == 0 && $interval->m == 0 && $interval->d == 1)
                                                $diff = 'Yesterday';
                                                else
                                                    $diff = $interval->d.' days';
                                            }else if($interval->y == 0 && $interval->m == 0 && $interval->d == 0)
                                                $diff = 'Today';
                                            

                                            if ($diff !== 'Today' && $diff !== 'Yesterday')
                                                $diff = 'Before '.$diff;

                                            echo 'Posted '.$diff; 
                                            ?></p>
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
                @endif
            </div><!-- 04 features_items-->
            {{ $items->links()}}
        </div>
    </div>
</section>

@endsection
<!-- cush dox shop all view best -->