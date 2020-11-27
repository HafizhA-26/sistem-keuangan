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
							<tr> <!-- GET DARI DATABASE TABEL ACCOUNT DAN DETAIL ACCOUNT-->
								<td>123456789</td>
								<td>Nama</td>
								<td>Pria</td>
								<td>08123456789</td>
								<td>Kaprog</td>
								<td>Cimahi</td>
								<td>Foto.jpg</td>
								<td><a href="/edit-profil"><i class="fas fa-edit" title="Edit Profil"></i></a> &nbsp; <a href="" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash" title="Delete Profil"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection