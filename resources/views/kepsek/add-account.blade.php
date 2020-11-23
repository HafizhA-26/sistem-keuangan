@extends('layouts.layout-add-account')

@section('sub-content')
    <div class="content background-1">
		
		<div class="card">
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
			<div class="card-header">
				<h4>Tambah Akun</h1>
			</div>
			<div class="card-body">
				<form class="" method="post" action="/store-data-account" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label class="label">NIP</label>
						<input type="text" onkeypress="return hanyaAngka(event)" name="nip" class="form-control" placeholder="Masukan NIP (contoh: 1234)" autocomplete="off">
					</div>
					<div class="form-group">
						<label class="label">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Masukan Password">
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
						<input type="text" onkeypress="return hanyaAngka(event)" name="noHP" class="form-control" placeholder="Masukan No. Handphone (contoh: 0812--)" autocomplete="off">
					</div>
					<div class="form-group">
						<label class="label">Jabatan</label>
						<select class="form-control" name="jabatan">
							<option disabled selected>-- Select --</option>
							@if(count($jabatan) > 0)
								@foreach ($jabatan->all() as $namaJ)
									<option value="{{ $namaJ->id_jabatan }}">{{ $namaJ->nama_jabatan }}</option>
								@endforeach
							@endif
							<!-- TAMPIL OPTION DARI DATABASE JABATAN-->

						</select>
					</div>
					<div class="form-group">
						<label class="label">Alamat ( optional )</label>
						<textarea class="form-control" name="alamat" placeholder="Masukan Alamat" maxlength="100" autocomplete="off"></textarea>
					</div>
					<div class="form-group">
						<label class="label">Picture ( optional )</label>
						<input type="file" name="picture" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE GAMBAR (JPG/PNG/JPEG) -->
						<img id="gambar" width="150" height="150">
					</div>

					<br><br>
					<div class="form-group">
						<input type="submit" name="" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection