@extends('layouts.layout-sidebar')

@section('web-content')

	{{-- NOTE for Aria --}}
	{{-- KALAU MAU NGUJI KONTENNYA TAMBAHIN DI IF NYA "|| session()->get('nama_jabatan') == Admin" --}}

	@if(session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Kepala Keuangan" || session()->get('nama_jabatan') == "Staf APBD" || session()->get('nama_jabatan') == "Staf BOS" || session()->get('nama_jabatan') == "Admin" ) <!-- Jabatan =  Ka. Keuangan, Kepsek, Staf APBD, Staf BOS -->
	<label class="d-none" id="searchtable">{{ $search }}</label>
	<div class="row">
		<div class="col-md">
			<div class="card">
					<!-- TABEL SUBMISSION UNTUK KEPALA SEKOLAH -->
					<div>
						<!-- SEMUA ISI TABLE NGE GET DARI DATA PENGAJU -->
						<table class="data-table display nowrap" cellspacing="0" id="dataTable">
							<thead>

								<tr>
									<th>No</th>
									<th>ID</th>
									<th>Pengajuan</th>
									<th>Pengaju</th>
									<th>Jenis Dana</th>
									<th>Jumlah</th>
									<th>Tanggal</th>
									<th>Action</th>
								</tr>

							</thead>
							<tbody>
								@foreach ($datasub as $dtsub)
								@php
									// Memformat tanggal jadi format Hari-Bulan-Tahun
									$date = date_create($dtsub->created_at);
									$date = date_format($date, "d-m-Y");
									$jumlah = number_format($dtsub->jumlah,2,",",".");
								@endphp
								<tr class="text-center">
									<td data-priority="1">{{ $loop->iteration }}</td>
									<td data-priority="2">{{ $dtsub->id_pengajuan }}</td> <!-- PERLU BACKEND -->
									<td data-priority="3">{{$dtsub->judul}}</td> <!-- PERLU BACKEND -->
									<td data-priority="4">{{$dtsub->nama}}</td>
									<td data-priority="5">{{ $dtsub->id_dana }}</td>
									<td data-priority="6">Rp. {{$jumlah}}</td> <!-- PERLU BACKEND -->
									<td data-priority="7">{{$date}}</td> <!-- PERLU BACKEND -->
									<td data-priority="8"><a href="" class="btn btn-primary detail" data-toggle="modal" data-target="#detail-{{$dtsub->id_pengajuan}}">Give Permission</a></td>
								</tr>
								@endforeach
							</tbody>
								
								@foreach ($datasub as $data)
									@php
											// Memformat tanggal jadi format Hari-Bulan-Tahun
											$date = date_create($data->created_at);
											$date = date_format($date, "d-m-Y");
											// Mengambil file extension di variabel $file_ex
											$file_ex = substr($data->file_lampiran,-3);

											// Mengambil file size dan memformat nya dengan fungsi formatSizeUnits dari ReportController
											$file_path = storage_path() .'/uploaded_file/'. $data->file_lampiran;
											if(file_exists($file_path))
												$size = App\Http\Controllers\ReportController::formatSizeUnits(filesize($file_path));
											$jumlah = number_format($data->jumlah,2,",",".");
									@endphp
								
								<!-- Modal -->
								<div class="modal fade" id="detail-{{ $data->id_pengajuan }}" tabindex="-1">
										<div class="modal-dialog">
											<div class="modal-content" style="border: 0">
												
												<!-- Header --->
												<div class="modal-header bg-blue" style="color: white">
													<h5 class="modal-title" id="judul">Submissions</h4> <!-- DI GET DARI DATA PENGAJU -->
													<button type="button" class="close" style="color: white" data-dismiss="modal"><i class="fas fa-times"></i></button>
												</div>

												<!-- Body -->
												<div class="modal-body top"> <!-- DI GET DARI DATA PENGAJU --> <!-- DESKRIPSI -->
													<div class="alert alert-primary" style="font-size: 0.9rem" role="alert">
														<pre>{{ $data->deskripsi }}</pre>
													</div>
				
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Attached File</b></span>
				
														{{-- cek jika ada file_lampiran --}}
														@if ($data->file_lampiran)
															@if (!file_exists(storage_path() .'/uploaded_file/'. $data->file_lampiran))
																<div class="alert alert-warning text-center" role="alert">
																	File is missing, contact the submitter to re-submit his submission
																</div>
															@else
																<div class="alert alert-primary">
																	
																	{{-- Bagian untuk penampilan file --}}
																	
																	<a class="file-click m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
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
																				{{ $data->file_lampiran }}
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
														<span class="in-title"><b>Status : </b></span>
														<span class="in-desc"><mark class="bg-light">{{ $data->status }}</mark></span> <!-- CANTUMKAN STATUS -->
													</div>
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Jumlah : </b></span>
														<span class="in-desc">Rp. {{ $jumlah }}</span> <!-- CANTUMKAN STATUS -->
													</div>
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Transaction ID : </b></span>
														<span class="in-desc"><mark class="bg-light">{{ $data->id_transaksi }}</mark></span> <!-- MUNCUL JIKA PENGAJUAN DITERIMA/ACC -->
													</div>
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Submitter : </b></span>
														<span class="in-desc">{{ $data->nama }}</span> <!-- CANTUMKAN NAMA PENGAJU -->
													</div>
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Submitted Date : </b></span>
														<span class="in-desc">{{ $date }}</span> <!-- CANTUMKAN TAANGGAL DIAJUKAN -->
													</div>
													<div class="modal-body bottom pt-1 pb-2">
														<span class="in-title"><b>Comments : </b></span>
													</div>
													@php
														// Ambil daftar comment dari pengajuan terkait
														$comments = DB::table('comments')
															->join('detail_accounts','detail_accounts.nip','=','comments.nip')
															->where('id_pengajuan','=',$data->id_pengajuan)
															->get();
													@endphp
				
													@foreach ($comments->all() as $c)
														<div class="modal-body bottom pt-1 pb-2">
															<img src="{{ URL::asset("img/avatar/$c->picture") }}" class="ava" alt="">&nbsp; <!-- GET AVATAR PENGOMENTAR-->
															<span class="in-title2">{{ $c->nama }}</span> <br><br> <!-- GET NAMA PENGOMENTAR-->
															<div class="alert alert-secondary komentar" style="font-size: 0.8rem" role="alert">
																<pre>{{ $c->komentar }}</pre>
															</div> <!-- GET KOMENTAR-->
														</div>
													@endforeach
													
												</div>

												<!-- Footer -->
												<div class="modal-footer d-flex" style="justify-content: space-between;">
													<div>
														<button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Close</button>
													</div>
													<div>
														<button class="btn btn-danger" data-toggle="modal" data-target="#tidakizinkan-{{$data->id_pengajuan}}">Reject</button>
														<button class="btn btn-success" data-toggle="modal" data-target="#izinkan-{{$data->id_pengajuan}}">Allow</button>
													</div>
													
													@php
														$izinLink = '';
														$tolakLink = '';
														switch(session()->get('nama_jabatan')){
															case 'Kepala Sekolah':
																$izinLink = '/submission/diizinkankepsek';
																$tolakLink = '/submission/tidakdiizinkankepsek';
																break;
															case 'Kepala Keuangan':
																$izinLink = '/submission/diizinkankakeuangan';
																$tolakLink = '/submission/tidakdiizinkankakeuangan';
																break;
															case 'Staf BOS':
																$izinLink = '/submission/diizinkanbos';
																$tolakLink = '/submission/tidakdiizinkanbos';
																break;
															case 'Staf APBD':
																$izinLink = '/submission/diizinkanapbd';
																$tolakLink = '/submission/tidakdiizinkanapbd';
																break;
														}
													@endphp
		
												</div>
											</div>
										</div>
										
									</div>
									<!-- Modal Izinkan -->
									<div class="modal fade bs-example-modal-sm" id="izinkan-{{$data->id_pengajuan}}" tabindex="1">
										<div class="modal-dialog modal-sm">
											<form method="POST" action="{{ $izinLink }}">
												@csrf
											<div class="modal-content">
												<div class="modal-header bg-green">
													<h5 class="modal-title " style="color: white">Izinkan</h5>	
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
											<form method="POST" action="{{ $tolakLink }}">
												@csrf
											<div class="modal-content">
												<div class="modal-header bg-red">
													<h5 class="modal-title" style="color: white">Tidak Izinkan</h5>
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
								@endforeach
						</table>
					</div>
					<!-- TABEL SUBMISSION UNTUK KEPALA KEUANGAN -->
				</div>
				@endif

				@if(session()->get('nama_jabatan') == "Kaprog") <!-- Jabatan = Kaprog-->
				<div class="row">
					<div class="col-md">
						<div class="card">
							<div class="card-body">
								@if ($message = Session::get('pesan'))
									<div class="alert alert-danger alert-dismissible fade show text-center alert-error w-100" role="alert">
										<button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										<p class="alert-login" style="margin-bottom: 0; color: black;">{{ $message }}</p>
									</div>
								@endif
								<form action="/submission/add" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="form-group">
										<label class="label">Judul Pengajuan</label>
										<input type="text" name="judul" class="form-control" placeholder="Masukan Judul Pengajuan" autocomplete="off" required>
									</div>
									
									<div class="form-group d-none">
										<label class="label">Pilih ID Dana</label>
										<select class="form-control" name="id_Dana">
											<option disabled>-- Select --</option>
											<option value="BOS" selected>BOS</option>
											<option value="APBD">APBD</option>
										</select>
									</div>
									<div class="form-group">
										<label class="label">Jumlah</label>
										<input type="text" name="jumlah" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukan Jumlah Dana" autocomplete="off" required>
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
										<input type="submit" name="buttonsubmit" class="btn btn-primary theme-2 w-100">
									</div>
								</form>
							</div>
						</div>
					</div>
			</div>
		</div>
		

	</div>
	@endif
	
@endsection