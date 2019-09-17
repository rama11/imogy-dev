<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IMOGY</title>
		<link href="img/imoicon.png" rel="icon" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #ffff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
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
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
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
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                  <img src="img/WIMOGY.png" style="position: relative;" width="80%">
                </div> 

                <!-- <div class="links">
                    <a href="https://laravel.com/docs">OnTime</a>
                    <a href="https://laracasts.com">Excelent</a>
                    <a href="https://laravel-news.com">Smart</a>
                    <a href="https://forge.laravel.com">Things</a>
                    <a href="https://github.com/laravel/laravel">Fast</a>
                </div> -->
            </div>
        </div>
			<footer class="contant">
			<div class="aw">
		<img src="img/sip.png" style="position:fixed; right:0.1px; bottom:0.2px; align-items:right; text-align: right;" width="10%"></div>
        
		</footer>
    </body>
</html>
