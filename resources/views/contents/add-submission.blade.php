@extends('layouts.layout-sidebar')

@section('web-content')
<div class="row">
	<div class="col-md">
		<div class="card">
			<div class="card-body">
				@if ($message = Session::get('pesan'))
						<div class="alert alert-success alert-dismissible fade show text-center alert-error w-100" role="alert">
								<button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							<p class="alert-login" style="margin-bottom: 0; color: black;">{{ $message }}</p>
						</div>
				@endif
				@if ($message = Session::get('pesanError'))
					<div class="alert alert-danger alert-dismissible fade show text-center alert-error w-100" role="alert">
						<button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<p class="alert-login" style="margin-bottom: 0; color: black;">{{ $message }}</p>
					</div>
				@endif
				<form action="/submission/createsubmissions" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label class="label">Judul Pengajuan</label>
						<input type="text" name="judul" class="form-control" placeholder="Masukan Judul Pengajuan" autocomplete="off" required>
					</div>
					<div class="form-group">
						<label class="label">Pemasukan/Penggunaan</label>
						<select class="form-control" name="pilihan" id="pilihan" onchange="showJenis()">
							<option disabled selected>-- Select --</option>
							<option value="Pemasukan">Pemasukan</option>
							<option value="Penggunaan">Penggunaan</option>
						</select>
					</div>
					@php
						$jenisM;
						$jenisK;
						if(session()->get('nama_jabatan') == "Staf BOS"){
							$jenisM = \App\Models\JenisSubmission::getMasukBOS();
							$jenisK = \App\Models\JenisSubmission::getKeluarBOS();
						}elseif(session()->get('nama_jabatan') == "Staf APBD"){
							$jenisM = \App\Models\JenisSubmission::getMasukAPBD();
							$jenisK = \App\Models\JenisSubmission::getKeluarAPBD();
						}
					@endphp
					@if (!$jenisM->isEmpty())
						<div class="form-group d-none" id="jenisMasuk">
							<label class="label">Jenis Pengajuan</label>
							<select class="form-control" name="jenis">
								<option disabled selected>-- Select --</option>
								@foreach ($jenisM->all() as $j)
									<option value={{ $j->id_jenis }}>{{ $j->nama_jenis }}</option>
								@endforeach
							</select>
						</div>
					@endif
					@if (!$jenisK->isEmpty())
						<div class="form-group d-none" id="jenisKeluar">
							<label class="label">Jenis Pengajuan</label>
							<select class="form-control" name="jenis">
								<option disabled selected>-- Select --</option>
								@foreach ($jenisK->all() as $j)
									<option value={{ $j->id_jenis }}>{{ $j->nama_jenis }}</option>
								@endforeach
							</select>
						</div>
					@endif
					
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
@push('js')
	<script>
		function showJenis(){
			var m = document.getElementById("jenisMasuk");
			var k = document.getElementById("jenisKeluar");
			var selection = document.getElementById("pilihan");
			var selectedText = selection.options[selection.selectedIndex].text;
			if(selectedText == "Pemasukan"){
				if(m) m.classList.remove("d-none");
				if(k) k.classList.add("d-none");
			}
			if (selectedText == "Penggunaan"){
				if(k) k.classList.remove("d-none");
				if(m) m.classList.add("d-none");
			}
		}
		window.onload = function() {
			showJenis();
		};
	</script>
@endpush
@endsection