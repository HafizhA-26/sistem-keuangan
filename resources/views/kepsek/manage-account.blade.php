@extends('layouts.layout-manage-account')

@section('sub-content')
<div class="content background-1">
		@if ($pesan = Session::get('pesan'))
			
			<div class="modal fade" id="ModalSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Message</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <div class="alert alert-success">
						  {{ $pesan }}
					  </div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			</div>
			<script>
				$('#ModalSuccess').modal('show');
			</script>
		@endif
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
							<tr style="text-align: center">
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
								<tr style="text-align: center"> <!-- GET DARI DATABASE TABEL ACCOUNT DAN DETAIL ACCOUNT-->
									<td>{{ $akun->nip }}</td>
									<td>{{ $akun->nuptk }}</td>
									<td>{{ $akun->nama }}</td>
									<td>{{ $akun->jk }}</td>
									<td>{{ $akun->noHP }}</td>
									<td>{{ $akun->nama_jabatan }}</td>
									<td>{{ $akun->alamat }}</td>
									<td>{{ $akun->picture }}</td>
									<td><a href="/edit-profil/{{ $akun->nip }}"><i class="fas fa-edit" title="Edit Profil"></i></a> &nbsp; <a href="#" type="button" data-toggle="modal" data-target="#confirmation{{ $akun->nip }}"><i class="fas fa-trash" title="Delete Profil"></i></a></td>
								</tr>

								  <!-- Modal -->
								  <div class="modal fade" id="confirmation{{ $akun->nip }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									@php
										$transaksi = DB::table('accounts')
														->join('transaksi','transaksi.id_pengaju','=','accounts.nip')
														->count();
									@endphp
									<div class="modal-dialog modal-dialog-centered" role="document">
									  <div class="modal-content" style="border: 0">
										<div class="modal-header bg-danger">
										  <h5 class="modal-title text-white" id="confirm"><strong>Confirmation</strong></h5>
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"><i class="fas fa-times text-white"></i></span>
										  </button>
										</div>
										<div class="modal-body text-center p-4">
											Apakah anda yakin ingin menghapus akun dengan NIP <mark>{{ $akun->nip }}</mark> ?
											@if ($transaksi != 0)
												<div class="alert alert-warning mt-3" role="alert" style="font-size: 0.90rem">
													<h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> WARNING <i class="fas fa-exclamation-triangle"></i></h6>
													<em>Akun ini telah melakukan {{ $transaksi }} transaksi<br>
													Untuk kelengkapan data, Akun ini hanya akan dinonaktifkan</em>
												</div>
											@else
												<div class="alert alert-success mt-3 font-italic" role="alert" style="font-size: 0.90rem">
													Akun ini dapat dihapus dengan aman
												</div>
											@endif
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
											@if ($transaksi != 0)
												<a href="/deactive-account/{{ $akun->nip }}" class="btn btn-primary" data-dismiss="modal">Deactivate this account</a>
											@else
												<a href="/del-account/{{ $akun->nip }}" class="btn btn-primary" data-dismiss="modal">Delete this account</a>
											@endif
											
										</div>
									  </div>
									</div>
								  </div>
							@endforeach
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection