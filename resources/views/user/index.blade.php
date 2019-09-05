@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<a class="btn btn-primary" href="{{ route('user.create') }}">Create New User</a>
		</div>
		<div class="row justify-content-center mt-5 mb-5">
			<form method="GET" action="{{ url()->current() }}">
				<div class="input-group">
					<input class="form-control" type="text" name="search" value="{{ $search }}" required/>
					<div class="input-group-append">
						<input class="btn btn-primary" type="submit" value="Search">
					</div>
				</div>
			</form>
		</div>
		@if ($paginator->hasPages())
			<div class="row justify-content-center mt-5">{{ $paginator->links() }}</div>
		@endif
		@if ($paginator->isNotEmpty())
			@foreach ($paginator as $user)
				<div class="row justify-content-center mt-2">
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
							<th scope="row">Role</th>
							<td>{{ $user->role_name }}</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="container">
									<div class="row">
										<form method="POST" action="{{ url("users/{$user->id}") }}" onsubmit="return confirm('Are you sure you want to delete the user \'{{ $user->name }}\'?');">
											@method('DELETE')
											@csrf
											<input class="btn btn-danger" type="submit" value="Delete"/>
										</form>
										<a class="btn btn-primary ml-md-1" href="{{ url("users/{$user->id}/edit") }}">Edit</a>
									</div>
								</div>
							</td>
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
		@if ($paginator->hasPages())
			<div class="row justify-content-center mt-5">{{ $paginator->links() }}</div>
		@endif
	</div>
@endsection
