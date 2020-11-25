@extends('adminlte::page')


@section('content_header')
	<h1>Nová faktura</h1>
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

	<form role="form" action="{{ route('invoice.store') }}" method="POST">
	@csrf

	<!-- Main content -->
		<section class="invoice">
			<!-- vyresi cislo faktury -->
			<div class="form-group col-md-6">
				<label for="invoice_number_placeholder">Číslo faktury</label>
				<input type="text" class="form-control" id="invoice_number_placeholder"
					   name="invoice_number_placeholder"
					   value=" {{ $nextInvoiceNumber }}" disabled>
				<input type="hidden" name="invoice_number" value="{{ $nextInvoiceNumber }}">
			</div>
			<!-- info row -->
			<div class="row invoice-info">
				<div class="col-sm-6 invoice-col">
					Dodavatel
					<address>
						<label for="contractor_name">Název subjektu</label>
						<input type="text" class="form-control" id="contractor_name"
							   value="{{ $user->company_name }}" disabled>
						<label for="contractor_street">Ulice</label>
						<input type="text" class="form-control" id="contractor_street"
							   value="{{ $user->street }}" disabled>
						<label for="contractor_city">Město</label>
						<input type="text" class="form-control" id="contractor_city"
							   value="{{ $user->city }}" disabled>
						<label for="contractor_postcode">PSČ</label>
						<input type="text" class="form-control" id="contractor_postcode"
							   value="{{ $user->postcode }}" disabled>
						<label for="contractor_country">Země</label>
						<input type="text" class="form-control" id="contractor_country"
							   value="{{ $user->country }}" disabled>
					</address>

					<label for="contractor_identification_number">IČO: </label>
					<input type="text" class="form-control" id="contractor_identification_number"
						   name="contractorIdentificationNumber" value="{{ $user->identification_number }}" disabled>
					@if($user->tax_identification_number)
						<label for="contractor_city">DIČ: </label>
						<input type="text" class="form-control" id="contractor_tax_identification_number"
							   value="{{ $user->tax_identification_number }}" disabled>
					@endif

				</div>
				<!-- /.col -->
				<div class="col-sm-6 invoice-col" id="customer-data-root">
					Odběratel
					<address>
						<div class="form-group col-md-12">
							<label>Výběr zákazníka</label>
							<select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
									data-select2-id="1" tabindex="-1" aria-hidden="true" name="customer_id"
									id="customer-dropdown">
								<option value disabled selected>Vyberte odběratele</option>

								@foreach ($customers as $customer)

									<option value="{{ $customer->id }}">{{ $customer->name }}</option>

								@endforeach
							</select>
							<br>
						</div>
					</address>

					<div>
						<label for="contractor_name" class="d-none" id="customer_name_label">Název subjektu</label>
						<input type="text" class="form-control d-none" id="customer_name" name="contractor_name"
							   disabled>
						<label for="contractor_street" class="d-none" id="customer_street_label">Ulice</label>
						<input type="text" class="form-control d-none" id="customer_street" name="contractor_street"
							   disabled>
						<label for="contractor_city" class="d-none" id="customer_city_label">Město</label>
						<input type="text" class="form-control d-none" id="customer_city" name="contractor_city"
							   disabled>
						<label for="contractor_postcode" class="d-none" id="customer_postcode_label">PSČ</label>
						<input type="text" class="form-control d-none" id="customer_postcode" name="contractor_postcode"
							   disabled>
						<label for="contractor_country" class="d-none" id="customer_country_label">Země</label>
						<input type="text" class="form-control d-none" id="customer_country" disabled>
						<label for="contractor_name" class="d-none"
							   id="customer_identification_number_label">IČO</label>
						<input type="text" class="form-control d-none" id="customer_identification_number"
							   name="contractor_name"
							   disabled>
						<label for="contractor_street" class="d-none"
							   id="customer_tax_identification_number_label">DIČ</label>
						<input type="text" class="form-control d-none" id="customer_tax_identification_number"
							   name="contractor_street"
							   disabled>
					</div>

				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
			<hr>
			<div class="row invoice-info">
				<div class="col-sm-6 invoice-col">
					<label for="contractor_city">Variabilní symbol: </label>
					<input type="text" class="form-control" id="variable_symbol" name="variableSymbol">
					<label for="contractor_city">Konstantní symbol: </label>
					<input type="text" class="form-control" id="constant_symbol" name="constantSymbol">
					<label for="contractor_city">Specifický symbol: </label>
					<input type="text" class="form-control" id="specific_symbol" name="specificSymbol">
					<div class="form-group col-md-12">
						<label>Způsob platby</label>
						<select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
								data-select2-id="1" tabindex="-1" aria-hidden="true" name="payment_type">
							<option value="bankovní převod">Bankovní převod</option>
							<option value="hotovost">Hotovost</option>
							<option value="dobirka">Dobírka</option>
						</select>
					</div>
					<div class="row invoice-info">
						<div class="col-sm-6 invoice-col">
							<label for="bank_account_number">Číslo účtu</label>
							<input type="text" class="form-control" id="bank_account_number" name="bankAccountNumber">
							<label for="bank_account_iban">IBAN</label>
							<input type="text" class="form-control" id="bank_account_iban" name="bankAccountIban">
							<label for="bank_account_swift">SWIFT</label>
							<input type="text" class="form-control" id="bank_account_swift" name="bankAccountSwift">
						</div>
					</div>
				</div>

				<div class="col-sm-6 invoice-col">
					<label for="contractor_city">Datum vystavení: </label>
					<input type="date" class="form-control" id="issue_date" name="issue_date">
					<label for="contractor_city">Datum splatnosti: </label>
					<input type="date" class="form-control" id="due_date" name="due_date">
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
							<td><input type="text" name="items[0][name]"></td>
							<td><input type="text" name="items[0][amount]"></td>
							<td><input type="text" name="items[0][unit]"></td>
							<td><input type="text" name="items[0][price]"></td>
							@if($user->tax_identification_number)
								<td>
									<select name="items[0][vat]" id="vat-exists" class="form-control select2 select2-hidden-accessible">
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
					<button class="btn btn-secondary" id="add-invoice-item">Přidat položku</button>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->

			<div class="row">

				<!-- /.col -->
				<div class="col-6">


					<div class="table-responsive">
						<table class="table">
							<tr>
								<th style="width:50%">Celkem bez DPH:</th>
								<td>$250.30</td>
							</tr>
							<tr>
								<th>Sazba DPH (21%)</th>
								<td>$10.34</td>
							</tr>
							<tr>
								<th>Základ daně:</th>
								<td>$5.80</td>
							</tr>
							<tr>
								<th>DPH:</th>
								<td>$265.24</td>
							</tr>
							<tr>
								<th>Celkem k úhradě:</th>
								<td>$265.24</td>
							</tr>
						</table>
					</div>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="note">Poznámka</label>
					<textarea type="text" class="form-control" id="note" name="note"></textarea>
				</div>
			</div>

			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Vytvořit fakturu</button>
			</div>
		</section>
	</form>

	<!-- /.content -->
	<div class="clearfix"></div>


@endsection
