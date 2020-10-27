@extends('layouts.layout1')

@section('content')
	<!-- Konten Login -->
	<div class="container-fluid background-1 pr-5" style="height: 100%;">
		<div class="row">
			<div class="col-md-12">
				
				<form class="box" action="/checking" method="POST">
					@csrf
					<h3>Login</h3>
					<div class="form-group">
						<br>
						<label>NIP</label>
						<input type="text" onkeypress="return hanyaAngka(event)" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP" name="nip" autocomplete="off">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
					</div>
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							
							<ul class="login-error">
								@foreach ($errors->all() as $error)
								<li class="alert-login">{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					@if ($message = Session::get('pesan'))
						<div class="alert alert-danger alert-dismissible fade show text-center alert-error" role="alert">
							<button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							<p class="alert-login" style="margin-bottom: 0">{{ $message }}</p>
						</div>
						@error('password')
							<div class="alert alert-danger alert-dismissible fade show text-center alert-error" role="alert">
								{{ $message }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@enderror
						@error('nip')
							<div class="alert alert-danger alert-dismissible fade show text-center alert-error" role="alert">
								{{ $message }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@enderror
					@endif
					<div class="btn-submit mt-4">
						<button type="submit" class="btn btn-primary submit-login" value="Login">Log In</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection