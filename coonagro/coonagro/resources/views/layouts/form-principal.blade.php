<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @if(isset($tag))
        @if($tag == '1')
            <link rel="sortcut icon" href="../img/favicon.png" type="image/png" style="border-radius:100px" />
        @elseif($tag == '2')
            <link rel="sortcut icon" href="../../img/favicon.png" type="image/png" style="border-radius:100px" />
        @elseif($tag == '3')
            <link rel="sortcut icon" href="../../../img/favicon.png" type="image/png" style="border-radius:100px" />
        @else
            <link rel="sortcut icon" href="img/favicon.png" type="image/png" style="border-radius:100px" />
        @endif
    @else
        <link rel="sortcut icon" href="img/favicon.png" type="image/png" style="border-radius:100px" />
    @endif


    <title>Coonagro - Cooperativa Naciona Agroindustrial</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    @if(isset($tag))
        @if($tag == '1')
            <link rel="stylesheet" href="../css/style.css">
        @elseif($tag == '2')
            <link rel="stylesheet" href="../../css/style.css">
        @elseif($tag == '3')
            <link rel="stylesheet" href="../../../css/style.css">
        @else
            <link rel="stylesheet" href="css/style.css">
        @endif
    @else
        <link rel="stylesheet" href="css/style.css">
    @endif

    <link rel="stylesheet" href="@yield('css')">

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>


</head>
<body style="-webkit-font-smoothing: antialiased;">

    <nav class="navbar navbar-dark bg-success">
        <div class="nav-item" > <i class="fas fa-user"></i> {{Auth::user()->NOME}} </div>
        <div class="nav-item" > <i class="fas fa-envelope"></i> {{Auth::user()->EMAIL}}</div>
    </nav>

    <div style="text-align:center">

        @if(isset($tag))
            @if($tag == '1')
                <img id="imgForm" src="../img/capa.png">
            @elseif($tag == '2')
                <img id="imgForm" src="../../img/capa.png">
            @elseif($tag == '3')
                <img id="imgForm" src="../../../img/capa.png">
            @else
                <img id="imgForm" src="img/capa.png">
            @endif
        @else
            <img id="imgForm" src="img/capa.png">
        @endif
        
    </div>

    @yield('conteudo')
</body>

@if(isset($tag))
    @if($tag == '1')
        <script type="text/javascript" src="../js/functions.js"></script>
    @elseif($tag == '2')
        <script type="text/javascript" src="../../js/functions.js"></script>
    @elseif($tag == '3')
        <script type="text/javascript" src="../../../js/functions.js"></script>
    @else
        <script type="text/javascript" src="js/functions.js"></script>
    @endif
@else
    <script type="text/javascript" src="js/functions.js"></script>
@endif



<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script type="text/javascript" src="@yield('js')"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->

@yield('bloco-js')
