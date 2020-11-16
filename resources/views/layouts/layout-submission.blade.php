@extends('layouts.layout1')

@section('content')

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
				<a href="#"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
				<a href="#" class="disabled"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
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
		<a href="#"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
		<a href="#" class="disabled"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
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

@endsection