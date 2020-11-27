@extends('adminlte::page')

@section('content_header')
	<h1 class="mt-2" style="font-weight: 600;">{{ $customer->name }}</h1>
@endsection

@section('action_header')
	<div class="d-flex mt-2">
		<a href="{{ route('customers.edit', $customer->id)}}" class="btn btn-primary mt-2">Editovat<i
				class="far fa-edit pl-2"></i></a>

		<form class="ml-2 mt-2 delete-customer" action="{{ route('customers.destroy', $customer->id) }}"
			  method="POST">
			@csrf
			@method('delete')
			<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
			</button>
		</form>
	</div>
@endsection

@section('content')
	<div>
		<h5 class="font-weight-bold" style="font-size: 1.4rem;">Identifikace</h5>
		<div class="form-row mt-3">
			@if($customer->identification_number)
				<div class="form-group col-md-4" id="ico-root">
					<label class="control-label" for="identification_number">IČO</label>
					<input type="text" value="{{ $customer->name }}" class="form-control" id="identification_number"
						   name="identification_number" readonly>
				</div>
			@endif
			@if($customer->tax_identification_number)
				<div class="form-group col-md-4">
					<label for="tax_identification_number">DIČ</label>
					<input type="text" value="{{ $customer->tax_identification_number }}" class="form-control"
						   id="tax_identification_number"
						   name="tax_identification_number" readonly>
				</div>
			@endif
			<div class="form-group  col-md-4">
				<label class="control-label" for="name">Název zákazníka</label>
				<input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" readonly>
			</div>
		</div>

		<hr>

		<h5 class="mt-2 font-weight-bold" style="font-size: 1.4rem;">Adresa</h5>
		<div class="form-row mt-3">
			<div class="form-group  col-md-4">
				<label class="control-label" for="street">Ulice</label>
				<input type="text" value="{{ $customer->street }}" class="form-control" id="street" name="street"
					   readonly>
			</div>
			<div class="form-group  col-md-3">
				<label class="control-label" for="city">Město</label>
				<input type="text" value="{{ $customer->city }}" class="form-control" id="city" name="city" readonly>
			</div>
			<div class="form-group  col-md-2">
				<label class="control-label" for="postcode">PSČ</label>
				<input type="text" value="{{ $customer->postcode }}" class="form-control" id="postcode" name="postcode"
					   readonly>
			</div>
			<div class="form-group  col-md-3">
				<label class="control-label" for="country">Země</label>
				<input type="text" value="{{ $customer->country }}" class="form-control" id="country" name="country"
					   readonly>
			</div>
		</div>

		<hr>

		<h5 class="mt-2 font-weight-bold" style="font-size: 1.4rem;">Kontaktní osoba</h5>
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="contact_person_name">Jméno</label>
				<input type="text" value="{{ $customer->contact_person_name ?? '' }}" class="form-control"
					   id="contact_person_name" name="contact_person_name" readonly>
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_phone">Telefon</label>
				<input type="text" value="{{ $customer->contact_person_phone ?? '' }}" class="form-control"
					   id="contact_person_phone" name="contact_person_phone" readonly>
			</div>
			<div class="form-group col-md-4">
				<label for="contact_person_email">Email</label>
				<input type="email" value="{{ $customer->contact_person_email ?? '' }}" class="form-control"
					   id="contact_person_email" name="contact_person_email" readonly>
			</div>
		</div>

		<h5>Ostatní</h5>
		<div class="form-row">
			<div class="form-group col-md-10">
				<label for="note">Poznámka</label>
				<input type="text" value="{{ $customer->note ?? '' }}" class="form-control" id="note" name="note"
					   readonly>
			</div>
			<div class="form-group col-md-2">
				<label for="invoice_due_date">Splatnost faktur (dní)</label>
				<input type="text" value="{{ $customer->invoice_due_date ?? '' }}" class="form-control"
					   id="invoice_due_date" name="invoice_due_data" readonly>
			</div>
		</div>
	</div>
@endsection
