@extends('adminlte::page')


@section('content_header')
	<h1 style="font-weight: 600;">Faktura č. {{ $invoice->invoice_number }}</h1>
@endsection

@section('action_header')
	<div class="d-flex mt-2">
		<a href="" class="btn btn-dark ml-2 m-2"><i class="fas fa-print"></i></a>

		<form class="ml-2 mt-2 delete-row" action="{{ route('invoice.destroy', $invoice->id) }}"
			  method="POST">
			@csrf
			@method('delete')
			<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
			</button>
		</form>
	</div>
@endsection

@section('content')
	<section class="invoice p-4 rounded">
		<div class="form-group col-md-12 mb-5">
			<h2 class="text-gray text-md-right" style="font-size: 1.6rem;">Faktura číslo <span class="text-dark"
																							   style="font-weight: 600;">{{ $invoice->invoice_number }}</span>
			</h2>
		</div>

		<div class="row invoice-info">
			<div class="col-sm-6 invoice-col">
				<p class="font-weight-bold text-gray" style="letter-spacing: 3px;">DODAVATEL</p>
				<div class="mt-2">
					<p class="mb-0 font-weight-bold">{{ $invoice->contractor_contact_person_name }}</p>

					<p class="mb-0">{{ $invoice->contractor_street }}</p>

					<p class="mb-0">{{ $invoice->contractor_postcode }} {{ $invoice->contractor_city }}</p>

					<p class="mb-0">{{ $invoice->contractor_country }}</p>
				</div>

				<div class="mt-4">
					<p>IČO {{ $invoice->contractor_identification_number }}</p>
					@if($invoice->contractor_tax_identification_number)
						<p>DIČ {{ $invoice->contractor_tax_identification_number }}</p>
					@endif
				</div>
			</div>
			<div class="col-sm-6 invoice-col" id="customer-data-root">
				<p class="font-weight-bold text-gray" id="odberatel_heading" style="letter-spacing: 3px;"></p>
				<div>
					<p class="mb-0 font-weight-bold" id="customer_name">{{ $invoice->customer_name }}</p>

					<p class="mb-0" id="customer_street">{{ $invoice->customer_street }}</p>

					<p class="mb-0"><span id="customer_postcode">{{ $invoice->customer_postcode }}</span>&nbsp;<span
							id="customer_city">{{ $invoice->customer_city }}</span></p>

					<p class="mb-0" id="customer_country">{{ $invoice->customer_country }}</p>

				</div>
				<div class="mt-4">
					@if($invoice->customer_identification_number)
						<p class="mb-0"
						   id="customer_identification_number">IČO {{ $invoice->customer_identification_number }}</p>
					@endif
					@if($invoice->customer_tax_identification_number)
						<p class="mb-0"
						   id="customer_tax_identification_number">
							DIČ {{ $invoice->customer_tax_identification_number }}</p>
					@endif
				</div>
			</div>
		</div>

		<hr class="my-4">

		<div class="row invoice-info">
			<div class="col-sm-6 invoice-col">
				<div class="d-md-flex flex-column">

					@if($invoice->variable_symbol)
						<div class="d-flex">
							<p class="font-weight-bold">Variabilní symbol:</p>
							<p class="ml-2">{{ $invoice->variable_symbol }}</p>
						</div>
					@endif

					@if($invoice->constant_symbol)
						<div class="d-flex">
							<p class="font-weight-bold">Konstantní symbol:</p>
							<p class="ml-2">{{ $invoice->constant_symbol }}</p>
						</div>
					@endif
				</div>

				<div class="d-flex" id="payment-type-root">
					<p class="font-weight-bold">Způsob platby:</p>
					<p class="ml-2">{{ $invoice->payment_type }}</p>
				</div>
				@if($invoice->specific_symbol)
					<div class="d-flex">
						<p class="font-weight-bold">Variabilní symbol:</p>
						<p>{{ $invoice->specific_symbol }}</p>

					</div>
				@endif


			</div>

			<div class="col-sm-6 invoice-col">
				<div class="d-md-flex">
					<div class="mt-2">
						<label for="issue_date">Datum vystavení: </label>
						<input type="date" value="{{ $invoice->issue_date }}" class="form-control" id="issue_date"
							   name="issue_date" readonly>
					</div>
					<div class="ml-md-4 mt-2">
						<label for="due_date">Splatnost: </label>
						<input type="date" class="form-control" id="due_date" name="due_date"
							   value="{{ $invoice->due_date }}" readonly>
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
						@if(!$invoice->items[0]->vat == 0)
							<th>DPH (%)</th>
						@endif
						<th>Součet</th>
					</tr>
					</thead>
					<tbody id="invoice-items-root">
					@foreach($invoice->items as $index => $item)
						<tr>
							<td>{{ $item->name }}</td>
							<td>{{ $item->amount }}</td>
							<td>{{ $item->unit }}</td>
							<td>@convert($item->price) Kč</td>
							@if(!$item->vat == 0)
								<td>
									<p>{{ $item->vat }}</p>
								</td>
							@endif
							<td>@convert($item->amount * $item->price) Kč</td>
						</tr>
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						@if(!$invoice->items[0]->vat == 0)
							<td></td>
						@endif
						<td><p class="mb-0 font-weight-bold">@convert($invoice->total_sum) Kč</p></td>
					</tr>
					</tbody>
				</table>
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

		@if($invoice->note)
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="note">Poznámka</label>
					<textarea type="text" class="form-control" id="note" name="note"
							  readonly>{{ $invoice->note ?? '' }}</textarea>
				</div>
			</div>
		@endif
	</section>

	<!-- /.content -->
	<div class="clearfix"></div>


@endsection
