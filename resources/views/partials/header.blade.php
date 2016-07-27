<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('home') }}">Brand</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('store.products') }}">All categories</a></li>
						<li role="separator" class="divider"></li>
						@foreach(DB::table('categories')->get() as $category)
							<li>
								<a href="{{ route('category.products', [
									'category_name' => $category->category_name
								])}}">
									{{ ucfirst($category->category_name) }}
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@if(!Auth::check())
					<li><a href="{{ route('user.login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login</a></li>
				@else
					<li>
						<a href="{{ route('product.shoppingCart') }}">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							Shopping Cart
							<span class="badge">{{ Session::has('cart_' . md5(Auth::user()->id)) ? Session::get('cart_' . md5(Auth::user()->id))->totalQuantity : '' }}</span>
						</a>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle clearfix" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<img src="{{ route('user.avatar', ['filename' => Auth::user()->avatar]) }}" alt="user_avatar" class="img-responsive img-circle pull-left">&nbsp;
							<span class="header-username">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('user.settings') }}"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Settings</a></li>
							<li><a href="{{ route('user.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Logout</a></li>
						</ul>
					</li>
				@endif
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>