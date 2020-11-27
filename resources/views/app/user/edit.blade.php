@extends('adminlte::page')

@section('content_header')
	<h1 style="font-weight: 600;">Fakturační údaje</h1>
@endsection

@section('content')
	<form class="mt-4" action="{{ route('user.update') }}" method="POST">
		@csrf
		@method('patch')

		<h5 class="font-weight-bold" style="font-size: 1.4rem;">Identifikace</h5>
		<div class="form-row mt-3">
			<div class="form-group required col-md-4" id="ico-root">
				<label class="control-label" for="identification_number">IČO</label>
				<input type="text" value="{{ $user->identification_number }}"
					   class="form-control @error('identification_number') is-invalid @enderror"
					   id="identification_number" name="identification_number" autofocus>
				@error('identification_number')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="tax_identification_number">DIČ</label>
				<input type="text" class="form-control @error('tax_identification_number') is-invalid @enderror"
					   id="tax_identification_number" value="{{ $user->tax_identification_number ?? '' }}"
					   name="tax_identification_number">
				@error('tax_identification_number')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group required col-md-4">
				<label class="control-label" for="contact_person_name">Název subjektu</label>
				<input type="text" class="form-control @error('contact_person_name') is-invalid @enderror"
					   id="contact_person_name" name="contact_person_name" value="{{ $user->contact_person_name }}">
				@error('contact_person_name')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<button class="btn btn-secondary" id="fetch-user-from-ares">Načíst informace z ARES</button>
			</div>
		</div>

		<hr>

		<h5 class="mt-2 font-weight-bold" style="font-size: 1.4rem;">Adresa</h5>
		<div class="form-row mt-3">
			<div class="form-group required col-md-4">
				<label class="control-label" for="street">Ulice</label>
				<input type="text" value="{{ $user->street }}"
					   class="form-control @error('street') is-invalid @enderror" id="street" name="street">
				@error('street')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group required col-md-3">
				<label class="control-label" for="city">Město</label>
				<input type="text" value="{{ $user->city }}" class="form-control @error('city') is-invalid @enderror"
					   id="city" name="city">
				@error('city')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group required col-md-2">
				<label class="control-label" for="postcode">PSČ</label>
				<input type="text" value="{{ $user->postcode }}"
					   class="form-control @error('city') is-invalid @enderror" id="postcode" name="postcode">
				@error('postcode')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group required col-md-3">
				<label class="control-label" for="country">Země</label>
				<input type="text" value="{{ $user->country }}"
					   class="form-control @error('country') is-invalid @enderror" id="country" name="country">
				@error('country')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
		</div>

		<hr>

		<h5 class="mt-2 font-weight-bold" style="font-size: 1.4rem;">Kontaktní údaje</h5>
		<div class="form-row mt-3">
			<div class="form-group col-md-4">
				<label for="contact_person_phone">Telefon</label>
				<input type="text" value="{{ $user->contact_person_phone ?? '' }}"
					   class="form-control @error('contact_person_phone') is-invalid @enderror"
					   id="contact_person_phone" name="contact_person_phone">
				@error('contact_person_phone')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_email">Email</label>
				<input type="email" value="{{ $user->contact_person_email ?? '' }}"
					   class="form-control @error('contact_person_email') is-invalid @enderror"
					   id="contact_person_email" name="contact_person_email">
				@error('contact_person_email')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_website">Webová stránka</label>
				<input type="text" value="{{ $user->contact_person_website ?? '' }}"
					   class="form-control @error('contact_person_website') is-invalid @enderror"
					   id="contact_person_website" name="contact_person_website">
				@error('contact_person_website')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
		</div>

		<button type="submit" class="btn btn-primary">Uložit fakturační údaje</button>
	</form>

@endsection
