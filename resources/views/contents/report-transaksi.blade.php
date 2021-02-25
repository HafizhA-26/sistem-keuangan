@extends('layouts.layout-sidebar')

@section('web-content')
	<label class="d-none" id="searchtable">{{ $search }}</label>
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
					<div class="card-body res-text-center">
						<a href="/export-excel-transaction" class="btn btn-primary theme-2 mb-3" >Export to Excel <i class="fas fa-file-export ml-2"></i></a>
						<table class="table data-table display nowrap" id="dataTable"> <!-- GET DARI DATABASE -->
							<thead>
								<tr>
									<th data-priority="1">No</th>
									<th data-priority="2">Id Transaksi</th>
									<th data-priority="3">Jenis Dana</th>
									<th data-priority="4">Jumlah</th>
									<th data-priority="5">Jenis</th>
									<th data-priority="6">Pengaju</th>
									<th data-priority="7">Tanggal Transaksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($report->all() as $r)
									@php
										$date = date_create($r->updated_at);
										$date = date_format($date, "d-m-Y");
										$jumlah = number_format($r->jumlah,2,",",".");
									@endphp
									<tr class="text-center"> 
										<td>{{ $loop->iteration }}</td>
										<td>{{ $r->id_transaksi }}</td>
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
			

		</div>
	

		<!--Tabel Transaksi End-->

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") <!--Jabatan = Staf APBD, Staf BOS-->
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

		<!--Tabel Transaksi Start-->
		<div class="row">
			<!--Tabel Transaksi Start-->
			<div class="col-md">
				<div class="card">
					<div class="card-body res-text-center">
						<a href="/export-excel-transaction" class="btn btn-primary theme-2 mb-3" >Export to Excel <i class="fas fa-file-export ml-2"></i></a>
						<table class="table data-table display nowrap" id="dataTable"> <!-- GET DARI DATABASE -->
							<thead>
								<tr>
									<th data-priority="1">No</th>
									<th data-priority="2">Id Transaksi</th>
									<th data-priority="3">Jenis Dana</th>
									<th data-priority="4">Jumlah</th>
									<th data-priority="5">Jenis</th>
									<th data-priority="6">Pengaju</th>
									<th data-priority="7">Tanggal Transaksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($report->all() as $r)
									@php
										$date = date_create($r->updated_at);
										$date = date_format($date, "d-m-Y");
										$jumlah = number_format($r->jumlah,2,",",".");
									@endphp
									<tr class="text-center">
										<td>{{ $loop->iteration }}</td>
										<td>{{ $r->id_transaksi }}</td>
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
			

		</div>
	
		<!--Tabel Transaksi End-->

	@endif
@endsection