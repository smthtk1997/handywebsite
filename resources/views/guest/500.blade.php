<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500</title>
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
</head>

<body>
<div class="main-wrapper">
    <div class="error-box">
        <div class="error-body text-center">
            <h1 class="error-title text-info">500</h1>
            <h3 class="text-uppercase error-subtitle">INTERNAL SERVER ERROR !</h3>
            <p class="text-muted m-t-30 m-b-30">PLEASE TRY AFTER SOME TIME</p>
            <a href="{{route('home')}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a>
        </div>
    </div>
</div>
</body>

</html>