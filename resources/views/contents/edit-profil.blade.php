@extends('layouts.layout-sidebar')

@section('web-content')
	<div class="row">
		<div class="col-md">
			<div class="card">
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
						<div class="row">
							<div class="col-md-3">
								<img id="gambar" class="prev-img" src="{{ URL::asset('img/avatar/'.$detail->picture) }}">
								<div class="form-group">
									<input type="file" id="fileImg" name="pic" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])" accept=".jpg,.jpeg,.png"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE GAMBAR (JPG/PNG/JPEG) -->
									
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<label class="label">NIP</label>
									<input type="text" name="nip" value="{{ $akun->nip }}" onkeypress="return hanyaAngka(event)" class="form-control"  placeholder="Enter NIP, e.g 18121122" autocomplete="off" readonly>
								</div>
								<div class="form-group">
										<label class="label">New Password</label>
										<input type="password" name="password" class="form-control" placeholder="Enter New Password" id="inputPassword">
									
									<input class="mt-2" type="checkbox" onclick="liatPass()" id="showps"><label class="form-check-label ml-2" for="showps" style="font-size: 0.8rem">Show Password</label>
								</div>
								<div class="form-group">
									<label class="label">NUPTK</label>
									<input type="text" value="{{ $detail->nuptk }}" name="nuptk" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Enter NUPTK, e.g 2039220893" autocomplete="off" maxlength="20">
								</div>
								<div class="form-group">
									<label class="label">Nama</label>
									<input type="text" name="nama" value = "{{ $detail->nama }}" class="form-control" placeholder="Enter Name" autocomplete="off" maxlength="50" >
								</div>
								<div class="form-group">
									<label class="label">Jenis Kelamin</label>
									<select class="form-control" name="jk" >
										<option disabled>-- Select --</option>
										<option value="Pria" {{ $detail->jk == "Pria"? 'selected' : '' }}>Pria</option>
										<option value="Wanita" {{ $detail->jk == "Wanita"? 'selected' : '' }}>Wanita</option>
										<!-- TAMPIL OPTION JENIS KELAMIN SESUAI DARI DATABASE ACCOUNT-->
									</select>
								</div>
								<div class="form-group">
									<label class="label">No. Handphone</label>
									<input type="text" name="noHP" value="{{ $detail->noHP }}" class="form-control" placeholder="Enter Phone Number, e.g 08292729109" autocomplete="off" maxlength="20">
								</div>
								@if (session()->get('nama_jabatan') == "Admin")
									<div class="form-group">
										<label class="label">Jabatan</label>
										<select class="form-control" name="jabatan" id="jabatanForm" onchange="showJurusan()">
											<option disabled>-- Select Jabatan --</option>
											@foreach ($jabatan->all() as $J)
												<option value="{{ $J->id_jabatan }}" {{ $detail->id_jabatan == $J->id_jabatan ? 'selected' : '' }}>{{ $J->nama_jabatan }}</option>
											@endforeach
											<!-- TAMPIL OPTION NAMA JABATAN SESUAI DARI DATABASE ACCOUNT-->
			
										</select>
									</div>
								@endif
								
								
									<div class="form-group d-none" id="jurusan"> <!-- FORM INI MUNCUL JIKA JABATAN KAPROG-->
										<label class="label">Jurusan</label>
										<select class="form-control" name="jurusan" id="jurusanSelect">
											<option disabled selected>-- Select Jurusan --</option>
											@foreach ($jurusan->all() as $jur)
												<option value="{{ $jur->id_jurusan }}" {{ $detail->id_jurusan == $jur->id_jurusan ? 'selected' : '' }} >{{ $jur->nama_jurusan }}</option>
											@endforeach
										</select>
									</div>
								
								
								<div class="form-group">
									<label class="label">Alamat</label>
									<textarea class="form-control" placeholder="Enter Adress, e.g Lembur Sawah No.20 Kota Cimahi"maxlength="100" name="alamat">{{ $detail->alamat }}</textarea>
								</div>
								
			
								<br><br>
								<div class="form-group">
									<button type="button" class="btn btn-primary btn-update" data-toggle="modal" data-target="#confirmation">
										Submit
									</button>
									  
								</div>
							</div>
						</div>
						
						<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content" style="border: 0">
								<div class="modal-header bg-danger">
								<h5 class="modal-title text-white" id="confirm">Confirmation</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true"><i class="fas fa-times text-white"></i></span>
								</button>
								</div>
								<div class="modal-body text-center p-4">
									Apakah anda yakin ingin mengubah data akun dengan NIP <mark>{{ $akun->nip }}</mark> ?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
									<input type="submit" class="btn btn-success" value="Update" name="submit">
								</div>
							</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	@if ($akun->nip == Auth::user()->nip)
	<script>
		window.onload = function() {
			showJurusan();
		};
		const link = document.querySelectorAll('.nav__link');
		link.forEach(l => l.classList.remove('active'));
	</script>
	@endif
	
@endsection