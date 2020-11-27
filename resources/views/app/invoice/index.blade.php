@extends('adminlte::page')

@section('content_header')
	<h1 class="mt-2" style="font-weight: 600;">Vystavené faktury</h1>
@endsection

@if($canCreateInvoice)
@section('action_header')
	<a href="{{ route('invoice.create')}}" class="btn btn-primary mt-2 py-2 px-4">Vytvořit fakturu<i
			class="fa fa-plus pl-2"></i></a>
@endsection
@endif

@section('content')

	@if(!$canCreateInvoice)

		<div class="rounded alert-success p-4 w-100" role="alert">
			<h2 class="alert-heading text-center">(⊃｡•́‿•̀｡)⊃</h2>
			<h3 class="alert-heading text-center" style="font-weight: 600; font-size: 3rem;">Vítejte!</h3>
			<p class="pt-4" style="font-size: 1.4rem">Děkujeme, že používáte náš fakturační systém!<br>Abyste mohli
				vystavit svou
				první fakturu, musíte nejdříve nastavit své fakturační údaje a vytvořit prvního zákazníka.</p>
			<hr class="my-5">
			<div class="d-flex justify-content-between">
				<a href="{{ route('user.edit') }}" class="btn btn-dark btn-lg">Nastavit fakturační údaje</a>
				<a href="{{ route('customers.create') }}" class="btn btn-warning btn-lg">Vytvořit prvního zákazníka</a>
			</div>
		</div>

	@elseif ($canCreateInvoice && $user->invoices->isEmpty())
		<div class="text-center mt-5">

			<h2 class="display-2">ಥ﹏ಥ</h2>
			<p style="font-size: 1.6rem;">Nemáte žádnou vystavenou fakturu.</p>

		</div>
	@else

		<div class="row mt-2">
			<div class="col-12">
				<div class="card">

					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
						<table class="table table-hover text-nowrap">
							<thead>
							<tr>
								<th>Vystavena</th>
								<th>Číslo faktury</th>
								<th>Stav</th>
								<th>Zákazník</th>
								<th>Částka</th>
								<th>Akce</th>
							</tr>
							</thead>
							<tbody>

							@foreach ($user->invoices as $invoice)
								<tr>
									<td>{{ $invoice->created_at->format('d.m.Y') }}</td>
									<td>
										<a href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->invoice_number }}</a>
									</td>

									@if($invoice->due_date < \Carbon\Carbon::now() && !$invoice->is_paid)
										<td><span class="badge badge-danger">Po splatnosti</span></td>
									@else
										<td><span
												class="badge {{ $invoice->is_paid ? 'badge-success' : 'badge-warning' }}">{{ $invoice->is_paid ? 'Zaplacená' : 'Nezaplacená' }}</span>
										</td>
									@endif
									<td>
										{{ \Illuminate\Support\Str::limit($invoice->customer_name, 20, '...') }}
									</td>
									<td>
										@convert($invoice->total_sum) Kč
									</td>
									<td class="d-flex">

										@if(!$invoice->is_paid)
											<form class="ml-2" action="{{ route('invoice.markAsPaid', $invoice->id) }}"
												  method="POST">
												@csrf
												<button type="submit" class="btn btn-success" title="Označit jako zaplacenou">
													<i class="fa fa-money-bill"></i>
												</button>
											</form>
										@else
											<form class="ml-2" action="{{ route('invoice.markAsUnpaid', $invoice->id) }}"
												  method="POST">
												@csrf
												<button type="submit" class="btn btn-danger" title="Označit jako nezaplacenou">
													<i class="fa fa-money-bill"></i>
												</button>
											</form>

										@endif

										<a href="" class="btn btn-dark ml-2"><i class="fas fa-print"></i></a>

										<a class="btn btn-primary ml-2" id="mark-as-paid"
										   href="{{ route('invoice.edit', $invoice->id) }}"
										   title="Editovat fakturu">
											<i class="far fa-edit"></i>
										</a>

										<form class="ml-2 delete-row"
											  action="{{ route('invoice.destroy', $invoice->id) }}"
											  method="POST">
											@csrf
											@method('delete')
											<button type="submit" class="btn btn-danger"><i
													class="fas fa-trash" title="Odstranit fakturu"></i>
											</button>
										</form>
									</td>
								</tr>
							@endforeach

							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	@endif
@endsection
