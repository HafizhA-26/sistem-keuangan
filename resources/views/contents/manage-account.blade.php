@extends('layouts.layout-sidebar')

@section('web-content')

		@if ($pesan = Session::get('pesan'))
			
			<div class="modal fade" id="ModalSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Message</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <div class="alert alert-success">
						  {{ $pesan }}
					  </div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					$('#ModalSuccess').modal('show');
				});
				
			</script>
		@endif
		<div class="row">
			<div class="col-md">
				<div class="card res-text-center">
					<button type="button" class="btn btn-primary theme-2 mb-4" data-toggle="modal" data-target="#add"><i class="fas fa-user-plus mr-1"></i>Add Account</button>
					<table class="data-account display nowrap" cellspacing="0" id="dataTable">
						<thead> 
							<tr>
								<th data-priority="1">NIP</th>
								<th data-priority="3">NUPTK</th>
								<th data-priority="2">Nama</th>
								<th data-priority="6">Jenis Kelamin</th>
								<th data-priority="5">No. Handphone</th>
								<th data-priority="4">Jabatan</th>
								<th data-priority="7">Alamat</th>
								<th data-priority="8">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($daftar->all() as $akun)
								<tr style="text-align: center"> <!-- GET DARI DATABASE TABEL ACCOUNT DAN DETAIL ACCOUNT-->
									<td>{{ $akun->nip }}</td>
									<td>{{ $akun->nuptk }}</td>
									<td>{{ $akun->nama }}</td>
									<td>{{ $akun->jk }}</td>
									<td>{{ $akun->noHP }}</td>
									<td>{{ $akun->nama_jabatan }}</td>
									<td>{{ $akun->alamat }}</td>
									<td><a href="/edit-profil/{{ $akun->nip }}"><i class="fas fa-edit" title="Edit Profil"></i></a> &nbsp; <a href="#" type="button" data-toggle="modal" data-target="#confirmation{{ $akun->nip }}"><i class="fas fa-trash" title="Delete Profil"></i></a></td>
								</tr>

								  <!-- Modal -->
								  <div class="modal fade" id="confirmation{{ $akun->nip }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									@php
										$transaksi = DB::table('submissions')
														->join('accounts','submissions.id_pengaju','=','accounts.nip')
														->where('submissions.id_pengaju','=',$akun->nip)
														->count();
									@endphp
									<div class="modal-dialog modal-dialog-centered" role="document">
									  <div class="modal-content" style="border: 0">
										<div class="modal-header bg-danger">
										  <h5 class="modal-title text-white" id="confirm"><strong>Confirmation</strong></h5>
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"><i class="fas fa-times text-white"></i></span>
										  </button>
										</div>
										<div class="modal-body text-center p-4">
											Apakah anda yakin ingin menghapus akun dengan NIP <mark>{{ $akun->nip }}</mark> ?
											@if ($transaksi != 0)
												<div class="alert alert-warning mt-3" role="alert" style="font-size: 0.90rem">
													<h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> WARNING <i class="fas fa-exclamation-triangle"></i></h6>
													<em>Akun ini telah melakukan {{ $transaksi }} transaksi<br>
													Untuk kelengkapan data, Akun ini hanya akan dinonaktifkan</em>
												</div>
											@else
												<div class="alert alert-success mt-3 font-italic" role="alert" style="font-size: 0.90rem">
													Akun ini dapat dihapus dengan aman
												</div>
											@endif
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
											@if ($transaksi != 0)
												<a href="/deactive-account/{{ $akun->nip }}" class="btn btn-primary">Deactivate this account</a>
											@else
												<a href="/del-account/{{ $akun->nip }}" class="btn btn-primary">Delete this account</a>
											@endif
											
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
		
			<!--Modal Add Account-->
			<div class="modal" id="add">
				<div class="modal-dialog">
					<div class="modal-content">
						
						<!--Header-->
						<div class="modal-header bg-primary">
							<h4 class="text-white">Tambah Akun</h4>
							<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
						</div>

						<!--Body-->
						<div class="modal-body">
							<form class="" method="post" action="/store-data-account" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label class="label">NIP</label>
									<input type="text" onkeypress="return hanyaAngka(event)" name="nip" class="form-control" placeholder="Masukan NIP (contoh: 1234)" autocomplete="off">
								</div>
								<div class="form-group">
									<label class="label">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Masukan Password" id="inputPassword">
									<input class="mt-2" type="checkbox" onclick="liatPass()" id="showps"><label class="form-check-label ml-2" for="showps" style="font-size: 0.8rem">Show Password</label>
								</div>
								<div class="form-group">
									<label class="label">NUPTK</label>
									<input type="text" onkeypress="return hanyaAngka(event)" name="nuptk" class="form-control" placeholder="Masukan NUPTL (contoh: 2002939271)" autocomplete="off">
								</div>
								<div class="form-group">
									<label class="label">Nama</label>
									<input type="text" name="nama" class="form-control" placeholder="Masukan Nama" autocomplete="off">
								</div>
								<div class="form-group">
									<label class="label">Jenis Kelamin</label>
									<select class="form-control" name="jenis_kelamin">
										<option disabled selected>-- Select --</option>
										<option value="Pria">Pria</option>
										<option value="Wanita">Wanita</option>
									</select>
								</div>
								<div class="form-group">
									<label class="label">No. Handphone ( optional )</label>
									<input type="text" onkeypress="return hanyaAngka(event)" name="noHP" class="form-control" placeholder="Masukan No. Handphone (contoh: 0812--)" autocomplete="off" maxlength="20">
								</div>
								<div class="form-group">
									<label class="label">Jabatan</label>
									<select class="form-control" name="jabatan" onchange="showJurusan()" id="jabatanForm">
										@php
											$jabatan = DB::table('jabatan')->get();	
										@endphp
										<option disabled selected>-- Select --</option>
										@if(count($jabatan) > 0)
											@foreach ($jabatan->all() as $namaJ)
												<option value="{{ $namaJ->id_jabatan }}">{{ $namaJ->nama_jabatan }}</option>
											@endforeach
										@endif
										<!-- TAMPIL OPTION DARI DATABASE JABATAN-->

									</select>
								</div>

								<div class="form-group d-none" id="jurusan"> <!-- FORM INI MUNCUL JIKA MEMILIH JABATAN KAPROG-->
									<label class="label">Jurusan</label>
									<select class="form-control" name="jurusan">
										<option disabled selected>-- Select --</option>
										@php
											$daftar_jurusan = DB::table('jurusan')->get();
										@endphp
										@foreach ($daftar_jurusan->all() as $item)
											<option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label class="label">Alamat ( optional )</label>
									<textarea class="form-control" name="alamat" placeholder="Masukan Alamat" maxlength="100" autocomplete="off"></textarea>
								</div>
								<div class="form-group">
									<label class="label">Picture ( optional )</label>
									<input type="file" name="picture" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])" accept=".jpg,.jpeg,.png"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE 			GAMBAR (JPG/PNG/JPEG) -->
									<img id="gambar" width="150" height="150">
								</div>

								<br><br>
							<!-- ===== -->
						</div>

						<!--Footer-->
						<div class="modal-footer">
							<div class="form-group">
								<input type="submit" name="" class="btn btn-primary">
							</div>
						</div>

						</form> <!-- ===== -->
					</div>
				</div>
			</div>
		
	
@endsection