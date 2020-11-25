@extends('adminlte::page')

@section('content_header')
	<h1>Přidat zákazníka</h1>
@endsection

@section('content')

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{ route('customers.store') }}" method="POST">
		@csrf

		<h5>Identifikace</h5>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="name">Název zákazníka</label>
				<input type="text" class="form-control" id="name" name="name">
			</div>
			<div class="form-group col-md-4" id="ico-root">
				<label for="identification_number">IČO</label>
				<input type="text" class="form-control" id="identification_number" name="identification_number">
			</div>
			<div class="form-group col-md-4">
				<label for="tax_identification_number">DIČ</label>
				<input type="text" class="form-control" id="tax_identification_number" name="tax_identification_number">
			</div>
			<button class="btn btn-secondary" id="fetch-customer-from-ares">Načíst data</button>
		</div>

		<h5>Adresa</h5>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="street">Ulice</label>
				<input type="text" class="form-control" id="street" name="street">
			</div>
			<div class="form-group col-md-4">
				<label for="inputAddress2">Město</label>
				<input type="text" class="form-control" id="city" name="city">
			</div>
			<div class="form-group col-md-2">
				<label for="postcode">PSČ</label>
				<input type="text" class="form-control" id="postcode" name="postcode">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="country">Země</label>
				<input type="text" class="form-control" id="country" name="country">
			</div>
		</div>

		<h5>Kontaktní osoba</h5>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="contact_person_name">Jméno</label>
				<input type="text" class="form-control" id="contact_person_name" name="contact_person_name">
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_phone">Telefon</label>
				<input type="text" class="form-control" id="contact_person_phone" name="contact_person_phone">
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_email">Email</label>
				<input type="email" class="form-control" id="contact_person_email" name="contact_person_email">
			</div>
		</div>

		<h5>Ostatní</h5>
		<div class="form-row">
			<div class="form-group col-md-10">
				<label for="note">Poznámka</label>
				<input type="text" class="form-control" id="note" name="note">
			</div>
			<div class="form-group col-md-2">
				<label for="invoice_due_date">Splatnost faktur</label>
				<input type="text" class="form-control" id="invoice_due_date" name="invoice_due_data">
			</div>
		</div>
		<button type="submit" class="btn btn-secondary">Vytvořit nového zákazníka</button>
	</form>

@endsection
