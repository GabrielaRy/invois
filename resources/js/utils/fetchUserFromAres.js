import {fetchFromAres} from "./api";

const identificationNumber = $('#identification_number');

$('#fetch-user-from-ares').click((e) => {
	e.preventDefault();

	if (identificationNumber.val().length !== 8) {
		identificationNumber.addClass('is-invalid')
		$('#ico-root').append(
			'<p class="invalid-feedback" id="ico-error"><strong>IČO je nesprávně zadané</strong></p>'
		)

		return;
	}

	$('#fetch-user-from-ares')
		.prepend('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>')
		.attr('disabled', true);

	fetchFromAres(identificationNumber.val()).then(({payload}) => {

		$('#contact_person_name').val(payload.company);
		$('#tax_identification_number').val(payload.tin ? payload.tin : '');
		$('#street').val(`${payload.street} ${payload.house_number}`);
		$('#city').val(payload.city);
		$('#postcode').val(payload.zip);
		$('#country').val('Česká Republika');

		$('#fetch-user-from-ares')
			.attr('disabled', false)
			.find('span:first')
			.remove();

		if ($('#ico-error')) {
			$('#ico-error').remove()
			identificationNumber.removeClass('is-invalid')
		}

	})
});
