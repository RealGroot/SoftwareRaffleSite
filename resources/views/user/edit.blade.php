@extends('layouts.app')

@section('content')
	<div class="container">
		<form method="POST" action="{{ url("/users/{$user->id}") }}">
			@method('PATCH')
			@csrf
			<div class="form-group">
				<label for="username">Username</label>
				<input class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" value="{{ $user->name }}" maxlength="255" required/>
				@error('username')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="email">E-Mail</label>
				<input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ $user->email }}" maxlength="100" required/>
				@error('email')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="user-role">Role</label>
				<select class="form-control @error('role') is-invalid @enderror" id="user-role" name="role" required>
					@foreach ($roles as $role)
						<option value="{{ $role->name }}" @if ($user->hasRole($role->name)) selected @endif>
							{{ $role->display_name }}
						</option>
					@endforeach
				</select>
				@error('role')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<a class="btn btn-danger" href="{{ route('users') }}">Cancel</a>
				<input class="btn btn-primary" type="submit" value="Save"/>
			</div>
		</form>
	</div>
@endsection
