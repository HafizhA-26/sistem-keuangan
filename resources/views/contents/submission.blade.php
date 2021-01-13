@extends('layouts.layout-submission')

@section('sub-content')

	{{-- NOTE for Aria --}}
	{{-- KALAU MAU NGUJI KONTENNYA TAMBAHIN DI IF NYA "|| session()->get('nama_jabatan') == Admin" --}}

	@if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS" || session()->get('nama_jabatan') == "Admin" ) <!-- Jabatan =  Ka. Keuangan, Kepsek, Staf APBD, Staf BOS -->
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
		<!-- TABEL SUBMISSION UNTUK KEPALA SEKOLAH -->
		@if(session()->get('nama_jabatan') == "Kepala Sekolah")
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
					@php
							// Mengambil file extension di variabel $file_ex
							$file_ex = substr($data->file_lampiran,-3);

							// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
							$file_path = storage_path() .'/uploaded_file/'. $data->file_lampiran;
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
							$jumlah = number_format($data->jumlah,2,",",".");
					@endphp
					
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
										<label><b>File Lampiran</b></label>

										{{-- cek jika ada file_lampiran --}}
										@if ($data->file_lampiran)
											<div class="alert alert-primary">

												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click row m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
													<div class="col-md-2 ikon" style="font-size: 2rem">

														{{-- Cek extension file dan mengubah icon sesuai filenya--}}
														@if ($file_ex == "pdf")
															<i class="fas fa-file-pdf"></i>
														@else
															<i class="fas fa-file-alt"></i>
														@endif

													</div>

													{{-- Menampilkan judul dan size file lampiran --}}
													<div class="col-md file-title text-truncate font-weight-bold" style="font-size: 1.3rem">
														{{ $data->file_lampiran }}
														<div class="file-size" style="font-size: 0.6rem">
															{{ $size }}
														</div>
													</div>

												</a>
											</div>

										{{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
										@else
											<div class="alert alert-warning" role="alert">
												Tidak ada file lampiran
											  </div>
										@endif
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
								<button class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Izinkan</button>
								<button class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Tidak Izinkan</button>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/diizinkankepsek">
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
											<form method="POST" action="/submission/tidakdiizinkankepsek">
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
		@endif
		<!-- TABEL SUBMISSION UNTUK KEPALA KEUANGAN -->
		@if(session()->get('nama_jabatan') == "Kepala Keuangan")
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
						@php
							// Mengambil file extension di variabel $file_ex
							$file_ex = substr($data->file_lampiran,-3);

							// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
							$file_path = storage_path() .'/uploaded_file/'. $data->file_lampiran;
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
							$jumlah = number_format($data->jumlah,2,",",".");
						@endphp
					
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
										<label><b>File Lampiran</b></label>

										{{-- cek jika ada file_lampiran --}}
										@if ($data->file_lampiran)
											<div class="alert alert-primary">

												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click row m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
													<div class="col-md-2 ikon" style="font-size: 2rem">

														{{-- Cek extension file dan mengubah icon sesuai filenya--}}
														@if ($file_ex == "pdf")
															<i class="fas fa-file-pdf"></i>
														@else
															<i class="fas fa-file-alt"></i>
														@endif

													</div>

													{{-- Menampilkan judul dan size file lampiran --}}
													<div class="col-md file-title text-truncate font-weight-bold" style="font-size: 1.3rem">
														{{ $data->file_lampiran }}
														<div class="file-size" style="font-size: 0.6rem">
															{{ $size }}
														</div>
													</div>

												</a>
											</div>

										{{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
										@else
											<div class="alert alert-warning" role="alert">
												Tidak ada file lampiran
											  </div>
										@endif
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
								<button class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Izinkan</button>
								<button class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Tidak Izinkan</button>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/diizinkankakeuangan">
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
											<form method="POST" action="/submission/tidakdiizinkankakeuangan">
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
		@endif
		<!-- TABEL SUBMISSION UNTUK BOS -->
		@if(session()->get('nama_jabatan') == "Staf BOS")
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
						@php
							// Mengambil file extension di variabel $file_ex
							$file_ex = substr($data->file_lampiran,-3);

							// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
							$file_path = storage_path() .'/uploaded_file/'. $data->file_lampiran;
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
							$jumlah = number_format($data->jumlah,2,",",".");
						@endphp
					
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
										<label><b>File Lampiran</b></label>

										{{-- cek jika ada file_lampiran --}}
										@if ($data->file_lampiran)
											<div class="alert alert-primary">

												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click row m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
													<div class="col-md-1 ikon" style="font-size: 3rem">

														{{-- Cek extension file dan mengubah icon sesuai filenya--}}
														@if ($file_ex == "pdf")
															<i class="fas fa-file-pdf"></i>
														@else
															<i class="fas fa-file-alt"></i>
														@endif

													</div>

													{{-- Menampilkan judul dan size file lampiran --}}
													<div class="col-md file-title text-truncate font-weight-bold">
														{{ $data->file_lampiran }}
														<div class="file-size">
															{{ $size }}
														</div>
													</div>

												</a>
											</div>

										{{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
										@else
											<div class="alert alert-warning" role="alert">
												Tidak ada file lampiran
											  </div>
										@endif
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
								<a class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Izinkan</a>
								<a class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Tidak Izinkan</a>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/diizinkanbos">
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
											<form method="POST" action="/submission/tidakdiizinkanbos">
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
		@endif
		<!-- TABEL SUBMISSION UNTUK APBD -->
		@if(session()->get('nama_jabatan') == "Staf APBD")
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
						@php
							// Mengambil file extension di variabel $file_ex
							$file_ex = substr($data->file_lampiran,-3);

							// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
							$file_path = storage_path() .'/uploaded_file/'. $data->file_lampiran;
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
							$jumlah = number_format($data->jumlah,2,",",".");
						@endphp
					
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
										<label><b>File Lampiran</b></label>

										{{-- cek jika ada file_lampiran --}}
										@if ($data->file_lampiran)
											<div class="alert alert-primary">

												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click row m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
													<div class="col-md-2 ikon" style="font-size: 2rem">

														{{-- Cek extension file dan mengubah icon sesuai filenya--}}
														@if ($file_ex == "pdf")
															<i class="fas fa-file-pdf"></i>
														@else
															<i class="fas fa-file-alt"></i>
														@endif

													</div>

													{{-- Menampilkan judul dan size file lampiran --}}
													<div class="col-md file-title text-truncate font-weight-bold" style="font-size: 1.3rem">
														{{ $data->file_lampiran }}
														<div class="file-size" style="font-size: 0.6rem">
															{{ $size }}
														</div>
													</div>

												</a>
											</div>

										{{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
										@else
											<div class="alert alert-warning" role="alert">
												Tidak ada file lampiran
											  </div>
										@endif
									</div>
								</div>

								<!-- Footer -->
								<div class="modal-footer">
								<a class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Izinkan</a>
								<a class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Tidak Izinkan</a>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="/submission/diizinkanapbd">
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
											<form method="POST" action="/submission/tidakdiizinkanapbd">
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
		@endif
	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Kaprog") <!-- Jabatan = Kaprog-->
	<div class="content">
		<div class="card">
			<div class="card-header">
				<h4>Tambah Pengajuan</h1>
			</div>
			<div class="card-body">
				<form class="/submission/add" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label class="label">Judul Pengajuan</label>
						<input type="text" name="judul" class="form-control" placeholder="Masukan Judul Pengajuan" autocomplete="off">
					</div>
					
					<div class="form-group">
						<label class="label">Pilih ID Dana</label>
						<select class="form-control" name="id_Dana">
							<option disabled selected>-- Select --</option>
							<option value="BOS">BOS</option>
							<option value="APBD">APBD</option>
						</select>
					</div>
					<div class="form-group">
						<label class="label">Jumlah</label>
						<input type="text" name="jumlah" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukan Jumlah Dana" autocomplete="off">
					</div>
					<div class="form-group">
						<label class="label">Deskripsi</label>
						<textarea class="form-control desk" name="deskripsi" placeholder="Masukan Deskripsi atau Penjelasan" maxlength="1000" autocomplete="off"></textarea>
					</div>
					<div class="form-group">
						<label class="label">File Lampiran</label>
						<input type="file" name="file_lampiran" class="form-control-file"> <br>
					</div>
					
					{{-- NOTE --}}
					{{-- Ini input hidden buat id_submission, id_transaksi, id_user, dan id_dana --}}
					<input type="hidden" name="pilihan" value="Penggunaan">
					<input type="hidden" name="jenis" value="Pending">
					<input type="hidden" name="namajabatan" id="namajabatan" value="Kaprog"><br>
					<input type="hidden" name="idPengajuan" id="idPengajuan" value="{{ $idPengajuan }}"><br>
					<input type="hidden" name="idTransaksi" id="idTransaksi" value="{{ $idTransaksi }}"><br>
					<input type="hidden" name="idPengaju" value="{{ $idUser }}"><br>
					<div class="form-group">
						<input type="submit" name="buttonsubmit" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif
	
@endsection