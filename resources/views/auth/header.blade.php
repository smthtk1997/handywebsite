<!doctype html>
<html lang="en">

<head>

    <!-- WittyLight -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wittylight">

    <!-- Favicon icon & Title -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('imgs/favicon.png')}}">
    <title>@yield('title', 'Home') | {{ config('app.name', 'Laravel') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Prompt:400" rel="stylesheet" type="text/css">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/addstyle.css')}}" rel="stylesheet" type="text/css">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    @yield('style')

</head>

<body>
@yield('content')

@yield('script')
</body>

</html>
