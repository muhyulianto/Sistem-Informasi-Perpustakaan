<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}
        {{-- Font awesome --}}
        <link href="{{ asset('fonts/fontawesome/fontawesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-image: url("{{ asset('img/book.jpeg') }}");
                background-size: cover;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: relative;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 500px;
            }

            .title {
                font-size: 30px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 15px;
                font-family: 'Pattaya';
            }

            .dropdown-menu{
                display: block;
                left: 15px;
            }

            .list{
                margin: 0 !important;
            }

            .list > .panel-body {
                padding: 5px 15px ;
            }

            .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { width: 100%; }

            .pagination{
                margin: 0 !important;
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" style="{{ (Request::is('/*') ? 'color: rgb(66, 157, 209);' : '') }}" href="{{ url('/') }}">Home</a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="nav navbar-nav">
                        <a class="navbar-brand" style="{{ (Request::is('data*') ? 'color: rgb(66, 157, 209);' : '') }}" href="{{ route('data.index') }}">Data</a>
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @auth
                        <li><a href="{{ url('/data') }}">Admin</a></li>
                        @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        @endif
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="title m-b-md">
                            <i class="fa fa-book"></i> Perpustakaan
                        </div>
                        <form class="form-horizontal" action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <input id="search" type="text" name="search" class="form-control" autocomplete="off" placeholder="Tuliskan info buku">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i> Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

	            @isset($Bukus)
	                <div class="panel panel-default">
	                    <div class="panel-body">
	                        <table class="table table-striped table-bordered">
	                            <thead>
	                                <tr>
	                                    <th style="text-align: center;">No</th>
	                                    <th>Nama Buku</th>
	                                    <th>Aksi</th>
	                                </tr>
	                            </thead>
	                            @foreach($Bukus as $buku)
	                                <tr>
	                                    <td style="text-align: center;" class="col-sm-1">{{ ($Bukus ->currentpage()-1) * $Bukus ->perpage() + $loop->index + 1 }}</td>
	                                    <td>{{ $buku -> nama_buku }}</td>
	                                    <td class="col-sm-1">
	                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#view-data-{{ $buku->id }}"> Lihat</button>
	                                        @include('data.modal-view')
	                                    </td>
	                                </tr>
	                            @endforeach
	                        </table>
                            {{ $Bukus->links() }}
	                    </div>
	                </div>
	            @endisset
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery-3.3.1.min') }}"></script>
        {{-- Bootstrap Notify --}}
        <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
        <script type="text/javascript">
        	$('.mbuh').ready(function(){
        		@if(session('warning'))
	        		$.notify({
						message: "{{ session('warning') }}"
					},{
						type: 'danger',
						delay: 3500
					});
				@endif
        	})
        </script>
    </body>
</html>
