@extends('layouts.layout-submission')

@section('sub-content')
	<div class="content background-1">
		<div class="header_submission">
			<h4>Daftar Pengajuan</h4>
		</div>
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
			<table class="table">
				<tr>
					<th>Pengajuan</th>
					<th>Pengaju</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Detail Pengajuan</th>
				</tr>
				<tr>
					<td>Judul Pengajuan</td> <!-- PERLU BACKEND -->
					<td>Nama Jurusan</td> <!-- PERLU BACKEND -->
					<td>20-10-20</td> <!-- PERLU BACKEND -->
					<td>-</td> <!-- PERLU BACKEND -->
					<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail">Lihat Detail</button></td>

					<!-- Modal -->
					<div class="modal" id="detail">
						<div class="modal-dialog">
							<div class="modal-content">
								
								<!-- Header --->
								<div class="modal-header">
									<h4 class="modal-title">Judul Pengajuan</h4> <!-- DI GET DARI DATA PENGAJU -->
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<!-- Body -->
								<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU -->
									Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

									<div class="modal-body bottom">
										<label><b>File Lampiran<b></label>
											<!-- NANTI DI SINI TERCANTUM FILE LAMPIRAN -->
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#izinkan">Izinkan</button>

									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Izinkan</h5>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<label class="mid">Berikan Komentar</label>
													<textarea class="form-control"></textarea>
												</div>
												<div class="modal-footer">
													<input type="submit" name="submit" class="btn btn-primary" value="Submit">
												</div>
											</div>
										</div>
									</div>

									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan">Tidak Izinkan</button>

									<!-- Modal Tidak Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="tidakizinkan">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Tidak Izinkan</h5>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<label class="mid">Berikan Alasan</label>
													<textarea class="form-control"></textarea>
												</div>
												<div class="modal-footer">
													<input type="submit" name="submit" class="btn btn-primary" value="Submit">
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</tr>
			</table>
		</div>
	</div>
@endsection