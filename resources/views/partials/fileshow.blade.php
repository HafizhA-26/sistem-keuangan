@extends('')
@section('fileshow')
        @if ($data->file_lampiran)
            @if (!file_exists(storage_path() .'/uploaded_file/'. $data->file_lampiran))
                <div class="alert alert-warning" role="alert">
                    File is missing, contact the submitter no re-submit his submission
                </div>
            @else
                <div class="alert alert-primary">
                    
                    {{-- Bagian untuk penampilan file --}}
                    
                    <a class="file-click m-0 text-decoration-none" href="download/{{ $data->file_lampiran }}" title="{{ $data->file_lampiran }}" >
                        <div class="d-flex flex-wrap align-items-center flex-md-row">
                    
                            <div class="ikon">

                                {{-- Cek extension file dan mengubah icon sesuai filenya--}}
                                @if ($file_ex == "pdf")
                                    <i class="fas fa-file-pdf"></i>
                                @else
                                    <i class="fas fa-file-alt"></i>
                                @endif

                            </div>

                            {{-- Menampilkan judul dan size file lampiran --}}
                            <div class="file-title text-truncate">
                                {{ $data->file_lampiran }}
                                <div class="file-size">
                                    {{ $size }}
                                </div>
                            </div>
                                
                        </div>
                    </a>
                </div>
            @endif


        {{-- Kalau tidak ada file lampiran, akan memunculkan alert dibawah --}}
        @else
        <div class="alert alert-warning" role="alert">
            There is no attached file
        </div>
        @endif
@endsection