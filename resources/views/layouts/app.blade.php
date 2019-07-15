<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
		  <title>IMOGY</title>
		<link href="img/imoicon.png" rel="icon" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @yield('head')

</head>
<body @yield('body')>
    <div id="app">
        <nav  class="navbar navbar-default navbar-static-top" style="background-color: #2b4e62">
            <div class="container">
                <div class="navbar-header" >

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" style="backface-visibility: 1; background-color: #2b4e62" href="{{ url('/') }}">
					
                    <img src="img/bar.png" width="60px  ">
                    </a>
					
                </div>

                <div   class="collapse navbar-collapse" id="app-navbar-collapse"  style="background-color: #2b4e62">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <img src="{{ asset('img/user7-128x128.jpg')}}" class="user-image" alt="User Image">
                                   Engginer, {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="profile">
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a id="logout" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout

                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('background')
        @yield('content')
    </div>
        @yield('content2')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
 	@if(!Auth::guest())
 	<script type="text/javascript">
        $(document).ready(function () {
            $("#logout").click(function () {
                $.ajax({
                    type: "GET",
                    url: "raw/{{Auth::user()->id}}",
                    success: '',
                });
            });
        });
    </script>
    @endif
    @yield('script')
</body>
</html>
