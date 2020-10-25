<!-- Ini layout untuk mempersingkat koding jadi kaya simple templatenya -->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="css/all.min.css" type="text/css" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/icon/stm.png"/>
        <!-- Cek file controller untuk menambahkan title dinamis di app/Http/...... --> 
        <title>{{ $title }}n</title>
    </head>
    <body>
        <!-- Memanggil konten -->
        @yield('content')
        
        <script src="js/all.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    </body>
</html>