@extends('adminlte::page')


@section('content_header')
	<h1>Nastavení faktur</h1>
@endsection

@section('content')

	<form class="mt-4" action="{{ route('invoiceSettings.update') }}" method="POST" enctype="multipart/form-data">
		@csrf
		@method('patch')

		<h5 class="font-weight-bold" style="font-size: 1.4rem;">Soubory</h5>
		<div class="form-row mt-3">
			<div class="form-group required col-md-6">
				<label class="control-label" for="logo">Logo</label>
				<div class="custom-file">
					<label class="custom-file-label" for="logo">Vyberte soubor</label>
					<input type="file" class="custom-file-input" id="logo" name="logo">
				</div>
				@error('logo')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group required col-md-6">
				<label class="control-label" for="signature">Razítko / Podpis</label>
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="signature" name="signature">
					<label class="custom-file-label" for="signature">Vyberte soubor</label>
				</div>
				@error('signature')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
		</div>

		<hr>

		<h5 class="mt-2 font-weight-bold" style="font-size: 1.4rem;">Výchozí nastavení faktur</h5>
		<div class="form-row mt-3">
			<div class="form-group col-md-4">
				<label for="constant_symbol">Konstantní symbol</label>
				<input type="text" value="{{ $invoiceSetting->constant_symbol ?? '' }}"
					   class="form-control @error('constant_symbol') is-invalid @enderror"
					   id="constant_symbol" name="constant_symbol">
				@error('constant_symbol')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="payment_type">Typ platby</label>
				<select class="form-control @error('payment_type') is-invalid @enderror" name="payment_type" id="payment_type">
					<option value="Bankovní převod" {{ $invoiceSetting->payment_type == 'Bankovní převod' ? 'selected' : '' }}>Bankovní převod</option>
					<option value="Hotovost" {{ $invoiceSetting->payment_type == 'Hotovost' ? 'selected' : '' }}>Hotovost</option>
					<option value="Dobírka" {{ $invoiceSetting->payment_type == 'Dobírka' ? 'selected' : '' }}>Dobírka</option>
				</select>
				@error('payment_type')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
			<div class="form-group col-md-4">
				<label for="due_date">Délka splatnosti</label>
				<input type="text" value="{{ $invoiceSetting->due_date ?? '' }}"
					   class="form-control @error('due_date') is-invalid @enderror"
					   id="due_date" name="due_date">
				@error('due_date')
				<div class="invalid-feedback">
					<strong>{{ $message }}</strong>
				</div>
				@enderror
			</div>
		</div>

		<button type="submit" class="btn btn-primary">Uložit nastavení faktur</button>
	</form>

@endsection
