@extends('layouts.layout-edit-profil')

@section('sub-content')
	<!-- GET VALUE DARI DATABASE DI SETIAP FORM-->
	<div class="content background-1" >
		<div class="card">
			<div class="card-header">
				<h4>Edit Profil</h1>
			</div>
			<div class="card-body">
				<form class="" method="post">
					<div class="form-group">
						<label class="label">NIP</label>
						<input type="text" name="" class="form-control" placeholder="Masukan NIP (contoh: 1234)" value="">
					</div>
					<div class="form-group">
						<label class="label">Password</label>
						<input type="password" name="" class="form-control" placeholder="Masukan Password" value="">
					</div>
					<div class="form-group">
						<label class="label">NUPTK</label>
						<input type="text" name="" class="form-control" placeholder="Masukan NUPTK (contoh: 2002939271)" value="">
					</div>
					<div class="form-group">
						<label class="label">Nama</label>
						<input type="text" name="" class="form-control" placeholder="Masukan Nama" value="">
					</div>
					<div class="form-group">
						<label class="label">Jenis Kelamin</label>
						<select class="form-control">
							<option disabled>-- Select --</option>
							<!-- TAMPIL OPTION JENIS KELAMIN SESUAI DARI DATABASE ACCOUNT-->
						</select>
					</div>
					<div class="form-group">
						<label class="label">No. Handphone</label>
						<input type="text" name="" class="form-control" placeholder="Masukan No. Handphone (contoh: 0812--)" value="">
					</div>
					<div class="form-group">
						<label class="label">Jabatan</label>
						<select class="form-control">
							<option disabled>-- Select --</option>

							<!-- TAMPIL OPTION NAMA JABATAN SESUAI DARI DATABASE ACCOUNT-->

						</select>
					</div>
					<div class="form-group"> <!-- FORM INI MUNCUL JIKA JABATAN KAPROG-->
						<label class="label">Jurusan</label>
						<select class="form-control">
							<option disabled selected>-- Select --</option>
							<option>Teknik Elektronika Industri</option>
							<option>Teknik Elektronika Daya dan Komunikasi</option>
							<option>Teknik Otomasi Industri</option>
							<option>Teknik Pendingin dan Tata Udara</option>
							<option>Instrumentasi dan Otomatisasi Proses</option>
							<option>Teknik Mekatronika</option>
							<option>Sistem Informasi Jaringan dan Aplikasi</option>
							<option>Rekayasa Perangkat Lunak</option>
							<option>Produksi Film dan Program Televisi</option>
						</select>
					</div>
					<div class="form-group">
						<label class="label">Alamat</label>
						<textarea class="form-control" placeholder="Masukan Alamat" maxlength="100"></textarea>
					</div>
					<div class="form-group">
						<label class="label">Picture</label>
						<input type="file" name="" class="form-control-file" onchange="document.getElementById('gambar').src= window.URL.createObjectURL(this.files[0])"> <br> <!-- UBAH FORMAT SUPAYA CUMA BISA INPUT FILE GAMBAR (JPG/PNG/JPEG) -->
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