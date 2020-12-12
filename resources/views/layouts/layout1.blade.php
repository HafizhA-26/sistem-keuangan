<!-- Ini layout untuk mempersingkat koding jadi kaya simple templatenya -->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href={{ URL::asset('css/bootstrap.css') }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/style.css") }}>
        <link href={{ URL::asset("css/all.min.css") }} type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="icon" type="image/png" href={{ URL::asset("img/icon/stm.png") }} >
        <!-- Cek file controller untuk menambahkan title dinamis di app/Http/...... --> 
        <title>{{ $title?? '' }} Sistem Informasi Keuangan</title>
    </head>
    <body class="background-1">
        <!-- Memanggil konten -->
        @yield('content')
        <script>
            function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
        
            return false;
            return true;
        }
        </script>
         <script>
            function liatPass() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        </script>
        <script>
            function showJurusan() {
                var t = document.getElementById('jabatanForm');
                var selectedText = t.options[t.selectedIndex].text;
                if(selectedText == "Kaprog"){
                    document.getElementById('jurusan').classList.remove("d-none");
                    document.getElementById('jurusanSelect').setAttribute("name", "jurusan");
                }else{
                    document.getElementById('jurusan').classList.add("d-none");
                    document.getElementById('jurusanSelect').setAttribute("name", "jurusanNone");
                }
            }
        </script>
        <script src={{ URL::asset("js/all.min.js") }}></script>
        <script src={{ URL::asset("js/jquery.js") }}></script>
        <script src={{ URL::asset("js/bootstrap.min.js") }}></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    </body>
</html>