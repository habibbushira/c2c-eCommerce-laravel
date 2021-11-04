<!-- cush dox shop all view best -->
@extends('layouts.front.design')

@section('content')

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				@include('layouts.front.sidebar')
			</div>
			
			<div class="col-sm-9 padding-right">
				<div class="features_items">
					<h2 class="title text-center">Top 10 Shops</h2>
					<form action="{{ route('search_shop')}}" method="get">
						<label>Search for shop: </label>
						<i class="fa fa-search search-icon"></i>
						<input type="text" name="query" value="{{ request()->input('query') }}" placeholder="Search"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection