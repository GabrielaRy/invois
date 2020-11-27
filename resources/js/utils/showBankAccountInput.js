
$(document).ready(function () {

	if ($('#payment-type').val() === 'Bankovní převod') {
		$('#payment-type-root').append(`
		<div class="row mt-3 invoice-info" id="bank-account-number">
			<div class="col-sm-12 invoice-col">
				<label for="bank_account_number">Číslo účtu</label>
				<input type="text" class="form-control" id="bank_account_number" name="bankAccountNumber">
			</div>
		</div>
		`);
	}

});

$('#payment-type').change(e => {

	if ($('#bank-account-number')) {
		$('#bank-account-number').remove();
	}

	if (e.target.value === 'Bankovní převod') {
		$('#payment-type-root').append(`
		<div class="row mt-3 invoice-info" id="bank-account-number">
			<div class="col-sm-12 invoice-col">
				<label for="bank_account_number">Číslo účtu</label>
				<input type="text" class="form-control" id="bank_account_number" name="bankAccountNumber">
			</div>
		</div>
		`);
	}

});
