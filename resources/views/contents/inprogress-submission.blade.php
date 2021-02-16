@extends('layouts.layout-sidebar')

@section('web-content')
<!-- Untuk Jabatan Kaprog langsung di direct ke report-submission, tanpa masuk ke halaman ini-->

	@if(session()->get('nama_jabatan') != "Kepala Sekolah" && session()->get('nama_jabatan') != "Kepala Keuangan") <!--Jabatan = Kepsek, Ka. Keuangan, Staf APBD, Staf BOS -->
    <label class="d-none" id="searchtable">{{ $search }}</label>
    <div class="row res-text-center">
		<div class="col-md">
            <div class="card">
                <div class="card-body">
                    @if($message = Session::get('pesan'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ $message }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					@endif
                    <table class="data-table display nowrap" cellspacing="0" id="dataTable">
                        <thead>

                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Pengajuan</th>
                                <th>Pengaju</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($submission as $data)
                                @php
                                    // Memformat tanggal jadi format Hari-Bulan-Tahun
                                    $date = date_create($data->created_at);
                                    $date = date_format($date, "d-m-Y");
                                    $jumlah = number_format($data->jumlah,2,",",".");
                                    $status = '';
                                    if(strpos($data->status,"ACC-2") !== false){
                                        $status = "In process by Kepala Sekolah";
                                    }else if(strpos($data->status,"ACC-1") !== false){
                                        $status = "In process by Kepala Keuangan";
                                    }elseif (strpos($data->status,"ACC-B") !== false) {
                                        $status = "In process by Staf BOS";
                                    }elseif (strpos($data->status,"ACC-A") !== false) {
                                        $status = "In process by Staf APBD";
                                    }
                                @endphp
                                <tr class="text-center">
                                    <td data-priority="1">{{ $loop->iteration }}</td>
                                    <td data-priority="2">{{$data->id_pengajuan}}</td> <!-- PERLU BACKEND -->
                                    <td data-priority="3">{{$data->judul}}</td> <!-- PERLU BACKEND -->
                                    <td data-priority="4">{{$data->nama}}</td>
                                    <td data-priority="5">Rp. {{$jumlah}}</td> <!-- PERLU BACKEND -->
                                    <td data-priority="6">{{$date}}</td> <!-- PERLU BACKEND -->
                                    <td data-priority="2" style="color: var(--orange); background-color: #ffeeba">{{$status}}</td>
                                    <td data-priority="7"><button class="btn btn-danger table-action" data-toggle="modal" data-target="#delete-{{$data->id_pengajuan}}">Delete</button></td>
                                </tr>
                                <div class="modal fade" id="delete-{{$data->id_pengajuan}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="border: 0">
                                        <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white" id="confirm"><strong>Confirmation</strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fas fa-times text-white"></i></span>
                                        </button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            Apakah anda yakin ingin menarik & menghapus pengajuan <mark>{{ $data->judul }}</mark> ?
                                            <div class="alert alert-warning mt-3" role="alert" style="font-size: 0.8rem">
                                                <h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle"></i> WARNING <i class="fas fa-exclamation-triangle"></i></h6>
                                                <span>Data pengajuan ini akan dihapus secara permanen !</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <a href="/submission/inprogress-submission/delete-submission/{{ $data->id_pengajuan }}" class="btn btn-danger" value="Edit Profile" name="submit">Delete</a>
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
	@endif
@endsection