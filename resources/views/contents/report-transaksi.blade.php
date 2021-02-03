@extends('layouts.layout-sidebar')

@section('web-content')
    @if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Admin") <!--Jabatan = Kepsek, Ka. Keuangan--> 
		<!-- Row Start-->
		<div class="row">
			<div class="col-md">
				<div class="card count-stat">
					<div class="icon-stat" style="background-color: var(--light-green)">
						<i class="fas fa-funnel-dollar"></i>
					</div>
					<div class="card-body desc-stat">
						<h5 class="card-title">{{$masuk ?? 'N'}}</h5>
						<p class="card-text">Pemasukkan</p>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="card count-stat">
					<div class="icon-stat" style="background-color: var(--red)">
						<i class="fas fa-hand-holding-usd"></i>
					</div>
					<div class="card-body desc-stat">
						<h5 class="card-title">{{$keluar ?? 'N'}}</h5>
						<p class="card-text">Pengeluaran</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Row End-->
		<div class="row">
			<!--Tabel Transaksi Start-->
			<div class="col-md">
				<div class="card">
					<table class="table data-table display nowrap" id="dataTable"> <!-- GET DARI DATABASE -->
						<thead>
							<tr>
								<th>Jenis Dana</th>
								<th>Jumlah</th>
								<th>Jenis</th>
								<th>Pengaju</th>
								<th>Tanggal Transaksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($report->all() as $r)
								@php
									$date = date_create($r->updated_at);
									$date = date_format($date, "d-m-Y");
									$jumlah = number_format($r->jumlah,2,",",".");
								@endphp
								<tr>
									<td>{{ $r->id_dana }}</td>
									<td>Rp. {{ $jumlah }}</td>
									<td style="color: {{ $r->jenis=='keluar'? 'var(--red)': 'var(--light-green)' }}">{{ $r->jenis }}</td>
									{{-- Mengambil data jurusan jika terdapat id_jurusannya --}}
									@if ($r->id_jurusan)
										@php
											$jurusan = \App\Models\Jurusan::find($r->id_jurusan);
										@endphp
										<td>{{ $r->nama }} / {{ $jurusan->nama_jurusan }}</td> <!-- PERLU BACKEND -->
									@else 
										<td>{{ $r->nama }}</td> <!-- PERLU BACKEND -->
									@endif
									<td>{{ $date }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			

		</div>
	

		<!--Tabel Transaksi End-->

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") <!--Jabatan = Staf APBD, Staf BOS-->
	<div class="content">
		<div class="back">
			<a href="/report"><i class="fa fa-arrow-left icon3" title="Back to Report"></i></a>
		</div>
		<div class="header_report">
			<h4>Laporan Transaksi</h4>
		</div> <br>
		<!-- Row Start-->
		<div class="row">
		<div class="col-md-2"></div>
			<div class="col-md-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h2>{{ $masuk?? 'N' }}</h2> <!--GET COUNT JUMLAH PADA TABEL, JENIS: PEMASUKAN-->
						<p>Pemasukan</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-download"></i>
					</div>
					<a href="#tabel-transaksi" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-danger">
					<div class="inner">
						<h2>{{ $keluar?? 'N' }}</h2> <!--GET COUNT JUMLAH PADA TABEL, JENIS: PENGELUARAN-->
						<p>Pengeluaran</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-upload"></i>
					</div>
					<a href="#tabel-transaksi" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		<!-- Row End-->

		<!--Tabel Transaksi Start-->
		<div class="box1 box-info" id="tabel-transaksi">
			<div class="box-header with-border">
			@if(session()->get('nama_jabatan') == "Staf APBD") <!--Jabatan = Staf APBD-->
				<h3 class="box-title">Tabel Transaksi APBD</h3>
			@endif

			@if(session()->get('nama_jabatan') == "Staf BOS") <!--Jabatan = Staf BOS-->
				<h3 class="box-title">Tabel Transaksi BOS</h3>
			@endif

				<div class="right">
				<form class="form-inline" method="post">
					<div class="form-group">
						<input type="text" name="" placeholder="Search" class="form-control search"> <!-- PERLU BACKEND -->
						<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
					</div>
				</form>
				</div>
			</div>
			<div class="box-info">
				<div class="table-responsive">
					<table class="table no-margin"> 
						<!-- GET DARI DATABASE, HANYA TAMPILKAN SESUAI JENIS DANA JIKA BOS = HANYA TAMPILKAN BOS, JIKA APBD = HANYA TAMPILKAN APBD -->
						<thead>
							<tr>
								<th>Jumlah</th>
								<th>Jenis</th>
								<th>Pengaju</th>
								<th>Tanggal Transaksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($report->all() as $r)
								@php
									$date = date_create($r->updated_at);
									$date = date_format($date, "d-m-Y");
									$jumlah = number_format($r->jumlah,2,",",".");
								@endphp
								<tr>
									<td>Rp. {{ $jumlah }}</td>
									<td>{{ $r->jenis }}</td>
									@if ($r->id_jurusan)
										@php
											$jurusan = \App\Models\Jurusan::find($r->id_jurusan);
										@endphp
										<td>{{ $r->nama }} / {{ $jurusan->nama_jurusan }}</td> <!-- PERLU BACKEND -->
									@else 
										<td>{{ $r->nama }}</td> <!-- PERLU BACKEND -->
									@endif
									<td>{{ $date }}</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
					{{ $report->links() }}
				</div>
			</div>
		</div>
		<!--Tabel Transaksi End-->

	@endif
@endsection