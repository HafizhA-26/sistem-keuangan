@extends('layouts.layout-sidebar')

@section('web-content')
<div class="row">
	<div class="col-md">
		<div class="card">
			<div class="card-body">
				<form action="/submission/createsubmissions" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label class="label">Judul Pengajuan</label>
						<input type="text" name="judul" class="form-control" placeholder="Masukan Judul Pengajuan" autocomplete="off" required>
					</div>
					<div class="form-group">
						<label class="label">Pemasukan/Penggunaan</label>
						<select class="form-control" name="pilihan">
							<option disabled selected>-- Select --</option>
							<option value="Pemasukan">Pemasukan</option>
							<option value="Penggunaan">Penggunaan</option>
						</select>
					</div>
					<div class="form-group">
						<label class="label">Jumlah</label>
						<input type="text" name="jumlah" onkeypress="return hanyaAngka(event)"  class="form-control" placeholder="Masukan Jumlah Dana" autocomplete="off" required>
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
					@if(session()->get('nama_jabatan') == "Staf BOS")
						<input type="hidden" name="idDana" value="BOS">
					@endif
					@if(session()->get('nama_jabatan') == "Staf APBD")
						<input type="hidden" name="idDana" value="APBD">
					@endif
					<input type="hidden" name="jenis" value="Pending">
					<input type="hidden" name="namajabatan" id="namajabatan" value="{{ $namajabatan }}"><br>
					<input type="hidden" name="idPengajuan" id="idPengajuan" value="{{ $idPengajuan }}"><br>
					<input type="hidden" name="idTransaksi" id="idTransaksi" value="{{ $idTransaksi }}"><br>
					<input type="hidden" name="idPengaju" value="{{ $idUser }}"><br>
					<div class="form-group">
						<input type="submit" name="" class="btn btn-primary theme-2 w-100">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection