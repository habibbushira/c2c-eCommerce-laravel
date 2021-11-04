<div class="navbar navbar-expand-lg navbar-light mb-4" >
    <a href="/"><img src="{{ asset('/logo.gif')}}" width="100px" /></a>
    <form action="{{ route('search')}}" method="get">
		<input type="text" name="query" value="{{ request()->input('query') }}" placeholder="Search for product(s)" style="width: 200%;" />
	</form>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-2" id="navbarCollapse">
    	<ul class="navbar-nav ml-auto nav-flex-icons">
	    	<li class="nav-item active">
                <a class="nav-link" href="/"><i class="fa fa-home"></i> @lang('header.home')<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            	<a class="nav-link" href="/post"><i class="fa fa-plus"></i> @lang('header.post')</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">@lang('header.items')</a>
                <ul class="dropdown-menu" aria-labelledby="dropdown1">
                    <a class="dropdown-item" href="{{ route('recent_items') }}">@lang('header.recently_posted')</a>
                    <a class="dropdown-item" href="{{ route('top_solds') }}">@lang('header.top_sold')</a>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('item.types') }}">@lang('header.categories')</a>
            </li>

            @if (Route::has('login'))
                @auth
                	<li class="nav-item">
		            	<a class="nav-link" href="{{ route('peoples') }}"><i class="fa fa-user"></i> @lang('header.peoples')</a>
		            </li>
		            <li class="nav-item">
		            	<a class="nav-link" href="{{ url('/vendors') }}"><i class="fa fa-user"></i> @lang('header.vendors')</a>
		            </li>
		            <li class="nav-item">
		            	<a class="nav-link" href="{{ url('/customer') }}"><i class="fa fa-user"></i> @lang('header.customer')</a>
		            </li>
		            <li class="nav-item">
		            	<a class="nav-link" href="{{ route('wishlists.view')}}"><i class="fa fa-star"></i> @lang('header.wishlist')</a>
		            </li>
                @endauth
            @endif
			<li class="nav-item">
				<a href="/compare" class="nav-link">
					<i class="fa fa-shopping-cart"></i> @lang('header.comparision')
					<span class="badge badge-pill badge-secondary" id="compare">
						{{ sizeof(Cart::instance('comparision')->content()) > 0 ? sizeof(Cart::instance('comparision')->content()) : '' }}
					</span>
				</a>
			</li>
		    
		    @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}" ><i class="fa fa-lock"></i> @lang('header.login')</a>
            </li>
            <li class="nav-item">
            	<a class="nav-link" href="{{ route('register') }}" ><i class="fa fa-lock"></i> @lang('header.register')</a>
            </li>
            @else
            	<li class="nav-item dropdown">
			    	<a href="" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        	<img src="{{ asset('storage/users/small/'.Auth::user()->profile)}}" alt="user" class="rounded-circle" width="31">
			        </a>
			        <div class="dropdown-menu dropdown-menu-right dropdown-secondary"
			          aria-labelledby="navbarDropdownMenuLink-55">
			          	<a class="dropdown-item" href="/settings/user_profile"><i class="ti-user m-r-5 m-l-5"></i> @lang('header.my_profile')</a>
			          	<a class="dropdown-item" href="/settings/account"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>

			          	<a class="dropdown-item" href="/items"><i class="ti-user m-r-5 m-l-5"></i> @lang('header.my_items')</a>

	                    <a class="dropdown-item" href="{{ url('logout') }}" 
	                        onclick="event.preventDefault();
	                                         document.getElementById('logout-form').submit();"
	                    ><i class="fa fa-power-off m-r-5 m-l-5"></i> @lang('header.logout')</a>

	                    <form id="logout-form" action="{{ route('logout') }}" 
	                    		method="POST" style="display: none;">
	                            @csrf
	                    </form>
			        </div>
			    </li>
            @endguest
	    </ul>
    </div>
</div>