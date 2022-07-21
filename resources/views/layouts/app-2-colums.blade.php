<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GhanaDriver - Driving Ghana</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Scripts -->
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0&appId=200685819943351&autoLogAppEvents=1" nonce="eruJCcAe"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div id="fb-root"></div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
		        <a class="navbar-brand" href="/"><img src='/vendor/landing-page/img/gdlogo.jpg' style='width: 300px' /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left side of navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Middle of navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
							<a href="https://www.facebook.com/GhanaDriver-280709168700063/"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
                        </li>
                    </ul>

					@include('layouts.nav')
                </div>
            </div>
        </nav>

        <div class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
            
					            @yield('content')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
						@include('z.navbook')
                        &nbsp;
			            @yield('nav-ridehailing')
                    </div>
                </div>
            </div>
        </div>
    	<footer class="footer">
    		<div class="span12 text-center">
		    	&copy; 2022 GhanaDriver.com&nbsp;&nbsp;&nbsp;<a href="/privacypolicy">Privacy Policy</a>
	    	</div>
        </footer>
    </div>
</body>
</html>

