@extends('layouts.layout-submission')

@section('sub-content')
<div class="content">
		<div class="card">
			<div class="card-header">
				<h4>Tambah Pengajuan</h1>
			</div>
			<div class="card-body">
				<form class="" method="post">
					<div class="form-group">
						<label class="label">Judul Pengajuan</label>
						<input type="text" name="" class="form-control" placeholder="Masukan Judul Pengajuan">
					</div>
					<div class="form-group">
						<label class="label">Deskripsi</label>
						<textarea class="form-control desk" placeholder="Masukan Deskripsi atau Penjelasan" maxlength="1000"></textarea>
					</div>
					<div class="form-group">
						<label class="label">File Lampiran</label>
						<input type="file" name="" class="form-control-file"> <br>
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