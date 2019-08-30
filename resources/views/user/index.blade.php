@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<a class="btn btn-primary" href="{{ route('user.create') }}">Create New User</a>
		</div>
		<div class="row justify-content-center mt-md-5 mb-md-5">
			<form method="GET" action="{{ url()->current() }}">
				<div class="input-group">
					<input class="form-control" type="text" name="search" value="{{ $search }}"/>
					<div class="input-group-append">
						<input class="btn btn-primary" type="submit" value="Search">
					</div>
				</div>
			</form>
		</div>
		@if ($userPage->isNotEmpty())
			@foreach ($userPage as $user)
				<div class="row justify-content-center mt-md-2">
					<table class="table">
						<colgroup>
							<col class="w-auto"/>
							<col class="w-100"/>
						</colgroup>
						<tr>
							<th scope="row">Username</th>
							<td>{{ $user->name }}</td>
						</tr>
						<tr>
							<th scope="row">E-Mail</th>
							<td>{{ $user->email }}</td>
						</tr>
						<tr>
							<td colspan="2"><a class="btn btn-primary" href="{{ url("users/{$user->id}") }}">Edit</a></td>
						</tr>
					</table>
				</div>
			@endforeach
		@elseif ($searched)
			<div class="row justify-content-center">
				<div class="alert alert-info" role="alert">
					No user entries found.
				</div>
			</div>
		@else
			<div class="row justify-content-center">
				<div class="alert alert-info" role="alert">
					The are no users registered.
				</div>
			</div>
		@endif
	</div>
@endsection
