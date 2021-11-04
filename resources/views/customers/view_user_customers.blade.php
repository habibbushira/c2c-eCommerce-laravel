<!-- cush dox shop all view best -->

@extends('layouts.front.design')

@section('content')

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-12 padding-right">
				<div class="features_items">
					<h2 class="title text-center">@lang('customer.title'):-</h2>
					@if(sizeof($customers) == 0)
						<p>@lang('customer.no_customer')</p>
					@endif

					@foreach($customers as $people)
					<div class="card" style="margin-bottom: 10px;">
						<div class="card-header">
							{{$people->name}}
						</div>
						<div class="card-body">
							<div class="row">
							<div class="col-sm-3">
								<img src="{{ asset('storage/users/small/'.$people->profile)}}" width="100" height="100" class="img-thumbnail"/>
							</div>
							<div class="col-sm-9">
								<p><b>@lang('register.country'): </b>{{$people->country}}</p>
								<p><b>@lang('register.region'): </b>{{$people->region}}</p>
								<p><b>@lang('register.address1'): </b>{{$people->address1}}</p>
								<p><b>@lang('register.phone_number'): </b>{{$people->phone_number}}</p>
								<p>Click <a href="{{ route('person.items', $people->id) }}">here</a> to view detail</p>
							</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

