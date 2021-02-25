@extends('layouts.layout-sidebar')

@section('web-content')
    <div class="row">
		<div class="col-md">
			<div class="card">
				@if($message = Session::get('pesan'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ $message }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@elseif($message = Session::get('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
				<div class="card-body">
						<form class="" method="post" action="/manage-account/store-data-account" enctype="multipart/form-data">
									@csrf
									<div class="form-group">
										<label class="label">NIP</label>
										<input type="text" onkeypress="return hanyaAngka(event)" name="nip" class="form-control" placeholder="Enter NIP, e.g 18121122" autocomplete="off" maxlength="20">
									</div>
									<div class="form-group">
										<label class="label">Password</label>
										<input type="password" name="password" class="form-control" placeholder="Enter Password" id="inputPassword">
										<input class="mt-2" type="checkbox" onclick="liatPass()" id="showps"><label class="form-check-label ml-2" for="showps" style="font-size: 0.8rem">Show Password</label>
									</div>
									<div class="form-group">
										<label class="label">NUPTK</label>
										<input type="text" onkeypress="return hanyaAngka(event)" name="nuptk" class="form-control" placeholder="Enter NUPTK, e.g 2039220893" autocomplete="off" maxlength="20">
									</div>
									<div class="form-group">
										<label class="label">Nama</label>
										<input type="text" name="nama" class="form-control" placeholder="Enter Name" autocomplete="off">
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
										<label class="label">No. Handphone <small>( optional )</small></label>
										<input type="text" onkeypress="return hanyaAngka(event)" name="noHP" class="form-control" placeholder="Enter Phone Number, e.g 08292729109" autocomplete="off" maxlength="20">
									</div>
									<div class="form-group">
										<label class="label">Jabatan</label>
										<select class="form-control" name="jabatan" onchange="showJurusan()" id="jabatanForm">
											@php
												$jabatan = DB::table('jabatan')->get();	
											@endphp
											<option disabled selected>-- Select Jabatan --</option>
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
											<option disabled selected>-- Select Jurusan --</option>
											@php
												$daftar_jurusan = DB::table('jurusan')->get();
											@endphp
											@foreach ($daftar_jurusan->all() as $item)
												<option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="label">Alamat <small>( optional )</small></label>
										<textarea class="form-control" name="alamat" placeholder="Enter Adress, e.g Lembur Sawah No.20 Kota Cimahi" maxlength="100" autocomplete="off"></textarea>
									</div>
									<div class="form-group">
										<label class="label">Picture <small>( optional )</small></label>
										<input type="file" name="picture" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])" accept=".jpg,.jpeg,.png"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE 			GAMBAR (JPG/PNG/JPEG) -->
										<img id="gambar" width="150" height="150">
									</div>

									<div class="form-group">
										<input type="submit" name="" class="btn btn-primary theme-2">
									</div>
								<!-- ===== -->
						</div>

							<!--Footer-->
							

						</form>
				</div>
			</div>
		</div>
	</div>
@endsection