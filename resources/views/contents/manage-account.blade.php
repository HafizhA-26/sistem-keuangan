@extends('layouts.layout-sidebar')

@section('web-content')
		<div class="row">
			<div class="col-md">
				<div class="card res-text-center">
					<a href="/manage-account/add-account" class="btn btn-primary theme-1 mb-4"><i class="fas fa-user-plus mr-1"></i>Add Account</a>
					<table class="data-table display nowrap" cellspacing="0" id="dataTable">
						<thead> 
							<tr>
								<th data-priority="2">NIP</th>
								<th data-priority="3">NUPTK</th>
								<th data-priority="1">Nama</th>
								<th data-priority="6">Jenis Kelamin</th>
								<th data-priority="5">No. Handphone</th>
								<th data-priority="4">Jabatan</th>
								<th data-priority="7">Alamat</th>
								<th data-priority="8">Action</th>
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
									<td><a href="/manage-account/edit-account-data/{{ $akun->nip }}"><i class="fas fa-edit" title="Edit Profil"></i></a> &nbsp; <a href="#" type="button" data-toggle="modal" data-target="#confirmation{{ $akun->nip }}"><i class="fas fa-trash" title="Delete Profil"></i></a></td>
								</tr>

								  <!-- Modal -->
								  <div class="modal fade" id="confirmation{{ $akun->nip }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									@php
										$transaksi = DB::table('submissions')
														->join('accounts','submissions.id_pengaju','=','accounts.nip')
														->where('submissions.id_pengaju','=',$akun->nip)
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
												<a href="/deactive-account/{{ $akun->nip }}" class="btn btn-primary">Deactivate this account</a>
											@else
												<a href="/del-account/{{ $akun->nip }}" class="btn btn-primary">Delete this account</a>
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
	
@endsection