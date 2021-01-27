@extends('layouts.layout-sidebar')

@section('web-content')

	@if(session()->get("nama_jabatan") == "Admin") <!-- Jabatan = Admin-->
		
		<div class="row">
			<div class="col-md">
				<div class="card count-stat">
					<div class="icon-stat" style="background-color: var(--lightblue)">
						<i class="fas fa-users"></i>
					</div>
					<div class="card-body desc-stat">
						<h5 class="card-title">{{ $all }}</h5>
						<p class="card-text">Total Users</p>
					</div>
				</div>
			  </div>
			<div class="col-md">
				<div class="card count-stat">
					<div class="icon-stat" style="background-color: var(--green)">
						<i class="fas fa-user-check"></i>
					</div>
					<div class="card-body desc-stat">
						<h5 class="card-title">{{ $conline }}</h5>
						<p class="card-text">Online Users</p>
					</div>
				</div>
			  </div>
			  <div class="col-md">
				<div class="card count-stat">
					<div class="icon-stat" style="background-color: var(--red)">
						<i class="fas fa-user-times"></i>
					</div>
					<div class="card-body desc-stat">
						<h5 class="card-title">{{ $coffline }}</h5>
						<p class="card-text">Offline Users</p>
					</div>
				</div>
			  </div>
		</div>
		<div class="row mtop">
			<div class="col-md-6">
				<div class="box1 box-head-color-b">
					<div class="box-header with-border">
						<h5 class="title">User List</h5>
					</div>
					<div class="box-info">
						<div class="table-responsive">
							<table class="table">
							<tr>
								<th>Name</th>
								<th>Status</th>
								<th>Last Seen</th>
							</tr>
							@foreach ($allData as $a)
							<tr>
								<td>{{$a->nama}}</td>
								@if ($a->status == "online")
									<td style="color: var(--green)">{{ $a->status }}</td>
								@else
									<td style="color: var(--red)">{{ $a->status }}</td>
								@endif 
								
								<td>{{ $a->last_seen }}</td>
							</tr>
							@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	
	@endif

	@if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") 
	<!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS-->
		
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
						<h2>{{$dashboardsubmission}}</h2> <!--GET COUNT TABLE SUBMISISON-->
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
						<h2>{{$reportS}}</h2> <!--GET COUNT LAPORAN PENGAJUUAN-->
						<p>Laporan Pengajuan</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-invoice"></i>
					</div>
					<a href="/report-submission" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h2>{{$reportT}}</h2> <!--GET COUNT LAPORAN TRANSAKSI-->
						<p>Laporan Transaksi</p>
					</div>
					<div class="ikon">
						<i class="fas fa-file-invoice-dollar"></i>
					</div>
					<a href="/report-transaksi" class="small-box-footer">View More <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>
		
    @endif

    @if(session()->get('nama_jabatan') == "Kaprog") <!--Jabatan = Kaprog-->
		
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
    @endif
    
@endsection