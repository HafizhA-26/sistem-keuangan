@extends('layouts.layout-add-account')

@section('sub-content')
    <div class="content background-1">
		<div class="card">
			<div class="card-header">
				<h4>Tambah Akun</h1>
			</div>
			<div class="card-body">
				<form class="" method="post">
					<div class="form-group">
						<label class="label">NIP</label>
						<input type="number" name="" class="form-control" placeholder="Masukan NIP (contoh: 1234)">
					</div>
					<div class="form-group">
						<label class="label">Password</label>
						<input type="password" name="" class="form-control" placeholder="Masukan Password">
					</div>
					<div class="form-group">
						<label class="label">Nama</label>
						<input type="text" name="" class="form-control" placeholder="Masukan Nama">
					</div>
					<div class="form-group">
						<label class="label">Jenis Kelamin</label>
						<select class="form-control">
							<option disabled selected>-- Select --</option>
							<option>Pria</option>
							<option>Wanita</option>
						</select>
					</div>
					<div class="form-group">
						<label class="label">No. Handphone</label>
						<input type="number" name="" class="form-control" placeholder="Masukan No. Handphone (contoh: 0812--)">
					</div>
					<div class="form-group">
						<label class="label">Jabatan</label>
						<select class="form-control">
							<option disabled selected>-- Select --</option>

							<!-- TAMPIL OPTION DARI DATABASE JABATAN-->

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