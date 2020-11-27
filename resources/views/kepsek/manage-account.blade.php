@extends('layouts.layout-manage-account')

@section('sub-content')
<div class="content background-1">
		<div class="header_account">
			<h3>List Account</h3>
		</div>
		<div class="btn-add">
			<a href="/add-account" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Account</a>
		</div>
		<div class="box2 box-info">
			<div class="box-info">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead> 
							<tr>
								<th>NIP</th>
                                <th>NUPTK</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>No. Handphone</th>
								<th>Jabatan</th>
								<th>Alamat</th>
								<th>Picture</th>
								<th>Manage</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($daftar->all() as $akun)
								<tr> <!-- GET DARI DATABASE TABEL ACCOUNT DAN DETAIL ACCOUNT-->
									<td>{{ $akun->nip }}</td>
									<td>{{ $akun->nuptk }}</td>
									<td>{{ $akun->nama }}</td>
									<td>{{ $akun->jk }}</td>
									<td>{{ $akun->noHP }}</td>
									<td>{{ $akun->nama_jabatan }}</td>
									<td>{{ $akun->alamat }}</td>
									<td>{{ $akun->picture }}</td>
								<td><a href="/edit-profil/{{ $akun->nip }}"><i class="fas fa-edit" title="Edit Profil"></i></a> &nbsp; <a href="/del-account/{{ $akun->nip }}" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash" title="Delete Profil"></i></a></td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection