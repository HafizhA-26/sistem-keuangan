@extends('layouts.layout-report')

@section('sub-content')
    <div class="content">
		<div class="back">
			<a href="/report"><i class="fa fa-arrow-left" title="Back to Report"></i></a>
		</div>
		<div class="header_report">
			<h4>Laporan Pengajuan</h4>
		</div> <br>

		<div class="box1 box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Tabel Pengajuan</h3>

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
					<table class="table">
					<tr>
						<th>Pengajuan</th>
						<th>Pengaju</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Detail Pengajuan</th>
					</tr>
					@foreach ($report->all() as $r)
						<tr>
							<td>{{ $r->judul }}</td> <!-- PERLU BACKEND -->
							<td>{{ $r->nama }}{{ $r->nama_jurusan? '/'.$r->nama_jurusan : '' }}</td> <!-- PERLU BACKEND -->
							<td>{{ $r->updated_at }}</td> <!-- PERLU BACKEND -->
							<td>{{ $r->status }}</td> <!-- PERLU BACKEND -->
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Lihat Detail</button></td>

					<!-- Modal -->
					<div class="modal" id="detail{{ $r->id_pengajuan }}">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								
								<!-- Header --->
								<div class="modal-header">
									<h4 class="modal-title">{{ $r->judul }}</h4> <!-- DI GET DARI DATA PENGAJU -->
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

									<!-- Body -->
									<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU --> <!-- DESKRIPSI -->
										{{ $r->deskripsi }}

										<div class="modal-body bottom">
											<label><b>File Lampiran</b></label>
												<!-- CANTUMKAN FILE LAMPIRAN -->
										</div>
										<div class="modal-body bottom">
											<label><b>Status : </b></label>
											<label>{{ $r->status }}</label> <!-- CANTUMKAN STATUS -->
										</div>
										<div class="modal-body bottom">
											<label><b>Id Transaksi : </b></label>
											<label>{{ $r->id_transaksi }}</label> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
										</div>
										<div class="modal-body bottom">
											<label><b>Pengaju : </b></label>
											<label>{{ $r->nama }}</label> <!-- CANTUMKAN NAMA PENGAJU -->
										</div>
										<div class="modal-body bottom">
											<label><b>Tanggal Diajukan : </b></label>
											<label>{{ $r->created_at }}</label> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
										</div>
										<div class="modal-body bottom">
											<img src="../img/icon/stm.png" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
											<label>Nama Pengomentar</label> <br><br> <!-- GET NAMA PENGOMENTAR-->
											<textarea disabled="" class="form-control"></textarea> <!-- GET KOMENTAR-->
										</div>
									</div>

									<!-- Footer -->
									<div class="modal-footer">
										<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>
						</tr>
					@endforeach
					
					</table>
				</div>
			</div>
		</div>

	</div>
@endsection