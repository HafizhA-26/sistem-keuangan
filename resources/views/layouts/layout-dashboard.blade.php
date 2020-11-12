@extends('layouts.layout1')

@section('content')
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistem Informasi Keuangan</title>

	<link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<link rel="icon" type="image/png" href="../img/icon/stm.png"/>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>

	<input type="checkbox" id="check">
	<!-- Header area start -->
	<header>
		<label for="check">
			<i class="fas fa-bars" id="sidebar_btn"></i>
		</label>
		<div class="left_area">
			<h3>Sistem <span>Informasi Keuangan</span></h3>
		</div>
		<div class="right_area">
			<a href="login.php" class="logout_btn"><i class="fa fa-sign-out-alt"></i> Sign Out</a>
		</div>
	</header>
	<!-- Header area end -->

	<!-- Mobile navigation bar start -->
		<div class="mobile_nav">
			<div class="nav_bar">
				<img src="../img/icon/stm.png" class="mobile_profile_image" alt="">
				<i class="fa fa-bars nav_btn"></i>
			</div>
			<div class="mobile_nav_items">
				<a href="#" class="disabled"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
				<a href="#"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
				<a href="#"><i class="fas fa-book"></i><span>Report</span></a>
				<a href="#"><i class="fas fa-user-plus"></i><span>Add Account</span></a>
				<a href="#"><i class="fas fa-user"></i><span>Edit Profil</span></a>
			</div>
		</div>
	<!-- Mobile navigation bar end-->

	<!-- Sidebar start -->
	<div class="sidebar">
		<div class="profile_info">
			<img src="../img/icon/stm.png" class="profile_image" alt="">
		</div>
		<a href="#" class="disabled"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
		<a href="#"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
		<a href="#"><i class="fas fa-book"></i><span>Report</span></a>
		<a href="#"><i class="fas fa-user-plus"></i><span>Add Account</span></a>
		<a href="#"><i class="fas fa-user"></i><span>Edit Profil</span></a>
	</div>
	<!-- Sidebar end -->

	<!-- Content -->
		@yield('content')

	<!-- Javascript -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('.nav_btn').click(function(){
				$('.mobile_nav_items').toggleClass('active');
			});
		});
	</script>

</body>
</html>
@endsection