@extends('layouts.layout1')

@section('content')
    <div class="container-fluid background-1">
		<div class="row">
			<div class="col-md-3 border-right">
				<header class="border-bottom">
					<img src="../img/icon/stm.png">
					<span class="h6">&nbsp;Sistem Informasi Keuangan</span>
				</header>
				<ul>
					<li class="list-inline h4"><a href="" class="nav-link disabled listtype">Dashboard</a></li><br>
					<li class="list-inline h4"><a href="" class="nav-link listtype">Submission</a></li><br>
					<li class="list-inline h4"><a href="" class="nav-link listtype">Report</a></li><br>
					<li class="list-inline h4"><a href="" class="nav-link listtype">Add Account</a></li><br>
					<li class="list-inline h5 bawah"><a href="login.php" class="listtype">Sign Out <i class="fa fa-sign-out-alt"></i></a></li>
				</ul>
			</div>
			@yield('content')
		</div>
    </div>
@endsection