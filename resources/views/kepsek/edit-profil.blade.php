@extends('layouts.layout-edit-profil')

@section('sub-content')
	
	<div class="content" >
		<div class="card">
			<div class="card-header">
				<h4>Edit Profil</h1>
			</div>
			<div class="card-body">
				@if($message = Session::get('pesan'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ $message }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if(count($errors) > 0)
					@foreach ($errors->all() as $item)
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							{{ $item }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endforeach
					
				@endif
				<form class="" action="/update/{{ $akun->nip }}" method="post" enctype="multipart/form-data">
					@csrf
					@php
						$jabatan = DB::table('jabatan')->get();
						$jurusan = DB::table('jurusan')->get();
					@endphp
					<div class="form-group">
						<label class="label">NIP</label>
						<input type="text" name="nip" value="{{ $akun->nip }}" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukan NIP (contoh: 1234)" autocomplete="off" readonly>
					</div>
					<div class="form-group">
						@if (session()->get('nip') == $akun->nip)
							<label class="label">Password</label>
							<input type="password" name="password" value="{{ Crypt::decryptString(session()->get('ps')) }}" class="form-control" placeholder="Masukan Password" id="inputPassword">
						@else
							<label class="label">New Password</label>
							<input type="password" name="password" class="form-control" placeholder="Masukan Password Baru" id="inputPassword">
						@endif
						<input class="mt-2" type="checkbox" onclick="liatPass()" id="showps"><label class="form-check-label ml-2" for="showps" style="font-size: 0.8rem">Show Password</label>
					</div>
					<div class="form-group">
						<label class="label">NUPTK</label>
						<input type="text" value="{{ $detail->nuptk }}" name="nuptk" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukan NUPTK (contoh: 2002939271)" autocomplete="off" maxlength="20">
					</div>
					<div class="form-group">
						<label class="label">Nama</label>
						<input type="text" name="nama" value = "{{ $detail->nama }}" class="form-control" placeholder="Masukan Nama" autocomplete="off" maxlength="50">
					</div>
					<div class="form-group">
						<label class="label">Jenis Kelamin</label>
						<select class="form-control" name="jk">
							<option disabled>-- Select --</option>
							<option value="Pria" {{ $detail->jk == "Pria"? 'selected' : '' }}>Pria</option>
							<option value="Wanita" {{ $detail->jk == "Wanita"? 'selected' : '' }}>Wanita</option>
							<!-- TAMPIL OPTION JENIS KELAMIN SESUAI DARI DATABASE ACCOUNT-->
						</select>
					</div>
					<div class="form-group">
						<label class="label">No. Handphone</label>
						<input type="text" name="noHP" value="{{ $detail->noHP }}" class="form-control" placeholder="Masukan No. Handphone (contoh: 0812--)" autocomplete="off">
					</div>
					@if (session()->get('nama_jabatan') == "Kepala Sekolah" || session()->get('nama_jabatan') == "Admin")
						<div class="form-group">
							<label class="label">Jabatan</label>
							<select class="form-control" name="jabatan">
								<option disabled>-- Select --</option>
								@foreach ($jabatan->all() as $J)
									<option value="{{ $J->id_jabatan }}" {{ $detail->id_jabatan == $J->id_jabatan ? 'selected' : '' }}>{{ $J->nama_jabatan }}</option>
								@endforeach
								<!-- TAMPIL OPTION NAMA JABATAN SESUAI DARI DATABASE ACCOUNT-->

							</select>
						</div>
					@endif
					
					@if ($detail->id_jurusan)
						<div class="form-group"> <!-- FORM INI MUNCUL JIKA JABATAN KAPROG-->
							<label class="label">Jurusan</label>
							<select class="form-control" name="jurusan">
								<option disabled selected>-- Select --</option>
								@foreach ($jurusan->all() as $jur)
									<option disabled>-- Select --</option>
									<option value="{{ $jur->id_jurusan }}" {{ $detail->id_jurusan ? 'selected' : '' }} >{{ $jur->nama_jurusan }}</option>
								@endforeach
							</select>
						</div>
					@endif
					
					<div class="form-group">
						<label class="label">Alamat</label>
						<textarea class="form-control" placeholder="Masukan Alamat" maxlength="100" name="alamat">{{ $detail->alamat }}</textarea>
					</div>
					<div class="form-group">
						<label class="label">Picture</label>
						<input type="file" name="pic" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])" accept=".jpg,.jpeg,.png"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE GAMBAR (JPG/PNG/JPEG) -->
						<img id="gambar" width="150" height="150" src="{{ URL::asset('img/avatar/'.$detail->picture) }}">
					</div>

					<br><br>
					<div class="form-group">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation">
							Submit
						</button>
						  
							<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content" style="border: 0">
									<div class="modal-header bg-danger">
									<h5 class="modal-title text-white" id="confirm"><strong>Confirmation</strong></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"><i class="fas fa-times text-white"></i></span>
									</button>
									</div>
									<div class="modal-body text-center p-4">
										Apakah anda yakin ingin mengubah data akun dengan NIP <mark>{{ $akun->nip }}</mark> ?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
										<input type="submit" class="btn btn-primary" value="Edit Profile" name="submit">
									</div>
								</div>
								</div>
						    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
@endsection