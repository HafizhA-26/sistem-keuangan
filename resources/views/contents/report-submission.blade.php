@extends('layouts.layout-report')

@section('sub-content')
	<!-- NOTE : YANG ADA IF NYA LINE = 6, 106, 117, 121, 211 -->

    @if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Admin") <!-- Jabatan = Kepsek, Ka. Keuangan-->
	<div class="content">
		<div class="back">
			<a href="/report"><i class="fa fa-arrow-left icon3" title="Back to Report"></i></a>
		</div>
		<div class="header_report">
			<h4>Laporan Pengajuan</h4>
		</div> <br>

		<div class="box1 box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Tabel Pengajuan</h3>

				<div class="right">
					<form class="form-inline" action="/report-submission" method="get">
						<div class="form-group">
							<input type="text" name="search" placeholder="Search" class="form-control search" id="searchInput" autocomplete="off"> <!-- PERLU BACKEND -->
							<button type="submit" class="btn btn-info" id="searchButton"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
			</div>
			<div class="box-info">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Pengajuan</th>
								<th>Pengaju</th>
								<th>Jumlah</th>
								<th>Tanggal</th>
								<th>Status</th>
								<th>Detail Pengajuan</th>
							</tr>
						</thead>
					<tbody id="dataTable">
					@foreach ($report->all() as $r)
						@php
							// Memformat tanggal jadi format Hari-Bulan-Tahun
							$date = date_create($r->created_at);
							$date = date_format($date, "d-m-Y");

							// Mengambil file extension di variabel $file_ex
							$file_ex = substr($r->file_lampiran,-3);

							// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
							$file_path = storage_path() .'/uploaded_file/'. $r->file_lampiran;
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
							$jumlah = number_format($r->jumlah,2,",",".");
						@endphp
						<tr>
							<td>{{ $r->judul }}</td> <!-- PERLU BACKEND -->

							{{-- Mengambil data jurusan jika terdapat id_jurusannya --}}
							@if ($r->id_jurusan)
								@php
									$jurusan = \App\Models\Jurusan::find($r->id_jurusan);
								@endphp
								<td>{{ $r->nama }} / {{ $jurusan->nama_jurusan }}</td> <!-- PERLU BACKEND -->
							@else 
								<td>{{ $r->nama }}</td> <!-- PERLU BACKEND -->
							@endif
							<td>Rp. {{ $jumlah }}</td>
							<td>{{ $date }}</td> <!-- PERLU BACKEND -->
							<td>{{ $r->status }}</td> <!-- PERLU BACKEND -->
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Lihat Detail</button></td>

					
						</tr>

						<!-- Modal -->
						<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
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

											{{-- cek jika ada file_lampiran --}}
											@if ($r->file_lampiran)
												<div class="alert alert-primary">

													{{-- Bagian untuk penampilan file --}}
													
													<a class="file-click row m-0 text-decoration-none" href="download/{{ $r->file_lampiran }}" title="{{ $r->file_lampiran }}" >
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
															{{ $r->file_lampiran }}
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
										
										<div class="modal-body bottom">
											<label><b>Status : </b></label>
											<label><mark class="bg-light">{{ $r->status }}</mark></label> <!-- CANTUMKAN STATUS -->
										</div>
										<div class="modal-body bottom">
											<label><b>Id Transaksi : </b></label>
											<label><mark class="bg-light">{{ $r->id_transaksi }}</mark></label> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
										</div>
										<div class="modal-body bottom">
											<label><b>Pengaju : </b></label>
											<label>{{ $r->nama }}</label> <!-- CANTUMKAN NAMA PENGAJU -->
										</div>
										<div class="modal-body bottom">
											<label><b>Tanggal Diajukan : </b></label>
											<label>{{ $date }}</label> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
										</div>

										@php
											// Ambil daftar comment dari pengajuan terkait
											$comments = DB::table('comments')
												->join('detail_accounts','detail_accounts.nip','=','comments.nip')
												->where('id_pengajuan','=',$r->id_pengajuan)
												->get();
										@endphp

										@foreach ($comments->all() as $c)
											<div class="modal-body bottom">
												<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
												<label>{{ $c->nama }}</label> <br><br> <!-- GET NAMA PENGOMENTAR-->
												<textarea disabled="" class="form-control" style="font-size: 0.8rem">{{ $c->komentar }}</textarea> <!-- GET KOMENTAR-->
											</div>
										@endforeach
										
									</div>

									<!-- Footer -->
									<div class="modal-footer">
										<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</tbody>
					</table>
					{{-- Pagination table, layout pagination ada di resources/views/vendor/pagination/bootstrap-4.blade.php  --}}
					
						{{ $report->links() }}
					
				</div>
			</div>
		</div>

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") <!-- Jabatan = Staf APBD, Staf BOS-->
	<div class="content">
		<div class="back">
			<a href="/report"><i class="fa fa-arrow-left icon3" title="Back to Report"></i></a>
		</div>
		<div class="header_report">
			<h4>Laporan Pengajuan</h4>
		</div> <br>

		<div class="box1 box-info">
			<div class="box-header with-border">
			@if(session()->get('nama_jabatan') == "Staf APBD") <!--Jabatan = Staf APBD-->
				<h3 class="box-title">Tabel Pengajuan APBD</h3>
			@endif

			@if(session()->get('nama_jabatan') == "Staf BOS") <!--Jabatan = Staf BOS-->
				<h3 class="box-title">Tabel Pengajuan BOS</h3>
			@endif
				<div class="right">
					<form class="form-inline" action="/report-submission" method="get">
						<div class="form-group">
							<input type="text" name="search" placeholder="Search" class="form-control search" id="searchInput" autocomplete="off"> <!-- PERLU BACKEND -->
							<button type="submit" class="btn btn-info" id="searchButton"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
			</div>
			<div class="box-info">
				<div class="table-responsive">
				<!-- TAMPILKAN SESUAI JENIS DANA, JIKA STAF APBD = HANYA TAMPILKAN APBD, JIKA BOS = HANYA TAMPILKAN BOS-->
					<table class="table">
					<tr>
						<th>Pengajuan</th>
						<th>Pengaju</th>
						<th>Jumlah</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Detail Pengajuan</th>
					</tr>
					@foreach ($report->all() as $r)
					@php
						// Memformat tanggal jadi format Hari-Bulan-Tahun
						$date = date_create($r->created_at);
						$date = date_format($date, "d-m-Y");

						// Mengambil file extension di variabel $file_ex
						$file_ex = substr($r->file_lampiran,-3);

						// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
						$file_path = storage_path() .'/uploaded_file/'. $r->file_lampiran;
						$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
						$jumlah = number_format($r->jumlah,2,",",".");
					@endphp
					<tr>
						<td>{{ $r->judul }}</td> <!-- PERLU BACKEND -->

						{{-- Mengambil data jurusan jika terdapat id_jurusannya --}}
						@if ($r->id_jurusan)
							@php
								$jurusan = \App\Models\Jurusan::find($r->id_jurusan);
							@endphp
							<td>{{ $r->nama }} / {{ $jurusan->nama_jurusan }}</td> <!-- PERLU BACKEND -->
						@else 
							<td>{{ $r->nama }}</td> <!-- PERLU BACKEND -->
						@endif
						<td>Rp. {{ $jumlah }}</td>
						<td>{{ $date }}</td> <!-- PERLU BACKEND -->
						<td>{{ $r->status }}</td> <!-- PERLU BACKEND -->
						<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Lihat Detail</button></td>
					</tr>

					<!-- Modal -->
					<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
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

										{{-- cek jika ada file_lampiran --}}
										@if ($r->file_lampiran)
											<div class="alert alert-primary">

												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click row m-0 text-decoration-none" href="download/{{ $r->file_lampiran }}" title="{{ $r->file_lampiran }}" >
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
														{{ $r->file_lampiran }}
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
									
									<div class="modal-body bottom">
										<label><b>Status : </b></label>
										<label><mark class="bg-light">{{ $r->status }}</mark></label> <!-- CANTUMKAN STATUS -->
									</div>
									<div class="modal-body bottom">
										<label><b>Id Transaksi : </b></label>
										<label><mark class="bg-light">{{ $r->id_transaksi }}</mark></label> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
									</div>
									<div class="modal-body bottom">
										<label><b>Pengaju : </b></label>
										<label>{{ $r->nama }}</label> <!-- CANTUMKAN NAMA PENGAJU -->
									</div>
									<div class="modal-body bottom">
										<label><b>Tanggal Diajukan : </b></label>
										<label>{{ $date }}</label> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
									</div>

									@php
										// Ambil daftar comment dari pengajuan terkait
										$comments = DB::table('comments')
											->join('detail_accounts','detail_accounts.nip','=','comments.nip')
											->where('id_pengajuan','=',$r->id_pengajuan)
											->get();
									@endphp

									@foreach ($comments->all() as $c)
										<div class="modal-body bottom">
											<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
											<label>{{ $c->nama }}</label> <br><br> <!-- GET NAMA PENGOMENTAR-->
											<textarea disabled="" class="form-control" style="font-size: 0.8rem">{{ $c->komentar }}</textarea> <!-- GET KOMENTAR-->
										</div>
									@endforeach
									
								</div>

								<!-- Footer -->
								<div class="modal-footer">
									<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					</table>
					{{ $report->links() }}
				</div>
			</div>
		</div>

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Kaprog") <!-- Jabatan = Kaprog-->
	<div class="content">
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
						<th>Jumlah</th>
						<th>Jenis Dana</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Detail Pengajuan</th>
					</tr>
					@foreach ($report->all() as $r)
					@php
						// Memformat tanggal jadi format Hari-Bulan-Tahun
						$date = date_create($r->created_at);
						$date = date_format($date, "d-m-Y");
						// Mengambil file extension di variabel $file_ex
						$file_ex = substr($r->file_lampiran,-3);

						// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
						
						$file_path = storage_path() .'/uploaded_file/'. $r->file_lampiran;
						if(file_exists($file_path))
							$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
						$jumlah = number_format($r->jumlah,2,",",".");
						if(strpos($r->status,"ACC-3") !== false){
							$status = "Diterima";
						}else{
							$status = "Ditolak";
						}
					@endphp
					<tr>
						<td>{{ $r->judul }}</td> <!-- PERLU BACKEND -->

						{{-- Mengambil data jurusan jika terdapat id_jurusannya --}}
						@if ($r->id_jurusan)
							@php
								$jurusan = \App\Models\Jurusan::find($r->id_jurusan);
							@endphp
							<td>{{ $r->nama }} / {{ $jurusan->nama_jurusan }}</td> <!-- PERLU BACKEND -->
						@else 
							<td>{{ $r->nama }}</td> <!-- PERLU BACKEND -->
						@endif
						<td>Rp. {{ $jumlah }}</td>
						<td>{{ $r->id_dana }}</td>
						<td>{{ $date }}</td> <!-- PERLU BACKEND -->
						<td>{{ $status }}</td> <!-- PERLU BACKEND -->
						<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Lihat Detail</button></td>
					</tr>
					<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
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

										{{-- cek jika ada file_lampiran --}}
										@if ($r->file_lampiran)
										@if (!file_exists(storage_path() .'/uploaded_file/'. $r->file_lampiran))
											<div class="alert alert-warning text-center" role="alert">
												File is missing, contact the submitter to re-submit his submission
											</div>
										@else
											<div class="alert alert-primary">
												
												{{-- Bagian untuk penampilan file --}}
												
												<a class="file-click m-0 text-decoration-none" href="download/{{ $r->file_lampiran }}" title="{{ $r->file_lampiran }}" >
													<div class="d-flex flex-wrap align-items-center flex-md-row">
												
														<div class="ikon">
	
															{{-- Cek extension file dan mengubah icon sesuai filenya--}}
															@if ($file_ex == "pdf")
																<i class="fas fa-file-pdf"></i>
															@else
																<i class="fas fa-file-alt"></i>
															@endif
	
														</div>
	
														{{-- Menampilkan judul dan size file lampiran --}}
														<div class="file-title text-truncate">
															{{ $r->file_lampiran }}
															<div class="file-size">
																{{ $size }}
															</div>
														</div>
															
													</div>
												</a>
											</div>
										@endif


									{{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
									@else
										<div class="alert alert-warning text-center" role="alert">
											There is no attached file
										  </div>
									@endif
									</div>
									
									<div class="modal-body bottom">
										<label><b>Status : </b></label>
										<label><mark class="bg-light">{{ $r->status }}</mark></label> <!-- CANTUMKAN STATUS -->
									</div>
									<div class="modal-body bottom">
										<label><b>Id Transaksi : </b></label>
										<label><mark class="bg-light">{{ $r->id_transaksi }}</mark></label> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
									</div>
									<div class="modal-body bottom">
										<label><b>Pengaju : </b></label>
										<label>{{ $r->nama }}</label> <!-- CANTUMKAN NAMA PENGAJU -->
									</div>
									<div class="modal-body bottom">
										<label><b>Tanggal Diajukan : </b></label>
										<label>{{ $date }}</label> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
									</div>

									@php
										// Ambil daftar comment dari pengajuan terkait
										$comments = DB::table('comments')
											->join('detail_accounts','detail_accounts.nip','=','comments.nip')
											->where('id_pengajuan','=',$r->id_pengajuan)
											->get();
									@endphp

									@foreach ($comments->all() as $c)
										<div class="modal-body bottom">
											<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
											<label>{{ $c->nama }}</label> <br><br> <!-- GET NAMA PENGOMENTAR-->
											<textarea disabled="" class="form-control" style="font-size: 0.8rem">{{ $c->komentar }}</textarea> <!-- GET KOMENTAR-->
										</div>
									@endforeach
									
								</div>

								<!-- Footer -->
								<div class="modal-footer">
									<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					
					</table>
					{{ $report->links() }}
				</div>
			</div>
		</div>

	</div>
	@endif
@endsection