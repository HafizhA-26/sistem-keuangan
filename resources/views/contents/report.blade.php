@extends('layouts.layout-report')

@section('sub-content')
<!-- Untuk Jabatan Kaprog langsung di direct ke report-submission, tanpa masuk ke halaman ini-->

	@if() <!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS -->
    <div class="content">
		<div class="row">
  		<div class="col-sm-6">
  			<div class="thumbnail">
  				<h5>Laporan Transaksi</h5>
  				<i class="fas fa-file-invoice-dollar"></i> <br>
  				<a href="/report-transaction" class="btn btn-primary">Check</a>
  			</div>
  		</div>
  		<div class="col-sm-6">
  			<div class="thumbnail">
  				<h5>Laporan Pengajuan</h5>
  				<i class="fas fa-file-invoice"></i> <br>
  				<a href="/report-submission" class="btn btn-primary">Check</a>
  			</div>
  		</div>
		</div>
	</div>
	@endif
@endsection