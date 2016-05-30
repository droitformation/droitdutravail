<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Droit du travail</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Droit du travail | login">
    <meta name="author" content="Cindy Leschaud | @DesignPond">

    <link rel="stylesheet" href="<?php echo asset('backend/css/styles.css?=121');?>">
    <link rel="stylesheet" href="<?php echo asset('backend/css/login.css?=121');?>">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

</head>
<body class="focusedform">

<div class="verticalcenter">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Problème<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="logo"><a href="{{ url('/') }}">Droit du travail</a></div>
    <div class="panel panel-primary">

        <!-- Contenu -->
        @yield('content')
        <!-- Fin contenu -->

    </div>
</div>

</body>
</html>