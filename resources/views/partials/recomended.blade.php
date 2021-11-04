@auth
@if(sizeof($vendor_items) > 0)
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Recommended items</h2>

    @foreach($vendor_items as $vendor)
    <div class="card">
        <div class="card-header">{{ $vendor->name}} @lang('item.item_info') <a href="{{ route('person.items', $vendor->id) }}">>></a></div>
        <div class="card-body">
            <div class="carousel-inner">
                <?php $count = 0; ?>
                @foreach($vendor->owned()->orderBy('updated_at', 'DESC')->get()->chunk(4) as $chunk)
                <div class="carousel-item  {{ $count == 0 ? 'active' : ''}}">
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
                                            <li class="nav-item"><a class="nav-link" href="{{ url('/manage_item/'.$item->id) }}">Manage Item</a></li>
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
                <?php $count = 1; ?>
                @endforeach
            </div>
            @if(sizeof($vendor->owned) > 4)
                <a class="left item-control" href="#recommended-item-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#recommended-item-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>   
            @endif 
        </div>
    </div>
    @endforeach
</div><!--/recommended_items-->
@endif
@endauth