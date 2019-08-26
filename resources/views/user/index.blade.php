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
			border: 2px solid gray;
			margin-top: 10px;
			padding: 5px;
		}
	</style>

	<div class="resource-index-container">
		<div class="resource-index">
			<div>
				<form action="/users/create">
					<input type="submit" value="Create New User"/>
				</form>
			</div>
			<div style="margin-top: 20px;">
				<form action="/users">
					<label><input type="text" name="search"/></label>
					<input type="submit" value="Search"/>
				</form>
			</div>
			@if ($users->isNotEmpty())
				<ul>
					@foreach ($users as $user)
						<li class="resource-item">
							<table>
								<tr>
									<td>Username:</td>
									<td>{{ $user->name }}</td>
								</tr>
								<tr>
									<td>Role:</td>
									<td>{{ $user->roles()->limit(1)->get(['display_name'])[0]['display_name'] }}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div style="display: flex; justify-content: center;">
											<form action="/users/{!! urlencode($user->id) !!}/show" style="margin-right: 10px;">
												<input type="submit" value="Show"/>
											</form>
											<form action="/users/{!! urlencode($user->id) !!}/edit">
												<input type="submit" value="Edit"/>
											</form>
										</div>
									</td>
								</tr>
							</table>
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
