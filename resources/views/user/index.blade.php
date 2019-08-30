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
		@if ($paginator->hasPages())
		<div class="row justify-content-center">
			<ul class="pagination">
				<li class="page-item @if ($paginator->previousPageUrl() === null) disabled @endif">
					<a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
				</li>
				@foreach ($pages as $pageIndex => $pageUrl)
					<li class="page-item @if ($pageIndex === $paginator->currentPage()) active @endif">
						<a class="page-link" href="{{ $pageUrl }}">{{ $pageIndex }}</a>
					</li>
				@endforeach
				<li class="page-item @if ($paginator->nextPageUrl() === null) disabled @endif">
					<a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
				</li>
			</ul>
		</div>
		@endif
		@if ($paginator->isNotEmpty())
			@foreach ($paginator as $user)
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
	</div>
@endsection
