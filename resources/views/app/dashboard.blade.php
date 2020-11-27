@extends('adminlte::page')

@section('content_header')
	<h1 class="mt-2" style="font-weight: 600;">Dashboard</h1>
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-6 col-12">
			<div class="info-box bg-gradient-info">
				<span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Faktury</span>
					<span class="info-box-number py-2" style="font-size: 2rem">{{ $invoicesThisMonth->count() }}</span>

					<div class="progress">
						<div class="progress-bar" style="width: 0%"></div>
					</div>
					<span class="progress-description">
                  vystavených faktur tento měsíc
                </span>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-12">
			<div class="info-box bg-gradient-success">
				<span class="info-box-icon"><i class="fas fa-money-bill"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Částka</span>
					<span class="info-box-number py-2" style="font-size: 2rem">@convert($invoicesPriceThisMonth) Kč</span>

					<div class="progress">
						<div class="progress-bar" style="width: 0%"></div>
					</div>
					<span class="progress-description">
                  celková hodnota faktur za tento měsíc
                </span>
				</div>
			</div>
		</div>
	</div>
@endsection
