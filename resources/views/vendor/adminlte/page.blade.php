@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if($layoutHelper->isLayoutTopnavEnabled())
	@php( $def_container_class = 'container' )
@else
	@php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
	@stack('css')
	@yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
	<div class="wrapper">

		{{-- Top Navbar --}}
		@if($layoutHelper->isLayoutTopnavEnabled())
			@include('adminlte::partials.navbar.navbar-layout-topnav')
		@else
			@include('adminlte::partials.navbar.navbar')
		@endif

		{{-- Left Main Sidebar --}}
		@if(!$layoutHelper->isLayoutTopnavEnabled())
			@include('adminlte::partials.sidebar.left-sidebar')
		@endif

		{{-- Content Wrapper --}}
		<div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">

			{{-- Content Header --}}
			<div class="content-header container">
				@if (session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if (session('warning'))
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						{{ session('warning') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if (session('error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						{{ session('error') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				@endif
				@if(Auth::user()->email_verified_at === null)
					<div class="alert alert-warning" role="alert">
						Potvrďte prosím svou emailovou adresu {{ Auth::user()->email }}, na kterou byl odeslán aktivační
						odkaz.
					</div>
				@endif
				@if(Request::get('verified') == 1)
					<div class="alert alert-success" role="alert">
						Vaše emailová adresa byla úspěšně potvrzena.
					</div>
				@endif
				<div
					class="d-flex flex-column flex-md-row justify-content-between {{ config('adminlte.classes_content_header') ?: $def_container_class }}">

					@yield('content_header')

					@yield('action_header')

				</div>
			</div>

			{{-- Main Content --}}
			<div class="content container pb-5">
				<div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
					@yield('content')
				</div>
			</div>

		</div>

		{{-- Footer --}}
		@hasSection('footer')
			@include('adminlte::partials.footer.footer')
		@endif

		{{-- Right Control Sidebar --}}
		@if(config('adminlte.right_sidebar'))
			@include('adminlte::partials.sidebar.right-sidebar')
		@endif

	</div>
@stop

@section('adminlte_js')
	@stack('js')
	@yield('js')
@stop
