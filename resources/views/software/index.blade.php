@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		@role('admin')
		<div class="row justify-content-center mb-5">
			<a class="btn btn-primary" href="{{ route('key.create') }}">Create New Software Key</a>
		</div>
		@endrole
		<div class="row justify-content-center">
			<form class="mr-3" method="GET" action="{{ url()->current() }}">
				<input class="form-control btn btn-danger" type="submit" value="Clear">
			</form>
			<form method="GET" action="{{ url()->current() }}">
				<div class="input-group">
					<input class="form-control" type="text" name="search" value="{{ $search }}" required/>
					<div class="input-group-append">
						<input class="btn btn-primary" type="submit" value="Search">
					</div>
				</div>
			</form>
		</div>
		<div class="row justify-content-center mt-3">
			<div class="alert alert-info" role="alert">
				Next raffle date: {{ $raffleDate }}.
			</div>
		</div>
		@if ($paginator->hasPages())
			<div class="row justify-content-center mt-3">{{ $paginator->links() }}</div>
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
									<img class="ml-n2 position-absolute" src="{{ $platform->icon_url }}"
										 alt="{{ $platform->name }} icon"
										 style="width: 2em; height: 2em; top: 50%; transform: translate(0, -50%);">
								@endif
								<h5 class="mb-0 ml-4 mr-4 font-weight-bold text-center">
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
								<div class="card-body p-0 collapse border-bottom" id="collapse-dlc-{{ $key->id }}">
									<ul class="list-group list-group-flush">
										@foreach ($child_keys as $dlc)
											<li class="list-group-item">
												{{ $dlc->title }}
												@role('admin')
													<a class="btn btn-primary float-right pl-2 pr-2 pt-1 pb-1" href="{{ url("/keys/{$dlc->id}/edit") }}">Edit</a>
												@endrole
											</li>
										@endforeach
									</ul>
								</div>
							@endif
							<div class="card-body p-2">
								@role('admin')
									<p class="card-text text-center">Votes: {{ $voteCount ?? 0 }}</p>
								@else
									<vote suffix="{{ $key->id }}" url="{{ url('/api/vote/toggle') }}" @if ($votes->contains($key->id)) checked @endif
										  payload="{{ encrypt(['user' => Auth::user()->id, 'software' => $key->id]) }}"></vote>
								@endrole
							</div>
							@if (!empty($key->shop_link) || !empty($key->instruction_link) || Entrust::hasRole('admin'))
								<div class="card-footer text-center">
									@if (!empty($key->shop_link))
										<a class="card-link" href="{{ $key->shop_link }}">Visit the Shop Site</a>
									@endif
									@if (!empty($key->instruction_link))
										<a class="card-link" href="{{ $key->instruction_link }}">Show installation instructions</a>
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
			<div class="row justify-content-center mt-5">
				<div class="alert alert-info" role="alert">
					No software found with that name.
				</div>
			</div>
		@else
			<div class="row justify-content-center mt-5">
				<div class="alert alert-info" role="alert">
					No software found.
				</div>
			</div>
		@endif
		@if ($paginator->hasPages())
			<div class="row justify-content-center mt-5">{{ $paginator->links() }}</div>
		@endif
	</div>
@endsection
