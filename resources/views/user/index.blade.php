@extends('layouts.app')

@section('content')
	<style>
		.resource-index-container {
			display: flex;
			justify-content: center;
			flex-direction: row;
		}

		.resource-index {
			display: flex;
			justify-content: center;
			flex-direction: column;
			align-items: center;
		}

		.resource-index ul {
			list-style-type: none;
			padding: 0;
		}

		.resource-index li {
			margin-top: 10px;
		}

		.resource-index table {
			width: 100%;
			height: 100%;
		}

		.btn {
			border: 1px solid gray;
			background-color: lightgray;
			padding: 5px 10px;
			border-radius: 0;
			margin-top: 5px;
		}

		.column-min {
			width: 1%;
			white-space: nowrap;
		}
	</style>

	<div class="resource-index-container">
		<div class="resource-index">
			<form action="{{ url("/users/create") }}">
				<input type="submit" value="Create New User"/>
			</form>
			<form style="margin-top: 20px" action="{{ route('users') }}">
				@csrf
				<label><input type="text" name="search"/></label>
				<input type="submit" value="Search"/>
			</form>
			@if ($users->isNotEmpty())
				<ul>
					@foreach ($users as $user)
						<li class="resource-item">
							<div style="justify-content: center; display: flex; flex-direction: column; border: 2px solid gray; padding: 5px;">
								<table>
									<colgroup>
										<col class="column-min">
										<col>
									</colgroup>
									<tr>
										<td>Username:</td>
										<td>{{ $user->name }}</td>
									</tr>
									<tr>
										<td>E-Mail:</td>
										<td>{{ $user->email }}</td>
									</tr>
									<tr>
										<td>Role:</td>
										<td>{{ $user->roles()->limit(1)->get(['display_name'])[0]['display_name'] }}</td>
									</tr>
								</table>
								<div style="justify-content: center; display: flex; flex-direction: row; border-top: 2px solid gray">
									<a class="btn" href="{{ url("/users/{$user->id}/edit") }}">Edit</a>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			@elseif ($searched)
				<p>No user entries found.</p>
			@else
				<p>The are no users registered.</p>
			@endif
		</div>
	</div>
@endsection
