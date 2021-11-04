@extends('layouts.front.design')

@section('content')
	<div class="container">
		<h2 class="title text-center">@lang('item.types')</h2>
		<?php $count = 0; ?>
        @foreach($types->chunk(4) as $chunk)
            <div class="carousel-item  {{ $count == 0 ? 'active' : ''}}">
            <div class="row">
                @foreach($chunk as $type)
                @if($type->items->count() > 0)
                <?php $item = $type->items()->first();?>
                <div class="col-md-4 col-sm-6">
                    <div class="product-image-wrapper">
                        <div class="single-items">
                            <div class="iteminfo text-center">
                                <a href="{{ route('typeItems',$type->id)}}">
                                <?php $image = $item->images->first() ? $item->images->first()->image : '';?>
                                <img src="{{ asset('storage/items/small/'.$image) }}" alt="" class="img-rounded"/>
                                </a>

                                <h2>{{ $type->name}}</h2>
                            </div>                                    
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            </div>
        @endforeach
	</div>
@endsection