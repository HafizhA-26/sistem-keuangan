@extends('layouts.layout-dashboard')

@section('sub-content')

    @if() <!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS-->
    <div class="content">
		<div class="header_dashboard">
			<h4>Dashboard</h4>
        </div> <br>
        
        @if() <!--Jabatan = Kepsek, Ka. Keuangan-->
        <div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-4">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Jumlah Dana BOS</span>
              		<span class="info-box-number">Rp. 2.000.000</span>
            		</div>
          		</div>
        	</div>
        	<div class="col-md-4">
          		<div class="info-box">
            		<span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Anggaran APBD</span>
              		<span class="info-box-number">Rp. 1.000.000</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

        @if() <!--Jabatan = Staf BOS-->
        <div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Jumlah Dana BOS</span>
              		<span class="info-box-number">Rp. 2.000.000</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

        @if() <!--Jabatan = Staf APBD-->
        <div class="row">
			<div class="col-md-3">
			</div>
        	<div class="col-md-6">
          		<div class="info-box">
            		<span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
            		<div class="info-box-content">
              		<span class="info-box-text">Anggaran APBD</span>
              		<span class="info-box-number">Rp. 1.000.000</span>
            		</div>
          		</div>
        	</div>
		</div>
        @endif

		<div class="row mtop">
			<div class="col-md-4">
			</div>
			<div class="col-md-4 tabel-sub">
				<div class="box1 box-head-color-r">
					<div class="box-header with-border">
						<h5 class="title">Pengajuan</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
								<!-- TAMPILKAN 2 ATAU 3 COUNT -->
							<tr>
								<th>Pengajuan</th>
								<th>Pengaju</th>
							</tr>
							<tr>
								<td>Judul Pengajuan</td> 
								<td>Nama Pengaju/Jurusan</td>
							</tr>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<a href="/submission">View More</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop">
			<div class="col-md-6 tabel-sub">
				<div class="box1 box-head-color-g">
					<div class="box-header with-border">
						<h5 class="title">Laporan Pengajuan</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
								<!-- TAMPILKAN 2 ATAU 3 COUNT -->
							<tr>
								<th>Pengajuan</th>
								<th>Pengaju</th>
								<th>Jumlah</th>
								<th>Status</th>
							</tr>
							<tr>
								<td>Judul Pengajuan</td> 
								<td>Nama Pengaju/Jurusan</td>
								<td>Rp. 1.000.000</td>
								<td>Acc/Rejected/Pending</td>
							</tr>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<a href="/report-submission">View More</a>
					</div>
				</div>
			</div>
			<div class="col-md-6 tabel-sub">
				<div class="box1 box-head-color-b">
					<div class="box-header with-border">
						<h5 class="title">Laporan Transaksi</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
								<!-- TAMPILKAN 2 ATAU 3 COUNT -->
							<tr>
								<th>Dana</th>
								<th>Jumlah</th>
								<th>Jenis</th>
								<th>Pengaju</th>
							</tr>
							<tr>
								<td>APBD/BOS</td> <!-- PERLU BACKEND-->
								<td>Rp. 1.000.000</td> <!-- PERLU BACKEND-->
								<td>Keluar/Masuk/Pending</td> <!-- PERLU BACKEND-->
								<td>Nama Pengaju/Jurusan</td> <!-- PERLU BACKEND-->
							</tr>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<a href="/report-transaksi">View More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    @endif

    @if() <!--Jabatan = Kaprog-->
    <div class="content">
		<div class="header_dashboard">
			<h4>Dashboard</h4>
		</div> <br>
		<div class="row">
			<div class="col-md-5 mtop2">
          		<div class="info-box">
            		<span class="info-box-icon bg-primary"><i class="fas fa-hand-holding-usd"></i></span>
            		<div class="info-box-content2">
              		<span class="info-box-text2"><a href="/submission" title="Tambah Pengajuan Baru">Add New Submission</a></span>
            		</div>
          		</div>
        	</div>
			<div class="col-md-7 tabel-sub mtop">
				<div class="box1 box-head-color-g">
					<div class="box-header with-border">
						<h5 class="title">Laporan Pengajuan</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
								<!-- TAMPILKAN 2 ATAU 3 COUNT -->
							<tr>
								<th>Pengajuan</th>
								<th>Jumlah</th>
								<th>Jenis Dana</th>
								<th>Tanggal</th>
								<th>Status</th>
							</tr>
							<tr>
								<td>Judul Pengajuan</td> <!-- PERLU BACKEND-->
								<td>Rp. 1.000.000</td> <!-- PERLU BACKEND-->
								<td>APBD/BOS</td> <!-- PERLU BACKEND-->
								<td>10-10-20</td> <!-- PERLU BACKEND-->
								<td>Acc/Rejected/Pending</td> <!-- PERLU BACKEND-->
							</tr>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<a href="/report-submission">View More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    @endif
    
@endsection