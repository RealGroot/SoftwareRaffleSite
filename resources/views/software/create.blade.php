@extends('layouts.app')

@section('content')
	<div class="container">
		<form method="POST" action="{{ route('keys') }}">
			@csrf
			<div class="form-group">
				<label for="title">Software Title *</label>
				<input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title') }}" maxlength="255" required/>
				@error('title')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="key">Software Key *</label>
				<input class="form-control @error('key') is-invalid @enderror" id="key" type="text" name="key" value="{{ old('key') }}" maxlength="255" required/>
				@error('key')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="platform_name">Platform *</label>
				<select class="form-control @error('platform_name') is-invalid @enderror" id="platform_name" name="platform_name" required>
					@foreach ($platforms as $platform)
						<option value="{{ $platform->name }}" @if ($platform->name === old('platform')) selected @endif>{{ $platform->display_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="shop_link">Shop Link</label>
				<input class="form-control @error('shop_link') is-invalid @enderror" id="shop_link" type="url" name="shop_link" value="{{ old('shop_link') }}"/>
				@error('shop_link')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="back_img_link">Background Image Link</label>
				<input class="form-control @error('back_img_link') is-invalid @enderror" id="back_img_link" type="url" name="back_img_link" value="{{ old('back_img_link') }}"/>
				@error('back_img_link')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="instruction_link">Installation Instructions Link</label>
				<input class="form-control @error('instruction_link') is-invalid @enderror" id="instruction_link" type="url" name="instruction_link" value="{{ old('instruction_link') }}"/>
				@error('instruction_link')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="parent_id">Group Software Key ID</label>
				<input class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" type="number" name="parent_id" value="{{ old('parent_id') }}" min="1"/>
				@error('parent_id')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group">
				<a class="btn btn-danger" href="{{ route('keys') }}">Cancel</a>
				<input class="btn btn-primary" type="submit" value="Create"/>
			</div>
		</form>
	</div>
@endsection
