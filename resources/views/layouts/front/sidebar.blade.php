@push('css')
	<style type="text/css">
		.category-products .panel {
            background-color: #FFFFFF;
            border: 0px;
            border-radius: 0px;
            box-shadow:none;
            margin-bottom: 0px;
        }

        .category-products .panel-default .panel-heading {
          background-color: #FFFFFF;
          border: 0 none;
          color: #FFFFFF;
          padding: 5px 20px;
        }

        .category-products .panel-default .panel-heading .panel-title a {
          color: #696763;
          font-family: 'Roboto', sans-serif;
          font-size: 14px;
          text-decoration: none;
          text-transform: uppercase;
        }

        .panel-group .panel-heading + .panel-collapse .panel-body {
          border-top: 0 none;
        }

        .category-products .badge {
          background:none;
          border-radius: 10px;
          color: #696763;
          display: inline-block;
          font-size: 12px;
          font-weight: bold;
          line-height: 1;
          min-width: 10px;
          padding: 3px 7px;
          text-align: center;
          vertical-align: baseline;
          white-space: nowrap;
        }

        .panel-body ul{
          padding-left: 20px;
        }


        .panel-body ul li a {
          color: #696763;
          font-family: 'Roboto', sans-serif;
          font-size: 12px;
          text-transform: uppercase;
        }
	</style>
@endpush

<div class="left-sidebar">
	<div class="row mb-2">
		<form action="{{ route('search')}}" method="get">
			<i class="fa fa-search search-icon"></i>
			<input type="text" name="query" value="{{ request()->input('query') }}" placeholder="Search for product(s)"/>
		</form>
	</div>
	<h2>@lang('sidebar.category')</h2>
	<div class="panel-group category-products" id="accordian"><!--category-productsr-->
		<div class="panel panel-default">
			<div class="panel-body">
          <ul>
            @foreach($itemTypes as $type)
              <li><a href="/typeItems/{{ $type->id }}">{{ $type->name }} </a></li>
            @endforeach
          </ul>
        </div>
		</div>		
	</div>					
</div>