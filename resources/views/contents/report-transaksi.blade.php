@extends('layouts.layout-sidebar')

@section('web-content')
	<label class="d-none" id="searchtable">{{ $search }}</label>
    @if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Admin") <!--Jabatan = Kepsek, Ka. Keuangan--> 
		<!-- Row Start-->
		<div class="row">
			<div class="col-md">
				<div class="card p-0">
					<div class="card-header">
						Tampilan Laporan
					</div>
					<div class="card-body res-text-center" style="padding: 30px;">
						<form action="" method="get">
							<div class="row">
								@csrf
								<div class="col-md mb-2">
									<div class="form-inline">
										<label class="label mr-2">Jangka Waktu :</label>
										<select class="form-control" name="JangkaWaktu">
											<option value="1 Bulan" {{ $waktu=="1 Bulan"? "selected":"" }}>1 Bulan Terakhir</option>
											<option value="1 Tahun" {{ $waktu=="1 Tahun"? "selected":"" }}>1 Tahun Terakhir</option>
										</select>
									</div>
								</div>
								<div class="col-md mb-2">
									<div class="form-inline">
										<label class="label mr-2">Jenis Dana :</label>
										<select class="form-control" name="JenisDana" id="pilihanD" onchange="showJenisExtended()">
											<option value="" {{ $jenisDana==""? "selected":'' }}>All</option>
											<option value="BOS" {{ $jenisDana=="BOS"? "selected":'' }}>BOS</option>
											<option value="APBD" {{ $jenisDana=="APBD"? "selected":'' }}>APBD</option>
										</select>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-6 mb-2">
									<div class="form-inline">
										<label class="label mr-2">Pemasukan/Penggunaan : </label>
										<select class="form-control" name="masuk_keluar" id="pilihanP" onchange="showJenisExtended()">
											<option value="" {{ $masukKeluar==""? "selected":'' }}>All</option>
											<option value="masuk" {{ $masukKeluar=="masuk"? "selected":'' }}>Pemasukan</option>
											<option value="keluar" {{ $masukKeluar=="keluar"? "selected":'' }}>Penggunaan</option>
										</select>
									</div>
								</div>
								@php
										$jenisBM = \App\Models\JenisSubmission::getMasukBOS();
										$jenisBK = \App\Models\JenisSubmission::getKeluarBOS();
										$jenisAM = \App\Models\JenisSubmission::getMasukAPBD();
										$jenisAK = \App\Models\JenisSubmission::getKeluarAPBD();
									
								@endphp
								<div class="col-md-6 mb-1">
									<div class="form-inline" id="form-select">
									@if (!$jenisBM->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisBMasuk">
											<option value="">All</option>
											@foreach ($jenisBM->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
									@if (!$jenisBK->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisBKeluar">
											<option value="">All</option>
											@foreach ($jenisBK->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
									@if (!$jenisAM->isEmpty())
										<div class="form-inline d-none" id="jenisAMasuk">
											<label class="label">Jenis Pengajuan</label>
											<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisAMasuk">
												<option value="">All</option>
												@foreach ($jenisAM->all() as $j)
													<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
												@endforeach
											</select>
										</div>
									@endif
									@if (!$jenisAK->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisAKeluar">
											<option value="">All</option>
											@foreach ($jenisAK->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
									
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md text-center">
									<div class="form-group">
										<input type="submit" value="Show" name="" class="btn btn-primary theme-1" style="width: 6rem;" />
									</div>
								</div>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
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
		{{-- Chart --}}
		<div class="row">
			<div class="col-md">
				<div class="card" style="padding: 30px">
					<div class="card-body">
						<div id="chart" class="chart-container"></div>
						<div class="row">
							<div class="col-md text-center">
								<h5 class="chart-title" style="color: #06d6a0">Masuk</h5>
								<h3 class="chart-content">Rp.{{ number_format($jumlahM,2,",",".") }}</h3>
							</div>
							<div class="col-md text-center">
								<h5 class="chart-title" style="color: #ef476f">Keluar</h5>
								<h3 class="chart-content">Rp.{{ number_format($jumlahK,2,",",".") }}</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
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
			<div class="card p-0">
				<div class="card-header">
					Tampilan Laporan
				</div>
				<div class="card-body res-text-center" style="padding: 30px;">
					<form action="" method="get">
						<div class="row">
							@csrf
							<div class="col-md mb-2">
								<div class="form-inline">
									<label class="label mr-2">Jangka Waktu :</label>
									<select class="form-control" name="JangkaWaktu">
										<option value="1 Bulan" {{ $waktu=="1 Bulan"? "selected":"" }}>1 Bulan Terakhir</option>
										<option value="1 Terakhir" {{ $waktu=="1 Tahun"? "selected":"" }}>1 Tahun Terakhir</option>
									</select>
								</div>
							</div>
							<div class="col-md mb-2 d-none">
								<div class="form-inline">
									<label class="label mr-2">Jenis Dana :</label>
									<select class="form-control" name="JenisDana" id="pilihanD" onchange="showJenisExtended()">
										@if(session()->get('nama_jabatan') == "Staf BOS") <option value="BOS" selected>BOS</option> @endif
										@if(session()->get('nama_jabatan') == "Staf APBD") <option value="APBD" selected>APBD</option> @endif
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6 mb-2">
								<div class="form-inline">
									<label class="label mr-2">Pemasukan/Penggunaan : </label>
									<select class="form-control" name="masuk_keluar" id="pilihanP" onchange="showJenisExtended()">
										<option value="">All</option>
										<option value="masuk" {{ $masukKeluar=="masuk"? "selected":'' }}>Pemasukan</option>
										<option value="keluar" {{ $masukKeluar=="keluar"? "selected":'' }}>Penggunaan</option>
									</select>
								</div>
							</div>
							@php
								$jenisBM = null;
								$jenisBK = null;
								$jenisAM = null;
								$jenisAK = null;
								if(session()->get('nama_jabatan') == "Staf BOS"){
									$jenisBM = \App\Models\JenisSubmission::getMasukBOS();
									$jenisBK = \App\Models\JenisSubmission::getKeluarBOS();
								}elseif(session()->get('nama_jabatan') == "Staf APBD"){
									$jenisAM = \App\Models\JenisSubmission::getMasukAPBD();
									$jenisAK = \App\Models\JenisSubmission::getKeluarAPBD();
								}
							@endphp
							<div class="col-md-6 mb-1">
								<div class="form-inline" id="form-select">
								@if(session()->get('nama_jabatan') == "Staf BOS")
									@if (!$jenisBM->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisBMasuk">
											<option value="">All</option>
											@foreach ($jenisBM->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
									@if (!$jenisBK->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisBKeluar">
											<option value="">All</option>
											@foreach ($jenisBK->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
								@elseif(session()->get('nama_jabatan') == "Staf APBD")
									@if (!$jenisAM->isEmpty())
										<div class="form-inline d-none" id="jenisAMasuk">
											<label class="label">Jenis Pengajuan</label>
											<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisAMasuk">
												<option value="">All</option>
												@foreach ($jenisAM->all() as $j)
													<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
												@endforeach
											</select>
										</div>
									@endif
									@if (!$jenisAK->isEmpty())
										<select class="form-control form-control-sm long-option d-none" name="JenisPengajuan" id="jenisAKeluar">
											<option value="">All</option>
											@foreach ($jenisAK->all() as $j)
												<option value={{ $j->id_jenis }} {{ $jenisPengajuan==$j->id_jenis? "selected":"" }}>{{ $j->nama_jenis }}</option>
											@endforeach
										</select>
									@endif
								@endif
								
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md text-center">
								<div class="form-group">
									<input type="submit" value="Show" name="" class="btn btn-primary theme-1" style="width: 6rem;" />
								</div>
							</div>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
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
	{{-- Chart --}}
	<div class="row">
		<div class="col-md">
			<div class="card" style="padding: 30px">
				<div id="chart"></div>
			</div>
		</div>
		
	</div>
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
	
	@push('js')
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script>
		Highcharts.chart('chart', {

			title: {
				text: 'Transaction Logs Chart'
			},

			yAxis: {
				title: {
					text: 'Jumlah (Rp)'
				}
			},

			xAxis: {
				categories: {!!json_encode($categories)!!}
			},

			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},

			plotOptions: {
				series: {
					label: {

						connectorAllowed: false
					},
					connectNulls : true, 
				},
				rules: [{
					chartOptions: {  
						
					}  
				}]
			},

			series: [{
				name: 'Pemasukkan',
				color :'#06d6a0',
				data : {!!json_encode($dataMasuk)!!},
				// data: {!!json_encode($dataMasuk)!!},
			}, {
				name: 'Pengeluaran',
				color: '#ef476f',
				data: {!!json_encode($dataKeluar)!!},
			}],

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

			});
	</script>
	<script>
		function showJenisExtended(){
			var bm = document.getElementById("jenisBMasuk");
			var bk = document.getElementById("jenisBKeluar");
			var am = document.getElementById("jenisAMasuk");
			var ak = document.getElementById("jenisAKeluar");
			var selectionD = document.getElementById("pilihanD");
			var selectedDText = selectionD.options[selectionD.selectedIndex].text;
			var selectionP = document.getElementById("pilihanP");
			var selectedPText = selectionP.options[selectionP.selectedIndex].text;
			if(selectedDText == "BOS"){
				if(ak) {
					ak.classList.add("d-none");
					ak.disabled = true;
				}
				if(am){
					am.classList.add("d-none");	
					am.disabled = true;
				}
				if(selectedPText == "Pemasukan"){
					if(bm){
						bm.classList.remove("d-none");
						bm.disabled = false;
					} 
					if(bk){
						bk.classList.add("d-none");
						bk.disabled = true;
					}
				}
				else if (selectedPText == "Penggunaan"){
					if(bk) {
						bk.classList.remove("d-none");
						bk.disabled = false;
					}
					if(bm) {
						bm.classList.add("d-none");
						bm.disabled = true;
					}
				}
			}
			else if(selectedDText == "APBD"){
				if(bk){
					bk.classList.add("d-none");
					bk.disabled = true;
				}
				if(bm) {
					bm.classList.add("d-none");
					bm.disabled = true;
				}
				if(selectedPText == "Pemasukan"){
					if(am) {
						am.classList.remove("d-none");
						am.disabled = false;
					}
					if(ak) {
						ak.classList.add("d-none");
						ak.disabled = true;
					}
				}
				else if (selectedPText == "Penggunaan"){
					if(ak){
						ak.classList.remove("d-none");
						ak.disabled = false;
					}
					if(am){
						am.classList.add("d-none");	
						am.disabled = true;
					} 
				}
			}
			if(selectedPText == "All" || selectedDText == "All"){
				if(bk){
					bk.classList.add("d-none");
					bk.disabled = true;
				} 
				if(bm) {
					bm.classList.add("d-none");
					bm.disabled = true;
				}
				if(ak) {
					ak.classList.add("d-none");
					ak.disabled = true;
				}
				if(am){
					am.classList.add("d-none");	
					am.disabled = true;
				} 
			}
		}
		window.onload = function() {
			showJenisExtended();
		};
	</script>
	@endpush
	
@endsection