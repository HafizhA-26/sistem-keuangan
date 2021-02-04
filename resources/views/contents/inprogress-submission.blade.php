@extends('layouts.layout-sidebar')

@section('web-content')
<!-- Untuk Jabatan Kaprog langsung di direct ke report-submission, tanpa masuk ke halaman ini-->

	@if(session()->get('nama_jabatan') != "Kaprog") <!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS -->
    <div class="row res-text-center">
  		<div class="col-md-6">
			<a class="btn btn-primary btn-dashboard2 theme-money" href="/report/report-transaction">
				<i class="fas fa-file-invoice-dollar icon-title"></i>
				<span>Transactions Report</span>
				<div class="check-button">
					check <i class="fas fa-arrow-right icon-cek"></i>
				</div>
				
			</a>
  		</div>
  		<div class="col-md-6">
			<a class="btn btn-primary btn-dashboard2 theme-paper" href="/report/report-submission">
				<i class="fas fa-file-contract icon-title"></i>
				<span>Submissions Report</span>
				<div class="check-button">
					check <i class="fas fa-arrow-right icon-cek"></i>
				</div>
				
			</a>
  		</div>
		
	</div>
	@endif
@endsection