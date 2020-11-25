import {fetchCustomer} from "./api";

$('#customer-dropdown').change((e) => {
	e.preventDefault();

	fetchCustomer(e.target.value)
		.then(({payload}) => {

			$('#customer_tax_identification_number').addClass('d-none').val('');
			$('#customer_tax_identification_number_label').addClass('d-none');

			$('#customer_name').removeClass('d-none').val(payload.name);
			$('#customer_street').removeClass('d-none').val(payload.street);
			$('#customer_city').removeClass('d-none').val(payload.city);
			$('#customer_postcode').removeClass('d-none').val(payload.postcode);
			$('#customer_country').removeClass('d-none').val(payload.country);
			$('#customer_identification_number').removeClass('d-none').val(payload.identification_number);
			if (payload.tax_identification_number) {
				$('#customer_tax_identification_number').removeClass('d-none').val(payload.tax_identification_number);
			}

			$('#customer_name_label').removeClass('d-none');
			$('#customer_street_label').removeClass('d-none');
			$('#customer_city_label').removeClass('d-none');
			$('#customer_postcode_label').removeClass('d-none');
			$('#customer_country_label').removeClass('d-none');
			$('#customer_identification_number_label').removeClass('d-none');
			if (payload.tax_identification_number) {
				$('#customer_tax_identification_number_label').removeClass('d-none');
			}

		})
});

