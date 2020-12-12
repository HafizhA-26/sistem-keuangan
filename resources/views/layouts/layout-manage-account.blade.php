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
			<a href="/logout" class="logout_btn"><i class="fa fa-sign-out-alt"></i> Sign Out</a>
		</div>
	</header>
	<!-- Header area end -->

	<!-- Mobile navigation bar start -->
	<div class="mobile_nav">
			<div class="nav_bar">
				<img src="img/avatar/{{ session()->get('picture') }}" class="mobile_profile_image" alt=""> <!-- GET PICT DARI DATABASE ACCOUNT-->
				<a href="/edit-profil/{{ session()->get('nip') }}" class="edit" title="Edit Profil"><h5 class="mobile_name">{{ session()->get('nama') }} <i class="fas fa-edit"></i></a></h5> <!-- GET NAMA DARI DATABASE ACCOUNT-->
				<i class="fa fa-bars nav_btn"></i>
			</div>
			<div class="mobile_nav_items">
				<a href="/dashboard"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
				<a href="/submission"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
				<a href="/report"><i class="fas fa-book"></i><span>Report</span></a>
				<a href="/manage-account" class="disabled"><i class="fas fa-user-plus"></i><span>Manage Account</span></a>
			</div>
		</div>
	<!-- Mobile navigation bar end-->

	<!-- Sidebar start -->
	<div class="sidebar">
		<div class="profile_info">
			<img src="img/avatar/{{ session()->get('picture') }}" class="profile_image" alt=""> <!-- GET PICT DARI DATABASE ACCOUNT-->
			<a href="/edit-profil/{{ session()->get('nip') }}" class="edit" title="Edit Profil"><h5 class="name">{{ session()->get('nama') }} <i class="fas fa-edit"></i></a></h5> <!-- GET NAMA DARI DATABASE ACCOUNT-->
		</div>
		<a href="/dashboard"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
		<a href="/submission"><i class="fas fa-hand-holding-usd"></i><span>Submission</span></a>
		<a href="/report"><i class="fas fa-book"></i><span>Report</span></a>
		<a href="/manage-account" class="disabled"><i class="fas fa-user-plus"></i><span>Manage Account</span></a>
	</div>
	<!-- Sidebar end -->

	<!-- Content -->
		@yield('sub-content')

	<!-- Javascript -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('.nav_btn').click(function(){
				$('.mobile_nav_items').toggleClass('active');
			});
		});
	</script>

@endsection