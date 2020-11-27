@extends('adminlte::page')

@section('content_header')
	<h1 class="mt-2" style="font-weight: 600;">Seznam Zákazníků</h1>
@endsection

@section('action_header')
	<a href="{{ route('customers.create')}}" class="btn btn-primary mt-2 py-2 px-4">Přidat zákazníka<i
			class="fa fa-plus pl-2"></i></a>
@endsection

@section('content')

	@if($customers->isEmpty())

		<div class="text-center mt-5">

			<h2 class="display-2">ಥ﹏ಥ</h2>
			<p style="font-size: 1.6rem;">Seznam je prázdný. Začněte vytvořením nového zákazníka</p>

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
								<th>Název zákazníka</th>
								<th>IČO</th>
								<th>Adresa</th>
								<th>Akce</th>
							</tr>
							</thead>
							<tbody>

							@foreach ($customers as $customer)
								<tr>
									<td><a href="{{ route('customers.show', $customer->id) }}">{{ $customer->name }}</a>
									</td>
									<td>{{ $customer->identification_number }}</td>
									<td>{{ $customer->street }}, {{ $customer->city }} {{ $customer->postcode }}</td>
									<td class="d-flex">

										<a class="btn btn-primary" href="{{ route('customers.edit', $customer->id) }} ">
											<i class="far fa-edit"></i>
										</a>

										<form class="ml-2 delete-row" action="{{ route('customers.destroy', $customer->id) }}"
											  method="POST">
											@csrf
											@method('delete')
											<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>
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
