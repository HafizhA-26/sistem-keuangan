@extends('layouts.layout-dashboard')

@section('sub-content')

	@if(session()->get("nama_jabatan") == "Admin") <!-- Jabatan = Admin-->
	<div class="content">
		<div class="header_dashboard">
			<h4>Dashboard</h4>
		</div> <br>
		
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<div class="small-box bg-success">
					<div class="inner">
						<h2>{{$conline}}</h2> <!--JUMLAH ONLINE-->
						<p>User Online</p>
					</div>
					<div class="ikon">
						<i class="fas fa-user"></i>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-danger">
					<div class="inner">
						<h2>{{$coffline}}</h2> <!--JUMLAH OFFLINE-->
						<p>User Offline</p>
					</div>
					<div class="ikon">
						<i class="fas fa-user-slash"></i>
					</div>
				</div>
			</div>
		</div>
		

		<div class="row mtop">
			<div class="col-md-6">
				<div class="box1 box-head-color-g">
					<div class="box-header with-border">
						<h5 class="title">User Online</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
							<tr>
								<th>Nama</th>
								<th>Jabatan</th>
							</tr>
							@foreach ($online as $on)
							<tr>
								<td>{{$on->nama}}</td> 
								<td>{{$on->nama_jabatan}}</td>
							</tr>
							@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box1 box-head-color-r">
					<div class="box-header with-border">
						<h5 class="title">User Offline</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
							<tr>
								<th>Nama</th>
								<th>Jabatan</th>
							</tr>
							@foreach ($offline as $off)
							<tr>
								<td>{{$off->nama}}</td> 
								<td>{{$off->nama_jabatan}}</td>
							</tr>
							@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") 
	<!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS-->
    <div class="content">
		<div class="header_dashboard">
			<h4>Dashboard</h4>
        </div> <br>
        @php
			$bos = number_format($danaBOS,2,",",".");
			$apbd = number_format($danaAPBD,2,",",".");
		@endphp
        @if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan") <!--Jabatan = Kepsek, Ka. Keuangan-->
        <div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-4">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Jumlah Dana BOS</span>
              		<span class="info-box-number">Rp.{{$bos}}</span>
            		</div>
          		</div>
        	</div>
        	<div class="col-md-4">
          		<div class="info-box">
            		<span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Anggaran APBD</span>
              		<span class="info-box-number">Rp.{{$apbd}}</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

        @if(session()->get('nama_jabatan') == "Staf BOS") <!--Jabatan = Staf BOS-->
        <div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Jumlah Dana BOS</span>
              		<span class="info-box-number">Rp.{{$bos}}</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

        @if(session()->get('nama_jabatan') == "Staf APBD") <!--Jabatan = Staf APBD-->
        <div class="row">
			<div class="col-md-3">
			</div>
        	<div class="col-md-6">
          		<div class="info-box">
            		<span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Anggaran APBD</span>
              		<span class="info-box-number">Rp.{{$apbd}}</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

		<br> <br>
		<div class="row">
			<div class="col-md-4">
				<div class="small-box bg-danger">
					<div class="inner">
						<h2>69</h2> <!--GET COUNT TABLE SUBMISISON-->
						<p>Pengajuan</p>
					</div>
					<div class="ikon">
						<i class="fas fa-hand-holding-usd"></i>
					</div>
					<a href="/submission" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-success">
					<div class="inner">
						<h2>67</h2> <!--GET COUNT LAPORAN PENGAJUUAN-->
						<p>Laporan Pengajuan</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-invoice"></i>
					</div>
					<a href="/report-submsission" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h2>78</h2> <!--GET COUNT LAPORAN TRANSAKSI-->
						<p>Laporan Transaksi</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-invoice-dollar"></i>
					</div>
					<a href="/report-transaksi" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		
	</div>
    @endif

    @if(session()->get('nama_jabatan') == "Kaprog") <!--Jabatan = Kaprog-->
    <div class="content">
		<div class="header_dashboard">
			<h4>Dashboard</h4>
		</div> <br>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6 mtop2">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-hand-holding-usd"></i></span>
            		<div class="info-box-content2">
              		<span class="info-box-text2"><a href="/submission" title="Tambah Pengajuan Baru">Add New Submission</a></span>
            		</div>
          		</div>
        	</div>
		</div>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="small-box bg-success">
					<div class="inner">
						<h2>{{$jumlahpengajuan}}</h2> <!--GET COUNT LAPORAN PENGAJUUAN-->
						<p>Laporan Pengajuan</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-invoice"></i>
					</div>
					<a href="/report" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
	</div>
    @endif
    
@endsection