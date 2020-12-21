@extends('layouts.layout-submission')

@section('sub-content')

	{{-- NOTE for Aria --}}
	{{-- KALAU MAU NGUJI KONTENNYA TAMBAHIN DI IF NYA "|| session()->get('nama_jabatan') == Admin" --}}

	@if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS" ) <!-- Jabatan =  Ka. Keuangan, Kepsek, Staf APBD, Staf BOS -->
	<div class="content">
		<div class="header_submission">
			<h4>Daftar Pengajuan</h4>
		</div>

		@if(session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") <!-- Jabatan = Staf APBD, Staf BOS-->
		<div class="left">
			<a href="/addsubmission"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Submission</button></a>
		</div>
		@endif

		<div class="right">
			<form class="form-inline" method="post">
				<div class="form-group">
					<input type="text" name="" placeholder="Search" class="form-control"> <!-- PERLU BACKEND -->
					<button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
		<br><br>
		<div>
			<!-- SEMUA ISI TABLE NGE GET DARI DATA PENGAJU -->
			<table class="table" id="tablesubmission">
				<tr>
                    <th>No</th>
					<th>Pengajuan</th>
					<th>Pengaju</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Detail Pengajuan</th>
				</tr>
				<tr>
                    @foreach ($datasub as $dtsub)
                    <td>{{ $loop->iteration }}</td> <!-- PERLU BACKEND -->
					<td>{{$dtsub->judul}}</td> <!-- PERLU BACKEND -->
					<td>{{$dtsub->nama}}</td> <!-- PERLU BACKEND -->
                    <td>{{$dtsub->created_at}}</td> <!-- PERLU BACKEND -->
                    <td>{{$dtsub->status}}</td>
				<td><a href="" class="btn btn-secondary detail" data-toggle="modal" data-target="#detail-{{$dtsub->id_pengajuan}}">Lihat Detail</a></td>
                </tr>
					@endforeach
					@foreach ($datasub as $data)
						
					
					<!-- Modal -->
				<div class="modal" id="detail-{{ $data->id_pengajuan }}" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								
								<!-- Header --->
								<div class="modal-header">
									<h4 class="modal-title" id="judul">{{$data->judul}}</h4> <!-- DI GET DARI DATA PENGAJU -->
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Body -->
								<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU -->
									<p id="deskripsi">{{ $data->deskripsi }}</p>

									<div class="modal-body bottom">
										<label><b>File Lampiran<b></label>
											<!-- NANTI DI SINI TERCANTUM FILE LAMPIRAN -->
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
								<a class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Izinkan</a>
								<a class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Tidak Izinkan</a>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/diizinkan">
												@csrf
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Izinkan</h5>	
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<input type="hidden" name="jumlah" value="{{ $data->jumlah }}">
													<input type="hidden" value="{{ $data->id_pengajuan }}" name="id_pengajuan">
													<input type="hidden" value="{{ $data->id_transaksi }}" name="id_transaksi">
													<input type="hidden" value="{{$data->id_dana}}" name="idDana">
													<input type="hidden" name="status" value="{{$data->status}}">
													<label class="mid">Berikan Komentar</label>
													<textarea class="form-control" name="komentar"></textarea>
												</div>
												<div class="modal-footer">
													<input type="submit" name="submit" class="btn btn-primary" value="Submit">
												</div>
											</div>
										</form>
										</div>
									</div>

									

									<!-- Modal Tidak Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="tidakizinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/tidakdiizinkan">
												@csrf
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Tidak Izinkan</h5>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<input type="hidden" name="jumlah" value="{{ $data->jumlah }}">
													<input type="hidden" value="{{ $data->id_pengajuan }}" name="id_pengajuan">
													<input type="hidden" value="{{ $data->id_transaksi }}" name="id_transaksi">
													<input type="hidden" name="status" value="{{$data->status}}">
													<label class="mid">Berikan Alasan</label>
													<textarea class="form-control" name="komentar"></textarea>
												</div>
												<div class="modal-footer">
													<input type="submit" name="submit" class="btn btn-primary" value="Submit">
												</div>
											</div>
											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					@endforeach
			</table>
		</div>
	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Kaprog") <!-- Jabatan = Kaprog-->
	<div class="content">
		<div class="card">
			<div class="card-header">
				<h4>Tambah Pengajuan</h1>
			</div>
			<div class="card-body">
				<form class="" method="post">
					<div class="form-group">
						<label class="label">Judul Pengajuan</label>
						<input type="text" name="" class="form-control" placeholder="Masukan Judul Pengajuan">
					</div>
					<div class="form-group">
						<label class="label">Deskripsi</label>
						<textarea class="form-control desk" placeholder="Masukan Deskripsi atau Penjelasan" maxlength="1000"></textarea>
					</div>
					<div class="form-group">
						<label class="label">File Lampiran</label>
						<input type="file" name="" class="form-control-file"> <br>
					</div>
					<div class="form-group">
						<label class="label">Jenis Dana</label>
						<select class="form-control">
							<option disabled selected>-- Select --</option>
							<option>APBD</option>
							<option>BOS</option>
						</select>
					</div>

					<br><br>
					<div class="form-group">
						<input type="submit" name="" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif
	
@endsection