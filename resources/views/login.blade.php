@extends('layouts.layout1')

@section('content')
	<!-- Konten Login -->
	<div class="container-fluid background-1 pr-5" style="height: 100%;">
		<div class="row">
			<div class="col-md-12">
				<form class="box" action="/loginv" method="POST">
			@error('password')
				<div class="alert alert-danger alert-dismissible fade show text-center alert-error" role="alert">
					{{$message}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@enderror
			@error('nip')
				<div class="alert alert-danger alert-dismissible fade show text-center alert-error" role="alert">
					{{$message}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@enderror
					@csrf
					<h3>Login</h3>
					<div class="form-group">
						<br>
						<label>NIP</label>
						<input type="number" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP" name="nip">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
					</div>
					<div class="btn-submit mt-4">
						<button type="submit" class="btn btn-primary submit-login">Log In</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection