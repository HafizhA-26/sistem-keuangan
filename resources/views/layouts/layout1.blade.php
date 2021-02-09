<!-- Ini layout untuk mempersingkat koding jadi kaya simple templatenya -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href={{ URL::asset('css/bootstrap.css') }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/style.css") }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/style-rev.css") }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/responsive.css") }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/datatables.css") }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/responsive.dataTables.min.css") }}>
        <link rel="stylesheet" type="text/css" href={{ URL::asset("css/fonts/stylesheet.css") }}>
        <link href={{ URL::asset("css/all.min.css") }} type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="icon" type="image/png" href={{ URL::asset("img/icon/stm.png") }} >
        <!-- Cek file controller untuk menambahkan title dinamis di app/Http/...... --> 
        <title>{{ $title?? '' }}{{ $title ? ' - ' : '' }} Sistem Informasi Keuangan</title>
    </head>
    <body>
        <!-- Memanggil konten -->
        {{-- @yield('content') --}}
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
        <script src={{ URL::asset("js/bootstrap.bundle.min.js") }}></script>
        <script src={{ URL::asset("js/main.js") }}></script>
        <script src={{ URL::asset("js/datatables.min.js") }}></script>
        <script src={{ URL::asset("js/dataTables.responsive.min.js") }}></script>
    
        <script>
            $(document).ready( function () {
                $('#dataTable').DataTable({
                    responsive: true,
                    info: false,
                });
                var table = $('#dataTable').DataTable();
                var searchT = "";
                if(document.getElementById("searchtable").innerHTML != null){
                    searchT = document.getElementById("searchtable").innerHTML;
                }
                table.search(searchT).draw();
            } );
        </script>
       
        {{-- <script>
            $(document).ready(function(){
              $("#searchButton").on("click", function() {
                var value = document.getElementById('searchInput').value.toLowerCase();
                $("#dataTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
              $('#searchInput').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    var value = $(this).val().toLowerCase();
                    $("#dataTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                }
                });
            });
        </script> --}}
    </body>
</html>