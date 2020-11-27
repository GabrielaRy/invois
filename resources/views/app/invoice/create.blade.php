@extends('adminlte::page')


@section('content_header')
	<h1 style="font-weight: 600;">Nová faktura</h1>
@endsection

@section('content')
	<section class="invoice p-4 rounded">
		<form role="form" action="{{ route('invoice.store') }}" method="POST">
			@csrf
			<div class="form-group col-md-12 mb-5">
				<h2 class="text-gray text-md-right" style="font-size: 1.6rem;">Faktura číslo <span class="text-dark"
																								   style="font-weight: 600;">{{ $nextInvoiceNumber }}</span>
				</h2>
				<input type="hidden" name="invoice_number" value="{{ $nextInvoiceNumber }}">
			</div>

			<div class="d-flex w-100 justify-content-end">
				<div class="col-sm-12 col-md-6">
					<select class="form-control select2 select2-hidden-accessible" name="customer_id"
							id="customer-dropdown">
						<option value disabled selected>Vyberte odběratele</option>

						@foreach ($customers as $customer)
							<option value="{{ $customer->id }}">{{ $customer->name }}</option>
						@endforeach
					</select>
					<br>
				</div>
			</div>

			<div class="row invoice-info">
				<div class="col-sm-6 invoice-col">
					<p class="font-weight-bold text-gray" style="letter-spacing: 3px;">DODAVATEL</p>
					<div class="mt-2">
						<p class="mb-0 font-weight-bold">{{ $user->contact_person_name }}</p>
						<input type="hidden" class="form-control" value="{{ $user->contact_person_name }}" disabled>

						<p class="mb-0">{{ $user->street }}</p>
						<input type="hidden" class="form-control" value="{{ $user->street }}">

						<p class="mb-0">{{ $user->postcode }} {{ $user->city }}</p>
						<input type="hidden" class="form-control" value="{{ $user->city }}">

						<input type="hidden" class="form-control" value="{{ $user->postcode }}">

						<p class="mb-0">{{ $user->country }}</p>
						<input type="hidden" class="form-control" value="{{ $user->country }}">
					</div>

					<div class="mt-4">
						<p>IČO {{ $user->identification_number }}</p>
						<input type="hidden" class="form-control" name="contractor_dentification_umber"
							   value="{{ $user->identification_number }}">
						@if($user->tax_identification_number)
							<p>DIČ {{ $user->tax_identification_number }}</p>
							<input type="hidden" class="form-control" id="contractor_tax_identification_number"
								   value="{{ $user->tax_identification_number }}">
						@endif
					</div>
				</div>
				<div class="col-sm-6 invoice-col d-none" id="customer-data-root">
					<p class="font-weight-bold text-gray" id="odberatel_heading" style="letter-spacing: 3px;"></p>
					<div>
						<p class="mb-0 font-weight-bold" id="customer_name"></p>
						<input type="hidden" id="customer_name_input" name="contractor_name">

						<p class="mb-0" id="customer_street"></p>
						<input type="hidden" id="customer_street_input" name="contractor_street">

						<input type="hidden" id="customer_city_input" name="contractor_city">

						<p class="mb-0"><span id="customer_postcode"></span>&nbsp;<span id="customer_city"></span></p>
						<input type="hidden" id="customer_postcode_input" name="contractor_postcode">

						<p class="mb-0" id="customer_country"></p>
						<input type="hidden" id="customer_country_input" name="contractor_country">
					</div>
					<div class="mt-4">
						<p class="mb-0" id="customer_identification_number"></p>
						<input type="hidden" id="customer_identification_number_input"
							   name="contractor_identification_number">

						<p class="mb-0" id="customer_tax_identification_number"></p>
						<input type="hidden" id="customer_tax_identification_number_input"
							   name="contractor_tax_identification_number">
					</div>
				</div>
			</div>

			<hr class="my-4">

			<div class="row invoice-info">
				<div class="col-sm-6 invoice-col">
					<div class="d-md-flex">
						<div>
							<label for="variable_symbol">Variabilní symbol: </label>
							<input type="text" class="form-control @error('variable_symbol') is-invalid @enderror" value="{{ old('variable_symbol') }}" id="variable_symbol" name="variable_symbol">
							@error('variable_symbol')
							<div class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</div>
							@enderror
						</div>
						<div class="ml-md-4">
							<label for="constant_symbol">Konstantní symbol: </label>
							<input type="text" class="form-control @error('constant_symbol') is-invalid @enderror" id="constant_symbol" name="constant_symbol"
								   value="{{ $invoiceSettings->constant_symbol ?? '' }}">
							@error('constant_symbol')
							<div class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</div>
							@enderror
						</div>
					</div>
					<div class="d-md-flex mt-2">
						<div class="mt-2" id="payment-type-root">
							<label>Způsob platby</label>
							<select class="form-control select2 select2-hidden-accessible" id="payment-type"
									name="payment_type">
								<option
									value="Bankovní převod" {{ $invoiceSettings->payment_type == 'Bankovní převod' ? 'selected' : '' }}>
									Bankovní převod
								</option>
								<option
									value="Hotovost" {{ $invoiceSettings->payment_type == 'Hotovost' ? 'selected' : '' }}>
									Hotovost
								</option>
								<option
									value="Dobírka" {{ $invoiceSettings->payment_type == 'Dobírka' ? 'selected' : '' }}>
									Dobírka
								</option>
							</select>
						</div>
						<div class="ml-md-4 mt-2">
							<label for="specific_symbol">Specifický symbol: </label>
							<input type="text" class="form-control  @error('specific_symbol') is-invalid @enderror" value="{{ old('specific_symbol') }}" id="specific_symbol" name="specificSymbol">
							@error('specific_symbol')
							<div class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</div>
							@enderror
						</div>
					</div>

				</div>

				<div class="col-sm-6 invoice-col">
					<div class="d-md-flex">
						<div class="mt-2">
							<label for="issue_date">Datum vystavení: </label>
							<input type="date" class="form-control" id="issue_date" name="issue_date">
						</div>
						<div class="ml-md-4 mt-2">
							<label for="due_date">Splatnost (dní): </label>
							<input type="number" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date"
								   value="{{ $invoiceSettings->due_date ? $invoiceSettings->due_date : old('due_date') }}">
							@error('due_date')
							<div class="invalid-feedback">
								<strong>{{ $message }}</strong>
							</div>
							@enderror
						</div>
					</div>
				</div>
			</div>
			<br>

			<!-- Table row -->
			<div class="row">
				<div class="col-12 table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Název položky</th>
							<th>Množství</th>
							<th>MJ</th>
							<th>Cena bez DPH / MJ</th>
							@if($user->ŧax_identification_number)
								<th>DPH (%)</th>
							@endif
							<th></th>
						</tr>
						</thead>
						<tbody id="invoice-items-root">
						<tr>
							<td><input type="text" name="items[0][name]" autocomplete="off"></td>
							<td><input type="number" data-index="0" class="amount" name="items[0][amount]" autocomplete="off"></td>
							<td><input type="text" name="items[0][unit]" autocomplete="off"></td>
							<td><input type="number" data-index="0" class="price" name="items[0][price]" autocomplete="off"></td>
							@if($user->tax_identification_number)
								<td>
									<select name="items[0][vat]" id="vat-exists"
											class="form-control select2 select2-hidden-accessible">
										<option value="21">21%</option>
										<option value="15">15%</option>
										<option value="10">10%</option>
									</select>
								</td>
							@endif
							<td></td>
						</tr>
						</tbody>
					</table>
					<div class="w-100 d-flex justify-content-end">
						<button class="btn btn-secondary mb-3" id="add-invoice-item">Přidat položku<i
								class="fa fa-plus pl-2"></i></button>
					</div>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->

{{--			<div class="row">--}}

{{--				<!-- /.col -->--}}
{{--				<div class="col-12">--}}
{{--					<div class="table-responsive">--}}
{{--						<table class="table">--}}
{{--							<tr>--}}
{{--								<th style="width:50%">Celkem bez DPH:</th>--}}
{{--								<td id="price-without-vat">0,-</td>--}}
{{--							</tr>--}}
{{--							@if($user->tax_identification_number)--}}
{{--								<tr>--}}
{{--									<th>Sazba DPH (21%)</th>--}}
{{--									<td>$10.34</td>--}}
{{--								</tr>--}}
{{--								<tr>--}}
{{--									<th>DPH:</th>--}}
{{--									<td>$265.24</td>--}}
{{--								</tr>--}}
{{--								<tr>--}}
{{--									<th>Celkem k úhradě:</th>--}}
{{--									<td>$265.24</td>--}}
{{--								</tr>--}}
{{--							@endif--}}
{{--						</table>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--				<!-- /.col -->--}}
{{--			</div>--}}
{{--			<!-- /.row -->--}}

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="note">Poznámka</label>
					<textarea type="text" class="form-control @error('note') is-invalid @enderror" id="note" name="note"></textarea>
					@error('note')
					<div class="invalid-feedback">
						<strong>{{ $message }}</strong>
					</div>
					@enderror
				</div>
			</div>

				<button type="submit" class="btn btn-primary">Vytvořit fakturu</button>
		</form>
	</section>

	<!-- /.content -->
	<div class="clearfix"></div>


@endsection
