@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row justify-content-center">
			<a class="btn btn-primary" href="{{ route('key.create') }}">Create New Software Key</a>
		</div>
		<div class="row justify-content-center mt-5">
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
			<div class="row justify-content-center">
				@foreach ($paginator as $key)
					<div class="col-5" style="min-width: 300px; max-width: 500px">
						<div class="card mt-5">
							@if (!empty($key->back_img_link))
								<img class="card-img-top" src="{{ $key->back_img_link }}" alt="Software Image"
									 style="max-height: 250px">
							@endif
							<div class="card-header align-middle position-relative">
								@php $platform = $key->platform()->first(); @endphp
								@if (!empty($platform->icon_name))
									<i class="{{ $platform->icon_name }} fa-2x ml-n2 position-absolute"
									   style="top: 50%; transform: translate(0, -50%);"></i>
								@elseif (!empty($platform->icon_url))
									<img class="float-left" src="{{ $platform->icon_url }}"
										 alt="{{ $platform->name }} icon">
								@endif
								<h5 class="mb-0 ml-4 font-weight-bold text-center align-middle">
									{{ $key->title }}@role('admin') ({{ $key->id }})@endrole
								</h5>
							</div>
							@php $child_keys = $key->child_keys()->get(); @endphp
							@if ($child_keys->isNotEmpty())
								<div class="card-header text-center m-0 p-0">
									<h2 class="mb-0">
										<button class="btn btn-link text-decoration-none" type="button"
												data-toggle="collapse" data-target="#collapse-dlc-{{ $key->id }}">
											DLCs ({{ $child_keys->count() }})
										</button>
									</h2>
								</div>
								<div class="collapse" id="collapse-dlc-{{ $key->id }}">
									<div class="card-body p-0">
										<ul class="list-group list-group-flush">
											@foreach ($child_keys as $dlc)
												<li class="list-group-item">{{ $dlc->title }}</li>
											@endforeach
										</ul>
									</div>
								</div>
							@endif
							@if (!empty($key->shop_link) || !empty($key->instruction_link) || Entrust::hasRole('admin'))
								<div class="card-footer text-center">
									@if (!empty($key->shop_link))
										<a class="card-link" href="{{ $key->shop_link }}">Visit the Shop Site</a>
									@endif
									@if (!empty($key->instruction_link))
										<a class="card-link" href="{{ $key->instruction_link }}">Show installation
											instructions</a>
									@endif
									@role('admin')
									<a class="card-link" href="{{ url("/keys/{$key->id}/edit") }}">Edit Software Key</a>
									@endrole
								</div>
							@endif
						</div>
					</div>
				@endforeach
			</div>
		@elseif ($searched)
			<div class="row justify-content-center">
				<div class="alert alert-info" role="alert">
					No software key entries found.
				</div>
			</div>
		@else
			<div class="row justify-content-center">
				<div class="alert alert-info" role="alert">
					The are no software keys registered.
				</div>
			</div>
		@endif
		@if ($paginator->hasPages())
			<div class="row justify-content-center mt-5">{{ $paginator->links() }}</div>
		@endif
	</div>
@endsection
