@extends('layouts.layout-sidebar')

@section('web-content')
	<label class="d-none" id="searchtable">{{ $search }}</label>	
	<!-- NOTE : YANG ADA IF NYA LINE = 6, 106, 117, 121, 211 -->
    @if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Admin") <!-- Jabatan = Kepsek, Ka. Keuangan-->
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body res-text-center">
					<a href="/export-excel-submission" class="btn btn-primary theme-2 mb-3" >Export to Excel <i class="fas fa-file-export ml-2"></i></a>
					<table class="data-table display nowrap" cellspacing="0" id="dataTable">
						<thead>
							<tr>
								<th data-priority="1">No</th>
								<th data-priority="2">Pengajuan</th>
								<th data-priority="3">Pengaju</th>
								<th data-priority="4">Jumlah</th>
								<th data-priority="5">Tanggal</th>
								<th data-priority="6">Status</th>
								<th data-priority="7">Action</th>
							</tr>
						</thead>
					<tbody>
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
							if(strpos($r->status,"ACC-3") !== false){
								$status = "Diterima";
							}else{
								$status = "Ditolak";
							}
						@endphp
						<tr class="text-center">
							<td>{{ $loop->iteration }}</td>
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
							<td style="color: {{ $status=='Ditolak'? 'var(--red)': 'var(--light-green)' }}">{{ $status }}</td> <!-- PERLU BACKEND -->
							<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Look Detail</button></td>

					
						</tr>

						<!-- Modal -->
						<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
								
									<!-- Header --->
									<div class="modal-header bg-blue" style="color: white">
										<h5 class="modal-title" id="judul">Submissions</h4> <!-- DI GET DARI DATA PENGAJU -->
										<button type="button" class="close" style="color: white" data-dismiss="modal"><i class="fas fa-times"></i></button>
									</div>

									<!-- Body -->
									<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU --> <!-- DESKRIPSI -->

										<div class="alert alert-primary" style="font-size: 0.9rem" role="alert">
											<pre>{{ $r->deskripsi }}</pre>
										</div>

										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title"><b>Attached File</b></span>
	
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
										
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Status : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $r->status }}</mark></span> <!-- CANTUMKAN STATUS -->
											<button class="btn btn-sm btn-link" id="status-hint" onclick="showHint()"><i class="fas fa-question"></i></button>
											<div class="alert alert-info row status-hint d-none" id="alert-hint">
												<div class="col-md-6">
													<b>ACC-3</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Sekolah
												</div>
												<div class="col-md-6">
													<b>ACC-2</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Keuangan
												</div>
												<div class="col-md-6">
													<b>ACC-1</b> <i class="fas fa-arrow-right"></i> Diterima Staf BOS/APBD
												</div>
												<div class="col-md-6">
													<b>K</b> <i class="fas fa-arrow-right"></i> Transaksi Keluar
												</div>
												<div class="col-md-6">
													<b>M</b> <i class="fas fa-arrow-right"></i> Transaksi Masuk
												</div>
											</div>
										</div>
										<div class="modal-body bottom d-flex align-items-center res-justify-center pt-1 pb-2">
											<span class="in-title">Id Transaksi : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $r->id_transaksi }}</mark></span> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
											<form action="/report/report-transaction" method="get" >
												<input type="hidden" name="search" value="{{ $r->id_transaksi}}">
												<button type="submit" class="btn btn-sm btn-link"><i class="fas fa-search"></i></button>
											</form>
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Pengaju : </span>
											<span class="in-desc">{{ $r->nama }}</span> <!-- CANTUMKAN NAMA PENGAJU -->
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Tanggal Diajukan : </span>
											<span class="in-desc">{{ $date }}</span> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
										</div>
										<div class="modal-body bottom pt-2 pb-1">
											<span class="in-title"><b>Comments : </b></span>
										</div>
										@php
											// Ambil daftar comment dari pengajuan terkait
											$comments = DB::table('comments')
												->join('detail_accounts','detail_accounts.nip','=','comments.nip')
												->where('id_pengajuan','=',$r->id_pengajuan)
												->get();
										@endphp

										@foreach ($comments->all() as $c)
											<div class="modal-body bottom pt-1 pb-2">
												<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
												<span class="in-title2">{{ $c->nama }}</span> <br><br> <!-- GET NAMA PENGOMENTAR-->
												<div class="alert alert-secondary komentar" style="font-size: 0.8rem" role="alert">
													<pre>{{ $c->komentar }}</pre>
												</div>
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
				</div>
			</div>
		</div>

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS") <!-- Jabatan = Staf APBD, Staf BOS-->
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body res-text-center">
					<a href="/export-excel-submission" class="btn btn-primary theme-2 mb-3" >Export to Excel <i class="fas fa-file-export ml-2"></i></a>
					<table class="data-table display nowrap" cellspacing="0" id="dataTable">
						<thead>
							<tr>
								<th data-priority="1">No</th>
								<th data-priority="2">Pengajuan</th>
								<th data-priority="3">Pengaju</th>
								<th data-priority="4">Jumlah</th>
								<th data-priority="5">Tanggal</th>
								<th data-priority="6">Status</th>
								<th data-priority="7">Action</th>
							</tr>
						</thead>
						<tbody>
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
							if(strpos($r->status,"ACC-3") !== false){
									$status = "Diterima";
								}else{
									$status = "Ditolak";
								}
						@endphp
						
							<tr class="text-center">
								<td>{{ $loop->iteration }}</td>
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
								<td style="color: {{ $status=='Ditolak'? 'var(--red)': 'var(--light-green)' }}">{{ $status }}</td> <!-- PERLU BACKEND -->
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Look Detail</button></td>
							</tr>
						
	
						<!-- Modal -->
						<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
								
									<!-- Header --->
									<div class="modal-header bg-blue" style="color: white">
										<h5 class="modal-title" id="judul">Submissions</h4> <!-- DI GET DARI DATA PENGAJU -->
										<button type="button" class="close" style="color: white" data-dismiss="modal"><i class="fas fa-times"></i></button>
									</div>
	
									<!-- Body -->
									<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU --> <!-- DESKRIPSI -->
										<div class="alert alert-primary" style="font-size: 0.9rem" role="alert">
											<pre>{{ $r->deskripsi }}</pre>
										</div>
	
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">File Lampiran</span>
	
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
										
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Status : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $r->status }}</mark></span> <!-- CANTUMKAN STATUS -->
											<button class="btn btn-sm btn-link" id="status-hint" onclick="showHint()"><i class="fas fa-question"></i></button>
											<div class="alert alert-info row status-hint d-none" id="alert-hint">
												<div class="col-md-6">
													<b>ACC-3</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Sekolah
												</div>
												<div class="col-md-6">
													<b>ACC-2</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Keuangan
												</div>
												<div class="col-md-6">
													<b>ACC-1</b> <i class="fas fa-arrow-right"></i> Diterima Staf BOS/APBD
												</div>
												<div class="col-md-6">
													<b>K</b> <i class="fas fa-arrow-right"></i> Transaksi Keluar
												</div>
												<div class="col-md-6">
													<b>M</b> <i class="fas fa-arrow-right"></i> Transaksi Masuk
												</div>
											</div>
										</div>
										<div class="modal-body bottom d-flex align-items-center res-text-center pt-1 pb-2">
											<span class="in-title">Id Transaksi : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $r->id_transaksi }}</mark></span> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
											<form action="/report/report-transaction" method="get" >
												<input type="hidden" name="search" value="{{ $r->id_transaksi}}">
												<button type="submit" class="btn btn-sm btn-link"><i class="fas fa-search"></i></button>
											</form>
											
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Pengaju : </span>
											<span class="in-desc">{{ $r->nama }}</span> <!-- CANTUMKAN NAMA PENGAJU -->
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Tanggal Diajukan : </span>
											<span class="in-desc">{{ $date }}</span> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
										</div>
										<div class="modal-body bottom pt-2 pb-1">
											<span class="in-title"><b>Comments : </b></span>
										</div>
										@php
											// Ambil daftar comment dari pengajuan terkait
											$comments = DB::table('comments')
												->join('detail_accounts','detail_accounts.nip','=','comments.nip')
												->where('id_pengajuan','=',$r->id_pengajuan)
												->get();
										@endphp
	
										@foreach ($comments->all() as $c)
											<div class="modal-body bottom pt-1 pb-2">
												<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
												<span class="in-title2">{{ $c->nama }}</span> <br><br> <!-- GET NAMA PENGOMENTAR-->
												<div class="alert alert-secondary komentar" style="font-size: 0.8rem" role="alert">
													<pre>{{ $c->komentar }}</pre>
												</div> <!-- GET KOMENTAR-->
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
				</div>
			</div>
		</div>

	</div>
	@endif

	@if(session()->get('nama_jabatan') == "Kaprog") <!-- Jabatan = Kaprog-->
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body res-text-center">
					<a href="/export-excel-submission" class="btn btn-primary theme-2 mb-3" >Export to Excel <i class="fas fa-file-export ml-2"></i></a>
					<table class="data-table display nowrap" cellspacing="0" id="dataTable">
						<thead>
							<tr class="text-center">
								<th data-priority="1">No</th>
								<th data-priority="2">Pengajuan</th>
								<th data-priority="3">Pengaju</th>
								<th data-priority="4" >Jumlah</th>
								<th data-priority="5">Tanggal</th>
								<th data-priority="6">Status</th>
								<th data-priority="7">Action</th>
							</tr>
						</thead>
						<tbody>
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
						
							<tr class="text-center">
								<td>{{ $loop->iteration }}</td>
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
								<td style="color: {{ $status=='Ditolak'? 'var(--red)': 'var(--light-green)' }}">{{ $status }}</td> <!-- PERLU BACKEND -->
								<td><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detail{{ $r->id_pengajuan }}">Look Detail</button></td>
							</tr>
						
						
						<div class="modal fade" id="detail{{ $r->id_pengajuan }}">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
								
									<!-- Header --->
									<div class="modal-header bg-blue" style="color: white">
										<h5 class="modal-title" id="judul">Submissions</h4> <!-- DI GET DARI DATA PENGAJU -->
										<button type="button" class="close" style="color: white" data-dismiss="modal"><i class="fas fa-times"></i></button>
									</div>
	
									<!-- Body -->
									<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU --> <!-- DESKRIPSI -->
										<div class="alert alert-primary" style="font-size: 0.9rem" role="alert">
											<pre>{{ $r->deskripsi }}</pre>
										</div>
	
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">File Lampiran</span>
	
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
										
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Status : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $status }}</mark></span> <!-- CANTUMKAN STATUS -->
											<button class="btn btn-sm btn-link" id="status-hint" onclick="showHint()"><i class="fas fa-question"></i></button>
											<div class="alert alert-info row status-hint d-none" id="alert-hint">
												<div class="col-md-6">
													<b>ACC-3</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Sekolah
												</div>
												<div class="col-md-6">
													<b>ACC-2</b> <i class="fas fa-arrow-right"></i> Diterima Kepala Keuangan
												</div>
												<div class="col-md-6">
													<b>ACC-1</b> <i class="fas fa-arrow-right"></i> Diterima Staf BOS/APBD
												</div>
												<div class="col-md-6">
													<b>K</b> <i class="fas fa-arrow-right"></i> Transaksi Keluar
												</div>
												<div class="col-md-6">
													<b>M</b> <i class="fas fa-arrow-right"></i> Transaksi Masuk
												</div>
											</div>
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Id Transaksi : </span>
											<span class="in-desc"><mark class="bg-yellow">{{ $r->id_transaksi }}</mark></span> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Pengaju : </span>
											<span class="in-desc">{{ $r->nama }}</span> <!-- CANTUMKAN NAMA PENGAJU -->
										</div>
										<div class="modal-body bottom pt-1 pb-2">
											<span class="in-title">Tanggal Diajukan : </span>
											<span class="in-desc">{{ $date }}</span> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
										</div>
										<div class="modal-body bottom pt-2 pb-1">
											<span class="in-title"><b>Comments : </b></span>
										</div>
										@php
											// Ambil daftar comment dari pengajuan terkait
											$comments = DB::table('comments')
												->join('detail_accounts','detail_accounts.nip','=','comments.nip')
												->where('id_pengajuan','=',$r->id_pengajuan)
												->get();
										@endphp
	
										@foreach ($comments->all() as $c)
											<div class="modal-body bottom pt-1 pb-2">
												<img src="../img/avatar/{{ $c->picture }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
												<span class="in-title2">{{ $c->nama }}</span> <br><br> <!-- GET NAMA PENGOMENTAR-->
												<div class="alert alert-secondary komentar" style="font-size: 0.8rem" role="alert">
													<pre>{{ $c->komentar }}</pre>
												</div> <!-- GET KOMENTAR-->
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
				</div>
			</div>
		</div>

	</div>
	@endif
@endsection