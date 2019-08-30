@extends('layouts.app')

@section('content')
	<div class="container">
		<form method="POST" action="{{ route('users') }}">
			@csrf
			<div class="form-group">
				<label for="username">Username</label>
				<input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" value="{{ old('username') }}" maxlength="255" required/>
				@error('username')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="email">E-Mail</label>
				<input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" maxlength="100" required/>
				@error('email')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required/>
				@error('password')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="password_confirmation">Confirm Password</label>
				<input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" name="password_confirmation" required/>
				@error('password_confirmation')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="user-role">Role</label>
				<select class="form-control @error('role') is-invalid @enderror" id="user-role" name="role" required>
					@foreach ($roles as $role)
						<option value="{{ $role->name }}" @if ($role->name === old('role')) selected @endif>
							{{ $role->display_name }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<a class="btn btn-danger" href="{{ route('users') }}">Cancel</a>
				<input class="btn btn-primary" type="submit" value="Create"/>
			</div>
		</form>
	</div>
@endsection
