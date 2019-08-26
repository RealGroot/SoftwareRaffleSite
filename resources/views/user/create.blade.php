@php use App\Role; @endphp

@extends('layouts.app')

@section('content')
	<style>
		.resource-create-container {
			display: flex;
			justify-content: center;
			flex-direction: row;
		}

		.wmfg_layout_1 ul.wmfg_questions {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		.wmfg_layout_1 ul.wmfg_questions li.wmfg_q {
			margin: 10px 0;
		}

		.wmfg_layout_1 label.wmfg_label {
			display: block;
			margin: 0 0 5px 0;
			font-weight: bold;
		}

		.wmfg_layout_1 table.wmfg_answers td {
			padding: 2px;
			vertical-align: top;
		}

		.wmfg_layout_1 .wmfg_text {
			border: 1px solid #CCC;
			padding: 4px;
			font-size: 13px;
			color: #000000;
			width: 98.5%;
			background-color: #ffffff;
			background: -webkit-gradient(linear, 0 0, 0 100%, from(#f8f8f8), to(#fff));
			background: -moz-linear-gradient(top, #f8f8f8, #fff);
		}

		.wmfg_layout_1 .wmfg_btn {
			border: 1px solid #cccccc;
			cursor: pointer;
			font-weight: normal;
			font-size: 13px;
			padding: 6px;
			color: #444;
			font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
			background: -webkit-gradient(linear, left top, left bottom, from(#FAFAFA), color-stop(0.5, #FAFAFA), color-stop(0.5, #E5E5E5), to(#F9F9F9));
			background: -moz-linear-gradient(top, #FAFAFA, #FAFAFA 50%, #E5E5E5 50%, #F9F9F9);
			filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr='#FAFAFA', endColorstr='#E5E5E5');
		}

		.wmfg_layout_1 .wmfg_btn:hover {
			background: -webkit-gradient(linear, left top, left bottom, from(#EDEDED), color-stop(0.5, #EDEDED), color-stop(0.5, #D9D9D9), to(#EDEDED));
			background: -moz-linear-gradient(top, #EDEDED, #EDEDED 50%, #D9D9D9 50%, #EDEDED);
			filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr='#E3326E', endColorstr='#D9D9D9');
		}
	</style>

	<div class="resource-create-container">
		<div style="width:500px" class="wmfg_layout_1">
			<form method="post" action="{{ route('users') }}">
				@csrf
				<ul class="wmfg_questions">
					<li class="wmfg_q">
						<label class="wmfg_label" for="username">Username *</label>
						<input type="text" class="wmfg_text" name="username" id="username" value="" required/>
					</li>
					<li class="wmfg_q">
						<label class="wmfg_label" for="email">E-Mail *</label>
						<input type="email" class="wmfg_text" name="email" id="email" value="" required/>
					</li>
					<li class="wmfg_q">
						<label class="wmfg_label" for="password">Password *</label>
						<input type="password" class="wmfg_text" name="password" id="password" value="" required/>
					</li>
					<li class="wmfg_q">
						<label class="wmfg_label" for="password_confirmation">Repeat Password *</label>
						<input type="password" class="wmfg_text" name="password_confirmation" id="password_confirmation"
							   value="" required/>
					</li>
					<li class="wmfg_q">
						<label class="wmfg_label" for="select_role">Role</label>
						<select class="wmfg_select" name="role" id="select_role">
							@foreach (Role::all(['name', 'display_name']) as $role)
								<option value="{{ $role->name }}">{{ $role->display_name }}</option>
							@endforeach
						</select>
					</li>
					<li class="wmfg_q">
						<input type="submit" class="wmfg_btn" name="submit" id="submit" value="Create"/>
					</li>
				</ul>
			</form>
		</div>
	</div>
@endsection
